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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome | Kibe Kicks and Fits</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="homepage">
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
                    <p class="hero-welcome">Welcome to Kibe Kicks</p>
                    <p class="eyebrow">Fresh drops every week</p>
                    <h1>Discover your next favorite pair with Kibe Kicks</h1>
                    <div class="hero-actions">
                        <a href="login.php" class="button">Login</a>
                        <a href="register.php" class="button">Register</a>
                        <a href="contact.php" class="button button-light">Contact Support</a>
                    </div>
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
