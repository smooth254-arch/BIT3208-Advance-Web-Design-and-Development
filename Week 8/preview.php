<?php
$shoes = [
    [
        'name' => 'Airforce 1 Custom',
        'price' => 'Ksh 3,200',
        'image' => 'WhatsApp Image 2024-11-13 at 08.20.18_02ffc443.jpg',
        'description' => 'Custom Airforce 1 shoes with unique flair.'
    ],
    [
        'name' => 'Versacche',
        'price' => 'Ksh 5,300',
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
<html>
<head>
    <meta charset="UTF-8">
    <title>Kibe Kicks and Fits Preview</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="navbar">
        <div class="logo">Kibe Kicks and Fits</div>
    </header>

    <section class="hero">
        <h1 id="main-title">Welcome, Demo User</h1>
        <p class="subtitle">Order one of these shoes now on 0717003737.</p>
    </section>

    <section class="shoe-container" id="shop">
        <?php foreach ($shoes as $shoe): ?>
            <div class="shoe-item">
                <h2><?php echo htmlspecialchars($shoe['name']); ?></h2>
                <img src="<?php echo htmlspecialchars(image_url($shoe['image'])); ?>" alt="<?php echo htmlspecialchars($shoe['name']); ?>" class="shoe-img">
                <p><strong>Price:</strong> <?php echo htmlspecialchars($shoe['price']); ?></p>
                <p><?php echo htmlspecialchars($shoe['description']); ?></p>
                <a href="tel:+254717003737" class="button">Order - 0717003737</a>
            </div>
        <?php endforeach; ?>
    </section>
</body>
</html>

