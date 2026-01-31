<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../login.php");
  exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  die('ID kios tidak valid');
}

$id_kios = (int) $_GET['id'];

/* ======================
   DATA KIOS
   ====================== */
$q_kios = mysqli_query($koneksi, "
  SELECT *
  FROM kios
  WHERE id_kios = $id_kios
  LIMIT 1
");

$kios = mysqli_fetch_assoc($q_kios);
if (!$kios) {
  die('Kios tidak ditemukan');
}

/* ======================
   SEWA TERAKHIR
   ====================== */
$q_sewa = mysqli_query($koneksi, "
  SELECT s.*, u.nama, u.no_hp
  FROM sewa s
  LEFT JOIN users u ON s.user_id = u.id
  WHERE s.kios_id = $id_kios
  ORDER BY s.id_sewa DESC
  LIMIT 1
");

$sewa = mysqli_fetch_assoc($q_sewa);

/* ======================
   LIST PENYEWA
   ====================== */
$q_user = mysqli_query($koneksi, "
  SELECT id, nama
  FROM users
  WHERE role = 'penyewa'
  ORDER BY nama ASC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Kios - <?= htmlspecialchars($kios['nama_kios']) ?></title>

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

h2{
  font-size:32px;
  margin-bottom:30px;
}

/* CARD */
.card{
  background:#fff;
  border-radius:26px;
  padding:40px;
  max-width:900px;
  margin:auto;
  box-shadow:0 14px 30px rgba(0,0,0,0.12);
}

.form-group{
  margin-bottom:22px;
}

.form-group label{
  display:block;
  font-size:16px;
  margin-bottom:8px;
  font-weight:600;
}

.form-group input,
.form-group textarea,
.form-group select{
  width:100%;
  padding:14px 16px;
  border-radius:12px;
  border:1px solid #ccc;
  font-size:15px;
}

textarea{
  resize:none;
  height:90px;
}

.subtitle{
  margin:30px 0 14px;
  font-size:18px;
  font-weight:700;
}

.checkbox-group{
  display:flex;
  gap:20px;
}

.checkbox-group label{
  font-weight:500;
}

.form-action{
  margin-top:40px;
  display:flex;
  justify-content:flex-end;
}

.btn-submit{
  background:#0b1d51;
  color:#fff;
  border:none;
  padding:14px 44px;
  border-radius:14px;
  font-size:16px;
  cursor:pointer;
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
  <h1>Kios<span>Qu</span></h1>

  <div class="admin-info">
    Admin<br><?= htmlspecialchars($_SESSION['email']) ?>
  </div>

  <div class="divider"></div>

  <a href="dashboard.php">Dashboard</a>
  <a href="informasi_kios.php" class="active">Informasi Kios</a>
  <a href="tambah_kios.php">Tambah Kios</a>
  <a href="pengaturan_admin.php">Pengaturan</a>
  <a href="../logout.php">Logout</a>
</div>

<!-- CONTENT -->
<div class="content">
  <h2>Edit Kios</h2>

  <form action="proses_edit_kios.php" method="POST">
    <input type="hidden" name="id_kios" value="<?= $id_kios ?>">

    <div class="card">

      <div class="form-group">
        <label>Nama Kios</label>
        <input type="text" name="nama_kios"
               value="<?= htmlspecialchars($kios['nama_kios']) ?>" required>
      </div>

      <div class="form-group">
        <label>Alamat</label>
        <textarea name="alamat" required><?= htmlspecialchars($kios['alamat']) ?></textarea>
      </div>

      <div class="subtitle">Data Sewa</div>

      <div class="form-group">
        <label>Nama Penyewa</label>
        <select name="user_id">
          <option value="">-- Pilih Penyewa --</option>
          <?php while($u = mysqli_fetch_assoc($q_user)): ?>
            <option value="<?= $u['id'] ?>"
              <?= ($sewa && $sewa['user_id']==$u['id']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($u['nama']) ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>

      <div class="form-group">
        <label>No Handphone</label>
        <input type="text" name="no_hp"
               value="<?= $sewa['no_hp'] ?? '' ?>">
      </div>

      <div class="form-group">
        <label>Tanggal Mulai Sewa</label>
        <input type="date" name="tanggal_mulai"
               value="<?= $sewa['tanggal_mulai'] ?? '' ?>">
      </div>

      <div class="form-group">
        <label>Tanggal Selesai Sewa</label>
        <input type="date" name="tanggal_selesai"
               value="<?= $sewa['tanggal_selesai'] ?? '' ?>">
      </div>

      <div class="form-group">
        <label>Status Pembayaran</label>
        <select name="status_pembayaran">
          <option value="Belum" <?= ($sewa['status_pembayaran'] ?? '')=='Belum'?'selected':'' ?>>Belum</option>
          <option value="Lunas" <?= ($sewa['status_pembayaran'] ?? '')=='Lunas'?'selected':'' ?>>Lunas</option>
        </select>
      </div>

      <div class="form-group">
        <label>Status Bayar</label>
        <div class="checkbox-group">
          <label><input type="checkbox" name="pbb" value="1" <?= ($sewa['pbb'] ?? 0) ? 'checked':'' ?>> PBB</label>
          <label><input type="checkbox" name="air" value="1" <?= ($sewa['air'] ?? 0) ? 'checked':'' ?>> Air</label>
          <label><input type="checkbox" name="listrik" value="1" <?= ($sewa['listrik'] ?? 0) ? 'checked':'' ?>> Listrik</label>
        </div>
      </div>

      <div class="form-action">
        <button type="submit" class="btn-submit">Simpan Perubahan</button>
      </div>

    </div>
  </form>
</div>

</body>
</html>
