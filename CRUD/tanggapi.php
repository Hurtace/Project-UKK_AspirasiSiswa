<?php
    session_name("pedulisaran_session");
    session_start();
    require '../db.php';

    if($_SESSION['status_login'] != true || $_SESSION['role'] != 'admin'){
        echo '<script>window.location="../login.php"</script>';
        exit;
    }

    $aspirasi = mysqli_query($conn, "SELECT * FROM tb_aspirasi WHERE id_pelaporan = '".$_GET['id']."' ");
    $id = mysqli_real_escape_string($conn, $_GET['id']);
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
            <h3>💬 Tanggapi Pengaduan</h3>
            <div class="box">
                <?php 
                    $data = $conn->query("SELECT 
                            tb_input_aspirasi.*, 
                            tb_siswa.nama_siswa,
                            tb_siswa.kelas,
                            tb_kategori.nama_kategori,
                            tb_aspirasi.status_aspirasi,
                            tb_aspirasi.feedback
                        FROM tb_input_aspirasi
                        JOIN tb_siswa ON tb_input_aspirasi.nis = tb_siswa.nis
                        JOIN tb_kategori ON tb_input_aspirasi.id_kategori = tb_kategori.id_kategori
                        LEFT JOIN tb_aspirasi ON tb_input_aspirasi.id_pelaporan = tb_aspirasi.id_pelaporan
                        WHERE tb_input_aspirasi.id_pelaporan = $id
                    ")->fetch_assoc();

                    if(isset($_POST['kirim'])){
                        $status   = mysqli_real_escape_string($conn, $_POST['status']);
                        $feedback = mysqli_real_escape_string($conn, $_POST['feedback']);

                        // cek apakah sudah ada data di tb_aspirasi
                        $cek = $conn->query("SELECT * FROM tb_aspirasi WHERE id_pelaporan='$id'");

                        if($cek->num_rows > 0){
                            $conn->query("
                                UPDATE tb_aspirasi 
                                SET status_aspirasi='$status', feedback='$feedback'
                                WHERE id_pelaporan='$id'
                            ");
                        } else {
                            $conn->query("
                                INSERT INTO tb_aspirasi (id_pelaporan, status_aspirasi, feedback)
                                VALUES ('$id','$status','$feedback')
                            ");
                        }
                        echo "<script>alert('Tanggapan berhasil disimpan'); window.location='../data-aspirasi.php';</script>";
                    }
                ?>
                <div class="detail-row">
                    <div class="label">NIS</div>
                    <div><?= $data['nis']; ?></div>
                </div>

                <div class="detail-row">
                    <div class="label">Nama</div>
                    <div><?= $data['nama_siswa']; ?></div>
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
                            } else {
                                echo "<span class='badge warning'>Menunggu</span>";
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

                <div class="pengaduan-box">
                    <?= $data['ket']; ?>
                </div>

                <form method="POST">
                    <h3>💬 Feedback</h3>
                    <br>
                    <select name="status" class="input-control">
                        <option value="Menunggu" <?= ($status=='Menunggu')?'selected':'' ?>>Menunggu</option>
                        <option value="Proses" <?= ($status=='Proses')?'selected':'' ?>>Proses</option>
                        <option value="Selesai" <?= ($status=='Selesai')?'selected':'' ?>>Selesai</option>
                    </select>

                    <textarea name="feedback" class="input-control" placeholder="Masukan Feedback"><?= $data['feedback'] ?? '' ?></textarea>

                    <button type="submit" name="kirim" class="btn-green">💾 KIRIM</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>