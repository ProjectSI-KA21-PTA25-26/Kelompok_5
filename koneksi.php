<?php
$host = "sql111.infinityfree.com";
$user = "if0_40931364";
$pass = "SIpPUxCfqNAml";
$db   = "if0_40931364_kiosqu";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if(!$koneksi){
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>