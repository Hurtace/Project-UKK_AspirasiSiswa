<?php
    session_name("pedulisaran_session");
    session_start();
    require 'db.php';
    if($_SESSION['status_login'] != true || $_SESSION['role'] != 'admin'){
        echo '<script>window.location="login.php"</script>';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kategori | PeduliSaran</title>
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
            <h3>Data Kategori</h3>
            <div class="box">
                <div class="action-bar">
                    <a href="CRUD/tambah-kategori.php" class="btn-add">Tambah Kategori</a>
                </div>
                <table border= "1" cellspacing= "0" class="table">
                    <thead>
                        <tr>
                            <th width ="60px">No</th> 
                            <th>Kategori</th>
                            <th width ="150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no = 1;
                            $kategori = mysqli_query($conn, "SELECT * FROM tb_kategori ORDER BY id_kategori DESC");
                            if(mysqli_num_rows($kategori) > 0){
                           while($row = mysqli_fetch_array($kategori)){
                        ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $row['nama_kategori'] ?></td>
                            <td>
                                <a href="CRUD/edit-kategori.php?id=<?php echo $row['id_kategori'] ?>">Edit</a> || 
                                <a href="CRUD/proses-hapus.php?idk=<?php echo $row['id_kategori'] ?>" onclick="return confirm('Yakin ingin hapus ?')">Hapus</a>
                            </td>
                        </tr>
                        <?php }}else{ ?>
                            <tr>
                                <td colspan = "3">Tidak Ada Data</td>
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