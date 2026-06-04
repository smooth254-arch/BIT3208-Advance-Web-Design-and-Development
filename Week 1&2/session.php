<?php
ini_set('session.use_cookies', 0);
ini_set('session.use_only_cookies', 0);
ini_set('session.use_trans_sid', 0);

function start_session_no_cookie() {
    if (session_status() === PHP_SESSION_NONE) {
        if (isset($_REQUEST['sid']) && preg_match('/^[a-zA-Z0-9,-]+$/', $_REQUEST['sid'])) {
            session_id($_REQUEST['sid']);
        }
        session_start();
    }
}

function get_session_url() {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        start_session_no_cookie();
    }
    return 'sid=' . session_id();
}

function append_sid($url) {
    $sep = strpos($url, '?') === false ? '?' : '&';
    return $url . $sep . get_session_url();
}
?>