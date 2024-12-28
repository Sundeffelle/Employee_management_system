<?php
// Start the session
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    // Include the database connection
    include '../inc/DB_connection.php';

    // Ensure the session is valid
    if (!isset($_SESSION['company_id']) || empty($_SESSION['company_id'])) {
        throw new Exception("No company_id found in session. Please log in.");
    }

    // Fetch the company ID from session
    $company_id = $_SESSION['company_id'];

    // Define subscription plan details
    $plan = 'PowerFlow';
    $monthly_amount = 4800; // $48 in cents
    $yearly_amount = 48200; // $482 in cents

    // Determine payment type (monthly/yearly)
    $payment_type = $_GET['payment_type'] ?? 'monthly'; // Default to monthly if not provided
    if ($payment_type === 'yearly') {
        $unit_amount = $yearly_amount;
        $product_name = "PowerFlow Subscription (Yearly)";
    } else {
        $unit_amount = $monthly_amount;
        $product_name = "PowerFlow Subscription (Monthly)";
    }

    // Include Stripe PHP library
    require __DIR__ . "/../vendor/autoload.php";
    $stripe_secret_key = "pk_live_51QTgs0KvBZ00hvQjbkC3HIIQMXYAOqB9iqRQBEVRaTDdUw5DD8Zpuujw23Ih2ukjq26OB0ENzItBpFRh0VfvA2PI006qjfVh6V"; // Replace with your live Stripe key
    \Stripe\Stripe::setApiKey($stripe_secret_key);

    // Create a Stripe checkout session
    $checkout_session = \Stripe\Checkout\Session::create([
        "mode" => "payment",
        "locale" => "en",
        "success_url" => "http://localhost/Softwares/employee_management_system/Resources/index.php", // Redirect on success
        "cancel_url" => "http://localhost/Softwares/employee_management_system/Company/subscription_plan.php", // Redirect on cancel
        "line_items" => [
            [
                "quantity" => 1,
                "price_data" => [
                    "currency" => "usd",
                    "unit_amount" => $unit_amount,
                    "product_data" => [
                        "name" => $product_name,
                    ],
                ],
            ],
        ],
    ]);

    // Redirect to the Stripe Checkout page
    http_response_code(303);
    header("Location: " . $checkout_session->url);
    exit;

} catch (Exception $e) {
    // Display the error message
    echo "Error: " . $e->getMessage();
}
?>
