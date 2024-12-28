<?php
session_start();
if (!isset($_SESSION['id'])) {
    $em = "First login";
    header("Location: login.php?error=".urlencode($em));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "../inc/DB_connection.php";

    $task_id = intval($_POST['task_id'] ?? 0);
    $employee_id = $_SESSION['id'];

    if ($task_id <= 0) {
        $em = "Invalid task.";
        header("Location: my_task.php?error=".urlencode($em));
        exit();
    }

    // Insert a new row in employee_task_hours with start_time = NOW()
    $sql = "INSERT INTO employee_task_hours (task_id, employee_id, start_time) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$task_id, $employee_id]);

    $em = "Work started for the task.";
    header("Location: my_task.php?success=".urlencode($em));
    exit();
} else {
    $em = "Invalid request.";
    header("Location: my_task.php?error=".urlencode($em));
    exit();
}
