<?php
require_once 'functions.php';
secure_session_start();
logout_user();
header('Location: login.php');
exit;
?>