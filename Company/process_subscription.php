<?php
try {
    ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    session_start();
    // Database configuration
    $sName = "localhost";
    $uName = "root";
    $pass = "";
    $db_name = "task_management_db";

    // Database connection
    $conn = new PDO("mysql:host=$sName;dbname=$db_name;charset=utf8mb4", $uName, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve form data
    $company_name   = $_POST['company_name'];
    $company_email  = $_POST['company_email'];
    $password       = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $industry       = $_POST['industry'];
    $company_size   = $_POST['company_size'];
    $contact_email  = $_POST['contact_email'];
    $contact_phone  = $_POST['contact_phone'];
    $address        = $_POST['address'];

    // Debugging form data (can be removed in production)
    // var_dump($company_name, $company_email, $industry, $company_size, $contact_email, $contact_phone, $address);

    // Validate inputs
    if (empty($company_name) || empty($company_email) || empty($password) || empty($confirm_password)) {
        throw new Exception("All fields are required.");
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        throw new Exception("Passwords do not match.");
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check for duplicate email
    $sql_check = "SELECT company_id FROM companies WHERE company_email = :company_email LIMIT 1";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->execute([':company_email' => $company_email]);
    if ($stmt_check->rowCount() > 0) {
        throw new Exception("A company with the email $company_email is already registered.");
    }

    // Insert data into the database
    $sql_companies = "INSERT INTO companies (company_name, company_email, password, industry, company_size, contact_email, contact_phone, address) 
                      VALUES (:company_name, :company_email, :password, :industry, :company_size, :contact_email, :contact_phone, :address)";
    $stmt_companies = $conn->prepare($sql_companies);
    $stmt_companies->execute([
        ':company_name'  => $company_name,
        ':company_email' => $company_email,
        ':password'      => $hashed_password,
        ':industry'      => $industry,
        ':company_size'  => $company_size,
        ':contact_email' => $contact_email,
        ':contact_phone' => $contact_phone,
        ':address'       => $address
    ]);

    // Redirect to success page
    header("Location: subscription_success.php");
    exit;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
