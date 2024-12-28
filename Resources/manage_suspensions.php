<?php
session_start();
if (!isset($_SESSION['role'])  && ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'company')) {
    header("Location: login.php");
    exit();
}

include "../inc/DB_connection.php";

// Fetch all employees
$query = "SELECT id, full_name, username, is_suspended FROM users WHERE role = 'employee'";
$stmt = $conn->prepare($query);
$stmt->execute();
$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = $_POST['employee_id'];
    $action = $_POST['action']; // suspend or release

    $is_suspended = $action === 'suspend' ? 1 : 0;
    $updateQuery = "UPDATE users SET is_suspended = ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->execute([$is_suspended, $employee_id]);

    header("Location: manage_suspensions.php?success=Action completed successfully");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Suspensions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3 class="mb-4">Manage Employee Suspensions</h3>
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Full Name</th>
            <th>Username</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($employees as $index => $employee): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= htmlspecialchars($employee['full_name']) ?></td>
                <td><?= htmlspecialchars($employee['username']) ?></td>
                <td>
                    <?= $employee['is_suspended'] ? '<span class="badge bg-danger">Suspended</span>' : '<span class="badge bg-success">Active</span>' ?>
                </td>
                <td>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="employee_id" value="<?= $employee['id'] ?>">
                        <?php if ($employee['is_suspended']): ?>
                            <button type="submit" name="action" value="release" class="btn btn-success btn-sm">Release</button>
                        <?php else: ?>
                            <button type="submit" name="action" value="suspend" class="btn btn-danger btn-sm">Suspend</button>
                        <?php endif; ?>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
