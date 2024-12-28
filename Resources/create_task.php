<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && ($_SESSION['role'] == "admin" || $_SESSION['role'] == "company")) {
    include "../inc/DB_connection.php";
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
    <title>Create Task</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container-fluid">
    <h3 class="text-center m-4">Create Task</h3>
    <div class="alert alert-success text-center" role="alert">
        <a href="main_page.php" class="alert-link">Go to Home Page</a>
    </div>

    <div class="row justify-content-center">
        <div class="col-6">
            <div class="card bg-light mb-3">
                <div class="card-header">
                    <i class="fa fa-tasks fa-lg"></i> Task Creation
                </div>
                <div class="card-body">
                    <form method="POST" action="app/add-task.php">
                        <?php if (isset($_GET['error'])) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?= htmlspecialchars(stripcslashes($_GET['error'])); ?>
                            </div>
                        <?php } ?>

                        <?php if (isset($_GET['success'])) { ?>
                            <div class="alert alert-success" role="alert">
                                <?= htmlspecialchars(stripcslashes($_GET['success'])); ?>
                            </div>
                        <?php } ?>

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Title" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control" placeholder="Description" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="due_date" class="form-label">Due Date</label>
                            <input type="date" name="due_date" id="due_date" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="assigned_to" class="form-label">Assigned to</label>
                            <select name="assigned_to" id="assigned_to" class="form-select" required>
                                <option value="0">Select employee</option>
                                <?php if ($users != 0) { 
                                    foreach ($users as $user) { ?>
                                        <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['full_name']); ?></option>
                                <?php } } ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Create Task</button>
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
