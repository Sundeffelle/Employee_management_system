<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    die("Unauthorized access");
}

if (isset($_POST['current_password']) && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
    include "../DB_connection.php";

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $admin_id = $_SESSION['id'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if the new passwords match
    if ($new_password !== $confirm_password) {
        die("New passwords do not match");
    }

    // Fetch the current password from the database
    $sql = "SELECT password FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->execute([$admin_id]);
    $user = $stmt->fetch();

    if ($user && password_verify($current_password, $user['password'])) {
        // Hash the new password
        $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the password in the database
        $sql_update = "UPDATE users SET password = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        if (!$stmt_update) {
            die("Error preparing update statement: " . $conn->error);
        }

        if ($stmt_update->execute([$new_password_hash, $admin_id])) {
            echo "Password changed successfully";
        } else {
            die("Failed to update password");
        }
    } else {
        die("Incorrect current password");
    }
} else {
    die("All fields are required");
}
?>
