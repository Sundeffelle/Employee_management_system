<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Check if the user is logged in and has an admin role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

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

// Check if employee filter is provided
$selectedEmployees = isset($_POST['employees']) ? $_POST['employees'] : [];

// Construct query for selected employees or all employees
$query = "SELECT 
              u.full_name AS employee_name,
              MONTH(k.evaluation_period) AS month,
              YEAR(k.evaluation_period) AS year,
              SUM((k.current_value * k.target_value) / 100) AS total_score
          FROM 
              kpis k
          JOIN 
              users u ON k.employee_id = u.id";

if (!empty($selectedEmployees)) {
    $placeholders = implode(',', array_fill(0, count($selectedEmployees), '?'));
    $query .= " WHERE u.full_name IN ($placeholders)";
}

$query .= " GROUP BY 
              u.id, YEAR(k.evaluation_period), MONTH(k.evaluation_period)
          ORDER BY 
              u.full_name, year, month";

$stmt = $conn->prepare($query);

// Bind selected employees if provided
if (!empty($selectedEmployees)) {
    $stmt->execute($selectedEmployees);
} else {
    $stmt->execute();
}

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Include PHPExcel library
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set header row
$sheet->setCellValue('A1', 'Employee Name')
      ->setCellValue('B1', 'Month')
      ->setCellValue('C1', 'Year')
      ->setCellValue('D1', 'Performance Score');

// Populate rows with data
$rowIndex = 2;
foreach ($data as $row) {
    $sheet->setCellValue('A' . $rowIndex, $row['employee_name'])
          ->setCellValue('B' . $rowIndex, $row['month'])
          ->setCellValue('C' . $rowIndex, $row['year'])
          ->setCellValue('D' . $rowIndex, round($row['total_score'], 2));
    $rowIndex++;
}

// Set headers to trigger download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="KPI_Performance_Admin.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit();
