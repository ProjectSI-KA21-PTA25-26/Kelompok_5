<?php
session_start();
if(!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin'){
  header("Location: ../login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Kios - Admin KiosQu</title>

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
  font-size:32px;
  margin-bottom:30px;
}

/* ===== CARD ===== */
.card{
  background:#fff;
  border-radius:26px;
  padding:40px;
  max-width:900px;
  box-shadow:0 14px 30px rgba(0,0,0,0.12);
  margin: 0 auto;
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

/* FOTO */
.foto-box{
  width:220px;
  height:160px;
  border-radius:14px;
  border:2px dashed #999;
  position:relative;
  cursor:pointer;
}

#plusIcon{
  position:absolute;
  top:50%;
  left:50%;
  transform:translate(-50%, -50%);
  font-size:48px;
  color:#777;
}

.foto-box input{ display:none; }

.foto-box img{
  width:100%;
  height:100%;
  object-fit:cover;
  border-radius:14px;
}

/* BUTTON */
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
    Admin<br>
    <?= htmlspecialchars($_SESSION['email']); ?>
  </div>

  <div class="divider"></div>

  <a href="dashboard.php">Dashboard</a>
  <a href="informasi_kios.php">Informasi Kios</a>
  <a href="tambah_kios.php" class="active">Tambah Kios</a>
  <a href="pengaturan_admin.php">Pengaturan</a>
  <a href="../logout.php">Logout</a>
</div>

<!-- CONTENT -->
<div class="content">
<h2>Tambah Kios</h2>

<form action="proses_tambah_kios.php" method="POST" enctype="multipart/form-data">
<div class="card">

  <!-- FOTO -->
  <div class="form-group">
    <label>Foto Kios</label>
    <label class="foto-box">
      <img id="previewFoto" style="display:none;">
      <span id="plusIcon">+</span>
      <input type="file" name="foto" accept="image/*" onchange="previewImage(this)" required>
    </label>
  </div>

  <div class="form-group">
    <label>Nama Kios</label>
    <input type="text" name="nama_kios" required>
  </div>

  <div class="form-group">
    <label>Alamat</label>
    <textarea name="alamat" required></textarea>
  </div>

  <div class="form-group">
    <label>Google Maps</label>
    <input type="text" name="maps" placeholder="alamat lengkap...." required>
  </div>

  <div class="form-group">
    <label>Fasilitas</label>
    <textarea name="fasilitas" placeholder="Kamar mandi, listrik, air PDAM" required></textarea>
  </div>

  <div class="form-group">
    <label>Jenis Kios</label>
    <select name="jenis_kios" required>
      <option value="">-- Pilih --</option>
      <option value="Retail">Retail</option>
      <option value="Jasa">Jasa</option>
      <option value="Kuliner">Kuliner</option>
    </select>
  </div>

  <div class="form-group">
    <label>Ukuran Kios</label>
    <input type="text" name="ukuran" placeholder="6 x 12 m²" required>
  </div>

  <div class="form-group">
    <label>Detail Lingkungan</label>
    <textarea name="lingkungan" required></textarea>
  </div>

  <div class="form-action">
    <button type="submit" class="btn-submit">Tambah Kios</button>
  </div>

</div>
</form>
</div>

<script>
function previewImage(input){
  const preview = document.getElementById('previewFoto');
  const plus = document.getElementById('plusIcon');

  if(input.files && input.files[0]){
    const reader = new FileReader();
    reader.onload = e => {
      preview.src = e.target.result;
      preview.style.display = 'block';
      plus.style.display = 'none';
    }
    reader.readAsDataURL(input.files[0]);
  }
}
</script>

</body>
</html>
