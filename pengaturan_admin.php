<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pengaturan Admin - KiosQu</title>

<style>
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

/* SIDEBAR */
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

.sidebar h1 span{
  color:#d6a4ff;
}

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

.sidebar a:hover,
.sidebar a.active{
  background:#555;
}

/* CONTENT */
.content{
  margin-left:340px;
  padding:50px;
  width:100%;
}

.content h2{
  font-size:34px;
  margin-bottom:30px;
}

/* CARD */
.card{
  background:#fff;
  border-radius:28px;
  padding:40px;
  max-width:900px;
  box-shadow:0 16px 35px rgba(0,0,0,0.15);
  margin-bottom:30px;
}

.card h3{
  font-size:22px;
  margin-bottom:18px;
}

.card p{
  font-size:16px;
  line-height:1.7;
  margin-bottom:10px;
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
  <h1>Kios<span>Qu</span></h1>

  <div class="admin-info">
    Admin<br>
    <?= htmlspecialchars($_SESSION['email']); ?>
  </div>

  <div class="divider"></div>

  <a href="dashboard.php">Dashboard</a>
  <a href="informasi_kios.php">Informasi Kios</a>
  <a href="tambah_kios.php">Tambah Kios</a>
  <a href="pengaturan_admin.php" class="active">Pengaturan</a>
  <a href="../logout.php">Logout</a>
</div>

<!-- CONTENT -->
<div class="content">
  <h2>Info Pengaturan</h2>

  <div class="card">
    <h3>Profil Admin</h3>
    <p><b>Email:</b> <?= htmlspecialchars($_SESSION['email']); ?></p>
    <p><b>Role:</b> Administrator</p>
  </div>

  <div class="card">
    <h3>Kontak Admin</h3>
    <p><b>WhatsApp:</b> 6281234567890</p>
    <p><b>Jam Operasional:</b> 08.00 – 17.00 WIB</p>
  </div>

  <div class="card">
    <h3>Aturan Penyewaan</h3>
    <p>- Pembayaran dilakukan sebelum masa sewa dimulai.</p>
    <p>- Perpanjangan sewa wajib dilakukan sebelum tanggal berakhir.</p>
    <p>- Pembatalan sewa tidak dapat dikembalikan.</p>
  </div>

  <div class="card">
    <h3>Informasi Aplikasi</h3>
    <p><b>Nama Aplikasi:</b> KiosQu</p>
    <p><b>Versi:</b> 1.0</p>
    <p><b>Dikembangkan oleh:</b> Administrator</p>
  </div>
</div>

</body>
</html>
