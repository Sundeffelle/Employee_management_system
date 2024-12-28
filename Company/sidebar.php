<nav class="side-bar">
    <div class="user-p">
        <?php
        // Include database connection
        include "DB_connection.php";

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
                ? 'uploads/profile_images/' . $result['profile_image'] 
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
            <li><a href="index.php"><i class="fa fa-tachometer"></i><span>Dashboard</span></a></li>
            <li><a href="my_task.php"><i class="fa fa-tasks"></i><span>My Task</span></a></li>
            <li><a href="profile.php"><i class="fa fa-user"></i><span>Profile</span></a></li>
            <li><a href="notifications.php"><i class="fa fa-bell"></i><span>Notifications</span></a></li>
            <li><a href="employee_view.php"><i class="fa fa-eye"></i><span>View Leave</span></a></li>
            <li><a href="leave_form.php"><i class="fa fa-paper-plane"></i><span>Request Leave</span></a></li>
            <li><a href="manage_kpi_table.php"><i class="fa fa-tasks"></i><span>Manage KPI</span></a></li>
            <li><a href="user_bargraph.php"><i class="fa fa-chart-line"></i><span>Progress Bar</span></a></li>
            <li><a href="logout.php"><i class="fa fa-sign-out"></i><span>Logout</span></a></li>
        </ul>
    <?php 
    } elseif ($_SESSION['role'] == "admin") { 
    ?>
        <!-- Admin Navigation Bar -->
        <ul id="navList">
            <li><a href="index.php"><i class="fa fa-tachometer"></i><span>Dashboard</span></a></li>
            <li><a href="user.php"><i class="fa fa-users"></i><span>Manage Users</span></a></li>
            <li><a href="create_task.php"><i class="fa fa-plus"></i><span>Create Task</span></a></li>
            <li><a href="tasks.php"><i class="fa fa-tasks"></i><span>All Tasks</span></a></li>
            <li><a href="leave.php"><i class="fa fa-calendar"></i><span>Manage Leave</span></a></li>
            <li><a href="create_kpis.php"><i class="fa fa-tasks"></i><span>Evaluation</span></a></li>
            <li><a href="change_password.php"><i class="fa fa-key"></i><span>Change Password</span></a></li>
            <li><a href="kpi_report.php"><i class="fa fa-bar-chart"></i><span>Employee Reports</span></a></li>
            <li><a href="employee_bargraph.php"><i class="fa fa-chart-bar"></i><span>Employees Progress Bar</span></a></li>
            <li><a href="payroll_form.php"><i class="fa fa-money"></i><span>Payroll</span></a></li>
            <li><a href="payroll_results_table.php"><i class="fa fa-file"></i><span>Deductions</span></a></li>
            <li><a href="expenses.php"><i class="fa fa-calculator"></i><span>Expenses</span></a></li>
            <li><a href="manage_suspensions.php"><i class="fa fa-ban"></i><span>Manage Employees</span></a></li>
            <li><a href="subscription_tracked.php"><i class="fa fa-eye"></i><span>View Subscriptions</span></a></li>
            <li><a href="logout.php"><i class="fa fa-sign-out"></i><span>Logout</span></a></li>
        </ul>
    <?php 
    } elseif ($_SESSION['role'] == "company") { 
    ?>
        <!-- Company Navigation Bar -->
        <ul id="navList">
            <li><a href="index.php"><i class="fa fa-tachometer"></i><span>Dashboard</span></a></li>
            <li><a href="tasks.php"><i class="fa fa-tasks"></i><span>All Tasks</span></a></li>
            <li><a href="reports.php"><i class="fa fa-bar-chart"></i><span>Reports</span></a></li>
            <li><a href="user.php"><i class="fa fa-users"></i><span>Manage Users</span></a></li>
            <li><a href="payroll_form.php"><i class="fa fa-money"></i><span>Payroll</span></a></li>
            <li><a href="payroll_results_table.php"><i class="fa fa-file"></i><span>Deductions</span></a></li>
            <li><a href="expenses.php"><i class="fa fa-calculator"></i><span>Expenses</span></a></li>
            <li><a href="logout.php"><i class="fa fa-sign-out"></i><span>Logout</span></a></li>
        </ul>
    <?php 
    } elseif ($_SESSION['role'] == "evaluator") { 
    ?>
        <!-- Evaluator Navigation Bar -->
        <ul id="navList">
            <li><a href="evaluation.php"><i class="fa fa-tachometer"></i><span>Dashboard</span></a></li>
            <li><a href="evaluate_tasks.php"><i class="fa fa-check-circle"></i><span>Evaluate Tasks</span></a></li>
            <li><a href="view_performance.php"><i class="fa fa-chart-line"></i><span>View Performance</span></a></li>
            <li><a href="feedback.php"><i class="fa fa-comment"></i><span>Provide Feedback</span></a></li>
            <li><a href="logout.php"><i class="fa fa-sign-out"></i><span>Logout</span></a></li>
        </ul>
    <?php 
    } 
    ?>
</nav>
