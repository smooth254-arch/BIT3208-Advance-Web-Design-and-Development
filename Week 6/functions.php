<?php
function secure_session_start(): void
{
    $secure = !empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off';
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => $secure,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);

    if (session_status() === PHP_SESSION_NONE) {
        if (empty($_COOKIE[session_name()]) && isset($_REQUEST['sid']) && preg_match('/^[a-zA-Z0-9,-]+$/', $_REQUEST['sid'])) {
            session_id($_REQUEST['sid']);
        }
        session_start();
    }

    if (!isset($_SESSION['initiated'])) {
        session_regenerate_id(true);
        $_SESSION['initiated'] = true;
    }
}

function h(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function get_csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token(?string $token): bool
{
    return !empty($token) && !empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function ensure_active_session(): bool
{
    if (!isset($_SESSION['last_activity'])) {
        return false;
    }
    $timeout = 1800;
    if (time() - $_SESSION['last_activity'] > $timeout) {
        return false;
    }
    $_SESSION['last_activity'] = time();
    return true;
}

function require_login(): void
{
    if (!isset($_SESSION['user_id'], $_SESSION['role']) || !ensure_active_session()) {
        logout_user();
        header('Location: login.php');
        exit;
    }
}

function require_admin(): void
{
    require_login();
    if ($_SESSION['role'] !== 'admin') {
        header('Location: login.php');
        exit;
    }
}

function logout_user(): void
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
}
?>
