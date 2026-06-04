<?php
session_start();
include 'db.php';

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');
if ($username === '' || $password === '') {
    header('Location: login.php?error=' . urlencode('Please enter both fields.'));
    exit;
}

$stmt = mysqli_prepare($conn, 'SELECT password FROM users WHERE username = ? LIMIT 1');
mysqli_stmt_bind_param($stmt, 's', $username);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $hash);
if (mysqli_stmt_fetch($stmt) && password_verify($password, $hash)) {
    $_SESSION['user'] = $username;
    mysqli_stmt_close($stmt);
    header('Location: fetch.php');
    exit;
}
mysqli_stmt_close($stmt);
header('Location: login.php?error=' . urlencode('Invalid credentials.'));
