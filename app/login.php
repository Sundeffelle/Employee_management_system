<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "../inc/DB_connection.php";

    function validate_input($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    function safe_redirect($url, $error_message = null) {
        if ($error_message) {
            $url .= "?error=" . urlencode($error_message);
        }
        header("Location: $url");
        exit();
    }

    $user_name = validate_input($_POST['user_name']);
    $password = validate_input($_POST['password']);

    // Validate required fields
    if (empty($user_name) || empty($password)) {
        safe_redirect("../Resources/login.php", "All fields are required.");
    }

    try {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$user_name]);

        if ($stmt->rowCount() === 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check if the user is suspended
            if ($user['is_suspended'] == 1) {
                safe_redirect("../Resources/login.php", "Your account is suspended. Please contact the administrator.");
            }

            // Verify password
            if (password_verify($password, $user['password'])) {
                session_regenerate_id(true); // Prevent session fixation

                // Set session variables
                $_SESSION['role'] = $user['role'];
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['department'] = $user['department'];
                $_SESSION['dob'] = $user['dob'];
                $_SESSION['gender'] = $user['gender'];
                $_SESSION['marital_status'] = $user['marital_status'];
                $_SESSION['work_location'] = $user['work_location'];
                $_SESSION['employment_type'] = $user['employment_type'];
                $_SESSION['profile_image'] = $user['profile_image'];

                // Redirect based on role
                switch ($user['role']) {
                    case 'admin':
                        safe_redirect("../Resources/index.php");
                        break;
                    case 'employee':
                        safe_redirect("../Resources/index.php");
                        break;
                    case 'evaluator':
                        safe_redirect("../Resources/index.php");
                        break;
                    default:
                        safe_redirect("../Resources/login.php", "Unknown role.");
                }
            } else {
                safe_redirect("../Resources/login.php", "Invalid username or password.");
            }
        } else {
            safe_redirect("../Resources/login.php", "No user found with that username.");
        }
    } catch (PDOException $e) {
        error_log("Login Error: " . $e->getMessage());
        safe_redirect("../Resources/login.php", "An error occurred. Please try again.");
    }
} else {
    safe_redirect("../Resources/login.php", "Invalid request method.");
}
