<?php
// Simple login using POST against users.json
$errors = [];
$success = '';
$username = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($username === '') $errors[] = 'Username is required.';
    if ($password === '') $errors[] = 'Password is required.';
    if (empty($errors)) {
        $usersFile = __DIR__ . '/users.json';
        $users = file_exists($usersFile) ? (json_decode(file_get_contents($usersFile), true) ?? []) : [];
        $found = null;
        foreach ($users as $u) {
            if (strcasecmp($u['username'], $username) === 0) { $found = $u; break; }
        }
        if (!$found) {
            $errors[] = 'Invalid username or password.';
        } else {
            if (password_verify($password, $found['password'])) {
                $success = 'Login successful. Welcome, ' . htmlspecialchars($found['username']) . '!';
            } else {
                $errors[] = 'Invalid username or password.';
            }
        }
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login - Week 4</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  <div class="form-container">
    <h1>Login</h1>
    <?php if ($success): ?>
      <p style="color:green;font-weight:bold;"><?php echo $success; ?></p>
    <?php endif; ?>
    <?php if (!empty($errors)): ?>
      <ul style="color:#b52a37;">
        <?php foreach($errors as $e): ?>
          <li><?php echo htmlspecialchars($e); ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
    <form method="POST" action="login.php">
      <label>Username</label>
      <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
      <label>Password</label>
      <input type="password" name="password" required>
      <button type="submit">Login</button>
    </form>
    <p style="text-align:center;margin-top:12px;">Don't have an account? <a href="register.php">Register</a></p>
  </div>
</body>
</html>
