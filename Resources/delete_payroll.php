<?php

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
include "../app/Model/Payroll.php";
if (isset($_GET['payroll_id'])) {
    $payroll_id = filter_input(INPUT_GET, 'payroll_id', FILTER_VALIDATE_INT);

    $query = "DELETE * FROM payroll WHERE payroll_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$payroll_id]);

    header("Location: payroll_results_table.php");
    exit();
} else {
    echo "Invalid payroll ID.";
}
?>
