<?php
include("session.php");
start_session_no_cookie();

if (isset($_SESSION['user_id'])) {
    header("Location: " . append_sid("Chichi.php"));
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kibe Kicks and Fits | Welcome</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="navbar">
        <div class="logo">Kibe Kicks and Fits</div>
        <nav>
            <ul class="nav-links">
                <li><a href="homepage.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php" class="button button-outline">Register</a></li>
            </ul>
        </nav>
    </header>

    <main class="landing-page">
        <section class="hero hero-landing">
            <div class="hero-copy">
                <span class="eyebrow">New drops, street-ready style</span>
                <h1>Step into your next pair with confidence</h1>
                <p class="intro-text">Kibe Kicks and Fits brings you premium sneakers, bold designs, and a seamless shopping experience.</p>
                <div class="hero-actions">
                    <a href="login.php" class="button">Login</a>
                    <a href="register.php" class="button button-outline">Register</a>
                </div>
                <div class="hero-meta">
                    <div><strong>120+</strong> trending styles</div>
                    <div><strong>24/7</strong> fast support</div>
                    <div><strong>100%</strong> authentic footwear</div>
                </div>
            </div>
        </section>

        <section class="feature-grid section-card-group">
            <article class="feature-card">
                <h3>Premium quality</h3>
                <p>Every pair is curated for comfort, durability, and modern style.</p>
            </article>
            <article class="feature-card">
                <h3>Ready for the city</h3>
                <p>Streetwear-ready looks with standout colorways and strong silhouettes.</p>
            </article>
            <article class="feature-card">
                <h3>Fast checkout</h3>
                <p>Sign in to access your dashboard, manage orders, and complete purchases quickly.</p>
            </article>
        </section>

        <section class="highlight-section">
            <div class="section-header">
                <h2>Featured sneaker picks</h2>
                <p>Preview what’s trending this week in the Kibe Kicks collection.</p>
            </div>

            <div class="shoe-container">
                <article class="shoe-item">
                    <img src="Airforce 1 custome.jpg" alt="Airforce 1 custom" class="shoe-img">
                    <h3>Airforce 1 Custom</h3>
                    <p>Classic styling with a custom edge for every outfit.</p>
                </article>
                <article class="shoe-item">
                    <img src="Wet look shoes.jpg" alt="Wet look sneakers" class="shoe-img">
                    <h3>Wet Look Runner</h3>
                    <p>Shiny finish and modern comfort for evening streetwear.</p>
                </article>
                <article class="shoe-item">
                    <img src="Versache.jpg" alt="Versache sneakers" class="shoe-img">
                    <h3>Versache Edition</h3>
                    <p>Bold silhouette and premium materials for standout looks.</p>
                </article>
            </div>
        </section>

        <section class="cta-bar">
            <div>
                <h2>Ready to shop your next pair?</h2>
                <p>Register now and unlock faster checkout, your own dashboard, and first-look access to new arrivals.</p>
            </div>
            <a href="register.php" class="button button-primary">Create Your Account</a>
        </section>

        <footer class="footer">
            <p>Want quick help? <a href="contact.php">Contact us</a> and we’ll support your order before you log in.</p>
        </footer>
    </main>
</body>
</html>
