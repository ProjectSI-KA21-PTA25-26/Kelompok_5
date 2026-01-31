<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}
$user_id = $_SESSION['id'];

$cek_sewa = mysqli_query($koneksi, "
  SELECT 1
  FROM sewa
  WHERE user_id = '$user_id'
    AND tanggal_selesai >= CURDATE()
  LIMIT 1
");

$sewa_aktif = mysqli_num_rows($cek_sewa) > 0;


?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pengaturan - KiosQu</title>

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
  color:white;
  padding:50px 30px;
}

.logo-link{
  text-decoration:none;
  color:white;
}

.logo{
  font-size:48px;
  font-weight:900;
  margin-bottom:14px;
}

.logo span{
  color:#d6a4ff;
}

.role{
  font-size:20px;
}

.email{
  font-size:14px;
  color:#d0d0d0;
}

.divider{
  height:4px;
  background:#888;
  margin:28px 0;
}

.menu a{
  display:block;
  padding:18px 26px;
  margin-bottom:18px;
  border-radius:32px;
  color:white;
  text-decoration:none;
  font-size:20px;
}

.menu a:hover,
.menu a.active{
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
  width:640px;
  background:white;
  border-radius:32px;
  padding:46px 42px;
  box-shadow:0 18px 45px rgba(0,0,0,.18);
}

/* ITEM */
.item{
  display:flex;
  justify-content:space-between;
  align-items:center;
  padding:26px 34px;
  margin-bottom:26px;
  border-radius:40px;
  font-size:22px;
  cursor:pointer;
}

/* BAHASA */
.item.lang{
  border:2px solid #2f80ed;
}

/* DROPDOWN */
.lang-dropdown{
  display:none;
  margin-top:-10px;
  margin-bottom:26px;
  background:#fff;
  border-radius:28px;
  padding:14px 0;
  box-shadow:0 12px 30px rgba(0,0,0,.12);
}

.lang-option{
  padding:18px 34px;
  font-size:22px;
  font-weight:600;
}

/* HAPUS AKUN */
.item.delete{
  border:2px solid #eb3939ff;
}

/* ================= MODAL ================= */
.modal{
  display:none;
  position:fixed;
  inset:0;
  background:rgba(0,0,0,.45);
  justify-content:center;
  align-items:center;
}

.modal-box{
  width:420px;
  background:white;
  padding:40px;
  border-radius:26px;
  text-align:center;
}

.modal-box h3{
  font-size:26px;
  margin-bottom:14px;
}

.modal-box p{
  font-size:18px;
  margin-bottom:28px;
}

.modal-box button{
  padding:14px 30px;
  border:none;
  border-radius:26px;
  font-size:18px;
  cursor:pointer;
  margin:0 8px;
}

.btn-cancel{
  background:#e0e0e0;
}

.btn-delete{
  background:#ff3b3b;
  color:white;
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
  <a href="index.php" class="logo-link">
    <div class="logo">Kios<span>Qu</span></div>
  </a>

  <div class="role">Penyewa</div>
  <div class="email"><?= $_SESSION['email']; ?></div>

  <div class="divider"></div>

  <div class="menu">
    <a href="informasi.php">Informasi Kios</a>
    <a href="pembayaran.php">Pembayaran</a>
    <a href="pengaturan.php" class="active">Pengaturan</a>
    <a href="logout.php">Logout</a>
  </div>
</div>

<!-- CONTENT -->
<div class="content">
  <div class="card">

    <!-- BAHASA -->
    <div class="item lang" onclick="toggleLang()">
      Bahasa
      <span id="arrow">›</span>
    </div>

    <div class="lang-dropdown" id="langDropdown">
      <div class="lang-option">Bahasa Indonesia</div>
    </div>

    <!-- HAPUS AKUN -->
    <div class="item delete" onclick="openModal()">
      Hapus Akun
    </div>

  </div>
</div>

<!-- MODAL -->
<div class="modal" id="modal">
  <div class="modal-box">
    <h3>Hapus Akun</h3>
    <?php if ($sewa_aktif): ?>
      <p style="color:#b00020;font-weight:600;">
        Akun kamu masih memiliki masa sewa aktif.<br>
        Jika akun dihapus, masa sewa akan <b>langsung berakhir</b>.
      </p>
    <?php else: ?>
      <p>
        Apakah kamu yakin ingin menghapus akun?<br>
        Akun akan dihapus secara permanen.
      </p>
    <?php endif; ?>
    <button class="btn-cancel" onclick="closeModal()">Batal</button>

    <form action="hapus_akun.php" method="POST" style="display:inline;">
      <button type="submit" class="btn-delete">Ya, Hapus</button>
    </form>
  </div>
</div>

<script>
function toggleLang(){
  const d = document.getElementById('langDropdown');
  const arrow = document.getElementById('arrow');

  if (d.style.display === 'block') {
    d.style.display = 'none';
    arrow.innerHTML = '›';
  } else {
    d.style.display = 'block';
    arrow.innerHTML = '⌄';
  }
}

function openModal(){
  document.getElementById('modal').style.display='flex';
}
function closeModal(){
  document.getElementById('modal').style.display='none';
}
</script>

</body>
</html>
