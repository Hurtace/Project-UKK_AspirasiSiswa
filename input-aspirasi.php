<?php
    session_name("pedulisaran_session");
    session_start();
    require 'db.php';

    if($_SESSION['status_login'] != true || $_SESSION['role'] != 'siswa'){
        echo '<script>window.location="login.php"</script>';
        exit;
    }
?>
<!DOCTYPE html>
    <html>
    <head>
        <title>Tambah Aspirasi | PeduliSaran</title>
        <link rel="stylesheet" href="assets/style.css">
        <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    </head>
    <body>

    <header>
        <div class="container">
            <h1><a href="index.php">PeduliSaran</a></h1>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="input-aspirasi.php">Berikan Aspirasi</a></li>
                <li><a href="history.php">History Aspirasi</a></li>
                <li><a href="keluar.php">keluar</a></li>
            </ul>
        </div>
    </header>

    <div class="section">
        <div class="container">
            <h3>Berikan Aspirasi</h3>
            <div class="box">
                <?php
                    $nis = $_SESSION['nis'];
                    $kategori = $conn->query("SELECT * FROM tb_kategori ORDER BY nama_kategori ASC");

                    if(isset($_POST['submit'])){
                        $id_kategori = $_POST['id_kategori'];
                        $lokasi      = htmlspecialchars($_POST['lokasi']);
                        $ket = mysqli_real_escape_string($conn, $_POST['ket']);

                        $insert = $conn->query("INSERT INTO tb_input_aspirasi (nis, id_kategori, lokasi, ket)
                            VALUES ('$nis', '$id_kategori', '$lokasi', '$ket')
                                ");

                        if($insert){
                            
                        

                            $conn->query("INSERT INTO tb_aspirasi (id_pelaporan, status_aspirasi)
                                VALUES ('$id_pelaporan', 'Menunggu')
                                ");
                            echo "<script>alert('Aspirasi berhasil dikirim!'); window.location='index.php';</script>";
                        }else{
                            echo "<script>alert('Gagal mengirim aspirasi!');</script>";
                        }
                    }
                ?>
                <form method="POST">
                        <select name="id_kategori" class="input-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php while($k = $kategori->fetch_assoc()){ ?>
                                <option value="<?= $k['id_kategori'] ?>">
                                    <?= $k['nama_kategori'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    <input type="text" name="lokasi" placeholder="Lokasi" class="input-control" required>
                    <textarea class ="input-control" name="ket" placeholder="Deskripsi" style="margin-bottom: 10px;"></textarea><br><br>
                    <input type="submit" name="submit" value="Kirim Aspirasi" class="btn">
                </form>
            </div>
        </div>
    </div>

        <script>
            CKEDITOR.replace( 'ket' );
        </script>
</body>
</html>