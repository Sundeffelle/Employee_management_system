<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Security: Regenerate session ID to prevent session fixation
session_regenerate_id(true);

// Check if the user is an admin
if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {

    // Include the database connection
    include '../inc/DB_connection.php';

    // Check if the form is submitted and required fields are present
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'], $_POST['leave_id'])) {
        
        // Sanitize the input
        $status = filter_var(trim($_POST['status']), FILTER_SANITIZE_STRING);
        $leave_id = filter_var(trim($_POST['leave_id']), FILTER_SANITIZE_NUMBER_INT);

        // Validate that input is not empty and leave_id is a valid integer
        if (!empty($status) && filter_var($leave_id, FILTER_VALIDATE_INT)) {
            
            // Update leave status using prepared statements
            try {
                $sql = "UPDATE leaves SET status = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$status, $leave_id]);

                // Redirect to the same page with a success message
                header("Location: manage_leave.php?success=Leave status updated.");
                exit();
            } catch (Exception $e) {
                // Log the error for debugging (don’t show sensitive information to the user)
                error_log("Error updating leave status: " . $e->getMessage());
                header("Location: manage_leave.php?error=Failed to update leave status.");
                exit();
            }
        } else {
            // Redirect with an error if the input is invalid
            header("Location: manage_leave.php?error=Invalid input.");
            exit();
        }
    } else {
        // Redirect with an error if the required POST data is missing
        header("Location: manage_leave.php?error=Missing required fields.");
        exit();
    }
} else {
    // Redirect to login if the user is not authenticated as an admin
    header("Location: login.php");
    exit();
}
?>



/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Security: Prevent session fixation
session_regenerate_id(true);

// Check if user is an admin
if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {

    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        header("Location: inc/nav.php?error=Invalid CSRF token.");
        exit();
    }

    include "DB_connection.php";

    // Validate and sanitize input
    if (isset($_POST['status'], $_POST['leave_id'])) {
        // Sanitize input to prevent SQL injection
        $status = filter_var(trim($_POST['status']), FILTER_SANITIZE_STRING);
        $leave_id = filter_var(trim($_POST['leave_id']), FILTER_SANITIZE_NUMBER_INT);

        if (!empty($status) && filter_var($leave_id, FILTER_VALIDATE_INT)) {
            // Update leave status (ensure the function is defined)
            try {
                update_leave_status($conn, [$status, $leave_id]);
                header("Location: inc/nav.php?success=Leave status updated.");
                exit();
            } catch (Exception $e) {
                // Log the error for security (ensure sensitive details are not displayed to users)
                error_log("Error updating leave status: " . $e->getMessage());
                header("Location: inc/nav.php?error=Failed to update leave status.");
                exit();
            }
        } else {
            header("Location: inc/nav.php?error=Invalid input.");
            exit();
        }
    } else {
        header("Location: inc/nav.php?error=Missing required fields.");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>
 







/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Security: Prevent session fixation
session_regenerate_id(true);

// Ensure the user is an admin
if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {

    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        header("Location: inc/nav.php?error=Invalid CSRF token.");
        exit();
    }

    include "DB_connection.php";

    // Validate and sanitize input
    if (isset($_POST['status'], $_POST['leave_id'])) {
        // Sanitize input to prevent SQL injection
        $status = filter_var(trim($_POST['status']), FILTER_SANITIZE_STRING);
        $leave_id = filter_var(trim($_POST['leave_id']), FILTER_SANITIZE_NUMBER_INT);

        if (!empty($status) && filter_var($leave_id, FILTER_VALIDATE_INT)) {
            // Update leave status (assuming update_leave_status uses prepared statements)
            try {
                update_leave_status($conn, [$status, $leave_id]);
                header("Location: inc/nav.php?success=Leave status updated.");
            } catch (Exception $e) {
                // Log the error for security (ensure sensitive details are not displayed to users)
                error_log("Error updating leave status: " . $e->getMessage());
                header("Location: inc/nav.php?error=Failed to update leave status.");
            }
        } else {
            header("Location: inc/nav.php?error=Invalid input.");
        }
    } else {
        header("Location: inc/nav.php?error=Missing required fields.");
    }
} else {
    header("Location: ../login.php");



}
function update_leave_status($conn, $data) {
    $sql = "UPDATE leaves SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->execute($data);
    } else {
        throw new Exception("Failed to prepare statement.");
    }
}




