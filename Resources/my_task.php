<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
    include "../inc/DB_connection.php";
    include "../app/Model/Task.php";
    include "../app/Model/User.php";

    // New include for our hours check function (if placed in Task.php or separate file)
    // include "app/Model/Hours.php"; // If we created a separate file for hours functions

    $tasks = get_all_tasks_by_id($conn, $_SESSION['id']);
?>
<!DOCTYPE html>
<html>
<head>
	<title>My Tasks</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/style.css">
</head>
<body>
	<input type="checkbox" id="checkbox">
	<?php include "../inc/header.php" ?>
	<div class="body">
		<?php include "../inc/nav.php" ?>
		<section class="section-1">
			<h4 class="title">My Tasks</h4>
			<?php if (isset($_GET['success'])) { ?>
      	  	<div class="success" role="alert">
			  <?php echo stripcslashes($_GET['success']); ?>
			</div>
			<?php } ?>
			<?php if ($tasks != 0) { ?>
			<table class="main-table">
				<tr>
					<th>#</th>
					<th>Title</th>
					<th>Description</th>
					<th>Status</th>
					<th>Due Date</th>
					<th>Action</th>
                    <th>Work</th>
				</tr>
				<?php $i=0; foreach ($tasks as $task) { 
                      $i++;
                      $ongoing = has_ongoing_session($conn, $_SESSION['id'], $task['id']);
                ?>
				<tr>
					<td><?=$i?></td>
					<td><?=htmlspecialchars($task['title'])?></td>
					<td><?=htmlspecialchars($task['description'])?></td>
					<td><?=htmlspecialchars($task['status'])?></td>
	            	<td><?=($task['due_date'])?htmlspecialchars($task['due_date']):"No Deadline";?></td>
					<td>
						<a href="edit-task-employee.php?id=<?=$task['id']?>" class="edit-btn">Edit</a>
					</td>
                    <td>
                      <?php if (!$ongoing) { ?>
                        <form action="start_work.php" method="POST" style="display:inline;">
                            <input type="hidden" name="task_id" value="<?=$task['id']?>">
                            <button type="submit" class="btn btn-success btn-sm">Start Work</button>
                        </form>
                      <?php } else { ?>
                        <form action="stop_work.php" method="POST" style="display:inline;">
                            <input type="hidden" name="task_id" value="<?=$task['id']?>">
                            <button type="submit" class="btn btn-danger btn-sm">Stop Work</button>
                        </form>
                      <?php } ?>
                    </td>
				</tr>
			   <?php } ?>
			</table>
		<?php }else { ?>
			<h3>Empty</h3>
		<?php  }?>
			
		</section>
	</div>
<script type="text/javascript">
	var active = document.querySelector("#navList li:nth-child(2)");
	active.classList.add("active");
</script>
</body>
</html>
<?php }else{ 
   $em = "First login";
   header("Location: login.php?error=$em");
   exit();
}
?>
