<?php
session_start();

// Display errors for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../inc/DB_connection.php"; 
include "../app/Model/User.php"; // Ensure `insert_user` function is defined here

// Set PDO to throw exceptions
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function validate_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Secure header redirection function
function safe_redirect($url, $error_message = null) {
    if ($error_message) {
        $url .= "?error=" . urlencode($error_message);
    }
    header("Location: $url");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture and validate input
    $full_name = validate_input($_POST['full_name'] ?? '');
    $user_name = validate_input($_POST['username'] ?? '');
    $email = validate_input($_POST['email'] ?? '');
    $password = validate_input($_POST['password'] ?? '');
    $role = validate_input($_POST['role'] ?? 'employee'); // Default to 'employee'
    $salary = validate_input($_POST['salary'] ?? '');
    $department = validate_input($_POST['department'] ?? '');
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
    $image_file_name = null;

    // Basic Validation
    if (empty($full_name) || empty($user_name) || empty($email) || empty($password) ||
        empty($role) || empty($salary) || empty($department)) {
        safe_redirect("../Resources/registration_form.php", "All fields are required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        safe_redirect("../Resources/registration_form.php", "Invalid email format.");
    }

    if (!is_numeric($salary) || $salary <= 0) {
        safe_redirect("../Resources/registration_form.php", "Salary must be a positive number.");
    }

    // Validate password strength
    if (!preg_match("/^.{6,}$/", $password)) {
        safe_redirect("../Resources/registration_form.php", "Password must be at least 6 characters long.");
    }

    // Check if username or email already exists
    $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_name, $email]);
    if ($stmt->rowCount() > 0) {
        safe_redirect("../Resources/registration_form.php", "Username or email already taken.");
    }

    // Hash password securely
    $password_hashed = password_hash($password, PASSWORD_BCRYPT);

    // Handle optional profile image upload
    if (!empty($_FILES['profile_image']['name'])) {
        $target_dir = "../uploads/profile_images/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $original_file_name = basename($_FILES['profile_image']['name']);
        $sanitized_file_name = preg_replace('/[^a-zA-Z0-9-\.]/', '', $original_file_name);
        $image_file_name = time() . "_" . $sanitized_file_name;
        $target_file = $target_dir . $image_file_name;
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $valid_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($image_file_type, $valid_extensions)) {
            safe_redirect("../Resources/registration_form.php", "Invalid image format. Only JPG, JPEG, PNG, and GIF are allowed.");
        }

        if ($_FILES['profile_image']['size'] > 2 * 1024 * 1024) {
            safe_redirect("../Resources/registration_form.php", "Image size exceeds 2MB.");
        }

        if (!move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
            safe_redirect("../Resources/registration_form.php", "Failed to upload image.");
        }
    }

    // Prepare data array for insertion
    $data = [
        $full_name, $user_name, $email, $password_hashed, $salary, $department,
        $role, $image_file_name, $dob, $gender, $marital_status, $nationality,
        $phone_number, $address, $emergency_contact, $work_location,
        $employment_type, $account_number, $bank_name, $ifsc_code, $tin, $insurance_number
    ];

    try {
        insert_user($conn, $data);
        safe_redirect("../Resources/login.php", "Registration successful! Please log in.");
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        safe_redirect("../Resources/registration_form.php", "Database error occurred.");
    } catch (Exception $ex) {
        error_log("General error: " . $ex->getMessage());
        safe_redirect("../Resources/registration_form.php", "Failed to create user.");
    }
} else {
    safe_redirect("../Resources/registration_form.php", "Invalid request.");
}
