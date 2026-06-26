<?php
require_once 'admin_auth.php';
require_once 'db.php';
$result = $conn->query('SELECT * FROM products ORDER BY id DESC');
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Manage Products | Kibe Kicks</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="app-shell">
    <aside class="sidebar">
      <h2>Kibe Admin</h2>
      <nav>
        <a href="admin_dashboard.php">Dashboard</a>
        <a class="active" href="manage_products.php">Manage Products</a>
        <a href="add_product.php">Add Product</a>
        <a href="logout.php">Logout</a>
      </nav>
    </aside>

    <main class="content">
      <div class="page-heading">
        <div>
          <h1>Manage Products</h1>
          <p style="color: var(--muted); margin-top: 8px;">Edit, delete and update your catalog.</p>
        </div>
        <div>
          <a class="btn" href="add_product.php">Add Product</a>
        </div>
      </div>

      <div class="table-wrap">
        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Price</th>
              <th>Image</th>
              <th>Description</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo (int)$row['id']; ?></td>
              <td><?php echo htmlspecialchars($row['name']); ?></td>
              <td><?php echo htmlspecialchars($row['price']); ?></td>
              <td><img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="product-img" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2260%22 height=%2260%22%3E%3Crect fill=%22%23ddd%22 width=%2260%22 height=%2260%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dy=%22.3em%22 font-family=%22Arial%22 font-size=%2212%22 fill=%22%23999%22%3ENo Image%3C/text%3E%3C/svg%3E'" width="64" height="64"></td>
              <td><?php echo htmlspecialchars($row['description']); ?></td>
              <td>
                <a class="btn btn-secondary" href="edit_product.php?id=<?php echo (int)$row['id']; ?>">Edit</a>
                <form method="post" action="delete_product.php" style="display:inline-block; margin:0;">
                  <input type="hidden" name="id" value="<?php echo (int)$row['id']; ?>">
                  <input type="hidden" name="csrf_token" value="<?php echo h(get_csrf_token()); ?>">
                  <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this product?');">Delete</button>
                </form>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</body>
</html>
