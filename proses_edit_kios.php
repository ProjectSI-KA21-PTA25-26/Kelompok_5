<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../login.php");
  exit;
}

$id_kios           = $_POST['id_kios'];
$user_id           = $_POST['user_id'];        // penyewa
$no_hp             = $_POST['no_hp'];
$tanggal_mulai   = $_POST['tanggal_mulai'];
$tanggal_selesai = $_POST['tanggal_selesai'];
$status_pembayaran = $_POST['status_pembayaran'];
$pbb               = $_POST['pbb'];
$air               = $_POST['air'];
$listrik           = $_POST['listrik'];

/* ======================
   VALIDASI
====================== */
if (!$id_kios) {
  die("ID kios tidak ditemukan");
}

/* ======================
   UPDATE NO HP USER
====================== */
mysqli_query($koneksi, "
  UPDATE users 
  SET no_hp = '$no_hp'
  WHERE id = '$user_id'
");

/* ======================
   CEK APAKAH SUDAH ADA SEWA
====================== */
$cek = mysqli_query($koneksi, "
  SELECT id_sewa FROM sewa 
  WHERE kios_id = '$id_kios'
  LIMIT 1
");

if (mysqli_num_rows($cek) > 0) {

  // UPDATE SEWA (kalau sudah ada)
  mysqli_query($koneksi, "
    UPDATE sewa SET
      user_id = '$user_id',
      tanggal_mulai = '$tanggal_mulai',
      tanggal_selesai = '$tanggal_selesai',
      status_pembayaran = '$status_pembayaran',
      pbb = '$pbb',
      air = '$air',
      listrik = '$listrik'
    WHERE kios_id = '$id_kios'
  ");

} else {

  // ✅ INI TEMPAT INSERT (PERTAMA KALI SEWA)
  mysqli_query($koneksi, "
    INSERT INTO sewa (
      kios_id, user_id, tanggal_mulai, tanggal_selesai,
      status_pembayaran, pbb, air, listrik
    ) VALUES (
      '$id_kios', '$user_id', '$tanggal_mulai', '$tanggal_selesai',
      '$status_pembayaran', '$pbb', '$air', '$listrik'
    )
  ");
}


/* ======================
   UPDATE STATUS KIOS
====================== */
$hari_ini = date('Y-m-d');

if (!empty($tanggal_selesai) && $tanggal_selesai >= $hari_ini) {
  // ADA SEWA AKTIF
  mysqli_query($koneksi, "
    UPDATE kios
    SET status_kios = 'Tersewa'
    WHERE id_kios = '$kios_id'
  ");
} else {
  // SEWA HABIS / DIKOSONGKAN
  mysqli_query($koneksi, "
    UPDATE kios
    SET status_kios = 'Tersedia'
    WHERE id_kios = '$kios_id'
  ");
}

/* ======================
   REDIRECT
====================== */
header("Location: informasi_kios.php");
exit;
