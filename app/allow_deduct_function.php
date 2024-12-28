<?php
ini_set('display_error',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_management_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();  
}
//include 'app/Model/Payroll.php';
// Dummy data for testing
insert_allowance($conn, 1, 150.00, 'Transport');
insert_deduction($conn, 1, 50.00, 'Tax');

function insert_deduction($conn, $payroll_id, $deduction_amount, $deduction_type) {
    $query = "INSERT INTO deductions (payroll_id, amount, type) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ids", $payroll_id, $deduction_amount, $deduction_type);
    if ($stmt->execute()) {
        echo "Deduction added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}

function insert_allowance($conn, $payroll_id, $allowance_amount, $allowance_type) {
    $query = "INSERT INTO allowances (payroll_id, amount, type) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ids", $payroll_id, $allowance_amount, $allowance_type);
    if ($stmt->execute()) {
        echo "Allowance added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
