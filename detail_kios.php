<?php
session_start();
include 'koneksi.php';

/* ===== VALIDASI ID ===== */
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  die('Kios tidak ditemukan');
}

$id_kios = (int)$_GET['id'];

/* ===== HITUNG PENGUNJUNG ===== */
mysqli_query($koneksi, "
  UPDATE kios
  SET jumlah_pengunjung = jumlah_pengunjung + 1
  WHERE id_kios = $id_kios
");

/* ===== QUERY DATA KIOS ===== */
$q = mysqli_query($koneksi, "
  SELECT 
    nama_kios,
    alamat,
    foto,
    maps,
    fasilitas,
    jenis_kios,
    ukuran,
    lingkungan
  FROM kios
  WHERE id_kios = $id_kios
  LIMIT 1
");

$kios = mysqli_fetch_assoc($q);
if (!$kios) {
  die('Kios tidak ditemukan');
}

/* ===== DATA ===== */
$nama_kios = $kios['nama_kios'];
$alamat    = $kios['alamat'];
$foto      = $kios['foto'] ?: 'default.jpg';

/* ===== MAPS OTOMATIS ===== */
$maps_raw = trim($kios['maps']);
if (preg_match('/^https?:\/\//i', $maps_raw)) {
  $maps = $maps_raw;
} else {
  $maps = "https://www.google.com/maps/search/?api=1&query=" . urlencode($maps_raw);
}

$fasilitas = $kios['fasilitas'];
$jenis     = $kios['jenis_kios'];
$ukuran    = $kios['ukuran'];
$lingkungan= $kios['lingkungan'];

/* ===== WHATSAPP ===== */
$no_admin = "6281234567890";
$pesan_wa = urlencode(
  "Halo Admin, saya tertarik dengan kios:\n".
  "Nama: $nama_kios\n".
  "Alamat: $alamat"
);
$link_wa = "https://wa.me/$no_admin?text=$pesan_wa";
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($nama_kios) ?></title>

<style>
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family:'Segoe UI', Arial, sans-serif;
}

body{
  background:#b9dbff;
  min-height:100vh;
}

/* BACK */
.back{
  position:fixed;
  top:24px;
  left:32px;
  font-size:20px;
  font-weight:800;
  color:#111;
  text-decoration:none;
}

.back:hover{
  text-decoration:underline;
}

/* WRAPPER */
.wrapper{
  display:flex;
  justify-content:center;
  align-items:center;
  padding:90px 20px;
}

/* CARD */
.card{
  width:580px;
  background:#fff;
  border-radius:30px;
  padding:34px 36px 40px;
  box-shadow:0 20px 42px rgba(0,0,0,.18);
}

.card img{
  width:100%;
  height:260px;
  object-fit:cover;
  border-radius:22px;
  margin-bottom:20px;
}

.card h2{
  text-align:center;
  font-size:28px;
  margin-bottom:22px;
}

.info p{
  font-size:17px;
  line-height:1.65;
  margin-bottom:12px;
}

.maps a{
  color:#1a73e8;
  font-weight:600;
  text-decoration:none;
}

.maps a:hover{
  text-decoration:underline;
}

.minat{
  margin-top:34px;
  text-align:center;
  font-size:22px;
  font-weight:800;
}

.panah{
  text-align:center;
  font-size:30px;
  margin:8px 0 18px;
}

.btn-wa{
  display:flex;
  justify-content:center;
}

.btn-wa a{
  padding:16px 44px;
  font-size:18px;
  font-weight:700;
  border-radius:36px;
  background:#e0e0e0;
  color:#000;
  text-decoration:none;
  transition:.25s;
}

.btn-wa a:hover{
  background:#25D366;
  color:#fff;
}
</style>
</head>

<body>

<a href="index.php" class="back">&lt; Back</a>

<div class="wrapper">
  <div class="card">

    <img src="img/<?= htmlspecialchars($foto) ?>" alt="<?= htmlspecialchars($nama_kios) ?>">

    <h2><?= htmlspecialchars($nama_kios) ?></h2>

    <div class="info">
      <p><b>Alamat:</b> <?= htmlspecialchars($alamat) ?></p>

      <p class="maps">
        <b>Maps:</b>
        <a href="<?= $maps ?>" target="_blank">Lihat lokasi di Google Maps</a>
      </p>

      <p><b>Fasilitas:</b> <?= htmlspecialchars($fasilitas) ?></p>
      <p><b>Jenis Kios:</b> <?= htmlspecialchars($jenis) ?></p>
      <p><b>Ukuran Kios:</b> <?= htmlspecialchars($ukuran) ?></p>
      <p><b>Detail Lingkungan:</b> <?= htmlspecialchars($lingkungan) ?></p>
    </div>

    <div class="minat">Apakah Anda berminat?</div>
    <div class="panah">⬇</div>

    <div class="btn-wa">
      <?php if (isset($_SESSION['login'])): ?>
        <a href="track_peminat.php?id=<?= $id_kios ?>&wa=<?= urlencode($link_wa) ?>">
          Pesan via WhatsApp
        </a>
      <?php else: ?>
        <a href="login.php">Login untuk pesan</a>
      <?php endif; ?>
    </div>

  </div>
</div>

</body>
</html>
