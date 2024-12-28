<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (isset($_POST['user_name']) && isset($_POST['password']) && isset($_POST['full_name']) && isset($_POST['email']) && $_SESSION['role'] == 'admin') {
    include "../DB_connection.php";

    function validate_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Collect input data
    $user_name = validate_input($_POST['user_name']);
    $password = validate_input($_POST['password']);
    $full_name = validate_input($_POST['full_name']);
    $email = validate_input($_POST['email']);
    $salary = validate_input($_POST['salary']);
    $department = validate_input($_POST['department']);
    $dob = validate_input($_POST['dob']);
    $gender = validate_input($_POST['gender']);
    $marital_status = validate_input($_POST['marital_status']);
    $nationality = validate_input($_POST['nationality']);
    $phone_number = validate_input($_POST['phone_number']);
    $address = validate_input($_POST['address']);
    $emergency_contact = validate_input($_POST['emergency_contact']);
    $work_location = validate_input($_POST['work_location']);
    $employment_type = validate_input($_POST['employment_type']);
    $account_number = validate_input($_POST['account_number']);
    $bank_name = validate_input($_POST['bank_name']);
    $ifsc_code = validate_input($_POST['ifsc_code']);
    $tin = validate_input($_POST['tin']);
    $insurance_number = validate_input($_POST['insurance_number']);
    $image_file_name = null;

    // Handle image upload
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
            $em = "Invalid image format. Only JPG, JPEG, PNG, and GIF are allowed.";
            header("Location: ../add-user.php?error=$em");
            exit();
        }

        if ($_FILES['profile_image']['size'] > 2 * 1024 * 1024) {
            $em = "Image size exceeds 2MB.";
            header("Location: ../add-user.php?error=$em");
            exit();
        }

        if (!move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
            $em = "Failed to upload image.";
            header("Location: ../add-user.php?error=$em");
            exit();
        }
    }

    // Validate inputs
    if (empty($user_name)) {
        $em = "Username is required.";
        header("Location: ../add-user.php?error=$em");
        exit();
    } elseif (empty($password)) {
        $em = "Password is required.";
        header("Location: ../add-user.php?error=$em");
        exit();
    } elseif (empty($full_name)) {
        $em = "Full name is required.";
        header("Location: ../add-user.php?error=$em");
        exit();
    } elseif (empty($email)) {
        $em = "Email is required.";
        header("Location: ../add-user.php?error=$em");
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $em = "Invalid email format.";
        header("Location: ../add-user.php?error=$em");
        exit();
    } elseif (empty($salary)) {
        $em = "Salary is required.";
        header("Location: ../add-user.php?error=$em");
        exit();
    } elseif (empty($department)) {
        $em = "Department is required.";
        header("Location: ../add-user.php?error=$em");
        exit();
    }

    // Hash the password
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into the database
    include "Model/User.php";
    $data = [
        $full_name,
        $user_name,
        $email,
        $password_hashed,
        $salary,
        $department,
        "employee", // Default role for new users
        $image_file_name,
        $dob,
        $gender,
        $marital_status,
        $nationality,
        $phone_number,
        $address,
        $emergency_contact,
        $work_location,
        $employment_type,
        $account_number,
        $bank_name,
        $ifsc_code,
        $tin,
        $insurance_number
    ];

    try {
        insert_user($conn, $data);
        $em = "User created successfully.";
        header("Location: ../add-user.php?success=$em");
        exit();
    } catch (Exception $e) {
        error_log("Error inserting user: " . $e->getMessage());
        $em = "Failed to create user.";
        header("Location: ../add-user.php?error=$em");
        exit();
    }
}
?>
