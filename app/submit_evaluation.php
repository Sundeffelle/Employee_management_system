<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

$host = "localhost";
$db_name = "task_management_db";
$username = "root";
$password = "";
try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

 // Ensure this is the correct path to your DB connection

// Capture form values and set to null if not present
$employee_id = $_POST['user_id'] ?? null;
$evaluator_id = $_POST['evaluator_id'] ?? null;
$kpi_id = $_POST['kpi_id'] ?? null;
$score = $_POST['score'] ?? null;
$feedback = $_POST['feedback'] ?? null;
$created_at = date('Y-m-d H:i:s'); // Set the current timestamp for created_at

// Check if all required fields are provided
if (!$employee_id || !$evaluator_id || !$kpi_id || !$score || !$feedback) {
    echo "All fields are required!";
    exit;
}

// Prepare the SQL query
$sql = "INSERT INTO evaluations (employee_id, evaluator_id, kpi_id, score, feedback, created_at) 
        VALUES (:employee_id, :evaluator_id, :kpi_id, :score, :feedback, :created_at)";

$stmt = $conn->prepare($sql);

// Execute the query with values from the form
$stmt->execute([
    ':employee_id' => $employee_id,
    ':evaluator_id' => $evaluator_id,
    ':kpi_id' => $kpi_id,
    ':score' => $score,
    ':feedback' => $feedback,
    ':created_at' => $created_at
]);

echo "Evaluation submitted successfully!";
?>
