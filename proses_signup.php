<?php
include 'koneksi.php';

$nama     = $_POST['nama'];
$email    = $_POST['email'];
$password = $_POST['password'];

// VALIDASI KOSONG
if(empty($nama) || empty($email) || empty($password)){
    echo "<script>
            alert('Semua field wajib diisi!');
            window.location='signup.php';
          </script>";
    exit;
}

// CEK EMAIL SUDAH ADA
$cek = mysqli_query($koneksi, "SELECT id FROM users WHERE email='$email'");
if(mysqli_num_rows($cek) > 0){
    echo "<script>
            alert('Email sudah terdaftar!');
            window.location='signup.php';
          </script>";
    exit;
}

// HASH PASSWORD
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// ROLE DEFAULT
$role = 'penyewa';

// INSERT USER
$query = mysqli_query($koneksi, 
  "INSERT INTO users (nama, email, password, role)
   VALUES ('$nama', '$email', '$password_hash', '$role')"
);

// CEK INSERT
if($query){
    // 🔥 SIGNUP BERHASIL → LOGIN
    header("Location: login.php");
    exit;
}else{
    echo "Gagal signup: " . mysqli_error($koneksi);
}
