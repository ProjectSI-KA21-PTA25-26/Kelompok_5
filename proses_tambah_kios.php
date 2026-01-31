<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin'){
  header("Location: ../login.php");
  exit;
}

/* ======================
   AMBIL DATA FORM
   ====================== */
$nama_kios   = mysqli_real_escape_string($koneksi, $_POST['nama_kios']);
$alamat      = mysqli_real_escape_string($koneksi, $_POST['alamat']);
$maps        = mysqli_real_escape_string($koneksi, $_POST['maps']);
$fasilitas   = mysqli_real_escape_string($koneksi, $_POST['fasilitas']);
$jenis_kios  = mysqli_real_escape_string($koneksi, $_POST['jenis_kios']);
$ukuran      = mysqli_real_escape_string($koneksi, $_POST['ukuran']);
$lingkungan  = mysqli_real_escape_string($koneksi, $_POST['lingkungan']);
$status_kios = mysqli_real_escape_string($koneksi, $_POST['status_kios']);

/* ======================
   UPLOAD FOTO
   ====================== */
$foto = $_FILES['foto']['name'];
$tmp  = $_FILES['foto']['tmp_name'];

$ext = pathinfo($foto, PATHINFO_EXTENSION);
$nama_foto_baru = uniqid('kios_').'.'.$ext;

$folder = "../img/";
move_uploaded_file($tmp, $folder.$nama_foto_baru);

/* ======================
   INSERT DATABASE
   ====================== */
$query = mysqli_query($koneksi, "
  INSERT INTO kios (
    nama_kios,
    alamat,
    foto,
    maps,
    fasilitas,
    jenis_kios,
    ukuran,
    lingkungan,
    status_kios
  ) VALUES (
    '$nama_kios',
    '$alamat',
    '$nama_foto_baru',
    '$maps',
    '$fasilitas',
    '$jenis_kios',
    '$ukuran',
    '$lingkungan',
    '$status_kios'
  )
");

if($query){
  header("Location: informasi_kios.php?success=1");
} else {
  echo "Gagal menambahkan kios";
}
