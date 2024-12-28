<nav class="side-bar">
    <div class="user-p">
        <?php
        // Include database connection
        include "../inc/DB_connection.php";

        // Check if user ID is set
        if (isset($_SESSION['id'])) {
            $user_id = $_SESSION['id'];

            // Fetch the profile image for the logged-in user
            $query = "SELECT COALESCE(profile_image, 'img/user.png') AS profile_image FROM users WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$user_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // Construct image path
            $profile_image = !empty($result['profile_image']) && $result['profile_image'] !== 'img/user.png' 
                ? '../uploads/profile_images/' . $result['profile_image'] 
                : 'img/user.png';
        } else {
            // Fallback if no session ID
            $profile_image = 'img/user.png';
        }
        ?>
        <img src="<?= htmlspecialchars($profile_image) ?>" alt="Profile Image" class="img-fluid rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
        <h4>Welcome</h4>
        <h4><?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest'; ?></h4>
    </div>

    <?php 
    session_regenerate_id(true);

    if ($_SESSION['role'] == "employee") {
    ?>
        <!-- Employee Navigation Bar -->
        <ul id="navList">
            <li><a href="index.php"><i class="fa fa-tachometer" aria-hidden="true"></i><span>Dashboard</span></a></li>
            <li><a href="my_task.php"><i class="fa fa-tasks" aria-hidden="true"></i><span>Timesheet</span></a></li>
            <li><a href="profile.php"><i class="fa fa-user" aria-hidden="true"></i><span>Profile</span></a></li>
            <li><a href="notifications.php"><i class="fa fa-bell" aria-hidden="true"></i><span>Notifications</span></a></li>
            <li><a href="employee_view.php"><i class="fa fa-eye" aria-hidden="true"></i><span>View Leave</span></a></li>
            <li><a href="leave_form.php"><i class="fa fa-pencil" aria-hidden="true"></i><span>Request Leave</span></a></li>
            <li><a href="manage_kpi_table.php"><i class="fa fa-bar-chart" aria-hidden="true"></i><span>Manage KPI</span></a></li>
            <li><a href="user_bargraph.php"><i class="fa fa-line-chart" aria-hidden="true"></i><span>Progress Bar</span></a></li>
            <li><a href="employee_reset.php"><i class="fa fa-line-chart" aria-hidden="true"></i><span>Reset Password</span></a></li>
            <li><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i><span>Logout</span></a></li>
        </ul>
    <?php 
    } else if ($_SESSION['role'] == "admin" || $_SESSION['role'] == "company") { 
    ?>
        <!-- Admin and Company Navigation Bar -->
        <ul id="navList">
            <li><a href="index.php"><i class="fa fa-tachometer" aria-hidden="true"></i><span>Dashboard</span></a></li>
            <li><a href="user.php"><i class="fa fa-users" aria-hidden="true"></i><span>Manage Users</span></a></li>
            <li><a href="create_task.php"><i class="fa fa-plus" aria-hidden="true"></i><span>Create Task</span></a></li>
            <li><a href="tasks.php"><i class="fa fa-tasks" aria-hidden="true"></i><span>All Tasks</span></a></li>
            <li><a href="leave.php"><i class="fa fa-envelope" aria-hidden="true"></i><span>Manage Leave</span></a></li>
            <li><a href="create_kpis.php"><i class="fa fa-bar-chart" aria-hidden="true"></i><span>Evaluation</span></a></li>
            <li><a href="change_password.php"><i class="fa fa-key" aria-hidden="true"></i><span>Change Password</span></a></li>
            <li><a href="kpi_report.php"><i class="fa fa-file" aria-hidden="true"></i><span>Employee Reports</span></a></li>
            <li><a href="employee_bargraph.php"><i class="fa fa-bar-chart" aria-hidden="true"></i><span>Employees Progress Bar</span></a></li>
            <li><a href="payroll_form.php"><i class="fa fa-money" aria-hidden="true"></i><span>Payroll</span></a></li>
            <li><a href="payroll_results_table.php"><i class="fa fa-calculator" aria-hidden="true"></i><span>Deductions</span></a></li>
            <li><a href="expenses.php"><i class="fa fa-credit-card" aria-hidden="true"></i><span>Expenses</span></a></li>
            <li><a href="manage_suspensions.php"><i class="fa fa-ban" aria-hidden="true"></i><span>Manage Employees</span></a></li>
            <li><a href="subscription_tracked.php"><i class="fa fa-eye" aria-hidden="true"></i><span>View Subscriptions</span></a></li>
            <li><a href="../Admin/expired_subscriptions.php"><i class="fa fa-clock-o" aria-hidden="true"></i><span>Expired Subscriptions</span></a></li>
            <li><a href="view_hours.php"><i class="fa fa-eye" aria-hidden="true"></i><span>Employee Hours</span></a></li>
            <li><a href="reset_password_form.php"><i class="fa fa-eye" aria-hidden="true"></i><span>Password Reset</span></a></li>
            
            <li><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i><span>Logout</span></a></li>
        </ul>
    <?php 
    } else if ($_SESSION['role'] == "evaluator") { 
    ?>
        <!-- Evaluator Navigation Bar -->
        <ul id="navList">
            <li><a href="evaluation.php"><i class="fa fa-tachometer" aria-hidden="true"></i><span>Dashboard</span></a></li>
            <li><a href="evaluate_tasks.php"><i class="fa fa-check-circle" aria-hidden="true"></i><span>Evaluate Tasks</span></a></li>
            <li><a href="view_performance.php"><i class="fa fa-line-chart" aria-hidden="true"></i><span>View Performance</span></a></li>
            <li><a href="feedback.php"><i class="fa fa-comment" aria-hidden="true"></i><span>Provide Feedback</span></a></li>
            <li><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i><span>Logout</span></a></li>
        </ul>
    <?php 
    } 
    ?>
</nav>
