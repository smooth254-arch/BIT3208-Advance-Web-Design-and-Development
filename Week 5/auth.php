<?php
session_start();
include 'db.php';

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');
if ($username === '') {
    header('Location: login.php?error=' . urlencode('Please enter a username.'));
    exit;
}

// Allow any username/password: create the user record if missing, then set session.
$insert = mysqli_prepare($conn, "INSERT IGNORE INTO users (username, password) VALUES (?, '')");
mysqli_stmt_bind_param($insert, 's', $username);
mysqli_stmt_execute($insert);
mysqli_stmt_close($insert);

$_SESSION['user'] = $username;
header('Location: fetch.php');
exit;
