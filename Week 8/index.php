<?php
include("session.php");
start_session_no_cookie();

if (isset($_SESSION['user_id'])) {
    header("Location: " . append_sid("Chichi.php"));
    exit();
}

header("Location: homepage.php");
exit();
?>