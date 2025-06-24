<?php
session_start();

// Clear all session variables
$_SESSION = array();

// Delete session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Clear remember me cookies
if (isset($_COOKIE['remember_user'])) {
    setcookie("remember_user", "", time() - 3600, "/");
}
if (isset($_COOKIE['remember_pass'])) {
    setcookie("remember_pass", "", time() - 3600, "/");
}

// Destroy session
session_destroy();

// Redirect to login page with logout message
header('Location: index.php?logout=1');
exit();
?>