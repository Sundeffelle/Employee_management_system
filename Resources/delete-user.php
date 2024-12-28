<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
    include "../inc/DB_connection.php";

    // Check if user_id is provided
    if ($_POST['user_id']) {
        // Validate and sanitize the user ID
        $id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);

        if ($id) {
            try {
                // Prepare the delete query
                $query = "DELETE FROM users WHERE id = ?";
                $stmt = $conn->prepare($query);

                if ($stmt->execute([$id])) {
                    // Redirect with a success message
                    header("Location: user.php?success=User deleted successfully.");
                    exit();
                } else {
                    // Redirect with an error message if deletion fails
                    header("Location: user.php?error=Failed to delete user.");
                    exit();
                }
            } catch (PDOException $e) {
                // Log and redirect on database error
                error_log("PDOException: " . $e->getMessage());
                header("Location: user.php?error=An error occurred while deleting the user.");
                exit();
            }
        } else {
            // Redirect with an error message if the ID is invalid
            header("Location: user.php?error=Invalid user ID.");
            exit();
        }
    } else {
        // Redirect with an error message if the user ID is missing
        header("Location: user.php?error=User ID not provided.");
        exit();
    }
} else {
    // Redirect if unauthorized access
    $em = "Unauthorized access.";
    header("Location: login.php?error=$em");
    exit();
}
?>
