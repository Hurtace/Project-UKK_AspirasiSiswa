<?php
    session_name("pedulisaran_session");
    session_start();
    require '../db.php';
    if($_SESSION['status_login'] != true || $_SESSION['role'] != 'admin'){
        echo '<script>window.location="../login.php"</script>';
    }

    $kategori = mysqli_query($conn, "SELECT * FROM tb_kategori WHERE id_kategori = '".$_GET['id']."' ");
    if(mysqli_num_rows($kategori) == 0){
        echo '<script>window.location="../data-kategori.php"</script>';
    }
    $k = mysqli_fetch_object($kategori);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori | PeduliSaran</title>
    <link rel="stylesheet" type="text/css" href="../assets/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,
        600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
</head>
<body>
    <!--header-->
    <header>
        <div class="container">
            <h1><a href="../dashboard.php">PeduliSaran</a></h1>
            <ul>
                <li><a href="../dashboard.php">Admin Dashboard</a></li>
                <li><a href="../profil.php">Admin Profile</a></li>
                <li><a href="../data-kategori.php">Data Kategori</a></li>
                <li><a href="../data-aspirasi.php">Data Aspirasi</a></li>
                <li><a href="../keluar.php">keluar</a></li>
            </ul>
        </div>
    </header>

    <!--content-->
    <div class="section">
        <div class="container">
            <h3>Edit Data Kategori</h3>
            <div class="box">
                <form action="" method="POST">
                    <input type="text" name="nama" placeholder="Nama Kategori" class="input-control" value="<?php echo $k->nama_kategori ?>" required>
                    <textarea class ="input-control" name="ket" placeholder="Deskripsi" style="margin-bottom: 10px;"><?php echo $k->ket_kategori ?></textarea><br><br>
                    <input type="submit" name="submit" value="Submit" class="btn">
                </form>
                <?php 
                    if(isset($_POST['submit'])){
                        $nama = ucwords($_POST['nama']);
                        $update = mysqli_query($conn, "UPDATE tb_kategori SET 
                                                                    nama_kategori = '".$nama."',
                                                                    ket_kategori = '".$ket."'
                                                                    WHERE id_kategori = '".$k->id_kategori."' ");

                        if($update){
                            echo '<script>alert("Edit Data Berhasil")</script>';
                            echo '<script>window.location="../data-kategori.php"</script>';
                        }else{
                            echo 'Gagal '.mysqli_error($conn);
                        }
                    }
                
                ?>
            </div>
        </div>
    </div>

    <!--footer-->
    <footer>
        <div class="container">
            <small>Copyright &copy; 2020 - Bukawarung.</small>
        </div>
    </footer>

    <script>
        CKEDITOR.replace( 'ket' );
    </script>
</body>
</html>