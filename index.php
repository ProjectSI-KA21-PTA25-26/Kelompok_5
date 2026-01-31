<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'koneksi.php';


$no_admin = "6281234567890";

/* ===============================
   AMBIL DATA KIOS (3 KIOS)
   =============================== */
$query = mysqli_query($koneksi, "
  SELECT id_kios as id, nama_kios, alamat, foto
  FROM kios 
  ORDER BY id_kios ASC
");

?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>KiosQu</title>

<style>
body{
  margin:0;
  font-family: Arial, sans-serif;
  background:#fff;
}

/* ===== NAVBAR ===== */
.navbar{
  background:#4da6ff;
  padding:14px 30px;
  display:flex;
  justify-content:space-between;
  align-items:center;
}

.logo{
  font-size:32px;
  font-weight:bold;
}

.logo a{
  text-decoration:none;
}

.logo .kios{
  background:linear-gradient(to right,#8BBEFF,#A7CCFF);
  -webkit-background-clip:text;
  -webkit-text-fill-color:transparent;
}

.logo .qu{
  background:linear-gradient(to right,#D6A4FF,#F2A7D7);
  -webkit-background-clip:text;
  -webkit-text-fill-color:transparent;
}

/* ===== MENU ===== */
.menu{
  display:flex;
  align-items:center;
  gap:12px;
}

.btn-login{
  text-decoration:none;
  background:#e6f1ff;
  padding:6px 14px;
  border-radius:20px;
  color:black;
  font-size:13px;
}

/* ===== PROFILE DROPDOWN ===== */
.profile-wrapper{
  position:relative;
}

.profile-pic{
  width:38px;
  height:38px;
  border-radius:50%;
  cursor:pointer;
}

.dropdown{
  position:absolute;
  top:48px;
  right:0;
  background:white;
  border-radius:14px;
  box-shadow:0 8px 20px rgba(0,0,0,0.15);
  width:170px;
  display:none;
  overflow:hidden;
  z-index:10;
}

.dropdown-name{
  padding:12px 16px;
  font-weight:bold;
  border-bottom:1px solid #eee;
  font-size:14px;
}

.dropdown a{
  display:block;
  padding:12px 16px;
  text-decoration:none;
  color:#333;
  font-size:14px;
}

.dropdown a:hover{
  background:#f1f1f1;
}

/* ===== HERO ===== */
.hero{
  height:calc(100vh - 80px);
  display:flex;
  flex-direction:column;
  justify-content:center;
  align-items:center;
  text-align:center;
}

.hero h1{
  font-size:80px;
  font-weight:bold;
  background:linear-gradient(to right,#8BBEFF,#F2A7D7);
  -webkit-background-clip:text;
  -webkit-text-fill-color:transparent;
}

.hero p{
  width:680px;
  font-size:25px;
  color:#333;
  margin:0px 0;
}

.hero button{
  padding:10px 28px;
  font-size:16px;
  border-radius:40px;
  border:none;
  background:#e0e0e0;
  cursor:pointer;
}

/* ===== LIST KIOS ===== */
.kios-list{
  display:flex;
  flex-direction:column;   /* LIST KE BAWAH */
  gap:30px;
  padding:0 80px;
}

/* SATU BARIS KIOS */
.kios-item{
  display:flex;
  align-items:center;
  gap:20px;
  padding:12px 0;
}

/* FOTO */
.kios-item img{
  width:150px;
  height:115px;
  border-radius:12px;
  object-fit:cover;
}

/* INFO */
.kios-item .info{
  flex:1;                 /* 🔥 BIAR TOMBOL KE KANAN */
  font-size:20px;
}

/* WRAPPER TOMBOL */
.aksi-kios{
  display:flex;
  gap:12px;
  white-space:nowrap; 
  margin-left:40px;   
  padding-right:20px
}

/* DETAIL */
.btn-detail{
  background:#e0e0e0;
  color:#000;
  padding:8px 16px;
  border-radius:17px;
  font-size:15px;
  text-decoration:none;
} 


/* ===== PESAN BUTTON ===== */
.pesan{
  background:black;
  color:white;
  padding:8px 16px;
  border-radius:17px;
  font-size:15px;
  border:none;
  cursor:pointer;
  transition:0.25s;
  display:inline-block;
}

.pesan-wa:hover{
  background:#25D366;
}

.pesan-wa:hover::after{
  content:" WhatsApp";
}

.aksi-kios{
  display:flex;
  gap:12px;
  margin-top:12px;
}

/* .btn-detail{
  padding:8px 18px;
  background:#e0e0e0;
  color:#000;
  border-radius:18px;
  text-decoration:none;
  font-size:15px;
  transition:.25s;
} */

.btn-detail:hover{
  background:#4da6ff;
  color:#fff;
}

</style>
</head>

<body>

<!-- ================= NAVBAR ================= -->
<div class="navbar">
  <div class="logo">
    <a href="index.php">
      <span class="kios">Kios</span><span class="qu">Qu</span>
    </a>
  </div>

  <div class="menu">
    <?php if(isset($_SESSION['login'])): ?>
      <div class="profile-wrapper">
        <img src="img/default-profile.png" class="profile-pic" id="profileBtn">

        <div class="dropdown" id="profileMenu">
          <div class="dropdown-name">
            <?php echo htmlspecialchars($_SESSION['nama']); ?>
          </div>
          <a href="informasi.php">Informasi</a>
          <a href="logout.php">Logout</a>
        </div>
      </div>
    <?php else: ?>
      <a href="login.php" class="btn-login">Login</a>
    <?php endif; ?>
  </div>
</div>

<!-- ================= HERO ================= -->
<div class="hero">
  <h1>KiosQu</h1>
  <p>
    Selamat datang di Kiosqu<br>
    Kepuasan Anda adalah prioritas kami.<br>
    Kami berkomitmen memberikan pelayanan <br>
    yang ramah, cepat, dan terpercaya demi kenyamanan Anda.
  </p>
</div>


<div class="kios-list">

<?php
while ($row = mysqli_fetch_assoc($query)) {

  $nama_kios = $row['nama_kios'];
  $alamat    = !empty($row['alamat']) ? $row['alamat'] : '-';
  $foto      = !empty($row['foto']) ? $row['foto'] : 'default.jpg';

  $pesan_wa = urlencode("Halo Admin, saya tertarik menyewa $nama_kios");
  $link_wa  = "https://wa.me/".$no_admin."?text=".$pesan_wa;
?>
  <div class="kios-item">

    <img src="img/<?php echo htmlspecialchars($foto); ?>"
         alt="<?php echo htmlspecialchars($nama_kios); ?>">

    <div class="info">
      <strong><?php echo htmlspecialchars($nama_kios); ?></strong><br>
      <?php echo htmlspecialchars($alamat); ?>
    </div>

    <div class="aksi-kios">
      <?php if (isset($_SESSION['login'])) { ?>
        <a href="detail_kios.php?id=<?php echo (int)$row['id']; ?>" class="btn-detail">
          Detail Kios
        </a>
        <a href="track_peminat.php?id=<?= $row['id'] ?>" class="pesan pesan-wa">
          Pesan
        </a>
      <?php } else { ?>
        <a href="login.php" class="btn-detail">Detail Kios</a>
        <a href="login.php" class="pesan">Pesan</a>
      <?php } ?>
    </div>

  </div>
<?php
}
?>

</div>


<!-- ================= JS DROPDOWN ================= -->
<script>
const btn = document.getElementById('profileBtn');
const menu = document.getElementById('profileMenu');

if(btn){
  btn.addEventListener('click', function(e){
    e.stopPropagation();
    menu.style.display =
      menu.style.display === 'block' ? 'none' : 'block';
  });

  document.addEventListener('click', function(){
    menu.style.display = 'none';
  });
}
</script>

</body>
</html>
