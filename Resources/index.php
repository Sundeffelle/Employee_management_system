<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (isset($_SESSION['role']) && $_SESSION['role'] == "admin" || $_SESSION['role'] == "company" || isset($_SESSION['id']) ) {

	include "../inc/DB_connection.php";
    include "../app/Model/Task.php";
    include "../app/Model/User.php";

	if ($_SESSION['role'] == "admin" || $_SESSION['role'] == "company") {
        // Admin and Company-specific logic
		$todaydue_task = count_tasks_due_today($conn);
	    $overdue_task = count_tasks_overdue($conn);
	    $nodeadline_task = count_tasks_NoDeadline($conn);
	    $num_task = count_tasks($conn);
	    $num_users = count_users($conn);
	    $pending = count_pending_tasks($conn);
	    $in_progress = count_in_progress_tasks($conn);
	    $completed = count_completed_tasks($conn);
		$company_performance = calculate_company_task_completion_rate($conn);
		$task_distribution = calculate_company_task_distribution($conn);
		$company_overall_ratio = calculate_company_overdue_ratio($conn);
		$average_employee  = calculate_average_employee_tasks($conn);

	} elseif ($_SESSION['role'] == "employee") {
        // Employee-specific logic
        $num_my_task = count_my_tasks($conn, $_SESSION['id']);
        $overdue_task = count_my_tasks_overdue($conn, $_SESSION['id']);
        $nodeadline_task = count_my_tasks_NoDeadline($conn, $_SESSION['id']);
        $pending = count_my_pending_tasks($conn, $_SESSION['id']);
	    $in_progress = count_my_in_progress_tasks($conn, $_SESSION['id']);
	    $completed = count_my_completed_tasks($conn, $_SESSION['id']);
		$task_rate = calculate_task_completion_rate($conn, $_SESSION['id']);
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/style.css">
</head>
<body>
	<input type="checkbox" id="checkbox">
	<?php include "../inc/header.php"; ?>
	<div class="body">
		<?php include "../inc/nav.php"; ?>
		<section class="section-1">
			<?php if ($_SESSION['role'] == "admin" || $_SESSION['role'] == "company") { ?>
				<div class="dashboard">
					<div class="dashboard-item">
						<i class="fa fa-users"></i>
						<span><?=$num_users?> Employee</span>
					</div>
					<div class="dashboard-item">
						<i class="fa fa-tasks"></i>
						<span><?=$num_task?> All Tasks</span>
					</div>
					<div class="dashboard-item">
						<i class="fa fa-window-close-o"></i>
						<span><?=$overdue_task?> Overdue</span>
					</div>
					<div class="dashboard-item">
						<i class="fa fa-clock-o"></i>
						<span><?=$nodeadline_task?> No Deadline</span>
					</div>
					<div class="dashboard-item">
						<i class="fa fa-exclamation-triangle"></i>
						<span><?=$todaydue_task?> Due Today</span>
					</div>
					<div class="dashboard-item">
						<i class="fa fa-bell"></i>
						<span><?=$overdue_task?> Notifications</span>
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
					<div class="dashboard-item">
						<i class="fa fa-check-square-o"></i>
						<span><?=$company_overall_ratio?> Overall Ratio</span>
					</div> 
					<div class="dashboard-item">
						<i class="fa fa-check-square-o"></i>
						<span><?=$average_employee?> Average Employee</span>
					</div> 
					<div class="dashboard-item">
						<i class="fa fa-square-o"></i>
						<span>Pending: <?=$task_distribution['pending']?>%</span>
					</div>
					<div class="dashboard-item">
						<i class="fa fa-spinner"></i>
						<span>In Progress: <?=$task_distribution['in_progress']?>%</span>
					</div>
					<div class="dashboard-item">
						<i class="fa fa-check-square-o"></i>
						<span>Completed: <?=$task_distribution['completed']?>%</span>
					</div>
					<div class="dashboard-item">
						<i class="fa fa-check-square-o"></i>
						<span><?=$company_performance?> Overall Performance</span>
					</div>
				</div>
			<?php } else { ?>
				<div class="dashboard">
					<div class="dashboard-item">
						<i class="fa fa-tasks"></i>
						<span><?=$num_my_task?> My Tasks</span>
					</div>
					<div class="dashboard-item">
						<i class="fa fa-window-close-o"></i>
						<span><?=$overdue_task?> Overdue</span>
					</div>
					<div class="dashboard-item">
						<i class="fa fa-clock-o"></i>
						<span><?=$nodeadline_task?> No Deadline</span>
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
					<div class="dashboard-item">
						<i class="fa fa-check-square-o"></i>
						<span><?=$task_rate?> Your Task Rate</span>
					</div>
				</div>
			<?php } ?>
		</section>
	</div>

	<script type="text/javascript">
		var active = document.querySelector("#navList li:nth-child(1)");
		active.classList.add("active");
	</script>
</body>
</html>
<?php 
} else { 
   $em = "First login";
   header("Location: login.php?error=$em");
   exit();
}
?>
