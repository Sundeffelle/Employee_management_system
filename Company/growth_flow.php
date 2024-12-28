<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    include '../inc/DB_connection.php';

    // Ensure session is valid
    if (!isset($_SESSION['company_id']) || empty($_SESSION['company_id'])) {
        throw new Exception("No company_id found in session. Please log in.");
    }

    // Fetch the company ID from session
    $company_id = $_SESSION['company_id'];

    // Fetch the payment method from the form submission
    if (!isset($_POST['payment_method'])) {
        throw new Exception("Please select a payment method.");
    }
    $payment_method = $_POST['payment_method'];

    // Set the subscription plan and amounts
    $plan = 'GrowthFlow';
    $monthly_amount = 3500; // $35 in cents
    $yearly_amount = 34500; // $345 in cents

    // Redirect to the appropriate payment gateway
    if ($payment_method === "Paystack") {
        header("Location: paystack_payment.php?plan=$plan&monthly_amount=$monthly_amount&yearly_amount=$yearly_amount");
        exit;
    } elseif ($payment_method === "Stripe") {
        header("Location: stripe_growth_payment.php?plan=$plan&payment_type=monthly&monthly_amount=$monthly_amount&yearly_amount=$yearly_amount");
        exit;
    } else {
        throw new Exception("Invalid payment method selected.");
    }
} catch (Exception $e) {
    // Display error message
    echo "Error: " . $e->getMessage();
}
