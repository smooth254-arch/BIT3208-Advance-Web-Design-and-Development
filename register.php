<?php
include("db.php");

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $fullname = trim($_POST['fullname'] ?? '');
  $email    = trim($_POST['email'] ?? '');
  $phone    = trim($_POST['phone'] ?? '');
  $rawPassword = $_POST['password'] ?? '';

  // Server-side validation
  if ($fullname === '') {
    $error = 'Full name is required.';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = 'Please enter a valid email address.';
  } elseif (!preg_match('/^\d{10,13}$/', $phone)) {
    $error = 'Please enter a valid phone number (10 to 13 digits).';
  } elseif (strlen($rawPassword) < 8 || !preg_match('/[0-9]/', $rawPassword) || !preg_match('/[A-Za-z]/', $rawPassword)) {
    $error = 'Password must be at least 8 characters and include letters and numbers.';
  }

  if ($error === '') {
    $password = password_hash($rawPassword, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
      $error = "Email already registered. Please login.";
    } else {
      $insert = $conn->prepare("INSERT INTO users (fullname, email, phone, password) VALUES (?, ?, ?, ?)");
      $insert->bind_param("ssss", $fullname, $email, $phone, $password);
      if ($insert->execute()) {
        header('Location: login.php');
        exit();
      } else {
        $error = "Error: " . htmlspecialchars($conn->error);
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - Kibe Kicks and Fits</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="form-container">
    <h1>Create Account</h1>
    <?php if(!empty($error)){ echo "<p class='error-msg'>" . htmlspecialchars($error) . "</p>"; } ?>
    <form action="" method="POST" novalidate>
      <input type="text" name="fullname" placeholder="Full Name" value="<?php echo isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : ''; ?>" required>
      <input type="email" name="email" placeholder="Email Address" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
      <input type="tel" name="phone" placeholder="Phone Number (10-13 digits)" pattern="[0-9]{10,13}" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>" required>
      <input type="password" name="password" placeholder="Password (min 8 chars, letters+numbers)" minlength="8" required>
      <button type="submit">Register</button>
      <p>Already have an account? <a href="login.php">Login</a></p>
    </form>
  </div>
</body>
</html>