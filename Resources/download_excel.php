<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Check if the user is logged in and has an employee role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'employee') {
    header("Location: login.php");
    exit();
}

// Ensure employee_id is set in the session
if (isset($_SESSION['employee_id'])) {
    die("Error: Employee ID is not set in the session.");
}

$employee_id = $_SESSION['id'];

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

// Fetch monthly KPI scores for the logged-in employee
$query = "SELECT 
              MONTH(k.evaluation_period) AS month,
              YEAR(k.evaluation_period) AS year,
              SUM((k.current_value * k.target_value) / 100) AS total_score
          FROM 
              kpis k
          WHERE 
              k.employee_id = :employee_id
          GROUP BY 
              YEAR(k.evaluation_period), MONTH(k.evaluation_period)
          ORDER BY 
              year, month";
$stmt = $conn->prepare($query);
$stmt->bindParam(':employee_id', $employee_id, PDO::PARAM_INT);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Include PHPExcel library
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set header row
$sheet->setCellValue('A1', 'Month')
      ->setCellValue('B1', 'Year')
      ->setCellValue('C1', 'Performance Score');

// Populate rows with data
$rowIndex = 2;
foreach ($data as $row) {
    $sheet->setCellValue('A' . $rowIndex, $row['month'])
          ->setCellValue('B' . $rowIndex, $row['year'])
          ->setCellValue('C' . $rowIndex, round($row['total_score'], 2));
    $rowIndex++;
}

// Set headers to trigger download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="KPI_Performance.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit();
?>
