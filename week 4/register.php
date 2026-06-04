<?php
// Simple registration form processing using POST and storing users in users.json
$errors = [];
$success = '';
$username = '';
$email = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $emailRaw = trim($_POST['email'] ?? '');
    $email = filter_var($emailRaw, FILTER_VALIDATE_EMAIL) ? $emailRaw : '';
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    if ($username === '') $errors[] = 'Username is required.';
    if ($email === '') $errors[] = 'A valid email is required.';
    if (strlen($password) < 6) $errors[] = 'Password must be at least 6 characters.';
    if ($password !== $password_confirm) $errors[] = 'Passwords do not match.';

    if (empty($errors)) {
        $usersFile = __DIR__ . '/users.json';
        if (!file_exists($usersFile)) file_put_contents($usersFile, json_encode([]));
        $users = json_decode(file_get_contents($usersFile), true) ?? [];
        // check duplicates
        foreach ($users as $u) {
            if (strcasecmp($u['username'], $username) === 0) { $errors[] = 'Username already taken.'; break; }
            if (isset($u['email']) && strcasecmp($u['email'], $email) === 0) { $errors[] = 'Email already registered.'; break; }
        }
        if (empty($errors)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $users[] = [
                'username' => $username,
                'email' => $email,
                'password' => $hash,
                'created_at' => time()
            ];
            file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), LOCK_EX);
            $success = 'Registration successful. You may now log in.';
            $username = $email = '';
        }
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Register - Week 4</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  <div class="form-container">
    <h1>Register</h1>
    <?php if ($success): ?>
      <p style="color:green;font-weight:bold;"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>
    <?php if (!empty($errors)): ?>
      <ul style="color:#b52a37;">
        <?php foreach($errors as $e): ?>
          <li><?php echo htmlspecialchars($e); ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
    <form method="POST" action="register.php">
      <label>Username</label>
      <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
      <label>Email</label>
      <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
      <label>Password</label>
      <input type="password" name="password" required>
      <label>Confirm Password</label>
      <input type="password" name="password_confirm" required>
      <button type="submit">Register</button>
    </form>
    <p style="text-align:center;margin-top:12px;">Already have an account? <a href="login.php">Login</a></p>
  </div>
</body>
</html>
