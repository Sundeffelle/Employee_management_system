<?php
include "../inc/navbar.php"

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<div class="container-fluid">
    <h3 class="text-center m-4">Payroll Management</h3>
    <div class="alert alert-success text-center" role="alert">
        <a href="index.php" class="alert-link">Back to Dashboard</a>
    </div>

    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card bg-light mb-3">
                <div class="card-header">
                    <i class="fa fa-money fa-lg"></i> Process Payroll
                </div>
                <div class="card-body">
                    <form id="createPayrollForm" action="process_payroll.php" method="POST">
                        <?php if (isset($_GET['error'])) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?= htmlspecialchars(stripslashes($_GET['error'])); ?>
                            </div>
                        <?php } ?>

                        <?php if (isset($_GET['success'])) { ?>
                            <div class="alert alert-success" role="alert">
                                <?= htmlspecialchars(stripslashes($_GET['success'])); ?>
                            </div>
                        <?php } ?>

                        <!-- Grouped Fields -->
                        <div class="input-group mb-3">
                            <input type="number" name="user_id" id="user_id" class="form-control" placeholder="Employee ID" required>
                            <input type="date" name="pay_date" id="pay_date" class="form-control" placeholder="Pay Date" required>
                        </div>

                        <div class="input-group mb-3">
                            <input type="number" step="0.01" name="gross_salary" id="gross_salary" class="form-control" placeholder="Gross Salary" required>
                            <input type="number" step="0.01" name="total_allowances" id="total_allowances" class="form-control" placeholder="Allowances">
                        </div>

                        <div class="input-group mb-3">
                            <input type="number" step="0.01" name="total_deductions" id="total_deductions" class="form-control" placeholder="Deductions">
                            <input type="number" step="0.01" name="net_salary" id="net_salary" class="form-control" placeholder="Net Salary" readonly>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Process Payroll</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="mt-auto mb-4">
    <div class="text-center">
        <span>&copy; <script>document.write(new Date().getFullYear())</script> PatMactech UK.</span>
    </div>
</footer>

<script>
    // Auto-calculate Net Salary based on Gross Salary, Allowances, and Deductions
    document.getElementById('gross_salary').addEventListener('input', calculateNetSalary);
    document.getElementById('total_allowances').addEventListener('input', calculateNetSalary);
    document.getElementById('total_deductions').addEventListener('input', calculateNetSalary);

    function calculateNetSalary() {
        const gross = parseFloat(document.getElementById('gross_salary').value) || 0;
        const allowances = parseFloat(document.getElementById('total_allowances').value) || 0;
        const deductions = parseFloat(document.getElementById('total_deductions').value) || 0;
        document.getElementById('net_salary').value = (gross + allowances - deductions).toFixed(2);
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
