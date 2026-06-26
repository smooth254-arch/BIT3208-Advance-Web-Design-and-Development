<?php
require_once 'admin_auth.php';
require_once 'db.php';

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: manage_products.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid form submission. Please refresh and try again.';
    } else {
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $price = trim($_POST['price'] ?? '');
        $image = trim($_POST['image'] ?? '');

        if ($name === '' || $price === '' || $image === '') {
            $error = 'Name, price, and image URL are required.';
        } else {
            $stmt = $conn->prepare('UPDATE products SET name = ?, price = ?, image = ?, description = ? WHERE id = ?');
            $stmt->bind_param('ssssi', $name, $price, $image, $description, $id);
            if ($stmt->execute()) {
                $stmt->close();
                header('Location: manage_products.php');
                exit;
            }
            $error = 'Unable to update product: ' . $conn->error;
            $stmt->close();
        }
    }
}

$stmt = $conn->prepare('SELECT name, price, image, description FROM products WHERE id = ? LIMIT 1');
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->bind_result($name, $price, $image, $description);
if (!$stmt->fetch()) {
    $stmt->close();
    header('Location: manage_products.php');
    exit;
}
$stmt->close();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit Product | Kibe Kicks</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="app-shell">
    <aside class="sidebar">
      <h2>Kibe Admin</h2>
      <nav>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="add_product.php">Add Product</a>
        <a class="active" href="manage_products.php">Manage Products</a>
        <a href="logout.php">Logout</a>
      </nav>
    </aside>

    <main class="content">
      <div class="page-heading">
        <div>
          <h1>Edit Product</h1>
          <p style="color: var(--muted); margin-top: 8px;">Update product details in your catalog.</p>
        </div>
      </div>

      <div class="form-card">
        <?php if ($error): ?><div class="alert"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
        <form method="post">
          <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(get_csrf_token()); ?>">

          <label for="name">Name</label>
          <input id="name" type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required>

          <label for="description">Description</label>
          <textarea id="description" name="description"><?php echo htmlspecialchars($description); ?></textarea>

          <div class="field-row">
            <div class="field">
              <label for="price">Price</label>
              <input id="price" type="text" name="price" value="<?php echo htmlspecialchars($price); ?>" required>
            </div>
            <div class="field">
              <label for="image">Image URL</label>
              <input id="image" type="text" name="image" value="<?php echo htmlspecialchars($image); ?>" required>
            </div>
          </div>

          <img id="imagePreview" src="<?php echo htmlspecialchars($image); ?>" alt="Product preview" class="preview-img" onerror="this.style.display='none'">
          <button type="submit">Update Product</button>
        </form>
        <a class="footer-link" href="manage_products.php">← Back to Manage Products</a>
      </div>
    </main>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function(){
      const imageInput = document.querySelector('input[name="image"]');
      const preview = document.getElementById('imagePreview');
      if(imageInput){
        imageInput.addEventListener('input', function(){
          preview.src = this.value;
          preview.style.display = this.value ? 'block' : 'none';
        });
      }
    });
  </script>
</body>
</html>
