<?php
include("session.php");
start_session_no_cookie();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include_once __DIR__ . DIRECTORY_SEPARATOR . 'week 3' . DIRECTORY_SEPARATOR . 'backend-php' . DIRECTORY_SEPARATOR . 'node_client.php';

$shoes = fetch_node_shoes();
$defaultShoes = [
    [
        'name' => 'Versache',
        'price' => 'Ksh 4,500',
        'image' => 'Wet look shoes.jpg',
        'description' => 'Premium sneakers with bold styling.'
    ],
    [
        'name' => 'Airforce 1 Custom',
        'price' => 'Ksh 3,200',
        'image' => 'Airforce 1 custome.jpg',
        'description' => 'Custom Airforce 1 shoes with unique flair.'
    ],
    [
        'name' => 'Classic Loafers',
        'price' => 'Ksh 5,000',
        'image' => 'Versache.jpg',
        'description' => 'Comfortable loafers with timeless design.'
    ]
];

if (!is_array($shoes) || count($shoes) === 0) {
    $shoes = $defaultShoes;
} else {
    foreach ($shoes as &$shoe) {
        if (!is_array($shoe)) {
            continue;
        }
        if (!isset($shoe['image']) || trim((string)$shoe['image']) === '') {
            $name = isset($shoe['name']) ? strtolower($shoe['name']) : '';
            if (strpos($name, 'versache') !== false) {
                $shoe['image'] = 'Wet look shoes.jpg';
            } elseif (strpos($name, 'airforce') !== false) {
                $shoe['image'] = 'Airforce 1 custome.jpg';
            } elseif (strpos($name, 'classic') !== false || strpos($name, 'loafer') !== false) {
                $shoe['image'] = 'Versache.jpg';
            } else {
                $shoe['image'] = 'sneaker-852-x-1280-background-7ot45s84y2sycgoh.jpg';
            }
        }
        if (!isset($shoe['description']) || trim((string)$shoe['description']) === '') {
            $shoe['description'] = 'High-quality kicks for the best fit.';
        }
    }
    unset($shoe);
}

function image_url($image) {
    $path = __DIR__ . DIRECTORY_SEPARATOR . $image;
    if (file_exists($path)) {
        return rawurlencode($image);
    }
    return rawurlencode('sneaker-852-x-1280-background-7ot45s84y2sycgoh.jpg');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Shop - Kibe Kicks and Fits</title>
    <link rel="stylesheet" href="style.css?v=1.2">
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
    <p class="subtitle">Take a look at the latest kicks below.</p>

    <section class="shoe-container">
        <?php foreach ($shoes as $product): ?>
            <div class="shoe-item">
                <h2><b><?php echo htmlspecialchars($product['name']); ?></b></h2>
                <img src="<?php echo htmlspecialchars(image_url($product['image'])); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="shoe-img">
                <p><i>Price: <?php echo htmlspecialchars($product['price']); ?></i></p>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <div class="button-group">
                    <a href="#" class="button order-button" onclick="orderChoice(event)">Order: 0717003737</a>
                </div>
            </div>
        <?php endforeach; ?>
    </section>

    <script>
        function orderChoice(event) {
            event.preventDefault();
            var useWhatsApp = confirm("Open WhatsApp? Press OK for WhatsApp, Cancel to call.");
            if (useWhatsApp) {
                window.location.href = "https://wa.me/254717003737";
            } else {
                window.location.href = "tel:+254717003737";
            }
        }
    </script>
</body>
</html>
