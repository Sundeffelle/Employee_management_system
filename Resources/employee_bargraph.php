<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['role'])  && ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'company')) {
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

$query = "SELECT 
              u.full_name AS employee_name,
              MONTH(k.evaluation_period) AS month,
              YEAR(k.evaluation_period) AS year,
              SUM((k.current_value * k.target_value) / 100) AS total_score
          FROM 
              kpis k
          JOIN 
              users u ON k.employee_id = u.id
          GROUP BY 
              u.id, YEAR(k.evaluation_period), MONTH(k.evaluation_period)
          ORDER BY 
              u.full_name, year, month";
$stmt = $conn->prepare($query);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$chartData = [];
$employees = [];
foreach ($data as $row) {
    $chartData[$row['employee_name']][] = [
        'month' => $row['month'],
        'year' => $row['year'],
        'total_score' => $row['total_score']
    ];
    $employees[] = $row['employee_name'];
}

$employees = array_unique($employees);  // Get unique employee names
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - KPI Performance</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container">
    <h3 class="text-center mt-4">Monthly KPI Performance per Employee</h3>
    
    <!-- Employee Filter Dropdown -->
    <label for="employeeSelect">Select Employees:</label>
    <select id="employeeSelect" multiple>
        <?php foreach ($employees as $employee) : ?>
            <option value="<?= htmlspecialchars($employee) ?>"><?= htmlspecialchars($employee) ?></option>
        <?php endforeach; ?>
    </select>
    
    <canvas id="kpiChart" width="400" height="200"></canvas>
</div>
<div>
    <a href="export-html.php">
<button type="submit" class="btn btn-primary">Export All Graphs to Excel</button>
</a>
</div>
<script>
// Prepare data for Chart.js
const originalChartData = <?php echo json_encode($chartData); ?>;
const labels = Array.from(new Set(Object.values(originalChartData).flatMap(d => d.map(item => `${item.month}-${item.year}`))));
const ctx = document.getElementById('kpiChart').getContext('2d');

// Function to generate datasets based on selected employees
function getDatasets(selectedEmployees) {
    return selectedEmployees.map(employee => ({
        label: employee,
        data: labels.map(label => {
            const [month, year] = label.split('-');
            const entry = originalChartData[employee]?.find(d => d.month == month && d.year == year);
            return entry ? entry.total_score : 0;
        })
    }));
}

// Create initial chart
let kpiChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: getDatasets(Object.keys(originalChartData))  // Display all employees initially
    },
    options: {
        responsive: true,
        scales: {
            x: { title: { display: true, text: 'Month-Year' }},
            y: { title: { display: true, text: 'Performance Score' }}
        },
        plugins: {
            legend: { position: 'top' },
            title: { display: true, text: 'Monthly KPI Performance per Employee' }
        }
    }
});

// Event listener for dropdown change
document.getElementById('employeeSelect').addEventListener('change', (event) => {
    const selectedEmployees = Array.from(event.target.selectedOptions).map(option => option.value);
    kpiChart.data.datasets = getDatasets(selectedEmployees.length ? selectedEmployees : Object.keys(originalChartData)); // Default to all if none selected
    kpiChart.update();
});
</script>
</body>
</html>
