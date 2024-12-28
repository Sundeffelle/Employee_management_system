<?php
 include "DB_connection.php"; // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $evaluator_id = $_POST['evaluator_id'];
    $employee_id = $_POST['employee_id'];

    $sql = "INSERT INTO assigned_evaluators (evaluator_id, employee_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute([$evaluator_id, $employee_id])) {
        echo "Evaluator assigned successfully!";
    } else {
        echo "Failed to assign evaluator.";
    }
}
?>
