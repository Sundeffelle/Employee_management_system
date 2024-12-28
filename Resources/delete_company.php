<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Ensure only admins can delete records
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "Access denied. Only admins can perform this action.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $sName = "localhost";
        $uName = "root";
        $pass  = "";
        $db_name = "task_management_db";

        $conn = new PDO("mysql:host=$sName;dbname=$db_name;charset=utf8mb4", $uName, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Get the company ID from the form
        $company_id = $_POST['company_id'];

        // Delete the company record
        $sql = "DELETE FROM companies WHERE company_id = :company_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':company_id' => $company_id]);

        // Redirect back to the admin dashboard
        header("Location: subscription_tracked.php");
        exit;

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
