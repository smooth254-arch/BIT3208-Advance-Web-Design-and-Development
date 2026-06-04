<?php
// POST-based welcome page that uses existing animation styles (#main-title)
$name = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
}
$display = $name !== '' ? ucwords(strtolower($name)) : 'Guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Welcome - Week 4</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div style="max-width:900px;margin:60px auto;text-align:center;padding:20px;">
        <h1 id="main-title">Welcome <?php echo htmlspecialchars($display); ?></h1>
        <?php if ($_SERVER['REQUEST_METHOD'] !== 'POST'): ?>
            <p style="margin-top:20px;">Submit your name via the form to see the animated welcome.</p>
            <form method="POST" action="welcome.php" style="margin-top:20px;">
                <input name="fullname" placeholder="Your full name" style="padding:10px;border-radius:6px;border:1px solid #ccc;width:240px;">
                <button type="submit" class="button">Submit</button>
            </form>
        <?php else: ?>
            <p style="margin-top:18px;color:#333;">This greeting was rendered from a POST request.</p>
        <?php endif; ?>
    </div>
</body>
</html>
