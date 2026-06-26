<?php
require_once 'admin_auth.php';
require_once 'db.php';

$result = $conn->query('SELECT COUNT(*) AS total FROM products');
$total = 0;
if ($result) {
    $row = $result->fetch_assoc();
    $total = $row['total'] ?? 0;
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Admin Dashboard | Kibe Kicks</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="app-shell">
    <aside class="sidebar">
      <h2>Kibe Admin</h2>
      <nav>
        <a class="active" href="admin_dashboard.php">Dashboard</a>
        <a href="add_product.php">Add Product</a>
        <a href="manage_products.php">Manage Products</a>
        <a href="logout.php">Logout</a>
      </nav>
    </aside>

    <main class="content">
      <div class="page-heading">
        <div>
          <h1>Dashboard</h1>
          <p style="color: var(--muted); margin-top: 8px;">Manage products and view admin stats.</p>
        </div>
      </div>

      <div class="page-heading" style="margin-top:-12px; margin-bottom:20px;">
        <div>
          <a class="btn" href="manage_products.php">Manage Products</a>
          <a class="btn btn-secondary" href="manage_admins.php">Manage Admins</a>
        </div>
      </div>

      <div class="panel-grid">
        <section class="panel">
          <h3>Total Products</h3>
          <p class="value"><?php echo (int)$total; ?></p>
          <p style="color: var(--muted); margin: 0;">Products currently stored in inventory.</p>
        </section>
      </div>
    </main>
  </div>
</body>
</html>
