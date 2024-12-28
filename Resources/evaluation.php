<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

	include "DB_connection.php";
	include "app/Model/Task.php";
	include "app/Model/User.php";

	if ($_SESSION['role'] == "evaluator") {
		// Fetch evaluator's specific tasks or evaluations
		$num_evaluator_tasks = count_my_tasks($conn, $_SESSION['id']);
		$overdue_task = count_my_tasks_overdue($conn, $_SESSION['id']);
		$pending = count_my_pending_tasks($conn, $_SESSION['id']);
		$in_progress = count_my_in_progress_tasks($conn, $_SESSION['id']);
		$completed = count_my_completed_tasks($conn, $_SESSION['id']);
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Evaluator Dashboard</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<?php include "inc/header.php"; ?>
	<div class="body">
		<?php include "inc/nav.php"; ?>
		<section class="section-1">
			<?php if ($_SESSION['role'] == "evaluator") { ?>
				<div class="dashboard">
					<div class="dashboard-item">
						<i class="fa fa-tasks"></i>
						<span><?=$num_evaluator_tasks?> Tasks</span>
					</div>
					<div class="dashboard-item">
						<i class="fa fa-window-close-o"></i>
						<span><?=$overdue_task?> Overdue</span>
					</div>
					<div class="dashboard-item">
						<i class="fa fa-square-o"></i>
						<span><?=$pending?> Pending</span>
					</div>
					<div class="dashboard-item">
						<i class="fa fa-spinner"></i>
						<span><?=$in_progress?> In Progress</span>
					</div>
					<div class="dashboard-item">
						<i class="fa fa-check-square-o"></i>
						<span><?=$completed?> Completed</span>
					</div>
                    <?php 
// Assuming $employee_id is available
$task_completion_rate = calculate_task_completion_rate($conn, $employee_id);
?>
<div class="dashboard-item">
    <i class="fa fa-check-circle-o"></i>
    <span>Task Completion Rate: <?=$task_completion_rate?>%</span>
</div>

				</div>
			<?php } ?>
		</section>
	</div>
</body>
</html>
<?php 
} else { 
    $em = "First login";
    header("Location: login.php?error=$em");
    exit();
}
?>
