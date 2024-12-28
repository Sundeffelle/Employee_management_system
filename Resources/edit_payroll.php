<?php
include "../inc/DB_connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['payroll_id'])) {
    $payroll_id = filter_input(INPUT_GET, 'payroll_id', FILTER_VALIDATE_INT);

    // Fetch payroll details along with employee name and department
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
            <title>Edit Payroll</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        </head>
        <body>
            <div class="container mt-5">
                <h2>Edit Payroll Record</h2>
                <form action="edit_payroll.php" method="POST">
                    <input type="hidden" name="payroll_id" value="<?= $payroll['payroll_id'] ?>">
                    <div class="form-group">
                        <label for="employee_name">Employee Name:</label>
                        <input type="text" class="form-control" id="employee_name" name="employee_name" value="<?= htmlspecialchars($payroll['full_name']) ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="department">Department:</label>
                        <input type="text" class="form-control" id="department" name="department" value="<?= htmlspecialchars($payroll['department']) ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="gross_salary">Gross Salary:</label>
                        <input type="number" step="0.01" class="form-control" id="gross_salary" name="gross_salary" value="<?= $payroll['gross_salary'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="total_allowances">Total Allowances:</label>
                        <input type="number" step="0.01" class="form-control" id="total_allowances" name="total_allowances" value="<?= $payroll['total_allowances'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="total_deductions">Total Deductions:</label>
                        <input type="number" step="0.01" class="form-control" id="total_deductions" name="total_deductions" value="<?= $payroll['total_deductions'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="net_salary">Net Salary:</label>
                        <input type="number" step="0.01" class="form-control" id="net_salary" name="net_salary" value="<?= $payroll['net_salary'] ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="pay_date">Pay Date:</label>
                        <input type="date" class="form-control" id="pay_date" name="pay_date" value="<?= $payroll['pay_date'] ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
                    <a href="payroll_results_table.php" class="btn btn-secondary mt-3">Cancel</a>
                </form>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "Payroll record not found.";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update payroll record
    $payroll_id = filter_input(INPUT_POST, 'payroll_id', FILTER_VALIDATE_INT);
    $gross_salary = filter_input(INPUT_POST, 'gross_salary', FILTER_VALIDATE_FLOAT);
    $total_allowances = filter_input(INPUT_POST, 'total_allowances', FILTER_VALIDATE_FLOAT);
    $total_deductions = filter_input(INPUT_POST, 'total_deductions', FILTER_VALIDATE_FLOAT);
    $pay_date = filter_input(INPUT_POST, 'pay_date', FILTER_SANITIZE_STRING);

    // Calculate net salary
    $net_salary = $gross_salary + $total_allowances - $total_deductions;

    // Update query
    $query = "UPDATE payroll 
              SET gross_salary = ?, total_allowances = ?, total_deductions = ?, net_salary = ?, pay_date = ? 
              WHERE payroll_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$gross_salary, $total_allowances, $total_deductions, $net_salary, $pay_date, $payroll_id]);

    header("Location: payroll_results_table.php");
    exit();
}
?>
