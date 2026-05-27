<?php
// Make dashboard the default index page by including the dashboard logic
include("session.php");
start_session_no_cookie();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include the dashboard (previously Chichi.php) directly so index.php
// becomes the main authenticated landing page.
include_once("Chichi.php");
?>