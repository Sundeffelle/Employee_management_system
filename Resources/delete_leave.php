<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['leave_id'])) {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "task_management_db";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        header("Location: manage_leave.php?error=Database connection failed.");
        exit();
    }

    // Get the leave ID from the form
    $leave_id = filter_input(INPUT_POST, 'leave_id', FILTER_VALIDATE_INT);

    if ($leave_id) {
        try {
            // Prepare and execute the delete query
            $sql = "DELETE FROM leaves WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$leave_id]);

            // Redirect with success message
            header("Location:leave.php?success=Leave request deleted successfully.");
            exit();
        } catch (PDOException $e) {
            // Redirect with error message
            error_log("Error deleting leave: " . $e->getMessage());
            header("Location: login.php?error=An error occurred while deleting the leave request.");
            exit();
        }
    } else {
        // Redirect with error message for invalid ID
        header("Location: manage_leave.php?error=Invalid leave request ID.");
        exit();
    }
} else {
    // Redirect with error message for invalid request method
    header("Location: main_page.php?error=Invalid request.");
    exit();
}
?>
