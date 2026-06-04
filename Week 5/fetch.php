<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

include 'db.php';

$result = mysqli_query($conn, "SELECT username FROM users");
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>User List - Week 5</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f5f5f5; padding:24px; }
        .card { background:#fff; max-width:520px; margin:auto; padding:20px; border-radius:12px; box-shadow:0 10px 24px rgba(0,0,0,.08); }
        ul { list-style:none; padding:0; }
        li { padding:10px 0; border-bottom:1px solid #eee; }
        .header { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; }
        .button { display:inline-block; padding:10px 16px; background:#0a69ff; color:#fff; border-radius:8px; text-decoration:none; }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <div>
                <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?></h2>
                <p>Logged in via Week 5 auth.</p>
            </div>
            <a class="button" href="logout.php">Logout</a>
        </div>
        <h3>Registered Users</h3>
        <ul>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <li><?php echo htmlspecialchars($row['username']); ?></li>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>
