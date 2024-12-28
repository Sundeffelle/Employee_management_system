<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && ($_SESSION['role'] == "admin" || $_SESSION['role'] == "company")) {
    include "../inc/DB_connection.php";
    include "../app/Model/Task.php";
    include "../app/Model/User.php";
    include "../inc/navbar.php";
    
    $text = "All Tasks";
    if (isset($_GET['due_date']) && $_GET['due_date'] == "Due Today") {
        $text = "Due Today";
        $tasks = get_all_tasks_due_today($conn);
        $num_task = count_tasks_due_today($conn);
    } elseif (isset($_GET['due_date']) && $_GET['due_date'] == "Overdue") {
        $text = "Overdue";
        $tasks = get_all_tasks_overdue($conn);
        $num_task = count_tasks_overdue($conn);
    } elseif (isset($_GET['due_date']) && $_GET['due_date'] == "No Deadline") {
        $text = "No Deadline";
        $tasks = get_all_tasks_NoDeadline($conn);
        $num_task = count_tasks_NoDeadline($conn);
    } else {
        $tasks = get_all_tasks($conn);
        $num_task = count_tasks($conn);
    }

    $users = get_all_users($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Tasks</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container-fluid">
    <h3 class="m-4"><i class="fa fa-tasks fa-lg"></i> Manage Tasks</h3>

    <div class="d-flex justify-content-center mb-4">
        <a href="create_task.php" class="btn btn-primary me-2">Create Task</a>
        <a href="tasks.php?due_date=Due Today" class="btn btn-secondary me-2">Due Today</a>
        <a href="tasks.php?due_date=Overdue" class="btn btn-warning me-2">Overdue</a>
        <a href="tasks.php?due_date=No Deadline" class="btn btn-info me-2">No Deadline</a>
        <a href="tasks.php" class="btn btn-dark">All Tasks</a>
    </div>

    <h4 class="text-center"><?= $text ?> (<?= $num_task ?>)</h4>

    <?php if (isset($_GET['success'])) { ?>
        <div class="alert alert-success ms-4 me-4" role="alert">
            <?= htmlspecialchars(stripcslashes($_GET['success'])); ?>
        </div>
    <?php } ?>

    <div class="row">
        <div class="col-12">
            <?php if ($tasks) { ?>
                <div class="card bg-light ms-4 me-4 mb-4">
                    <div class="card-header">
                        <i class="fa fa-list fa-lg"></i> Task Records
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Assigned To</th>
                                        <th scope="col">Due Date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($tasks as $index => $task) { ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td><?= htmlspecialchars($task['title']) ?></td>
                                            <td><?= htmlspecialchars($task['description']) ?></td>
                                            <td>
                                                <?php 
                                                foreach ($users as $user) {
                                                    if ($user['id'] == $task['assigned_to']) {
                                                        echo htmlspecialchars($user['full_name']);
                                                    }
                                                } ?>
                                            </td>
                                            <td>
                                                <?= $task['due_date'] ? htmlspecialchars($task['due_date']) : "No Deadline"; ?>
                                            </td>
                                            <td><?= htmlspecialchars($task['status']) ?></td>
                                            <td>
                                                <!-- Edit Button -->
                                                <a href="edit-task.php?id=<?= $task['id'] ?>" class="btn btn-success btn-sm me-1">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>

                                                <!-- Delete Button and Modal -->
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $task['id'] ?>">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>

                                                <!-- Delete Confirmation Modal -->
                                                <div class="modal fade" id="deleteModal<?= $task['id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="deleteModalLabel">Delete Task</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to delete the task titled "<?= htmlspecialchars($task['title']) ?>"?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form method="POST" action="app/delete_task.php">
                                                                    <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <h5 class="alert alert-primary ms-4 me-4">No Tasks Found</h5>
            <?php } ?>
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
