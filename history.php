<?php
    session_name("pedulisaran_session");
    session_start();
    require 'db.php';
    if($_SESSION['status_login'] != true || $_SESSION['role'] != 'siswa'){
        echo '<script>window.location="login.php"</script>';
    }
    $nis = $_SESSION['nis'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Aspirasi | PeduliSaran</title>
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
            <h1><a href="index.php">PeduliSaran</a></h1>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="input-aspirasi.php">Berikan Aspirasi</a></li>
                <li><a href="history.php">History Aspirasi</a></li>
                <li><a href="keluar.php">keluar</a></li>
            </ul>
        </div>
    </header>

    <!--content-->
    <div class="section">
        <div class="container">
            <h3>Data Aspirasi</h3>
            <div class="box">
                <table border= "1" cellspacing= "0" class="table">
                    <thead>
                        <tr>
                            <th width ="60px">No</th> 
                            <th>Nama</th>
                            <th>Keterangan</th>
                            <th>Lokasi</th>
                            <th>Waktu</th>
                            <th>Status</th>
                            <th width ="150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no = 1;
                            $produk = mysqli_query($conn, "SELECT 
                                            tb_input_aspirasi.id_pelaporan, 
                                            tb_siswa.nama_siswa, 
                                            tb_input_aspirasi.lokasi, 
                                            tb_input_aspirasi.ket, 
                                            tb_input_aspirasi.waktu_pelaporan, 
                                            tb_aspirasi.status_aspirasi 
                                        FROM tb_input_aspirasi
                                        JOIN tb_siswa
                                            ON tb_input_aspirasi.nis = tb_siswa.nis 
                                        LEFT JOIN tb_aspirasi 
                                            ON tb_input_aspirasi.id_pelaporan = tb_aspirasi.id_pelaporan
                                        WHERE tb_input_aspirasi.nis = '$nis'
                                        ORDER BY tb_input_aspirasi.waktu_pelaporan DESC");
                            if(mysqli_num_rows($produk) > 0){
                           while($row = mysqli_fetch_array($produk)){
                        ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $row['nama_siswa'] ?></td>
                            <td><?php echo $row['ket'] ?></td>
                            <td><?php echo $row['lokasi'] ?></td>
                            <td><?php echo $row['waktu_pelaporan'] ?></td>
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
                            <a href="CRUD/tanggapan.php?id=<?php echo $row['id_pelaporan']; ?>">
                                🔄 Progres
                            </a>
                        </td>
                        </tr>
                        <?php }} else{ ?>
                            <tr>
                                <td colspan="7">Tidak ada data</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
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