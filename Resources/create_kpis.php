<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

if (isset($_SESSION['role'])  && ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'company')) {
    include "../DB_connection.php";
    include "../app/Model/Kpis.php";
    include "../app/Model/User.php";

    $users = get_all_users($conn);
    include "../inc/navbar.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create KPI</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

<div class="container-fluid">
    <h3 class="text-center m-4">Create KPI</h3>
    <div class="alert alert-success text-center" role="alert">
        <a href="main_page.php" class="alert-link">Go to Home Page</a>
    </div>

    <div class="row justify-content-center">
        <div class="col-6">
            <div class="card bg-light mb-3">
                <div class="card-header">
                    <i class="fa-solid fa-chart-bar fa-lg"></i> KPI Creation
                </div>
                <div class="card-body">
                <form method="POST" action="setting_kpis.php">
    <h3 class="mb-3">Create a New KPI</h3>

    <div class="mb-3">
        <label for="kpi_name" class="form-label">KPI Name</label>
        <input type="text" name="kpi_name" id="kpi_name" class="form-control" placeholder="KPI Name" required>
    </div>

    <div class="mb-3">
        <label for="target_value" class="form-label">Target Value</label>
        <input type="number" name="target_value" id="target_value" class="form-control" placeholder="Target Value" required>
    </div>

    <div class="mb-3">
        <label for="current_value" class="form-label">Current Value</label>
        <input type="number" name="current_value" id="current_value" class="form-control" placeholder="Current Value" required>
    </div>

    <div class="mb-3">
        <label for="evaluation_period" class="form-label">Evaluation Period</label>
        <input type="date" name="evaluation_period" id="evaluation_period" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="employee_id" class="form-label">Assigned to</label>
        <select name="employee_id" id="employee_id" class="form-select" required>
            <option value="0">Select employee</option>
            <?php if ($users != 0) { 
                foreach ($users as $user) { ?>
                <option value="<?=$user['id']?>"><?=$user['full_name']?></option>
            <?php } } ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" id="status" class="form-select" required>
            <option value="on_track">active</option>
            <option value="at_risk">onleave</option>
            <option value="behind_schedule">inactive</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Create KPI</button>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php 
} else { 
    $em = "First login";
    header("Location: login.php?error=$em");
    exit();
} 
?>
