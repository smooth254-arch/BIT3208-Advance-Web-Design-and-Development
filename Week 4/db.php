<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kicks_db";

$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Try to select the database. If it does not exist, attempt to create it.
// Suppress mysqli exceptions/warnings and handle failures gracefully so the
// user sees a clear message if their MySQL user lacks CREATE DATABASE rights.
mysqli_report(MYSQLI_REPORT_OFF);
$selected = $conn->select_db($dbname);
if (!$selected) {
    $created = $conn->query("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    if ($created) {
        $selected = $conn->select_db($dbname);
    } else {
        die("Database '$dbname' does not exist and could not be created. " .
            "Please create the database manually (for example via phpMyAdmin) " .
            "or grant the MySQL user sufficient privileges. MySQL error: " . htmlspecialchars($conn->error));
    }
}

$conn->query("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(32) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$conn->query("CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price VARCHAR(64) NOT NULL,
    image VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$sample = $conn->query("SELECT COUNT(*) AS count FROM products");
if ($sample) {
    $count = $sample->fetch_assoc()['count'];
    if ($count == 0) {
        $conn->query("INSERT INTO products (name, price, image, description) VALUES
            ('Versache', 'Ksh 4,500', 'WhatsApp Image 2024-11-21 at 08.12.08_472b1aec.jpg', 'Premium sneakers with bold styling.'),
            ('Airforce 1 Custom', 'Ksh 3,200', 'WhatsApp Image 2024-11-13 at 08.20.18_02ffc443.jpg', 'Custom Airforce 1 shoes with unique flair.'),
            ('Classic Loafers', 'Ksh 5,000', 'Zaza.jpg', 'Comfortable loafers with timeless design.')");
    }
}
?>
