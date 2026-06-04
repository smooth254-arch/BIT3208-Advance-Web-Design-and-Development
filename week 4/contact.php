<?php
// Contact form processing using POST and storing messages in contacts.json
$errors = [];
$success = '';
$name = '';
$email = '';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $emailRaw = trim($_POST['email'] ?? '');
    $email = filter_var($emailRaw, FILTER_VALIDATE_EMAIL) ? $emailRaw : '';
    $message = trim($_POST['message'] ?? '');

    if ($name === '') $errors[] = 'Name is required.';
    if ($email === '') $errors[] = 'A valid email is required.';
    if ($message === '') $errors[] = 'Message cannot be empty.';

    if (empty($errors)) {
        $contactsFile = __DIR__ . '/contacts.json';
        if (!file_exists($contactsFile)) file_put_contents($contactsFile, json_encode([]));
        $contacts = json_decode(file_get_contents($contactsFile), true) ?? [];
        $contacts[] = [
            'name' => $name,
            'email' => $email,
            'message' => $message,
            'created_at' => time()
        ];
        file_put_contents($contactsFile, json_encode($contacts, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), LOCK_EX);
        $success = 'Thank you, your message has been received.';
        $name = $email = $message = '';
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Contact - Week 4</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  <div class="navbar">
    <div class="logo">Week 4</div>
    <ul>
      <li><a href="index.html">Home</a></li>
      <li><a href="welcome.php">Welcome POST</a></li>
      <li><a href="register.php">Register</a></li>
      <li><a href="login.php">Login</a></li>
      <li><a href="contact.php">Contact</a></li>
      <li><a href="process.php">Process</a></li>
    </ul>
  </div>
  <div class="form-container">
    <h1>Contact Us</h1>
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
    <form method="POST" action="contact.php">
      <label>Name</label>
      <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
      <label>Email</label>
      <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
      <label>Message</label>
      <textarea name="message" rows="5" required><?php echo htmlspecialchars($message); ?></textarea>
      <button type="submit">Send Message</button>
    </form>
  </div>
</body>
</html>
