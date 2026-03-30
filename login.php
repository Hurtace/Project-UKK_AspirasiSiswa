<?php
    session_name("pedulisaran_session");
    session_start();
    require 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | PeduliSaran</title>
    <link rel="stylesheet" type="text/css" href="assets/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,
        600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body id="bg-login">
    <div class="box-login">
        <img src="assets/SMK .png">
        <h2>Login</h2>
        <form method="POST">
            <select name="role" class="input-control" onchange="this.form.submit()">
                <option value="" disabled selected>-- Pilih Masuk Sebagai --</option>
                <option value="admin" <?= (isset($_POST['role']) && $_POST['role']=='admin')?'selected':''; ?>>Admin</option>
                <option value="siswa" <?= (isset($_POST['role']) && $_POST['role']=='siswa')?'selected':''; ?>>Siswa</option>
            </select>

            <?php
                $role = $_POST['role'] ?? '';
            ?>

            <?php if($role == 'admin'){ ?>
                <input type="text" name="username" placeholder="Username" class="input-control" required>
            <?php } elseif($role == 'siswa'){ ?>
                <input type="text" name="nis" placeholder="NIS" class="input-control" required>
            <?php } ?>

            <?php if($role != ''){ ?>
                <input type="password" name="pass" placeholder="Password" class="input-control" required>
                <input type="submit" name="login" value="Login" class="btn-login">
            <?php } ?>
            <?php if($role == 'siswa'){ ?>
                <p style="margin-top:20px;">
                    <a href="CRUD/tambah-siswa.php">Belum punya akun?</a>
                </p>
            <?php } ?>
        </form>
        <?php
            if(isset($_POST['login'])){
                $role = $_POST['role'];
                $pass = md5($_POST['pass']);

                if($role == 'admin'){
                    $username = mysqli_real_escape_string($conn,$_POST['username']);
                    $cek = mysqli_query($conn,"SELECT * FROM tb_admin WHERE username='$username' AND password='$pass'");
                }else{
                    $nis = mysqli_real_escape_string($conn,$_POST['nis']);
                    $cek = mysqli_query($conn,"SELECT * FROM tb_siswa WHERE nis='$nis' AND password='$pass'");
                }

                if(mysqli_num_rows($cek) > 0){
                    $d = mysqli_fetch_object($cek);
                    $_SESSION['status_login'] = true;
                    $_SESSION['role'] = $role;
                    $_SESSION['a_global'] = $d;
                    
                    if($role == 'admin'){
                        $_SESSION['id'] = $d->admin_id;
                        echo '<script>window.location="dashboard.php"</script>';
                    }else{
                        $_SESSION['nis'] = $d->nis;
                        echo '<script>window.location="index.php"</script>';
                    }
                    exit;

                }else{
                    echo "<script>alert('Username Atau Password Anda Salah')</script>";
                }
            }
        ?>
    </div>
</body>
</html>