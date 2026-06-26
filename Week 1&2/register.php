<?php
include("db.php");

$errors = [];
$success = '';
$fullname = '';
$email = '';
$phone = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $fullname = trim($_POST['fullname'] ?? '');
  $emailRaw = trim($_POST['email'] ?? '');
  $email = filter_var($emailRaw, FILTER_VALIDATE_EMAIL) ? $emailRaw : '';
  $phone = trim($_POST['phone'] ?? '');
  $rawPassword = $_POST['password'] ?? '';
  $password_confirm = $_POST['password_confirm'] ?? '';

  // Server-side validation
  if ($fullname === '') $errors[] = 'Full name is required.';
  if ($email === '') $errors[] = 'A valid email is required.';
  if (!preg_match('/^\d{10,13}$/', $phone)) $errors[] = 'Please enter a valid phone number (10 to 13 digits).';
  if (strlen($rawPassword) < 6) $errors[] = 'Password must be at least 6 characters.';
  if ($rawPassword !== $password_confirm) $errors[] = 'Passwords do not match.';

  if (empty($errors)) {
    $password = password_hash($rawPassword, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result && $result->num_rows > 0) {
      $errors[] = "Email already registered. Please login.";
    } else {
      $insert = $conn->prepare("INSERT INTO users (fullname, email, phone, password) VALUES (?, ?, ?, ?)");
      $insert->bind_param("ssss", $fullname, $email, $phone, $password);
      if ($insert->execute()) {
        header('Location: login.php?success=registered');
        exit();
      } else {
        $errors[] = "Error: " . htmlspecialchars($conn->error);
      }
      $insert->close();
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - Kicks Collection</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="form-container">
    <h1>Create Account</h1>
    <?php if ($success): ?><p class="success-msg"><?php echo $success; ?></p><?php endif; ?>
    <?php if (!empty($errors)): ?><ul class="error-msg"><?php foreach($errors as $e): ?><li><?php echo htmlspecialchars($e); ?></li><?php endforeach; ?></ul><?php endif; ?>
    <form action="register.php" method="POST" novalidate>
      <input type="text" name="fullname" placeholder="Full Name" value="<?php echo htmlspecialchars($fullname); ?>" required>
      <input type="email" name="email" placeholder="Email Address" value="<?php echo htmlspecialchars($email); ?>" required>
      <input type="tel" name="phone" placeholder="Phone Number (10-13 digits)" pattern="[0-9]{10,13}" value="<?php echo htmlspecialchars($phone); ?>" required>
      <input type="password" name="password" placeholder="Password (min 6 chars)" required>
      <input type="password" name="password_confirm" placeholder="Confirm Password" required>
      <button type="submit">Register</button>
      <p>Already have an account? <a href="login.php">Login</a></p>
    </form>
  </div>
</body>
</html>