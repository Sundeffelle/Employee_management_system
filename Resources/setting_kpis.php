<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == 'admin') {

    if (isset($_POST['kpi_name'], $_POST['employee_id'], $_POST['target_value'], $_POST['current_value'], $_POST['evaluation_period'], $_POST['status'])) {
        include "../inc/DB_connection.php";

        function validate_input($data) {
            return htmlspecialchars(stripslashes(trim($data)));
        }

        $kpi_name = validate_input($_POST['kpi_name']);
        $employee_id = (int) validate_input($_POST['employee_id']);
        $target_value = (float) validate_input($_POST['target_value']);
        $current_value = (float) validate_input($_POST['current_value']);
        $evaluation_period = validate_input($_POST['evaluation_period']);
        $status = validate_input($_POST['status']);

        // Validation checks
        if (empty($kpi_name)) {
            $em = "KPI name is required";
            header("Location: manage_kpi_table.php?error=$em");
            exit();
        } elseif ($employee_id === 0) {
            $em = "Select Employee";
            header("Location: manage_kpi_table.php?error=$em");
            exit();
        } elseif (empty($target_value)) {
            $em = "Target Value is required";
            header("Location: manage_kpi_table.php?error=$em");
            exit();
        } elseif (empty($evaluation_period)) {
            $em = "Evaluation period is required";
            header("Location: manage_kpi_table.php?error=$em");
            exit();
        } else {
            // Insert the new KPI into the database
            $sql = "INSERT INTO kpis (kpi_name, employee_id, target_value, current_value, evaluation_period, status) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$kpi_name, $employee_id, $target_value, $current_value, $evaluation_period, $status]);

            $em = "KPI created successfully";
            header("Location: manage_kpi_table.php?success=$em");
            exit();
        }
    } else {
        $em = "Unknown error occurred";
        header("Location: manage_kpi_table.php?error=$em");
        exit();
    }

} else { 
    $em = "Please log in";
    header("Location: login.php?error=$em");
    exit();
}
?>
