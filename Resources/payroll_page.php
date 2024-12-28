<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payroll Records</title>
</head>
<body class="d-flex flex-column min-vh-100">
    <h2>All Payroll Records</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>Gross Salary</th>
                <th>Total Allowances</th>
                <th>Total Deductions</th>
                <th>Net Pay</th>
                <th>Status</th>
                <th>Date Created</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include "../inc/DB_connection.php"; // Update with your actual connection file
            include '../app/Model/User.php';
            include '../app/Model/Payroll.php';
            $payrolls = get_all_payroll_records($conn); // Ensure this function retrieves data
            if ($payrolls) {
                foreach ($payrolls as $payroll) {
                    echo "<tr>
                            <td>{$payroll['user_id']}</td>
                            <td>{$payroll['gross_salary']}</td>
                            <td>{$payroll['total_allowances']}</td>
                            <td>{$payroll['total_deductions']}</td>
                            <td>{$payroll['net_salary']}</td>
                            <td>{$payroll['status']}</td>
                            <td>{$payroll['created_at']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No payroll records found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
