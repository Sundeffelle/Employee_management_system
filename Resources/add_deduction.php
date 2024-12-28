<?php
include "../inc/DB_connection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $employee_id = filter_input(INPUT_POST, 'employee_id', FILTER_SANITIZE_NUMBER_INT);
    $deduction_type = filter_input(INPUT_POST, 'deduction_type', FILTER_SANITIZE_STRING);
    $deduction_amount = filter_input(INPUT_POST, 'deduction_amount', FILTER_VALIDATE_FLOAT);

    if (!$employee_id || !$deduction_type || !$deduction_amount) {
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

        // Insert deduction
        $insertQuery = "INSERT INTO deductions (payroll_id, type, amount) VALUES (:payroll_id, :type, :amount)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bindParam(':payroll_id', $payroll_id, PDO::PARAM_INT);
        $stmt->bindParam(':type', $deduction_type, PDO::PARAM_STR);
        $stmt->bindParam(':amount', $deduction_amount, PDO::PARAM_STR);
        $stmt->execute();

        echo "Deduction added successfully.";
    } catch (Exception $e) {
        echo "Error processing deduction: " . $e->getMessage();
    }
}
?>
