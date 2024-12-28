<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    include '../inc/DB_connection.php';

    // Ensure the session is valid
    if (!isset($_SESSION['company_id']) || empty($_SESSION['company_id'])) {
        throw new Exception("No company_id found in session. Please log in.");
    }

    // Fetch the company ID from session
    $company_id = $_SESSION['company_id'];

    // Define the subscription details
    $plan = "StarterFlow"; // Fixed as this is for StarterFlow
    $start_date = date('Y-m-d'); // Use the current date as the start date
    $end_date = date('Y-m-d', strtotime($start_date . ' +30 days')); // Assuming a 30-day subscription
    $payment_method = "Stripe"; // Set to Stripe as the only payment method
    $status = 'pending'; // Initial status until payment is confirmed

    // Insert the subscription details into the database
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

    // Redirect to Stripe payment
    header("Location: stripe_payment.php");
    exit;
} catch (Exception $e) {
    // Display the error message
    echo "Error: " . $e->getMessage();
}
?>
