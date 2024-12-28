<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if (isset($_POST['id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    include "../inc/DB_connection.php";

    $id = intval($_POST['id']);

    try {
        $sql = "DELETE FROM employee_task_hours WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: view_hours.php?success=" . urlencode("Record deleted successfully."));
        exit();
    } catch (PDOException $e) {
        error_log($e->getMessage());
        header("Location: view_hours.php?error=" . urlencode("Failed to delete record."));
        exit();
    }
} else {
    header("Location: view_hours.php?error=" . urlencode("Unauthorized access."));
    exit();
}
