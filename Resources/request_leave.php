<?php

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_management_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();  
}

session_start();

// Check if user is logged in
if (isset($_SESSION['id'])) {

    // Validate input with safer methods
    $leave_type = htmlspecialchars(trim($_POST['leave_type']));
    $start_date = htmlspecialchars(trim($_POST['start_date']));
    $end_date = htmlspecialchars(trim($_POST['end_date']));
    $reason = htmlspecialchars(trim($_POST['reason']));
    $employee_id = $_SESSION['id'];

    // Prepare SQL query for inserting leave request
    $sql = "INSERT INTO leaves (employee_id, leave_type, start_date, end_date, reason) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->execute([$employee_id, $leave_type, $start_date, $end_date, $reason]);

    // Redirect to success page
    header("Location: leave_form.php?success=Leave request submitted.");
} else {
    // Redirect to login page if not logged in
    header("Location: login.php");
}
?>
