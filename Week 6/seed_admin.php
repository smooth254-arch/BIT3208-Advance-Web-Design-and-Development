<?php
require_once 'db.php';

$email = 'smoothtech19@gmail.com';
$password = 'Admin@123';
$fullname = 'Kibe Admin';
$phone = '0000000000';
$role = 'admin';

$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare('INSERT INTO users (fullname, email, phone, password, role) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE fullname = VALUES(fullname), phone = VALUES(phone), password = VALUES(password), role = VALUES(role)');
$stmt->bind_param('sssss', $fullname, $email, $phone, $hash, $role);
$result = $stmt->execute();
if ($result) {
    echo "Admin user created or updated successfully.\n";
    echo "Email: $email\n";
    echo "Password: $password\n";
    echo "Use the same email/password to log in at /login.php.\n";
    echo "To change the admin user later, update the users table in MySQL and set role='admin'.\n";
} else {
    echo "Failed to create admin user: " . $stmt->error . "\n";
}
$stmt->close();
$conn->close();
?>