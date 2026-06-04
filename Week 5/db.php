<?php
$conn = mysqli_connect("localhost", "root", "", "studentdb");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Ensure the users table exists for Week 5 authentication.
$create = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
mysqli_query($conn, $create);

$defaults = [
    ['admin', password_hash('secret123', PASSWORD_DEFAULT)],
    ['student', password_hash('pass123', PASSWORD_DEFAULT)]
];
$insert = mysqli_prepare($conn, "INSERT IGNORE INTO users (username, password) VALUES (?, ?)");
foreach ($defaults as $row) {
    mysqli_stmt_bind_param($insert, 'ss', $row[0], $row[1]);
    mysqli_stmt_execute($insert);
}
mysqli_stmt_close($insert);
