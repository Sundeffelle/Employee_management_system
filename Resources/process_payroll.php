<?php

ini_set('display_error', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../app/Model/Payroll.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data
    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
    $gross_salary = filter_input(INPUT_POST, 'gross_salary', FILTER_VALIDATE_FLOAT);
    $allowance_type = filter_input(INPUT_POST, 'allowance_type', FILTER_SANITIZE_STRING);
    $allowance_amount = filter_input(INPUT_POST, 'allowance_amount', FILTER_VALIDATE_FLOAT);
    $deduction_type = filter_input(INPUT_POST, 'deduction_type', FILTER_SANITIZE_STRING);
    $deduction_amount = filter_input(INPUT_POST, 'deduction_amount', FILTER_VALIDATE_FLOAT);
    $pay_date = filter_input(INPUT_POST, 'pay_date', FILTER_SANITIZE_SPECIAL_CHARS);

    // Insert payroll record
    $payroll_id = insert_payroll_record($conn, $user_id, $gross_salary, 0, 0, $pay_date);

    // Insert allowance and deduction
    if ($payroll_id) {
        if ($allowance_amount > 0) {
            insert_allowance($conn, $payroll_id, $allowance_amount, $allowance_type);
        }
        if ($deduction_amount > 0) {
            insert_deduction($conn, $payroll_id, $deduction_amount, $deduction_type);
        }

        // Update payroll record totals
        $total_allowances = get_total_allowances($conn, $payroll_id);
        $total_deductions = get_total_deductions($conn, $payroll_id);
        update_payroll_totals($conn, $payroll_id, $total_allowances, $total_deductions);

        header('Location: payroll_results_table.php');
        exit();
    } else {
        echo "Failed to create payroll.";
    }
}


?>
