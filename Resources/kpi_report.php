<?php
session_regenerate_id(true);
session_start();
if (isset($_SESSION['role'])  && ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'company')) {
    include "../inc/DB_connection.php";
    include "../app/Model/Kpis.php";  
    include "../app/Model/User.php";
    include "../inc/navbar.php";

    function get_kpi_report($conn) {
        $sql = "SELECT kpis.id, kpis.kpi_name, kpis.target_value, kpis.current_value, kpis.evaluation_period, 
                       kpis.status, users.full_name AS employee_name
                FROM kpis
                JOIN users ON kpis.employee_id = users.id";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    $kpi_report = get_kpi_report($conn);
?>
<div class="container-fluid">
    <h3 class="m-4"><i class="fa-solid fa-list fa-lg"></i> KPI Performance Report</h3>
    <div class="row">
        <div class="col-12">
            <?php if ($kpi_report) { ?>
                <div class="card bg-light ms-4 me-4 mb-4">
                    <div class="card-header">
                        <i class="fa-solid fa-list fa-lg"></i> KPI Records
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                      <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">KPI Name</th>
                                        <th scope="col">Employee</th>
                                        <th scope="col">Target Value</th>
                                        <th scope="col">Current Value</th>
                                        <th scope="col">Performance Score</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($kpi_report as $index => $kpi) { 
                                        $performance_score = calculate_performance_score($kpi['target_value'], $kpi['current_value']);
                                        
                                    ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td><?= htmlspecialchars($kpi['kpi_name']) ?></td>
                                            <td><?= htmlspecialchars($kpi['employee_name']) ?></td>
                                            <td><?= htmlspecialchars($kpi['target_value']) ?></td>
                                            <td><?= htmlspecialchars($kpi['current_value']) ?></td>
                                            <td><?= htmlspecialchars($performance_score) ?></td>
                                            <td><?= htmlspecialchars($kpi['status']) ?></td>
                                            <td>
                                                <button type="button" class="btn btn-success me-1" data-bs-toggle="modal" 
                                                        data-bs-target="#infoModal" 
                                                        onclick="showKpiDetails('<?= htmlspecialchars(json_encode($kpi)) ?>')">
                                                    <i class="fa-solid fa-circle-info fa-lg"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </p>
                    </div>
                </div>
            <?php } else { ?>
                <h5 class="alert alert-primary ms-4 me-4">No KPI Records Found</h5>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Info Modal -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoModalLabel">KPI Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Placeholder elements for each KPI detail -->
                <p><strong>KPI Name:</strong> <span id="kpiName"></span></p>
                <p><strong>Employee:</strong> <span id="employeeName"></span></p>
                <p><strong>Target Value:</strong> <span id="targetValue"></span></p>
                <p><strong>Current Value:</strong> <span id="currentValue"></span></p>
                <p><strong>Performance Score:</strong> <span id="performanceScore"></span></p>
                <p><strong>Status:</strong> <span id="status"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="printKpiDetails()">Print</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<footer class="mt-auto mb-4">
    <div class="text-center">
        <span>Copyright &copy; <script>document.write(new Date().getFullYear())</script> PatMactech UK.</span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

<!-- JavaScript for dynamic modal content and printing -->
<script>
function showKpiDetails(kpiData) {
    const kpi = JSON.parse(kpiData);
    document.getElementById('kpiName').textContent = kpi.kpi_name;
    document.getElementById('employeeName').textContent = kpi.employee_name;
    document.getElementById('targetValue').textContent = kpi.target_value;
    document.getElementById('currentValue').textContent = kpi.current_value;
    document.getElementById('performanceScore').textContent = <?= json_encode($performance_score) ?>;
    document.getElementById('status').textContent = kpi.status;
}

function printKpiDetails() {
    const modalContent = document.querySelector('#infoModal .modal-content');
    const newWindow = window.open('', '_blank');
    newWindow.document.write(modalContent.innerHTML);
    newWindow.document.close();
    newWindow.print();
}
</script>

<?php 
} else {
    header("Location: login.php");
    exit();
} 
?>
