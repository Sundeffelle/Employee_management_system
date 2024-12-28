<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the user is an admin and logged in
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
    include "../inc/DB_connection.php";
    include "../app/Model/Kpis.php";
    include "../app/Model/User.php"; // To retrieve employee names
    
    $kpis = get_all_kpis($conn); // Fetch all KPIs from the database
    $users = get_all_users($conn); // Fetch all users for employee names

    // Create an associative array of users with their IDs as keys
    $user_names = [];
    foreach ($users as $user) {
        $user_names[$user['id']] = $user['full_name'];
    }

    include "inc/navbar.php";
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manage KPIs</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>

    <div class="container mt-5">
        <h2 class="text-center mb-4">KPI Management</h2>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>KPI Name</th>
                    <th>Assigned Employee</th>
                    <th>Target Value</th>
                    <th>Achieved Value</th>
                    <th>Evaluation Period</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($kpis): ?>
                    <?php foreach ($kpis as $kpi): ?>
                        <tr>
                            <td><?= htmlspecialchars($kpi['id']) ?></td>
                            <td><?= htmlspecialchars($kpi['kpi_name'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($user_names[$kpi['employee_id']] ?? 'Unassigned') ?></td>
                            <td><?= htmlspecialchars($kpi['target_value'] ?? '0') ?></td>
                            <td><?= htmlspecialchars($kpi['current_value'] ?? '0') ?></td>
                            <td><?= htmlspecialchars($kpi['evaluation_period'] ?? 'No Date') ?></td>
                            <td><?= htmlspecialchars($kpi['status'] ?? 'Unknown') ?></td>
                            <td>
                                <a href="edit_kpi.php?id=<?= htmlspecialchars($kpi['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete_kpi.php?id=<?= htmlspecialchars($kpi['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this KPI?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="9" class="text-center">No KPIs found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <a href="create_kpi.php" class="btn btn-primary">Add New KPI</a>
    </div>

    </body>
    </html>

    <?php
} else {
    $em = "Please log in as an admin";
    header("Location: login.php?error=$em");
    exit();
}
?>
