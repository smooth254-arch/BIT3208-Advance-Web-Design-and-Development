<?php
include("session.php");
start_session_no_cookie();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Contact - KICKS COLLECTION</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="navbar">
        <div class="logo">KicksCollection</div>
        <nav>
            <ul class="nav-links">
                <li><a href="<?php echo append_sid('index.php'); ?>">Home</a></li>
                <li><a href="<?php echo append_sid('shop.php'); ?>">Shop</a></li>
                <li><a href="<?php echo append_sid('contact.php'); ?>">Contact</a></li>
                <li><a href="<?php echo append_sid('logout.php'); ?>" class="logout-link">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="form-container">
        <h1>Contact Us</h1>
        <p>Call or message us at <strong>+254717003737</strong>.</p>
        <p>Email: <strong>support@kickscollection.local</strong></p>
        <p>Address: Nairobi, Kenya</p>
    </div>
</body>
</html>