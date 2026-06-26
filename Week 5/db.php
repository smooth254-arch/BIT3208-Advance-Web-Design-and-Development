<?php
$conn = mysqli_connect("localhost", "root", "", "studentdb");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Ensure the users table exists for Week 5 authentication.
$create = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
mysqli_query($conn, $create);

// Ensure the password column is wide enough for bcrypt hashes.
mysqli_query($conn, "ALTER TABLE users MODIFY COLUMN password VARCHAR(255) NOT NULL");

// Remove duplicate usernames if table existed before the UNIQUE constraint.
$cleanup = "DELETE t1 FROM users t1
    INNER JOIN users t2
    WHERE t1.id > t2.id
      AND t1.username = t2.username";
mysqli_query($conn, $cleanup);

// Ensure username is unique.
$indexCheck = mysqli_query($conn, "SHOW INDEX FROM users WHERE Key_name = 'unique_username'");
if (!$indexCheck || mysqli_num_rows($indexCheck) === 0) {
    mysqli_query($conn, "ALTER TABLE users ADD UNIQUE INDEX unique_username (username)");
}

$defaults = [
    ['admin', password_hash('secret123', PASSWORD_DEFAULT)],
    ['student', password_hash('pass123', PASSWORD_DEFAULT)]
];
$insert = mysqli_prepare($conn, "INSERT INTO users (username, password) VALUES (?, ?) ON DUPLICATE KEY UPDATE password = VALUES(password)");
foreach ($defaults as $row) {
    mysqli_stmt_bind_param($insert, 'ss', $row[0], $row[1]);
    mysqli_stmt_execute($insert);
}
mysqli_stmt_close($insert);
