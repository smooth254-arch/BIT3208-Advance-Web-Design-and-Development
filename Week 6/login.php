<?php
require_once 'functions.php';
require_once 'db.php';
secure_session_start();

$error = '';

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: admin_dashboard.php');
        exit;
    }
    header('Location: /Kicks%20collection1/Week%208/Chichi.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid session token. Please refresh the page and try again.';
    } else {
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';

        if (!$email || $password === '') {
            $error = 'Please enter a valid email and password.';
        } else {
            $stmt = $conn->prepare('SELECT id, password, role FROM users WHERE email = ? LIMIT 1');
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->bind_result($id, $hash, $role);
            if ($stmt->fetch() && password_verify($password, $hash)) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $id;
                $_SESSION['role'] = $role;
                $_SESSION['last_activity'] = time();
                $stmt->close();
                if ($role === 'admin') {
                    header('Location: admin_dashboard.php');
                    exit;
                }
                header('Location: /Kicks%20collection1/Week%208/Chichi.php');
                exit;
            }
            $stmt->close();
            $error = 'Invalid email or password.';
        }
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login | Kibe Kicks</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="app-shell">
    <div class="form-card" style="max-width:420px; width:100%;">
      <h1 style="margin-top:0;">Login</h1>
      <?php if ($error): ?><div class="alert"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
      <form method="post">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(get_csrf_token()); ?>">
        <label for="email">Email</label>
        <input id="email" type="email" name="email" placeholder="admin@example.com" required>

        <label for="password">Password</label>
        <input id="password" type="password" name="password" placeholder="Password" required>

        <button type="submit" class="btn" style="width:100%; margin-top:18px;">Sign In</button>
      </form>
      
    </div>
  </div>
</body>
</html>