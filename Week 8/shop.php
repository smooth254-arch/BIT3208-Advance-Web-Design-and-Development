<?php
include("session.php");
start_session_no_cookie();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include("db.php");

$productQuery = $conn->query("SELECT name, price, image, description FROM products ORDER BY id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shop - Kibe Kicks and Fits</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="navbar">
        <div class="logo">Kibe Kicks and Fits</div>
        <nav>
            <ul class="nav-links">
                <li><a href="<?php echo append_sid('index.php'); ?>">Home</a></li>
                <li><a href="<?php echo append_sid('shop.php'); ?>">Shop</a></li>
                <li><a href="<?php echo append_sid('contact.php'); ?>">Contact</a></li>
                <li><a href="<?php echo append_sid('logout.php'); ?>" class="logout-link">Logout</a></li>
            </ul>
        </nav>
    </header>

    <h1 id="main-title">SHOP</h1>
    <p class="subtitle">Browse the shoes currently in the database.</p>

    <section class="shoe-container">
        <?php while ($product = $productQuery->fetch_assoc()): ?>
            <div class="shoe-item">
                <h2><b><?php echo htmlspecialchars($product['name']); ?></b></h2>
                <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="shoe-img">
                <p><i>Price: <?php echo htmlspecialchars($product['price']); ?></i></p>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <a href="tel:+254717003737" class="button">Order Now: +254717003737</a>
            </div>
        <?php endwhile; ?>
    </section>
</body>
</html>