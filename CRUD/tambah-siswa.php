<?php
    require '../db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | PeduliSaran</title>
    <link rel="stylesheet" type="text/css" href="../assets/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,
        600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body id="bg-login">
    <div class="box-login">
        <img src="../assets/SMK .png">
        <h2>Daftar Siswa</h2>
        <form method="POST">
            <input type="text" name="nis" placeholder="NIS" class="input-control" required>
            <input type="text" name="nama" placeholder="Nama Siswa" class="input-control" required>
            <input type="text" name="kelas" placeholder="Kelas" class="input-control" required>
            <input type="password" name="pass" placeholder="Password" class="input-control" required>
            <input type="submit" name="submit" value="Tambah Siswa" class="btn-login">
            <p style="margin-top:20px;">
                <a href="../login.php">Kembali Ke Halaman Login</a>
            </p>
        </form>
        <?php
           if(isset($_POST['submit'])){
                $nis   = $_POST['nis'];
                $nama  = $_POST['nama'];
                $kelas = $_POST['kelas'];
                $pass  = md5($_POST['pass']);

                $insert = mysqli_query($conn,"INSERT INTO tb_siswa 
                (nis,nama_siswa,kelas,password) 
                VALUES ('$nis','$nama','$kelas','$pass')");

                if($insert){
                    echo "<script>alert('Siswa berhasil ditambahkan')</script>";
                }else{
                    echo "<script>alert('Gagal menambah siswa')</script>";
                }
            }
        ?>
    </div>
</body>
</html>