<body class="d-flex flex-column min-vh-100">
    

<div class="container-fluid">
    <h3 class="m-4"><i class="fa-solid fa-list fa-lg"></i> Departmental Payroll Summary</h3>
    <div class="row">
        <div class="col-12">
            <?php
            include '../app/Model/Payroll.php';
            include '../inc/navbar.php';
            $payroll_summary = get_payroll_summary_by_department($conn);
            if ($payroll_summary) {
            ?>
                <div class="card bg-light ms-4 me-4 mb-4">
                    <div class="card-header">
                        <i class="fa-solid fa-chart-bar fa-lg"></i> Departmental Expenses
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Department</th>
                                        <th scope="col">Total Expense</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($payroll_summary as $summary) { ?>
                                        <tr>
                                            <td><?= htmlspecialchars($summary['department']) ?></td>
                                            <td><?= number_format($summary['total_expense'], 2) ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php
            } else {
                echo '<h5 class="alert alert-primary ms-4 me-4">No Departmental Payroll Data Found</h5>';
            }
            ?>
        </div>
    </div>
</div>
</body>