<?php
include("session.php");
start_session_no_cookie();
session_unset();
session_destroy();
header("Location: login.php");
exit();
?>