<?php
require_once 'admin_auth.php';
require_once 'db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid form submission. Please refresh and try again.';
    } else {
        $fullname = trim($_POST['fullname'] ?? '');
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
        $phone = trim($_POST['phone'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($fullname === '' || !$email || $phone === '' || $password === '') {
            $error = 'All fields are required for adding a new admin.';
        } else {
            $countStmt = $conn->prepare('SELECT COUNT(*) FROM users WHERE role = "admin"');
            $countStmt->execute();
            $countStmt->bind_result($adminCount);
            $countStmt->fetch();
            $countStmt->close();

            if ($adminCount >= 5) {
                $error = 'Maximum number of admin accounts reached (5).';
            } else {
                $stmt = $conn->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
                $stmt->bind_param('s', $email);
                $stmt->execute();
                $stmt->bind_result($count);
                $stmt->fetch();
                $stmt->close();

                if ($count > 0) {
                    $error = 'An account with this email already exists.';
                } else {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $insert = $conn->prepare('INSERT INTO users (fullname, email, phone, password, role) VALUES (?, ?, ?, ?, "admin")');
                    $insert->bind_param('ssss', $fullname, $email, $phone, $hash);
                    if ($insert->execute()) {
                        $success = 'Admin added successfully.';
                    } else {
                        $error = 'Could not add admin: ' . htmlspecialchars($conn->error);
                    }
                    $insert->close();
                }
            }
        }
    }
}

$admins = [];
$result = $conn->query('SELECT id, fullname, email, phone, created_at FROM users WHERE role = "admin" ORDER BY created_at DESC LIMIT 5');
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $admins[] = $row;
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Manage Admins | Kibe Kicks</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="app-shell">
    <aside class="sidebar">
      <h2>Kibe Admin</h2>
      <nav>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="manage_products.php">Manage Products</a>
        <a href="add_product.php">Add Product</a>
        <a class="active" href="manage_admins.php">Manage Admins</a>
        <a href="logout.php">Logout</a>
      </nav>
    </aside>

    <main class="content">
      <div class="page-heading">
        <div>
          <h1>Manage Admins</h1>
          <p style="color: var(--muted); margin-top: 8px;">Add and view up to five admin users.</p>
        </div>
      </div>

      <div class="form-card" style="margin-bottom: 24px;">
        <?php if ($error): ?><div class="alert"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
        <?php if ($success): ?><div class="alert" style="background:#d1fae5;border-color:#6ee7b7;color:#065f46"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>
        <form method="post">
          <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(get_csrf_token()); ?>">
          <label for="fullname">Full Name</label>
          <input id="fullname" type="text" name="fullname" required>

          <label for="email">Email</label>
          <input id="email" type="email" name="email" required>

          <label for="phone">Phone</label>
          <input id="phone" type="text" name="phone" required>

          <label for="password">Password</label>
          <input id="password" type="password" name="password" required>

          <button type="submit" class="btn">Create Admin</button>
        </form>
      </div>

      <div class="card">
        <h2>Existing Admins</h2>
        <div class="table-wrap" style="margin-top: 16px;">
          <table class="table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Created</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($admins as $admin): ?>
              <tr>
                <td><?php echo (int)$admin['id']; ?></td>
                <td><?php echo htmlspecialchars($admin['fullname']); ?></td>
                <td><?php echo htmlspecialchars($admin['email']); ?></td>
                <td><?php echo htmlspecialchars($admin['phone']); ?></td>
                <td><?php echo htmlspecialchars($admin['created_at']); ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
