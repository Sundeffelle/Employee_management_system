<?php
session_start();
if (isset($_SESSION['role']) && ($_SESSION['role'] == "admin" || $_SESSION['role'] == "company")) {
  include "../inc/DB_connection.php";

    // Join tasks, users, and employee_task_hours to see hours
    $sql = "SELECT th.id, t.title, u.full_name, th.work_date, th.start_time, th.end_time, th.hours_worked
            FROM employee_task_hours th
            JOIN tasks t ON th.task_id = t.id
            JOIN users u ON th.employee_id = u.id
            ORDER BY th.start_time DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $em = "First login as admin";
    header("Location: login.php?error=" . urlencode($em));
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>View Hours</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script>
    // Print Functionality
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.print-row').forEach(button => {
            button.addEventListener('click', function () {
                const row = this.closest('tr');
                const printContent = `<table class='table'><tr>${row.innerHTML}</tr></table>`;
                
                const win = window.open('', '', 'height=700,width=900');
                win.document.write('<html><head><title>Print Record</title></head><body>');
                win.document.write(printContent);
                win.document.write('</body></html>');
                win.document.close();
                win.print();
            });
        });
    });
</script>
</head>
<body>
<div class="container-fluid">
<h3 class="m-4">Hours Worked</h3>
<?php if ($records) { ?>
<table class="table table-hover">
   <thead>
     <tr>
       <th>#</th>
       <th>Task</th>
       <th>Employee</th>
       <th>Work Date</th>
       <th>Start Time</th>
       <th>End Time</th>
       <th>Hours Worked</th>
       <th>Actions</th>
     </tr>
   </thead>
   <tbody>
   <?php foreach ($records as $index => $r) { ?>
     <tr>
       <td><?= $index + 1 ?></td>
       <td><?= htmlspecialchars($r['title']) ?></td>
       <td><?= htmlspecialchars($r['full_name']) ?></td>
       <td><?= htmlspecialchars($r['work_date']) ?></td>
       <td><?= htmlspecialchars($r['start_time']) ?></td>
       <td><?= htmlspecialchars($r['end_time'] ?? 'In Progress') ?></td>
       <td><?= htmlspecialchars($r['hours_worked'] ?? 'N/A') ?></td>
       <td>
           <!-- Delete Button -->
           <form method="POST" action="delete_hours.php" class="d-inline">
               <input type="hidden" name="id" value="<?= $r['id'] ?>">
               <button type="submit" class="btn btn-danger btn-sm">Delete</button>
           </form>
           <!-- Print Button -->
           <button type="button" class="btn btn-secondary btn-sm print-row">Print</button>
       </td>
     </tr>
   <?php } ?>
   </tbody>
</table>
<?php } else { ?>
<h5>No hours recorded yet.</h5>
<?php } ?>
</div>
</body>
</html>
