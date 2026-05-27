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
<html>
<head>
    <title>Kibe Kicks and Fits</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="navbar">
        <div class="logo">Kibe Kicks and Fits</div>
        <nav>
            <ul class="nav-links">
                <li><a href="#">Home</a></li>
                <li><a href="#shop">Shop</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="<?php echo append_sid('logout.php'); ?>" class="logout-link">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section class="hero">
        <h1 id="main-title">WELCOME TO KIBE KICKS AND FITS</h1>
        <p class="subtitle">Hello <?php echo htmlspecialchars($_SESSION['fullname']); ?></p>
    </section>

    <section class="shoe-container" id="shop">
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