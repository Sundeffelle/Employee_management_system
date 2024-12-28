<?php

include "../inc/navbar.php";

?>

    <div class="container-fluid">
        <h3 class="text-center m-4">Leaves</h3>
        <div class="alert alert-success" role="alert">
            <a href="main_page.php" class="alert-link">Go to Home Page</a>
        </div>

        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card bg-light mb-3">
                    <div class="card-header">
                        <i class="fa-solid fa-address-card fa-lg"></i> ELR
                    </div>
                    <div class="card-body">
                        <form method="POST" action="request_leave.php">
                            <h3 class="mb-3">Request Leave</h3>
                            <div class="mb-3">
                                <label for="leave_type" class="form-label">Leave Type:</label>
                                <select name="leave_type" id="leave_type" class="form-select" required>
                                    <option value="sick">Sick Leave</option>
                                    <option value="vacation">Vacation Leave</option>
                                    <option value="maternity">Maternity Leave</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date:</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="end_date" class="form-label">End Date:</label>
                                <input type="date" name="end_date" id="end_date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="reason" class="form-label">Reason:</label>
                                <textarea name="reason" id="reason" class="form-control" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Request</button>
                        </form>  
                    </div>
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
</body>
</html>
