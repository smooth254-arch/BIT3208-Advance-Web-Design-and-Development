<?php
include("db.php");
include("session.php");
start_session_no_cookie();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        $stmt = $conn->prepare("SELECT id, fullname, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['fullname'] = $row['fullname'];
                header("Location: " . append_sid("Chichi.php"));
                exit();
            } else {
                $error = "Invalid password";
            }
        } else {
            $error = "No account found with this email";
        }
    }
}

$formAction = htmlspecialchars($_SERVER['PHP_SELF']);
if (isset($_REQUEST['sid'])) {
    $formAction .= '?sid=' . urlencode($_REQUEST['sid']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Kibe Kicks and Fits</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h1>Welcome Back</h1>
        <?php if(!empty($error)){ echo "<p class='error-msg'>" . htmlspecialchars($error) . "</p>"; } ?>
        <form action="<?php echo $formAction; ?>" method="POST">
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <p>Don't have an account? <a href="register.php">Register</a></p>
        </form>
    </div>
</body>
</html>