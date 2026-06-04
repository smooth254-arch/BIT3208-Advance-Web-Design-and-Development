<?php
session_start();
if (!isset($_SESSION['auth_user'])) {
    header('Location: auth_login.php');
    exit;
}
$items = [
    ['name' => 'Versache', 'price' => 'Ksh 4,500'],
    ['name' => 'Airforce 1 Custom', 'price' => 'Ksh 3,200'],
    ['name' => 'Classic Loafers', 'price' => 'Ksh 5,000'],
];
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Items - Week 4</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  <div style="max-width:900px;margin:60px auto;padding:24px;background:rgba(255,255,255,0.95);border-radius:16px;box-shadow:0 8px 24px rgba(0,0,0,0.12);">
    <h1 style="text-align:center;">Welcome <?php echo htmlspecialchars($_SESSION['auth_user']); ?></h1>
    <p style="text-align:center;margin-bottom:24px;">You are logged in and can view the item list below.</p>
    <div style="display:grid;gap:16px;">
      <?php foreach ($items as $item): ?>
        <div style="padding:18px;border:1px solid #ddd;border-radius:14px;">
          <h2 style="margin:0 0 10px"><?php echo htmlspecialchars($item['name']); ?></h2>
          <p style="margin:0;font-weight:bold;">Price: <?php echo htmlspecialchars($item['price']); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
    <p style="text-align:center;margin-top:30px;"><a href="auth_logout.php" class="button">Logout</a></p>
  </div>
</body>
</html>
