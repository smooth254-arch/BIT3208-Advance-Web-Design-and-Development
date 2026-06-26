<?php
$mysqli = new mysqli('localhost', 'root', '', 'kicks_db');
if ($mysqli->connect_error) {
    echo 'CONNECTFAIL: ' . $mysqli->connect_error;
    exit(1);
}
$result = $mysqli->query("SELECT id, email, role FROM users WHERE email = 'smoothtech19@gmail.com' LIMIT 1");
if ($result && $row = $result->fetch_assoc()) {
    echo 'FOUND:' . $row['id'] . ':' . $row['email'] . ':' . $row['role'];
    exit(0);
}
$hash = password_hash('Admin@123', PASSWORD_DEFAULT);
$stmt = $mysqli->prepare('INSERT INTO users (fullname, email, phone, password, role) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE fullname = VALUES(fullname), phone = VALUES(phone), password = VALUES(password), role = VALUES(role)');
$fullname = 'Kibe Admin';
$email = 'smoothtech19@gmail.com';
$phone = '0000000000';
$role = 'admin';
$stmt->bind_param('sssss', $fullname, $email, $phone, $hash, $role);
if ($stmt->execute()) {
    echo 'SEEDED:' . $email . ':' . $role;
} else {
    echo 'SEEDFAIL:' . $stmt->error;
}
$stmt->close();
$mysqli->close();
?>