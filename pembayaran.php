<?php
session_start();
include 'koneksi.php';
function tgl($date){
  return date('d M Y', strtotime($date));
}

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'penyewa') {
  header("Location: login.php");
  exit;
}

$user_id   = $_SESSION['id'];
$nama_user = $_SESSION['nama'];

/* =========================
   NOMOR ADMIN
   ========================= */
$no_admin = "6281234567890"; // GANTI nomor admin

/* =========================
   CEK SEWA TERAKHIR USER
   ========================= */
$sewa_q = mysqli_query($koneksi, "
  SELECT 
    s.*,
    k.nama_kios
  FROM sewa s
  JOIN kios k ON s.kios_id = k.id_kios
  WHERE s.user_id = '$user_id'
    AND s.tanggal_selesai >= CURDATE()
  ORDER BY s.id_sewa DESC
  LIMIT 1
");

$sewa = mysqli_fetch_assoc($sewa_q);

/* DEFAULT */
$punya_sewa = false;
$nama_kios  = "-";

/* JIKA ADA SEWA AKTIF */
if ($sewa) {
  $punya_sewa = true;
  $nama_kios  = $sewa['nama_kios'];

  $pesan_wa = urlencode(
    "Halo Admin, saya ingin memperpanjang sewa kios.\n".
    "Nama Kios: $nama_kios\n".
    "Atas Nama: $nama_user"
  );
} else {
  // ❌ TIDAK ADA SEWA AKTIF (expired / belum pernah)
  $pesan_wa = urlencode(
    "Halo Admin, saya tertarik menyewa kios.\n".
    "Nama: $nama_user"
  );
}

$link_wa = "https://wa.me/$no_admin?text=$pesan_wa";

?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pembayaran - KiosQu</title>

<style>
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family:'Segoe UI', Arial, sans-serif;
}

body{
  display:flex;
  min-height:100vh;
  background:#b9dbff;
}

/* ================= SIDEBAR ================= */
.sidebar{
  width:340px;
  background:#2f2f2f;
  color:#fff;
  padding:50px 30px 40px;
  display:flex;
  flex-direction:column;
}

.logo-link{
  text-decoration:none;
  color:inherit;
}

.logo{
  font-size:48px;
  font-weight:900;
  margin-bottom:18px;
}

.logo span{
  color:#d6a4ff;
}

.user-role{
  font-size:20px;
  margin-bottom:6px;
}

.user-email{
  font-size:15px;
  color:#d0d0d0;
}

.divider{
  height:4px;
  background:#8f8f8f;
  margin:28px 0;
}

.menu{
  flex:1;
}

.menu a{
  display:block;
  padding:18px 26px;
  margin-bottom:18px;
  border-radius:32px;
  color:#fff;
  text-decoration:none;
  font-size:20px;
  transition:0.25s;
}

.menu a.active,
.menu a:hover{
  background:#6b6b6b;
}

/* ================= CONTENT ================= */
.content{
  flex:1;
  display:flex;
  justify-content:center;
  align-items:center;
  padding:40px;
}

/* ================= CARD ================= */
.card{
  width:700px;
  height:500px;
  background:#fff;
  padding:50px 55px;
  border-radius:30px;
  box-shadow:0 20px 45px rgba(0,0,0,0.18);
}

.card.empty{
  width:800px;
  height:800px;
  display:flex;
  justify-content:center;     /* tengah vertikal */
  align-items:center;         /* tengah horizontal */
  background:#fff;
  border-radius:30px;
  box-shadow:0 20px 45px rgba(0,0,0,0.18);
}

/* wrapper isi empty */
.empty-content{
  display:flex;
  flex-direction:column;      /* ⬅️ INI KUNCI */
  align-items:center;
  gap:20px;                   /* jarak teks & button */
}

.empty-text{
  font-size:46px;
  font-weight:800;
  color:#777;
}


/* TEXT */
.card h2{
  font-size:30px;
  margin-bottom:10px;
}

.card p{
  font-size:20px;
  margin-bottom:50px;
}

/* BUTTON WA */
.btn-wa{
  display:inline-flex;
  justify-content:center;
  align-items:center;
  padding:20px 44px;
  font-size:20px;
  font-weight:600;
  background:#e0e0e0;
  color:#000;
  border-radius:36px;
  text-decoration:none;
  transition:.25s;
}

.btn-wa:hover{
  background:#25D366;
  color:#fff;
}

.btn-wa:hover span{
  display:none;
}

.btn-wa:hover::after{
  content:"WhatsApp";
  font-size:20px;
  font-weight:700;
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
  <a href="index.php" class="logo-link">
    <div class="logo">Kios<span>Qu</span></div>
  </a>

  <div class="user-role">Penyewa</div>
  <div class="user-email"><?= htmlspecialchars($_SESSION['email']); ?></div>

  <div class="divider"></div>

  <div class="menu">
    <a href="informasi.php">Informasi Kios</a>
    <a href="pembayaran.php" class="active">Pembayaran</a>
    <a href="pengaturan.php">Pengaturan</a>
    <a href="logout.php">Logout</a>
  </div>
</div>

<!-- CONTENT -->
<div class="content">

<?php if ($punya_sewa): ?>
  <div class="card">
    <h2><?= htmlspecialchars($nama_kios) ?></h2>

    <p><b>Status:</b> Tersewa</p>

    <p><b>Tanggal sewa:</b><br>
      <?= tgl($sewa['tanggal_mulai']) ?> s/d <?= tgl($sewa['tanggal_selesai']) ?>
    </p>

    <a href="<?= $link_wa ?>" target="_blank" class="btn-wa">
      <span>Perpanjang via</span>
    </a>
  </div>

<?php else: ?>
  <div class="card empty">
    <div class="empty-content">
      <div class="empty-text"> -Tidak ada informasi- </div>

      <a href="<?= $link_wa ?>" target="_blank" class="btn-wa">
        <span>Pesan kios</span>
      </a>
    </div>
  </div>
<?php endif; ?>


