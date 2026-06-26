<?php
require_once 'admin_auth.php';
require_once 'db.php';
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
            $error = 'Please enter name, price, and image URL.';
        } else {
            $stmt = $conn->prepare('INSERT INTO products (name, price, image, description) VALUES (?, ?, ?, ?)');
            $stmt->bind_param('ssss', $name, $price, $image, $description);
            if ($stmt->execute()) {
                $stmt->close();
                header('Location: admin_dashboard.php');
                exit;
            }
            $error = 'Could not save product: ' . $conn->error;
            $stmt->close();
        }
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add Product | Kibe Kicks</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="app-shell">
    <aside class="sidebar">
      <h2>Kibe Admin</h2>
      <nav>
        <a href="admin_dashboard.php">Dashboard</a>
        <a class="active" href="add_product.php">Add Product</a>
        <a href="manage_products.php">Manage Products</a>
        <a href="logout.php">Logout</a>
      </nav>
    </aside>

    <main class="content">
      <div class="page-heading">
        <div>
          <h1>Add Product</h1>
          <p style="color: var(--muted); margin-top: 8px;">Add a new product entry for the catalog.</p>
        </div>
      </div>

      <div class="form-card">
        <?php if ($error): ?><div class="alert"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
        <form method="post">
          <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(get_csrf_token()); ?>">

          <label for="name">Name</label>
          <input id="name" type="text" name="name" required>

          <label for="description">Description</label>
          <textarea id="description" name="description"></textarea>

          <div class="field-row">
            <div class="field">
              <label for="price">Price</label>
              <input id="price" type="text" name="price" required>
            </div>
            <div class="field">
              <label for="image">Image URL</label>
              <input id="image" type="text" name="image" required>
            </div>
          </div>

          <img id="imagePreview" alt="Product preview" class="preview-img" style="display:none;" onerror="this.style.display='none'">
          <button type="submit">Save Product</button>
        </form>
        <a class="footer-link" href="admin_dashboard.php">← Back to Dashboard</a>
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
