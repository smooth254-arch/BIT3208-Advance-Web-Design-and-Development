<?php
require_once 'functions.php';
secure_session_start();
require_login();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Kibe Kicks Home</title>
  <style>body{font-family:Arial,Helvetica,sans-serif;background:#f4f4f4;color:#111;margin:0;padding:40px} .box{max-width:800px;margin:0 auto;background:#fff;padding:24px;border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,.08)} a{color:#111;text-decoration:none}</style>
</head>
<body>
  <div class="box">
    <h1>Welcome to Kibe Kicks</h1>
    <p>You are logged in as <?php echo h($_SESSION['role']); ?>.</p>
    <p><a href="logout.php">Logout</a></p>
  </div>
</body>
</html>
