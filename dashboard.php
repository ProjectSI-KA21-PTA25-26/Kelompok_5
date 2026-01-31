<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin'){
  header("Location: ../login.php");
  exit;
}

/* ======================
   DATA DASHBOARD
   ====================== */

// total akun
$q_user = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM users Where role = 'penyewa'");
$total_user = mysqli_fetch_assoc($q_user)['total'];

// total kios
$q_kios_total = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM kios");
$total_kios = mysqli_fetch_assoc($q_kios_total)['total'];

// total peminat
$q_total_peminat = mysqli_query($koneksi, "
  SELECT SUM(jumlah_peminat) AS total
  FROM kios
");
$total_peminat = mysqli_fetch_assoc($q_total_peminat)['total'] ?? 0;

// data kios detail
$q_kios = mysqli_query($koneksi, "
  SELECT 
    nama_kios,
    jumlah_pengunjung,
    jumlah_peminat
  FROM kios
  ORDER BY nama_kios ASC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Admin - KiosQu</title>

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

/* ===== SIDEBAR ===== */
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

/* ===== CONTENT ===== */
.content{
  margin-left:340px;
  padding:50px;
  width:100%;
}

.content h2{
  font-size:34px;
  margin-bottom:30px;
}

/* ===== STAT CARD ===== */
.stats{
  display:grid;
  grid-template-columns: repeat(3, 1fr);
  gap:26px;
  margin-bottom:40px;
}

.stat-card{
  background:#fff;
  border-radius:22px;
  padding:30px;
  box-shadow:0 14px 30px rgba(0,0,0,0.12);
  text-align:center;
}

.stat-card h3{
  font-size:18px;
  margin-bottom:10px;
  color:#555;
}

.stat-card p{
  font-size:40px;
  font-weight:800;
  color:#0b1d51;
}

/* ===== TABLE ===== */
.table-card{
  background:#fff;
  border-radius:22px;
  padding:30px;
  box-shadow:0 14px 30px rgba(0,0,0,0.12);
}

table{
  width:100%;
  border-collapse:collapse;
}

th, td{
  padding:14px;
  text-align:left;
}

th{
  background:#f1f5f9;
}

tr:nth-child(even){
  background:#fafafa;
}
</style>
</head>

<body>

<!-- ===== SIDEBAR ===== -->
<div class="sidebar">
  <h1>Kios<span>Qu</span></h1>

  <div class="admin-info">
    Admin<br>
    <?= htmlspecialchars($_SESSION['email']); ?>
  </div>

  <div class="divider"></div>

  <a href="dashboard.php" class="active">Dashboard</a>
  <a href="informasi_kios.php">Informasi Kios</a>
  <a href="tambah_kios.php">Tambah Kios</a>
  <a href="pengaturan_admin.php">Pengaturan</a>
  <a href="../logout.php">Logout</a>
</div>

<!-- ===== CONTENT ===== -->
<div class="content">

  <h2>Dashboard</h2>

  <div class="stats">
    <div class="stat-card">
      <h3>Total Akun</h3>
      <p><?= $total_user ?></p>
    </div>

    <div class="stat-card">
      <h3>Total Kios</h3>
      <p><?= $total_kios ?></p>
    </div>

    <div class="stat-card">
      <h3>Total Peminat</h3>
      <p><?= $total_peminat ?></p>
    </div>
  </div>

  <div class="table-card">
    <h3 style="margin-bottom:20px;">Statistik Kios</h3>

    <table>
      <tr>
        <th>Nama Kios</th>
        <th>Mengunjungi</th>
        <th>Peminat</th>
      </tr>

      <?php while($k = mysqli_fetch_assoc($q_kios)): ?>
      <tr>
        <td><?= htmlspecialchars($k['nama_kios']) ?></td>
        <td><?= $k['jumlah_pengunjung'] ?></td>
        <td><?= $k['jumlah_peminat'] ?></td>
      </tr>
      <?php endwhile; ?>
    </table>
  </div>

</div>

</body>
</html>
