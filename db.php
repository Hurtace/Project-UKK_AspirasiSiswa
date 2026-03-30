<?php
    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'db_pedulisaran';

    $conn = mysqli_connect($hostname, $username, $password, $dbname) or die ('Gagal Menghubungkan Ke Database');
?>