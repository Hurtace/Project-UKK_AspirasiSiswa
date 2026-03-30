<?php
    session_name("pedulisaran_session");
    session_start();
    require '../db.php';

    if($_SESSION['status_login'] != true || $_SESSION['role'] != 'siswa'){
        echo '<script>window.location="../login.php"</script>'; 
    }
    $nis = $_SESSION['nis'];
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $aspirasi = mysqli_query($conn, "SELECT * FROM tb_aspirasi WHERE id_pelaporan = '$id' ");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Status Aspirasi | PeduliSaran</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <!--header-->
    <header>
        <div class="container">
           <h1><a href="../index.php">PeduliSaran</a></h1>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="../input-aspirasi.php">Berikan Aspirasi</a></li>
                <li><a href="../history.php">History Aspirasi</a></li>
                <li><a href="../keluar.php">keluar</a></li>
            </ul>
        </div>
    </header>

    <!--content-->
    <div class="section">
        <div class="container">
            <h3>💬 Informasi Pengaduan</h3>
            <div class="box">
                <?php 
                    $nis = $_SESSION['nis'];
                    $data = $conn->query("SELECT 
                        tb_input_aspirasi.*, 
                        tb_siswa.nama_siswa,
                        tb_siswa.kelas,
                        tb_kategori.nama_kategori,
                        tb_aspirasi.status_aspirasi,
                        tb_aspirasi.feedback
                    FROM tb_input_aspirasi
                    LEFT JOIN tb_siswa 
                        ON tb_input_aspirasi.nis = tb_siswa.nis
                    LEFT JOIN tb_kategori 
                        ON tb_input_aspirasi.id_kategori = tb_kategori.id_kategori
                    LEFT JOIN tb_aspirasi 
                        ON tb_input_aspirasi.id_pelaporan = tb_aspirasi.id_pelaporan
                    WHERE tb_input_aspirasi.id_pelaporan = '$id'
                    ")->fetch_assoc();
                ?>
                    <h2 class="title-center">
                        Data Pengaduan NIS <?= $data['nis']; ?>, 
                        Kelas <?= $data['kelas']; ?>
                    </h2>
                    <p class="sub-title">Aplikasi Pengaduan Sarana Sekolah</p>
                    <a href="../input-aspirasi.php" class="btn-blue">
                        ➕ Tambah Pengaduan
                    </a>
                    <hr>
                    <br>
                    <div class="detail-row">
                        <div class="label">NIS</div>
                        <div><?= $data['nis']; ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="label">Kelas</div>
                        <div><?= $data['kelas']; ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="label">Kategori Pengaduan</div>
                        <div><?= $data['nama_kategori']; ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="label">Status</div>
                    <div>
                        <?php 
                            $status = $data['status_aspirasi'] ?? 'Menunggu';
                            if($status == 'Selesai'){
                                    echo "<span class='badge success'>✔ Selesai</span>";
                            } elseif($status == 'Proses'){
                                echo "<span class='badge process'>Proses</span>";
                            }else{
                                echo "<span class='badge warning'>⏳ Menunggu</span>";
                            }
                        ?>
                    </div>
                </div>
                <div class="detail-row">
                    <div class="label">Lokasi</div>
                    <div><?= $data['lokasi']; ?></div>
                </div>
                <div class="detail-row">
                    <div class="label">Pengaduan</div>
                </div>
                <div class="box-aspirasi">
                    <?= $data['ket']; ?>
                </div>
                <div class="detail-row">
                    <div class="label">Pesan Admin</div>
                </div>
                <div class="box-aspirasi">
                    <?= $data['feedback']; ?>
                </div>
                <a href="../history.php" class="btn-yellow">
                    ⬅ Kembali
                </a>
            </div>
        </div>
    </div>
</body>
</html>