<?php
include "../inc/DB_connection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $employee_id = filter_input(INPUT_POST, 'employee_id', FILTER_SANITIZE_NUMBER_INT);
    $allowance_type = filter_input(INPUT_POST, 'allowance_type', FILTER_SANITIZE_STRING);
    $allowance_amount = filter_input(INPUT_POST, 'allowance_amount', FILTER_VALIDATE_FLOAT);

    if (!$employee_id || !$allowance_type || !$allowance_amount) {
        echo "Invalid form data. Please check your input.";
        exit;
    }

    try {
        // Fetch payroll ID
        $query = "SELECT payroll_id FROM payroll WHERE user_id = :employee_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':employee_id', $employee_id, PDO::PARAM_INT);
        $stmt->execute();
        $payroll = $stmt->fetch();

        if (!$payroll) {
            echo "Error: Payroll record for this employee does not exist. Please create a payroll record.";
            exit;
        }

        $payroll_id = $payroll['payroll_id'];

        // Insert allowance
        $insertQuery = "INSERT INTO allowances (payroll_id, allowance_type, allowance_amount) VALUES (:payroll_id, :type, :amount)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bindParam(':payroll_id', $payroll_id, PDO::PARAM_INT);
        $stmt->bindParam(':type', $allowance_type, PDO::PARAM_STR);
        $stmt->bindParam(':amount', $allowance_amount, PDO::PARAM_STR);
        $stmt->execute();

        echo "Allowance added successfully.";
    } catch (Exception $e) {
        echo "Error processing allowance: " . $e->getMessage();
    }
}
?>
