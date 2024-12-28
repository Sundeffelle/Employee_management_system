<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login_form.php?error=Unauthorized access.");
    exit();
}

// Include database connection
include '../inc/DB_connection.php';

// Fetch expired subscriptions
try {
    $query = "SELECT s.id, c.company_name, s.plan, s.start_date, s.end_date, s.status 
              FROM subscriptions s 
              JOIN companies c ON s.company_id = c.company_id
              WHERE s.end_date < CURDATE() AND s.status = 'active'";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $expired_subscriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Error fetching expired subscriptions: " . $e->getMessage());
}
?>


<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login_form.php?error=Unauthorized access.");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expired Subscriptions</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .table-container {
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .table thead {
            background-color: #007bff;
            color: #ffffff;
        }
        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .table tbody tr:hover {
            background-color: #e9ecef;
        }
        .badge-expired {
            background-color: #dc3545;
            color: #ffffff;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="table-container">
            <h2 class="text-center mb-4">Expired Subscriptions</h2>
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Company Name</th>
                        <th>Plan</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($expired_subscriptions)): ?>
                        <?php foreach ($expired_subscriptions as $index => $subscription): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($subscription['company_name']) ?></td>
                                <td><?= htmlspecialchars($subscription['plan']) ?></td>
                                <td><?= htmlspecialchars($subscription['start_date']) ?></td>
                                <td><?= htmlspecialchars($subscription['end_date']) ?></td>
                                <td>
                                    <span class="badge badge-expired">Expired</span>
                                </td>
                                <td>
                                    <form method="POST" action="remove_expired_subscription.php" class="d-inline">
                                        <input type="hidden" name="subscription_id" value="<?= $subscription['id'] ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">No expired subscriptions found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
