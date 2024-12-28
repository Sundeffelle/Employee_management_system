<?php
ini_set('display_errors',1);
ini_set('display_startup-errors', 1);
error_reporting(E_ALL);
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
    if ($_POST) {
        include "../DB_connection.php";
        include "../app/Model/User.php";
        $id = $_SESSION['id'];
        $full_name = trim($_POST['full_name']);
        $email = trim($_POST['email']);
        $phone_number = trim($_POST['phone_number']);
        $address = trim($_POST['address']);
        $department = trim($_POST['department']);
        $profile_image = $_FILES['profile_image'] ?? null;

        // Validation
        if (empty($full_name) || empty($email)) {
            header("Location: ../edit_profile.php?error=Full Name and Email are required");
            exit();
        }

        try {
            $user = get_user_by_id($conn, $id);

            $file_name = $user['profile_image'];
            if ($profile_image && $profile_image['error'] === UPLOAD_ERR_OK) {
                $target_dir = "../uploads/profile_images/";
                if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
                $file_name = uniqid("profile_", true) . "." . pathinfo($profile_image['name'], PATHINFO_EXTENSION);
                move_uploaded_file($profile_image['tmp_name'], $target_dir . $file_name);
            }

            // Update profile
            $sql = "UPDATE users 
                    SET full_name = ?, email = ?, phone_number = ?, address = ?, department = ?, profile_image = ? 
                    WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$full_name, $email, $phone_number, $address, $department, $file_name, $id]);

            header("Location: ../edit_profile.php?success=Profile updated successfully");
            exit();
        } catch (Exception $e) {
            header("Location: ../edit_profile.php?error=An error occurred. Please try again.");
            exit();
        }
    }
} else {
    header("Location: ../login.php?error=Unauthorized access");
    exit();
}
