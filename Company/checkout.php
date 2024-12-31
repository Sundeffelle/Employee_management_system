<?php
// Display errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include Stripe PHP library
require __DIR__ . "/../vendor/autoload.php"; // Ensure the correct path to Stripe library

// Set Stripe API secret key
$stripe_secret_key = "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";
\Stripe\Stripe::setApiKey($stripe_secret_key);

try {
    // Determine payment type (monthly or yearly)
    $payment_type = $_GET['payment_type'] ?? 'monthly'; // Default to 'monthly' if not provided

    // Set the amount and description based on payment type
    if ($payment_type === 'yearly') {
        $unit_amount = 28000; // $280 in cents for yearly subscription
        $product_name = "StarterFlow Subscription (Yearly)";
    } else {
        $unit_amount = 2700; // $27 in cents for monthly subscription
        $product_name = "StarterFlow Subscription (Monthly)";
    }

    // Create a Stripe checkout session
    $checkout_session = \Stripe\Checkout\Session::create([
        "mode" => "payment",
        "locale" => "en",
        "success_url" => "http://localhost/Softwares/employee_management_system/index.php", // Redirect to dashboard on success
        "cancel_url" => "http://localhost/Softwares/employee_management_system/Company/subscription_plan.php", // Redirect to subscription plans on cancel
        "line_items" => [
            [
                "quantity" => 1,
                "price_data" => [
                    "currency" => "usd",
                    "unit_amount" => $unit_amount, // Amount in cents
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
} catch (Exception $e) {
    // Handle exceptions and display the error message
    echo "Error: " . $e->getMessage();
}
