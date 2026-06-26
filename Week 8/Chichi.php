<?php
include("session.php");
start_session_no_cookie();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$shoes = [
    [
        'name' => 'Airforce 1 Custom',
        'price' => 'Ksh 3,200',
        'image' => 'WhatsApp Image 2024-11-13 at 08.20.18_02ffc443.jpg',
        'description' => 'Custom Airforce 1 shoes with unique flair.'
    ],
    [
        'name' => 'Versacche',
        'price' => 'Ksh 3,500',
        'image' => 'WhatsApp Image 2024-11-21 at 08.12.08_472b1aec.jpg',
        'description' => 'Premium sneakers with bold styling.'
    ],
    [
        'name' => 'Wet Look Shoes',
        'price' => 'Ksh 5,000',
        'image' => 'Zaza.jpg',
        'description' => 'Glossy wet-look shoes with a polished finish.'
    ]
];

function image_url($image) {
    return rawurlencode($image);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
        <h1 id="main-title">Welcome, <?php echo htmlspecialchars($_SESSION['fullname'] ?? 'Guest'); ?></h1>
    </section>

    <section class="shoe-container" id="shop">
        <?php foreach ($shoes as $shoe): ?>
            <div class="shoe-item">
                <h2><?php echo htmlspecialchars($shoe['name']); ?></h2>
                <img src="<?php echo htmlspecialchars(image_url($shoe['image'])); ?>" alt="<?php echo htmlspecialchars($shoe['name']); ?>" class="shoe-img">
                <p><strong>Price:</strong> <?php echo htmlspecialchars($shoe['price']); ?></p>
                <a href="tel:+254717003737" class="button">Order - 0717003737</a>
            </div>
        <?php endforeach; ?>
    </section>
</body>
</html>

