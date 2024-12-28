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

// Initialize arrays for processing
$chartData = [];
$allMonths = [];

// Populate chartData with monthly scores and track unique Month-Year labels
foreach ($data as $row) {
    $monthYear = sprintf('%02d-%d', $row['month'], $row['year']);
    $chartData[$monthYear] = $row['total_score'];
    $allMonths[$monthYear] = true;  // Use an associative array to get unique months
}

// Sort all months for consistent display
$allMonths = array_keys($allMonths);
sort($allMonths);

// Fill missing months with zero scores
foreach ($allMonths as $monthYear) {
    if (!isset($chartData[$monthYear])) {
        $chartData[$monthYear] = 0;  // Add zero score if month is missing
    }
}
ksort($chartData); // Sort months
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My KPI Progress</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container">
    <h3 class="text-center mt-4">My Monthly KPI Performance</h3>
    <canvas id="kpiChart" width="400" height="200"></canvas>
    <div class="text-center mt-3">
        <a href="download_pdf.php" class="btn btn-primary">Export to PDF</a>
        <a href="download_excel.php" class="btn btn-success">Export to Excel</a>
    </div>
</div>

<script>
// Prepare data for Chart.js
const labels = <?php echo json_encode(array_keys($chartData)); ?>;
const data = <?php echo json_encode(array_values($chartData)); ?>;

const ctx = document.getElementById('kpiChart').getContext('2d');
const kpiChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Performance Score',
            data: data,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            x: { title: { display: true, text: 'Month-Year' }},
            y: { title: { display: true, text: 'Performance Score' }}
        },
        plugins: {
            legend: { display: false },
            title: { display: true, text: 'My Monthly KPI Performance' }
        }
    }
});
</script>
</body>
</html>
