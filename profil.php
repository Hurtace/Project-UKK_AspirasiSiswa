<?php
    session_name("pedulisaran_session");
    session_start();
    require 'db.php';
    if($_SESSION['status_login'] != true || $_SESSION['role'] != 'admin'){
        echo '<script>window.location="login.php"</script>';
    }

    $query = mysqli_query($conn, "SELECT * FROM tb_admin WHERE admin_id = '".$_SESSION['id']."' ");
    $d = mysqli_fetch_object($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | PeduliSaran</title>
    <link rel="stylesheet" type="text/css" href="assets/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,
        600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <!--header-->
    <header>
        <div class="container">
            <h1><a href="dashboard.php">PeduliSaran</a></h1>
            <ul>
                <li><a href="dashboard.php">Admin Dashboard</a></li>
                <li><a href="profil.php">Admin Profile</a></li>
                <li><a href="data-kategori.php">Data Kategori</a></li>
                <li><a href="data-aspirasi.php">Data Aspirasi</a></li>
                <li><a href="keluar.php">keluar</a></li>
            </ul>
        </div>
    </header>

    <!--content-->
    <div class="section">
        <div class="container">
            <h3>Ubah Username</h3>
            <div class="box">
                <form method="POST">
                    <input type="username" name="user1" placeholder="Username Baru" class="input-control" value="<?php echo $d->username ?>" required>
                    <input type="username" name="user2" placeholder="Konfirmasi Username Baru" class="input-control" required>
                    <input type="submit" name="ubah_username" value="Ubah Username" class="btn">
                </form>
                <?php 
                    if(isset($_POST['ubah_username'])){
                        $user1 = $_POST['user1'];
                        $user2 = $_POST['user2'];

                        if($user2 != $user1){
                            echo '<script>alert("Konfirmasi Username Baru Tidak Sesuai")</script>';
                        }else{
                            $u_user = mysqli_query($conn, "UPDATE tb_admin SET
                                        username = '".$user1."'
                                        WHERE admin_id = '".$d->admin_id."' ");
                            if($u_user){
                                echo '<script>alert("Ubah Username Berhasil")</script>';
                                echo '<script>window.location="profil.php"</script>';
                            }else{
                                echo 'Gagal ' .mysqli_error($conn);
                            }
                        }
                    }
                ?>  
            </div>

            <h3>Ubah Password</h3>
            <div class="box">
                <form method="POST">
                    <input type="password" name="pass1" placeholder="Password Baru" class="input-control" required>
                    <input type="password" name="pass2" placeholder="Konfirmasi Password Baru" class="input-control" required>
                    <input type="submit" name="ubah_password" value="Ubah Password" class="btn">
                </form>
                <?php 
                    if(isset($_POST['ubah_password'])){
                        $pass1 = $_POST['pass1'];
                        $pass2 = $_POST['pass2'];

                        if($pass2 != $pass1){
                            echo '<script>alert("Konfirmasi Password Baru Tidak Sesuai")</script>';
                        }else{
                            $u_pass = mysqli_query($conn, "UPDATE tb_admin SET
                                        password = '".MD5($pass1)."'
                                        WHERE admin_id = '".$d->admin_id."' ");
                            if($u_pass){
                                echo '<script>alert("Ubah Data Berhasil")</script>';
                                echo '<script>window.location="profil.php"</script>';
                            }else{
                                echo 'Gagal ' .mysqli_error($conn);
                            }
                        }
                    }
                ?>
            </div>
        </div>
    </div>

    <!--footer-->
    <footer>
        <div class="container">
            <small>Copyright &copy; 2026 - PeduliSaran.</small>
        </div>
    </footer>
</body>
</html>