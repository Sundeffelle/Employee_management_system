<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    include '../inc/DB_connection.php';

    // Ensure session variables are set
    if (!isset($_SESSION['company_id']) || !isset($_SESSION['role'])) {
        throw new Exception("No valid session found. Please log in.");
    }

    // Check the role from the session
    if ($_SESSION['role'] !== 'company') {
        throw new Exception("Unauthorized access. Only companies can subscribe.");
    }

    $company_id = $_SESSION['company_id'];

    // Confirm the company exists
    $sql_company_check = "SELECT * FROM companies WHERE company_id = :company_id";
    $stmt_company_check = $conn->prepare($sql_company_check);
    $stmt_company_check->execute([':company_id' => $company_id]);
    $company_data = $stmt_company_check->fetch(PDO::FETCH_ASSOC);

    if (!$company_data) {
        throw new Exception("Invalid company ID. Please register or log in.");
    }

    // Ensure POST data is received
    if (!isset($_POST['start_date']) || empty($_POST['start_date'])) {
        throw new Exception("Start date is required.");
    }

    // Handle subscription logic
    $start_date = $_POST['start_date'];
    $end_date = date('Y-m-d', strtotime($start_date . ' +7 days'));
    $plan = 'Testing';
    $status = 'active';
    $payment_method = 'Free';

    $sql_insert = "INSERT INTO subscriptions (company_id, plan, start_date, end_date, status, payment_method) 
                   VALUES (:company_id, :plan, :start_date, :end_date, :status, :payment_method)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->execute([
        ':company_id' => $company_id,
        ':plan' => $plan,
        ':start_date' => $start_date,
        ':end_date' => $end_date,
        ':status' => $status,
        ':payment_method' => $payment_method,
    ]);

    echo "Free trial activated successfully!";
    // Redirect to the company dashboard
    header("Refresh: 3; URL=../Resources/index.php");
    exit;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
