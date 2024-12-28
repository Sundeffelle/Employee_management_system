<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../inc/DB_connection.php"; 
include "../app/Model/User.php"; // Ensure insert_user function is defined

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function validate_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// If form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = validate_input($_POST['full_name'] ?? '');
    $username = validate_input($_POST['username'] ?? '');
    $email = validate_input($_POST['email'] ?? '');
    $password = validate_input($_POST['password'] ?? '');
    $dob = validate_input($_POST['dob'] ?? '');
    $gender = validate_input($_POST['gender'] ?? '');
    $marital_status = validate_input($_POST['marital_status'] ?? '');
    $nationality = validate_input($_POST['nationality'] ?? '');
    $phone_number = validate_input($_POST['phone_number'] ?? '');
    $address = validate_input($_POST['address'] ?? '');
    $emergency_contact = validate_input($_POST['emergency_contact'] ?? '');
    $work_location = validate_input($_POST['work_location'] ?? '');
    $employment_type = validate_input($_POST['employment_type'] ?? '');
    $account_number = validate_input($_POST['account_number'] ?? '');
    $bank_name = validate_input($_POST['bank_name'] ?? '');
    $ifsc_code = validate_input($_POST['ifsc_code'] ?? '');
    $tin = validate_input($_POST['tin'] ?? '');
    $insurance_number = validate_input($_POST['insurance_number'] ?? '');
    $salary = validate_input($_POST['salary'] ?? '');
    $department = validate_input($_POST['department'] ?? '');

    // Role is hardcoded as admin
    $role = 'admin';

    // Basic validation
    if (empty($full_name) || empty($username) || empty($email) || empty($password) ||
        empty($salary) || empty($department)) {
        $em = "All required fields must be filled.";
        header("Location: admin_register_form.php?error=" . urlencode($em));
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $em = "Invalid email format.";
        header("Location: admin_register_form.php?error=" . urlencode($em));
        exit();
    }

    if (!is_numeric($salary) || $salary <= 0) {
        $em = "Salary must be a positive number.";
        header("Location: admin_register_form.php?error=" . urlencode($em));
        exit();
    }

    // Check if username or email already exists
    $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username, $email]);
    if ($stmt->rowCount() > 0) {
        $em = "Username or email already taken.";
        header("Location: admin_register_form.php?error=" . urlencode($em));
        exit();
    }

    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Profile image (optional)
    $image_file_name = null;
    if (!empty($_FILES['profile_image']['name'])) {
        $target_dir =  "../uploads/profile_images/";
        if (!is_dir($target_dir)) {
            if (!mkdir($target_dir, 0777, true)) {
                $em = "Failed to create directory for images.";
                header("Location: admin_register_form.php?error=" . urlencode($em));
                exit();
            }
        }

        $original_file_name = basename($_FILES['profile_image']['name']);
        $sanitized_file_name = preg_replace('/[^a-zA-Z0-9-\.]/', '', $original_file_name);
        $image_file_name = time() . "_" . $sanitized_file_name;
        $target_file = $target_dir . $image_file_name;
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $valid_extensions = ['jpg','jpeg','png','gif'];

        if (!in_array($image_file_type, $valid_extensions)) {
            $em = "Invalid image format. JPG, JPEG, PNG, and GIF are allowed.";
            header("Location: admin_register_form.php?error=" . urlencode($em));
            exit();
        }

        if ($_FILES['profile_image']['size'] > 2 * 1024 * 1024) {
            $em = "Image size exceeds 2MB.";
            header("Location: admin_register_form.php?error=" . urlencode($em));
            exit();
        }

        if (!move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
            $fileError = $_FILES['profile_image']['error'];
            $em = "Failed to upload image. File error code: $fileError. Check directory permissions and path.";
            header("Location: admin_register_form.php?error=" . urlencode($em));
            exit();
        }
    }

    $data = [
        $full_name, $username, $email, $password_hashed, $salary, $department, $role, $image_file_name,
        $dob, $gender, $marital_status, $nationality, $phone_number, $address,
        $emergency_contact, $work_location, $employment_type, $account_number, $bank_name,
        $ifsc_code, $tin, $insurance_number
    ];

    try {
        insert_user($conn, $data);
        header("Location: login_form.php?success=" . urlencode("Admin account created successfully! Please log in."));
        exit();
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        $em = "DB Error: " . $e->getMessage();
        header("Location: admin_register_form.php?error=" . urlencode($em));
        exit();
    } catch (Exception $ex) {
        error_log("General error: " . $ex->getMessage());
        $em = "Failed to create admin: " . $ex->getMessage();
        header("Location: admin_register_form.php?error=" . urlencode($em));
        exit();
    }

} else {
    $em = "Invalid request.";
    header("Location: admin_register_form.php?error=" . urlencode($em));
    exit();
}
