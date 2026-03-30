<?php
    session_name("pedulisaran_session");
    session_start();
    require 'db.php';
    if($_SESSION['status_login'] != true || $_SESSION['role'] != 'admin'){
        echo '<script>window.location="login.php"</script>';
    }
    $totalaspirasi = $conn->query("SELECT COUNT(*) FROM tb_input_aspirasi")->fetch_row()[0];
    $today = date('Y-m-d');
    $totalhariini = $conn->query("SELECT COUNT(*) FROM tb_input_aspirasi WHERE DATE(waktu_pelaporan)='$today'")->fetch_row()[0];
    $totalproses = $conn->query("SELECT COUNT(*) FROM tb_aspirasi WHERE status_aspirasi='proses'")->fetch_row()[0];
    $totalterlaksana = $conn->query("SELECT COUNT(*) FROM tb_aspirasi WHERE status_aspirasi='selesai'")->fetch_row()[0];
    $recent = $conn->query("SELECT tb_input_aspirasi.id_pelaporan, 
                                            tb_siswa.nama_siswa, 
                                            tb_input_aspirasi.ket, 
                                            tb_input_aspirasi.waktu_pelaporan, 
                                            tb_aspirasi.status_aspirasi 
                                        FROM tb_input_aspirasi
                                        JOIN tb_siswa
                                            ON tb_input_aspirasi.nis = tb_siswa.nis 
                                        LEFT JOIN tb_aspirasi 
                                            ON tb_input_aspirasi.id_pelaporan = tb_aspirasi.id_pelaporan 
                                        ORDER BY tb_input_aspirasi.waktu_pelaporan DESC LIMIT 10");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | PeduliSaran</title>
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
            <div id="page-dashboard">
                <div class="stats-grid">
                    <div class="stat-card gold">
                        <div class="stat-label">Total Aspirasi</div>
                        <div class="stat-value" id="stat-aspirasi"><?= $totalaspirasi ?></div>
                    </div>
                    <div class="stat-card sage">
                        <div class="stat-label">Jumlah Aspirasi Hari Ini</div>
                        <div class="stat-value" id="stat-hari"><?= $totalhariini ?></div>
                    </div>
                    <div class="stat-card ink">
                        <div class="stat-label">Aspirasi Di Proses</div>
                        <div class="stat-value" id="stat-kategori"><?= $totalproses ?></div>
                    </div>
                    <div class="stat-card rust">
                        <div class="stat-label">Aspirasi Terlaksana</div>
                        <div class="stat-value" id="stat-selesai"><?= $totalterlaksana ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-header">
            <div>
                <h3>Aspirasi</h3>
                <p>10 aspirasi terakhir yang dicatat</p>
            </div>
        </div>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pengirim</th>
                        <th>Aspirasi</th>
                        <th>Waktu</th>
                        <th>Status</th>
                        <th width ="150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; while($row = $recent->fetch_assoc()){ ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['nama_siswa'] ?></td>
                        <td><?= $row['ket'] ?></td>
                        <td><?= $row['waktu_pelaporan'] ?></td>
                        <td><?php
                            $status = $row['status_aspirasi'] ?? 'Menunggu';
                                if($status == 'Menunggu'){
                                    echo "<span class='badge warning'>Menunggu</span>";
                                } elseif($status == 'Proses'){
                                    echo "<span class='badge process'>Proses</span>";
                                } elseif($status == 'Selesai'){
                                    echo "<span class='badge success'>Selesai</span>";
                                }
                            ?>
                        </td>
                        <td>
                            <a href="CRUD/tanggapi.php?id=<?= $row['id_pelaporan'] ?>">
                                🔄 Tanggapi
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!--footer-->
    <div class="footer">
        <div class="container">
            <small>Copyright &copy; 2026 - PeduliSaran.</small>
        </div>
     </div>
</body>
</html>