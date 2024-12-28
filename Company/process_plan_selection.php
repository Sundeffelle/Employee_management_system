<?php
ini_set('display_erors',1);
ini_set('display_starp_errors',1);
error_reporting(E_ALL);
session_start();
include '../inc/DB_connection.php';
if (!isset($_SESSION['company_id']) || empty($_SESSION['company_id'])) {
    throw new Exception("No company_id in session.");
}

echo "Company ID in session: " . $_SESSION['company_id'] . "<br>";

// Check if the company ID exists in the database
$sql = "SELECT * FROM companies WHERE company_id = :company_id";
$stmt = $conn->prepare($sql);
$stmt->execute([':company_id' => $_SESSION['company_id']]);

if ($stmt->rowCount() === 0) {
    throw new Exception("Company ID not found in the companies table.");
}

try {
    
    $conn = new PDO("mysql:host=localhost;dbname=task_management_db;charset=utf8mb4", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Insert into companies table
    $sql = "INSERT INTO companies (company_name, company_email, industry, company_size, contact_email, contact_phone, address) 
            VALUES (:company_name, :company_email, :industry, :company_size, :contact_email, :contact_phone, :address)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':company_name' => $_POST['company_name'],
        ':company_email' => $_POST['company_email'],
        ':industry' => $_POST['industry'],
        ':company_size' => $_POST['company_size'],
        ':contact_email' => $_POST['contact_email'],
        ':contact_phone' => $_POST['contact_phone'],
        ':address' => $_POST['address']
    ]); 
    


    // Save the last inserted company_id into the session
    $_SESSION['company_id'] = $conn->lastInsertId();
    echo "Company successfully registered.<br>";
echo "Company ID: " . $_SESSION['company_id'] . "<br>";


    // Redirect to subscription plan selection
    header("Location: subscription_plan_selection.php");
    exit;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
