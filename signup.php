<?php
// signup.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Sign Up - KiosQu</title>

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
  flex-direction:column;
  align-items:center;
  justify-content:center;
}

/* LOGO */
.logo{
  font-size:140px;              /* 🔥 logo besar */
  font-weight:900;
  margin-bottom:30px;
  background:linear-gradient(to right,#8BBEFF,#F2A7D7);
  -webkit-background-clip:text;
  -webkit-text-fill-color:transparent;
}

/* CARD */
.card{
  width:520px;                 /* 🔥 card besar */
  background:white;
  border-radius:22px;
  padding:42px 44px;
  box-shadow:0 24px 48px rgba(0,0,0,0.18);
}

/* TITLE */
.card h2{
  text-align:center;
  font-size:28px;
  margin-bottom:8px;
}

.card .sub{
  text-align:center;
  font-size:14px;
  color:#666;
  margin-bottom:26px;
}

/* FORM */
label{
  font-size:15px;
  font-weight:600;
  display:block;
  margin-bottom:6px;
}

input{
  width:100%;
  padding:16px 18px;
  margin-bottom:20px;
  border-radius:12px;
  border:1px solid #ccc;
  font-size:16px;
}

/* BUTTON */
button{
  width:100%;
  padding:16px;
  background:black;
  color:white;
  border:none;
  border-radius:12px;
  font-size:16px;
  cursor:pointer;
  margin-top:8px;
}

/* FOOTER */
.footer{
  text-align:center;
  font-size:13px;
  color:#666;
  margin-top:22px;
}

.footer a{
  color:#4da6ff;
  text-decoration:none;
  font-weight:600;
}
</style>
</head>

<body>

<div class="logo">KiosQu</div>

<div class="card">
  <h2>Sign Up</h2>
  <div class="sub">Lorem ipsum dolor sit amet, consectetur</div>

  <form action="proses_signup.php" method="POST">

    <label>Full Name</label>
    <input type="text" name="nama" placeholder="Enter your name" required>

    <label>E-mail</label>
    <input type="email" name="email" placeholder="Enter your email" required>

    <label>Password</label>
    <input type="password" name="password" placeholder="Enter your password" required>

    <button type="submit">Create An Account</button>

  </form>

  <div class="footer">
    Already have an account?
    <a href="login.php">Sign In</a><br><br>
    By signing up you agree to our Terms and Conditions of Use
  </div>
</div>

</body>
</html>
