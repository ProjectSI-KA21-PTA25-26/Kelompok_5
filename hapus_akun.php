<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}

$user_id = $_SESSION['id'];

/* ======================
   CEK SEWA AKTIF
   ====================== */
$cek = mysqli_query($koneksi, "
  SELECT 1
  FROM sewa
  WHERE user_id = '$user_id'
    AND tanggal_selesai >= CURDATE()
  LIMIT 1
");

$sewa_aktif = mysqli_num_rows($cek) > 0;

/* ======================
   JIKA ADA SEWA AKTIF
   ====================== */
if ($sewa_aktif) {
  // ❌ TIDAK UPDATE STATUS APAPUN
  // ❌ TIDAK SENTUH TABEL SEWA
  // CUKUP LANJUT HAPUS AKUN
}

/* ======================
   HAPUS USER
   ====================== */
mysqli_query($koneksi, "
  DELETE FROM users
  WHERE id = '$user_id'
");

/* ======================
   LOGOUT
   ====================== */
session_destroy();
header("Location: index.php");
exit;
