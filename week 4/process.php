<?php
// Simple PHP processing page for Week 4
$result = '';
$input = '';
$notes = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = trim($_POST['input'] ?? '');
    $notes = trim($_POST['notes'] ?? '');
    if ($input !== '') {
        $result = 'Received: ' . htmlspecialchars($input);
        if ($notes !== '') {
            $result .= ' — Notes: ' . htmlspecialchars($notes);
        }
    } else {
        $result = 'Please enter a value to process.';
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Process - Week 4</title>
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
    <h1>PHP Processing Demo</h1>
    <p>Enter a simple value and PHP will process it using POST.</p>
    <?php if ($result !== ''): ?>
      <p style="color:#004099;font-weight:bold;"><?php echo $result; ?></p>
    <?php endif; ?>
    <form method="POST" action="process.php">
      <label>Value to process</label>
      <input type="text" name="input" value="<?php echo htmlspecialchars($input); ?>" required>
      <label>Notes</label>
      <input type="text" name="notes" value="<?php echo htmlspecialchars($notes); ?>">
      <button type="submit">Process</button>
    </form>
  </div>
</body>
</html>
