<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../inc/DB_connection.php"; 

function validate_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = validate_input($_POST['username'] ?? '');
    $password = validate_input($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $em = "All fields are required.";
        header("Location: admin_login.php?error=" . urlencode($em));
        exit();
    }

    try {
        $sql = "SELECT * FROM users WHERE username = ? AND role = 'admin' LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username]);

        if ($stmt->rowCount() === 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user['is_suspended'] == 1) {
                $em = "Your admin account is suspended.";
                header("Location: login_form.php?error=" . urlencode($em));
                exit();
            }

            if (password_verify($password, $user['password'])) {
                // Admin successfully logged in
                $_SESSION['role'] = $user['role'];
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['email'] = $user['email'];

                // Redirect admin to admin dashboard
                header("Location: ../Resources/index.php");
                exit();
            } else {
                $em = "Invalid username or password.";
                header("Location: login_form.php?error=" . urlencode($em));
                exit();
            }
        } else {
            $em = "No admin found with that username.";
            header("Location: login_form.php?error=" . urlencode($em));
            exit();
        }
    } catch (PDOException $e) {
        error_log("Login Error: " . $e->getMessage());
        $em = "An error occurred. Please try again.";
        header("Location: login_form.php?error=" . urlencode($em));
        exit();
    }
} else {
    $em = "Invalid request method.";
    header("Location: login_form.php?error=" . urlencode($em));
    exit();
}
