<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../login.php");
  exit;
}

/* ======================
   AMBIL SEMUA KIOS
   ====================== */
$kios_q = mysqli_query($koneksi, "
  SELECT id_kios, nama_kios, alamat, foto
  FROM kios
  ORDER BY id_kios ASC
");

$kios = [];
while ($row = mysqli_fetch_assoc($kios_q)) {
  $kios[] = $row;
}

/* INDEX SLIDER */
$index = isset($_GET['i']) ? (int)$_GET['i'] : 0;
$index = max(0, min($index, count($kios) - 1));

$k = $kios[$index];

/* ======================
   CEK SEWA AKTIF (SUMBER STATUS)
   ====================== */
$sewa_q = mysqli_query($koneksi, "
  SELECT 
    s.*,
    u.nama AS nama_penyewa,
    u.no_hp
  FROM sewa s
  LEFT JOIN users u ON s.user_id = u.id
  WHERE s.kios_id = '{$k['id_kios']}'
    AND s.tanggal_selesai >= CURDATE()
  ORDER BY s.id_sewa DESC
  LIMIT 1
");

$sewa = mysqli_fetch_assoc($sewa_q);
// ===== AUTO RESET JIKA SEWA SUDAH HABIS =====
if ($sewa && $sewa['tanggal_selesai'] < date('Y-m-d')) {

  mysqli_query($koneksi, "
    UPDATE kios
    SET status_kios = 'Tersedia'
    WHERE id_kios = '{$k['id_kios']}'
  ");

  // reset supaya dianggap tidak tersewa
  $sewa = null;
}


/* ===== DEFAULT (TERSEDIA) ===== */
$status = 'Tersedia'; 
$pembayaran   = '-';
$nama_penyewa = '-';
$no_hp        = '-';
$pbb          = '-';
$air          = '-';
$listrik      = '-';

/* ===== JIKA TERSEWA ===== */
if ($sewa) {
  $status       = 'Tersewa';
  $pembayaran   = $sewa['status_pembayaran'] ?: '-';
  $nama_penyewa = $sewa['nama_penyewa'] ?: '-';
  $no_hp        = $sewa['no_hp'] ?: '-';
  $pbb          = $sewa['pbb'] ? '✓' : '-';
  $air          = $sewa['air'] ? '✓' : '-';
  $listrik      = $sewa['listrik'] ? '✓' : '-';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Informasi Kios</title>

<style>
/* ===== RESET ===== */
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family:'Segoe UI', Arial, sans-serif;
}

body{
  background:#b9dbff;
  display:flex;
}

/* ===== SIDEBAR (TIDAK DIUBAH) ===== */
.sidebar{
  width:340px;
  background:#2f2f2f;
  color:#fff;
  padding:40px 30px;
  height:100vh;
  position:fixed;
}

.sidebar h1{
  font-size:42px;
  font-weight:900;
}

.sidebar h1 span{ color:#d6a4ff; }

.admin-info{
  margin-top:20px;
  font-size:14px;
  color:#ddd;
}

.divider{
  height:3px;
  background:#cbd5e1;
  margin:30px 0;
}

.sidebar a{
  display:block;
  color:#fff;
  text-decoration:none;
  padding:16px 22px;
  border-radius:30px;
  margin-bottom:14px;
  font-size:18px;
}

.sidebar a.active,
.sidebar a:hover{
  background:#555;
}

/* ===== CONTENT ===== */
.content{
  margin-left:340px;
  width:100%;
  position:relative;
  padding-top:40px;
}

/* ===== SLIDER ===== */
.slider-top{
  position:absolute;
  top:60px;
  left:0;
  right:0;
  padding:0 100px;
  display:flex;
  justify-content:space-between;
  font-size:20px;
  font-weight:700;
}

.slider-top a{
  text-decoration:none;
  color:#000;
}

/* ===== CARD ===== */
.card-wrapper{
  display:flex;
  justify-content:center;
  margin-top:120px;
}

.kios-card{
  background:#fff;
  width:520px;
  padding:40px;
  border-radius:32px;
  box-shadow:0 14px 30px rgba(0,0,0,0.15);
}

.kios-img{
  width:100%;
  height:260px;
  object-fit:cover;
  border-radius:24px;
  margin-bottom:22px;
}

.kios-card h2{
  font-size:26px;
  margin-bottom:16px;
  text-align:center;
}

.kios-info{
  font-size:15px;
  line-height:1.7;
}

.kios-info ul{
  padding-left:20px;
}

.btn-group{
  display:flex;
  justify-content:space-between;
  margin-top:34px;
}

.btn{
  background:#0b1d51;
  color:#fff;
  padding:12px 40px;
  border-radius:12px;
  text-decoration:none;
  font-weight:600;
}
</style>
</head>

<body>

<div class="sidebar">
  <h1>Kios<span>Qu</span></h1>
  <div class="admin-info">Admin<br><?= htmlspecialchars($_SESSION['email']) ?></div>
  <div class="divider"></div>

  <a href="dashboard.php">Dashboard</a>
  <a href="informasi_kios.php" class="active">Informasi Kios</a>
  <a href="tambah_kios.php">Tambah Kios</a>
  <a href="pengaturan_admin.php">Pengaturan</a>
  <a href="../logout.php">Logout</a>
</div>

<div class="content">

  <div class="slider-top">
    <div>
      <?php if ($index > 0): ?>
        <a href="?i=<?= $index-1 ?>">&lt; <?= $kios[$index-1]['nama_kios'] ?></a>
      <?php endif; ?>
    </div>
    <div>
      <?php if ($index < count($kios)-1): ?>
        <a href="?i=<?= $index+1 ?>"><?= $kios[$index+1]['nama_kios'] ?> &gt;</a>
      <?php endif; ?>
    </div>
  </div>

  <div class="card-wrapper">
    <div class="kios-card">

      <img src="../img/<?= htmlspecialchars($k['foto']) ?>" class="kios-img">
      <h2><?= htmlspecialchars($k['nama_kios']) ?></h2>

      <div class="kios-info">
        <p><b>Alamat:</b> <?= htmlspecialchars($k['alamat']) ?></p>
        <p><b>Status:</b> <?= $status ?></p>
        <p><b>Pembayaran sewa:</b> <?= $pembayaran ?></p>
        <p><b>Nama penyewa:</b> <?= htmlspecialchars($nama_penyewa) ?></p>
        <p><b>No HP:</b> <?= htmlspecialchars($no_hp) ?></p>

        <p><b>Status utilitas:</b></p>
        <ul>
          <li>PBB: <?= $pbb ?></li>
          <li>Air: <?= $air ?></li>
          <li>Listrik: <?= $listrik ?></li>
        </ul>
      </div>

      <div class="btn-group">
        <a href="edit_kios.php?id=<?= $k['id_kios'] ?>" class="btn">Edit</a>

        <?php if ($status === 'Tersedia'): ?>
          <a href="hapus_kios.php?id_kios=<?= $k['id_kios'] ?>"
             class="btn"
             onclick="return confirm('Yakin hapus kios ini?')">
             Hapus
          </a>
        <?php else: ?>
          <span class="btn" style="opacity:.5;cursor:not-allowed">Hapus</span>
        <?php endif; ?>
      </div>

    </div>
  </div>

</div>

</body>
</html>
