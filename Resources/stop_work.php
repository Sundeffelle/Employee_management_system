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

    // Find the ongoing entry (end_time IS NULL)
    $sql = "SELECT id FROM employee_task_hours WHERE employee_id = ? AND task_id = ? AND end_time IS NULL LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$employee_id, $task_id]);
    if ($stmt->rowCount() === 0) {
        $em = "No ongoing work session found.";
        header("Location: my_task.php?error=".urlencode($em));
        exit();
    }

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $hours_id = $row['id'];

    // Update end_time = NOW() and calculate hours_worked
    $updateSql = "UPDATE employee_task_hours 
                  SET end_time = NOW(), 
                      hours_worked = TIMESTAMPDIFF(MINUTE, start_time, NOW())/60
                  WHERE id = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->execute([$hours_id]);

    $em = "Work stopped for the task.";
    header("Location: my_task.php?success=".urlencode($em));
    exit();
} else {
    $em = "Invalid request.";
    header("Location: my_task.php?error=".urlencode($em));
    exit();
}
