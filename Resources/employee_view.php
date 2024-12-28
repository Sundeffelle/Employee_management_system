<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Ensure the user is logged in and is an employee
if (isset($_SESSION['role']) && $_SESSION['role'] == 'employee' && isset($_SESSION['id'])) {

    // Include database connection
    include "../inc/DB_connection.php";

    // Define the function to fetch employee leaves
    function get_employee_leaves($conn, $employee_id) {
        $query = "SELECT leave_type, start_date, end_date, status, reason 
                  FROM leaves 
                  WHERE employee_id = :employee_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':employee_id', $employee_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get the logged-in employee's ID from session
    $employee_id = $_SESSION['id'];

    // Fetch leave requests for the logged-in employee
    $leaves = get_employee_leaves($conn, $employee_id);
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My Leave Requests</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
    <div class="container-fluid">
        <h3 class="m-4"><i class="fa-solid fa-list fa-lg"></i> My Leave Requests</h3>
        <div class="row">
            <div class="col-12">
                <?php if ($leaves) { ?>
                    <div class="card bg-light ms-4 me-4 mb-4">
                        <div class="card-header">
                            <i class="fa-solid fa-list fa-lg"></i> My Leave Records
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                      <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Leave Type</th>
                                        <th scope="col">Start Date</th>
                                        <th scope="col">End Date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Reason</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($leaves as $index => $leave) { ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td><?= htmlspecialchars($leave['leave_type']) ?></td>
                                            <td><?= htmlspecialchars($leave['start_date']) ?></td>
                                            <td><?= htmlspecialchars($leave['end_date']) ?></td>
                                            <td>
                                                <?php if ($leave['status'] === 'approved') { ?>
                                                    <span class="badge bg-success">Approved</span>
                                                <?php } elseif ($leave['status'] === 'rejected') { ?>
                                                    <span class="badge bg-danger">Rejected</span>
                                                <?php } else { ?>
                                                    <span class="badge bg-warning">Pending</span>
                                                <?php } ?>
                                            </td>
                                            <td><?= htmlspecialchars($leave['reason']) ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <h5 class="alert alert-primary ms-4 me-4">No Leave Requests Found</h5>
                <?php } ?>
            </div>
        </div>
    </div>

    <footer class="mt-auto mb-4">
        <div class="text-center">
            <span>Copyright &copy; <script>document.write(new Date().getFullYear())</script> PatMactech UK.</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    </body>
    </html>

    <?php
} else {
    // If not logged in as employee, redirect to login page
    header("Location: login.php");
    exit();
}
?>
