<?php
session_start();
include 'koneksi.php';

$email    = $_POST['email'];
$password = $_POST['password'];

// ambil user
$query = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email'");
$user  = mysqli_fetch_assoc($query);

// email tidak ada
if(!$user){
    echo "<script>
            alert('Email tidak ditemukan');
            window.location='login.php';
          </script>";
    exit;
}

// password salah
if(!password_verify($password, $user['password'])){
    echo "<script>
            alert('Password salah');
            window.location='login.php';
          </script>";
    exit;
}

// ===== LOGIN BERHASIL =====
$_SESSION['login'] = true;
$_SESSION['id']    = $user['id'];
$_SESSION['nama']  = $user['nama'];
$_SESSION['email'] = $user['email'];
$_SESSION['role']  = $user['role'];

// redirect sesuai role
if($user['role'] === 'admin'){
    header("Location: admin/dashboard.php");
} else {
    header("Location: index.php");
}
exit;
