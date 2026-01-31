<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'penyewa') {
  header("Location: login.php");
  exit;
}

$user_id = $_SESSION['id'];

/* ======================
   AMBIL SEWA TERAKHIR USER
   ====================== */
$q = mysqli_query($koneksi, "
  SELECT 
    s.*,
    k.nama_kios,
    k.alamat,
    k.foto
  FROM sewa s
  JOIN kios k ON s.kios_id = k.id_kios
  WHERE s.user_id = '$user_id'
    AND s.tanggal_selesai >= CURDATE()
  ORDER BY s.id_sewa DESC
  LIMIT 1
");

$sewa = mysqli_fetch_assoc($q);

/* STATUS */
$aktif = $sewa ? true : false;


?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Informasi Kios</title>

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
  width:800px;
  height:900px;
  background:#fff;
  border-radius:30px;
  padding:34px;
  box-shadow:0 20px 45px rgba(0,0,0,0.18);
}

.card img{
  width:100%;
  height:450px;
  object-fit:unset;
  border-radius:22px;
  margin-bottom:10px;
}

.card h2{
  text-align:center;
  font-size:43px;
  margin-bottom:24px;
}

.info{
  font-size:22px;
  line-height:1.8;
}

.info b{
  font-weight:600;
}

.info ul{
  margin-top:8px;
  padding-left:22px;
}

.info ul li{
  margin-bottom:6px;
}

.logo-link{
  text-decoration:none;
  color:inherit;
}

/* ===== EMPTY STATE ===== */
.card.empty{
  display:flex;
  justify-content:center;   /* tengah horizontal */
  align-items:center;       /* tengah vertikal */
  height:800px;             /* tinggi card konsisten */
}

.empty-text{
  font-size:46px;
  font-weight:800;
  color:#777;
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
    <a href="informasi.php" class="active">Informasi Kios</a>
    <a href="pembayaran.php">Pembayaran</a>
    <a href="pengaturan.php">Pengaturan</a>
    <a href="logout.php">Logout</a>
  </div>
</div>

<!-- CONTENT -->
<div class="content">

<?php if (!$aktif): ?>
  <div class="card empty">
    <div class="empty-text"> -Tidak ada informasi- </div>
  </div>

<?php else: ?>
  <div class="card">
    <img src="img/<?= htmlspecialchars($sewa['foto']) ?>">
    <h2><?= htmlspecialchars($sewa['nama_kios']) ?></h2>

    <div class="info">
      <p><b>Alamat:</b> <?= htmlspecialchars($sewa['alamat']) ?></p>

      <p><b>Tanggal sewa:</b>
        <?= $sewa['tanggal_mulai'] ?> s/d <?= $sewa['tanggal_selesai'] ?>
      </p>

      <p><b>Status pembayaran:</b> <?= $sewa['status_pembayaran'] ?></p>

    <ul>
      <li>PBB: <?= $sewa['pbb'] ? '✓' : '-' ?></li>
      <li>Air: <?= $sewa['air'] ? '✓' : '-' ?></li>
      <li>Listrik: <?= $sewa['listrik'] ? '✓' : '-' ?></li>
    </ul>
  </div>
<?php endif; ?>

</div>

</body>
</html>
