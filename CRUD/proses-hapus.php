<?php
    require '../db.php';

    if(isset($_GET['idk'])){
        $delete = mysqli_query($conn, "DELETE FROM tb_kategori WHERE id_kategori = '".$_GET['idk']."' ");
        echo '<script>window.location="../data-kategori.php"</script>';
    }

    if(isset($_GET['ida'])){
        $id = mysqli_real_escape_string($conn, $_GET['ida']);

        mysqli_query($conn, "DELETE FROM tb_aspirasi WHERE id_pelaporan = '".$_GET['ida']."' ");
        mysqli_query($conn, "DELETE FROM tb_input_aspirasi WHERE id_pelaporan = '".$_GET['ida']."' ");

        echo '<script>alert("Data Berhasil Dihapus"); window.location="../data-aspirasi.php"</script>';
    }
?>