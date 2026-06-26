<?php
session_start();
if (isset($_SESSION['auth_user'])) {
    header('Location: auth_items.php');
    exit;
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['user'] ?? '');
    $pass = trim($_POST['pass'] ?? '');
    if ($user === 'admin' && $pass === 'secret123') {
        $_SESSION['auth_user'] = $user;
        header('Location: auth_items.php');
        exit;
    }
    $error = 'Invalid username or password.';
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Auth Login - Week 4</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  <div style="max-width:420px;margin:70px auto;padding:24px;background:rgba(255,255,255,0.95);border-radius:16px;box-shadow:0 8px 24px rgba(0,0,0,0.12);">
    <h1 style="text-align:center;margin-bottom:20px;">Admin Login</h1>
    <?php if ($error): ?>
      <p style="color:#b52a37;text-align:center;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="POST" action="auth_login.php">
      <label>Username</label>
      <input type="text" name="user" value="" required>
      <label>Password</label>
      <input type="password" name="pass" required>
      <button type="submit">Login</button>
    </form>
    <p style="margin-top:18px;text-align:center;font-size:0.95rem;">Use <strong>admin</strong> / <strong>secret123</strong></p>
  </div>
</body>
</html>
