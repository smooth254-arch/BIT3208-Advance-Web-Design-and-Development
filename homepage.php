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
    <title>Welcome | Kibe Kicks and Fits</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="navbar">
        <div class="logo">Kibe Kicks and Fits</div>
        <nav>
            <ul class="nav-links">
                <li><a href="homepage.php">Home</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main class="landing-page">
        <section class="hero hero-landing">
            <div class="hero-copy">
                <p class="eyebrow">Fresh drops every week</p>
                <h1>Discover your next favorite pair with Kibe Kicks</h1>
                <p class="intro-text">Explore bold sneaker styles and premium footwear before login. Register for your dashboard, fast checkout, and exclusive offers.</p>
                <div class="hero-actions">
                    <a href="login.php" class="button">Login</a>
                    <a href="register.php" class="button">Register</a>
                    <a href="contact.php" class="button button-light">Contact Support</a>
                </div>
            </div>
            <div class="hero-visual">
                <img src="sneaker-852-x-1280-background-7ot45s84y2sycgoh.jpg" alt="Sneaker showcase">
            </div>
        </section>

        <section class="landing-highlights">
            <div class="highlight-card">
                <h3>Easy access</h3>
                <p>Login or register in seconds and get a personal dashboard.</p>
            </div>
            <div class="highlight-card">
                <h3>Top picks</h3>
                <p>Preview the latest shoe styles before you sign in.</p>
            </div>
            <div class="highlight-card">
                <h3>Quick support</h3>
                <p>Contact support anytime from the landing page.</p>
            </div>
        </section>
    </main>
</body>
</html>
