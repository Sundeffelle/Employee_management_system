<?php
session_start();

// Ensure the user is logged in and has the correct role
if (isset($_SESSION['role']) && ($_SESSION['role'] === 'employee' || $_SESSION['role'] === 'admin' || $_SESSION['role']==='company') && isset($_SESSION['id'])) {

    // Include database connection and model
    include "../inc/DB_connection.php";
    include '../app/Model/Payroll.php';
    include '../inc/navbar.php';
    
    function get_employee_names($conn) {
        $query = "SELECT id, full_name FROM users WHERE role = 'employee'";
        $result = $conn->query($query);
    
        $employees = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $employees[] = $row;
            }
        }
    
        return $employees;
    } // <--- Closing brace added here

    // Fetch employee names for the form dropdown
    $employeeNames = get_employee_names($conn);

    // Fetch payroll details
    $payrolls = get_payroll_details($conn);

    
    include "../inc/DB_connection.php";

try {
    // Fetch employee IDs and names with payroll records
    $query = "SELECT users.id AS employee_id, users.full_name
              FROM payroll 
              INNER JOIN users ON payroll.user_id = users.id";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "Error fetching employees: " . $e->getMessage();
}
?>



    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Payroll Records</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="d-flex flex-column min-vh-100">
    <div class="container-fluid">
        <h3 class="m-4"><i class="fa-solid fa-list fa-lg"></i> Payroll Records</h3>

        <!-- Add Allowance and Deduction Buttons -->
        <div class="mb-3 ms-4">
       <!-- Add Deduction Button -->
<button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#deductionModal">
    Add Deduction
</button>

<!-- Add Allowance Button -->
<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#allowanceModal">
    Add Allowance
</button>

</button>


        </div>

        <div class="row">
            <div class="col-12">
                <?php if ($payrolls) { ?>
                    <div class="card bg-light ms-4 me-4 mb-4">
                        <div class="card-header">
                            <i class="fa-solid fa-list fa-lg"></i> Payroll Records
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                      <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Employee Name</th>
                                        <th scope="col">Department</th>
                                        <th scope="col">Gross Salary</th>
                                        <th scope="col">Total Allowances</th>
                                        <th scope="col">Total Deductions</th>
                                        <th scope="col">Net Salary</th>
                                        <th scope="col">Pay Date</th>
                                        <th scope="col">Actions</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($payrolls as $index => $payroll) { ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td><?= htmlspecialchars($payroll['full_name']) ?></td>
                                            <td><?= htmlspecialchars($payroll['department']) ?></td>
                                            <td><?= number_format($payroll['gross_salary'], 2) ?></td>
                                            <td><?= number_format($payroll['total_allowances'], 2) ?></td>
                                            <td><?= number_format($payroll['total_deductions'], 2) ?></td>
                                            <td><?= number_format($payroll['net_salary'], 2) ?></td>
                                            <td><?= htmlspecialchars($payroll['pay_date']) ?></td>
                                            <td>
                                            <a href="print_payroll.php?payroll_id=<?= $payroll['payroll_id'] ?>" target="_blank" class="btn btn-success btn-sm">Print</a>
                                            <a href="edit_payroll.php?payroll_id=<?= $payroll['payroll_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="delete_payroll.php?payroll_id=<?= $payroll['payroll_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this payroll record?');">Delete</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <h5 class="alert alert-primary ms-4 me-4">No Payroll Records Found</h5>
                <?php } ?>
            </div>
        </div>
    </div>



<!-- Deduction Modal -->
<div class="modal fade" id="deductionModal" tabindex="-1" aria-labelledby="deductionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="add_deduction.php" method="POST" id="deductionForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="deductionModalLabel">Add Deduction</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="deduction_employee_id">Select Employee:</label>
                        <select class="form-control" id="deduction_employee_id" name="employee_id" required>
                            <option value="">-- Select Employee --</option>
                            <?php foreach ($employees as $employee): ?>
                                <option value="<?= htmlspecialchars($employee['employee_id']) ?>">
                                    <?= htmlspecialchars($employee['full_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="deduction_type">Deduction Type:</label>
                        <input type="text" class="form-control" id="deduction_type" name="deduction_type" required>
                    </div>
                    <div class="form-group">
                        <label for="deduction_amount">Deduction Amount:</label>
                        <input type="number" step="0.01" class="form-control" id="deduction_amount" name="deduction_amount" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning">Add Deduction</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Allowance Modal -->
<div class="modal fade" id="allowanceModal" tabindex="-1" aria-labelledby="allowanceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="add_allowance.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="allowanceModalLabel">Add Allowance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="allowance_employee_id">Select Employee:</label>
                        <select class="form-control" id="allowance_employee_id" name="employee_id" required>
                            <option value="">-- Select Employee --</option>
                            <?php foreach ($employees as $employee): ?>
                                <option value="<?= htmlspecialchars($employee['employee_id']) ?>">
                                    <?= htmlspecialchars($employee['full_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="allowance_type">Allowance Type:</label>
                        <input type="text" class="form-control" id="allowance_type" name="allowance_type" required>
                    </div>
                    <div class="form-group">
                        <label for="allowance_amount">Allowance Amount:</label>
                        <input type="number" step="0.01" class="form-control" id="allowance_amount" name="allowance_amount" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Allowance</button>
                </div>
            </form>
        </div>
    </div>
</div>




    <footer class="mt-auto mb-4">
        <div class="text-center">
            <span>&copy; <script>document.write(new Date().getFullYear())</script> PatMacTech UK.</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    <style>
.modal-backdrop.show {
    z-index: 1050 !important; /* Ensure it's behind the modal */
}
.modal {
    z-index: 1055 !important; /* Ensure it's visible above the backdrop */
}
</style>
<script>
document.querySelector("[data-bs-target='#deductionModal']").addEventListener("click", function () {
    var modal = new bootstrap.Modal(document.getElementById("deductionModal"));
    modal.show();
    console.log('Deduction modal opened programmatically');
});
</script>

<script>
document.querySelector("#deductionModal").addEventListener("hidden.bs.modal", function () {
    document.body.classList.remove("modal-open");
    document.querySelector(".modal-backdrop")?.remove();
});
</script>


    </html>

    <?php
} else {
    // If the user does not have the required role, redirect to login page
    header("Location: login.php");
    exit();
}
?>
