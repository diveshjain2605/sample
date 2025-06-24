<?php
session_start();

// Check if user is logged in
function checkLogin() {
    if (!isset($_SESSION['user_name'])) {
        // Check for remember me cookies
        if (isset($_COOKIE['remember_user']) && isset($_COOKIE['remember_pass'])) {
            // Auto-login with cookies
            include('conn.php');
            $user_name = mysqli_real_escape_string($conn, $_COOKIE['remember_user']);
            $password = $_COOKIE['remember_pass']; // Already hashed

            $rawQuery = "SELECT * FROM user WHERE user_name='$user_name' and password='$password'";
            $query = mysqli_query($conn, $rawQuery);

            if(mysqli_num_rows($query) > 0) {
                $user = mysqli_fetch_assoc($query);
                $_SESSION['user_name'] = $user['first_name'];
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                return true;
            }
        }

        // Redirect to login if not authenticated
        header('Location: index.php');
        exit();
    }
    return true;
}

// Get current page name
function getCurrentPage() {
    return basename($_SERVER['PHP_SELF']);
}

// Check if current page requires authentication
$public_pages = ['index.php', 'intro.php', 'regestration.php', 'regestrationformsubmit.php', 'login_check.php'];
$current_page = getCurrentPage();

if (!in_array($current_page, $public_pages)) {
    checkLogin();
}
?>
