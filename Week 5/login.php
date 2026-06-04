<?php
session_start();
if (isset($_SESSION['user'])) {
    header('Location: fetch.php');
    exit;
}
$error = $_GET['error'] ?? '';
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login - Week 5</title>
    <style>
        body { font-family: Arial, sans-serif; background:#eef2ff; display:flex; align-items:center; justify-content:center; min-height:100vh; margin:0; }
        .box { background:#fff; padding:24px 28px; border-radius:14px; box-shadow:0 14px 32px rgba(0,0,0,.08); width:320px; }
        label { display:block; margin-top:14px; font-weight:600; }
        input { width:100%; padding:10px 12px; margin-top:8px; border:1px solid #ccd5ff; border-radius:10px; }
        button { width:100%; margin-top:20px; padding:12px; border:none; border-radius:10px; background:#3b5bff; color:#fff; font-weight:700; cursor:pointer; }
        .error { color:#b52a37; margin-top:12px; }
        .hint { font-size:.9rem; color:#555; margin-top:10px; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Student Database Login</h2>
        <form method="POST" action="auth.php">
            <label>Username</label>
            <input type="text" name="username" required>
            <label>Password</label>
            <input type="password" name="password" required>
            <button type="submit">Sign in</button>
        </form>
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
    </div>
</body>
</html>
