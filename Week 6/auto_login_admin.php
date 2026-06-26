<?php
// One-click local dev admin login. Removes risk by limiting to localhost only.
if (!in_array($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1', ['127.0.0.1','::1'])) {
    http_response_code(403);
    echo "Forbidden";
    exit;
}
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';
// start secure session
secure_session_start();

$email = 'smoothtech19@gmail.com';
// ensure admin exists
$hashStmt = $conn->prepare('SELECT id, fullname, password, role FROM users WHERE email = ? LIMIT 1');
$hashStmt->bind_param('s', $email);
$hashStmt->execute();
$hashStmt->bind_result($id, $fullname, $hash, $role);
$found = $hashStmt->fetch();
$hashStmt->close();

if (!$found) {
    // seed admin
    $password = 'Admin@123';
    $fullname = 'Kibe Admin';
    $phone = '0000000000';
    $role = 'admin';
    $h = password_hash($password, PASSWORD_DEFAULT);
    $ins = $conn->prepare('INSERT INTO users (fullname, email, phone, password, role) VALUES (?, ?, ?, ?, ?)');
    $ins->bind_param('sssss', $fullname, $email, $phone, $h, $role);
    $ins->execute();
    $ins->close();
    // re-query
    $q = $conn->prepare('SELECT id, fullname, password, role FROM users WHERE email = ? LIMIT 1');
    $q->bind_param('s', $email);
    $q->execute();
    $q->bind_result($id, $fullname, $hash, $role);
    $q->fetch();
    $q->close();
}

if (!$id) {
    echo "Unable to locate or create admin user.";
    exit;
}

session_regenerate_id(true);
$_SESSION['user_id'] = $id;
$_SESSION['fullname'] = $fullname;
$_SESSION['role'] = 'admin';
$_SESSION['last_activity'] = time();

header('Location: admin_dashboard.php');
exit;

?>
