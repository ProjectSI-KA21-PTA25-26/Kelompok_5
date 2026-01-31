<?php
// login.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login - KiosQu</title>

<style>
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family: Arial, sans-serif;
}

body{
  min-height:100vh;
  background:#4da6ff;
  display:flex;
  align-items:center;
  justify-content:center;
}

/* WRAPPER */
.wrapper{
  width:100%;
  max-width:1400px;          /* 🔥 lebih lebar lagi */
  display:flex;
  align-items:center;
  justify-content:space-between;
  padding:60px 80px;
}

/* LOGO */
.brand{
  flex:1;
  display:flex;
  justify-content:flex; /* 🔥 geser ke kiri */
  padding-left:0px;          /* 🔥 posisi aman (tidak mentok) */
}

.brand h1{
  font-size:160px;            /* 🔥 LOGO LEBIH BESAR */
  font-weight:900;
  line-height:1;
  background:linear-gradient(to right,#8BBEFF,#F2A7D7);
  -webkit-background-clip:text;
  -webkit-text-fill-color:transparent;
}

.brand-link{
  text-decoration:none;
  color:inherit;
  display:inline-block;
}


/* LOGIN CARD */
.login-card{
  width:480px;                /* 🔥 card sedikit lebih besar */
  background:white;
  border-radius:22px;
  padding:44px 42px;
  box-shadow:0 22px 44px rgba(0,0,0,0.18);
}

/* FORM */
.login-card label{
  font-size:17px;
  color:#333;
}

.login-card input{
  width:100%;
  padding:18px 20px;          /* 🔥 input makin tinggi */
  margin:10px 0 24px;
  border-radius:12px;
  border:1px solid #aaa;
  font-size:17px;
}

.forgot{
  text-align:right;
  font-size:15px;
  color:red;
  margin-bottom:20px;
  cursor:pointer;
}

/* BUTTON */
.login-card button{
  width:100%;
  padding:18px;
  background:black;
  color:white;
  border:none;
  border-radius:12px;
  font-size:17px;
  cursor:pointer;
}

/* SIGNUP */
.signup{
  text-align:center;
  margin-top:24px;
  font-size:16px;
}

.signup a{
  color:#4da6ff;
  text-decoration:none;
  font-weight:600;
}
</style>
</head>

<body>

<div class="wrapper">

  <!-- LOGO -->
<div class="brand">
  <a href="index.php" class="brand-link">
    <h1>KiosQu</h1>
  </a>
</div>


  <!-- LOGIN CARD -->
  <div class="login-card">
    <form action="proses_login.php" method="POST">

      <label>Email</label>
      <input type="email" name="email" placeholder="Enter your email address" required>

      <label>Password</label>
      <input type="password" name="password" placeholder="Enter your password" required>

      <div class="forgot">Forgot Password</div>

      <button type="submit">Sign In</button>

      <div class="signup">
        Don’t have an account?
        <a href="signup.php">Sign Up</a>
      </div>

    </form>
  </div>

</div>

</body>
</html>
