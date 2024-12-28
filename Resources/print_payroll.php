<?php
// Include database connection
include "../inc/DB_connection.php";

// Check if payroll_id is provided
if (isset($_GET['payroll_id'])) {
    $payroll_id = filter_input(INPUT_GET, 'payroll_id', FILTER_VALIDATE_INT);

    // Fetch payroll data
    $query = "SELECT payroll.*, users.full_name, users.department
              FROM payroll
              INNER JOIN users ON payroll.user_id = users.id
              WHERE payroll.payroll_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$payroll_id]);
    $payroll = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($payroll) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Print Payroll</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <style>
                @media print {
                    .no-print {
                        display: none;
                    }
                }
            </style>
        </head>
        <body>
            <div class="container mt-5">
                <h2 class="text-center mb-4">Payroll Details</h2>
                <table class="table table-bordered">
                    <tr>
                        <th>Employee Name</th>
                        <td><?= htmlspecialchars($payroll['full_name']) ?></td>
                    </tr>
                    <tr>
                        <th>Department</th>
                        <td><?= htmlspecialchars($payroll['department']) ?></td>
                    </tr>
                    <tr>
                        <th>Gross Salary</th>
                        <td><?= number_format($payroll['gross_salary'], 2) ?></td>
                    </tr>
                    <tr>
                        <th>Total Allowances</th>
                        <td><?= number_format($payroll['total_allowances'], 2) ?></td>
                    </tr>
                    <tr>
                        <th>Total Deductions</th>
                        <td><?= number_format($payroll['total_deductions'], 2) ?></td>
                    </tr>
                    <tr>
                        <th>Net Salary</th>
                        <td><?= number_format($payroll['net_salary'], 2) ?></td>
                    </tr>
                    <tr>
                        <th>Pay Date</th>
                        <td><?= htmlspecialchars($payroll['pay_date']) ?></td>
                    </tr>
                </table>
                <button class="btn btn-primary no-print" onclick="window.print()">Print</button>
                <a href="payroll_results_table.php" class="btn btn-secondary no-print">Back</a>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "<p class='alert alert-danger'>Payroll record not found.</p>";
    }
} else {
    echo "<p class='alert alert-danger'>No payroll ID provided.</p>";
}
?>
