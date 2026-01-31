<?php
session_start();
include '../koneksi.php';

/* =====================
   CEK ADMIN
   ===================== */
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../login.php");
  exit;
}

/* =====================
   CEK ID KIOS
   ===================== */
if (!isset($_GET['id_kios'])) {
  echo "ID kios tidak ditemukan";
  exit;
}

$id_kios = (int)$_GET['id_kios'];

/* =====================
   HAPUS DATA SEWA TERKAIT
   ===================== */
mysqli_query($koneksi, "
  DELETE FROM sewa
  WHERE kios_id = '$id_kios'
");

/* =====================
   HAPUS KIOS
   ===================== */
mysqli_query($koneksi, "
  DELETE FROM kios
  WHERE id_kios = '$id_kios'
");

/* =====================
   REDIRECT
   ===================== */
header("Location: informasi_kios.php?msg=deleted");
exit;

