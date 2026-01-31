<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['login'])){
  header("Location: login.php");
  exit;
}

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
  header("Location: index.php");
  exit;
}

$id_kios = (int)$_GET['id'];

/* Tambah peminat */
mysqli_query($koneksi, "
  UPDATE kios
  SET jumlah_peminat = jumlah_peminat + 1
  WHERE id_kios = $id_kios
");

/* Redirect ke WhatsApp */
$no_admin = "6281234567890";
$pesan = urlencode("Halo Admin, saya tertarik menyewa kios.");
header("Location: https://wa.me/$no_admin?text=$pesan");
exit;
