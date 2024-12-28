<?php 

session_start();

// Determine the role before unsetting the session
$redirectPage = "login.php"; // Default redirection page
if (isset($_SESSION['role'])) {
    switch ($_SESSION['role']) {
        case 'admin':
            $redirectPage = "../Admin/login_form.php"; // Admin login page
            break;
        case 'employee':
            $redirectPage = "login.php"; // Employee login page
            break;
        case 'company':
            $redirectPage = "../Company/subscription_success.php"; // Company login page
            break;
        default:
            $redirectPage = "login.php"; // Default fallback
            break;
    }
}

// Unset session variables and destroy the session
session_unset();
session_destroy();

// Redirect to the appropriate login page
header("Location: $redirectPage");
exit();

