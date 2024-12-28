<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
    include "../inc/DB_connection.php";
    include "../inc/navbar.php";
    include '../app/Model/User.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible="IE="edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container-fluid">
    <h3 class="text-center m-4">Add User</h3>
    <div class="alert alert-success text-center" role="alert">
        <a href="user.php" class="alert-link">Previous Page</a>
    </div>

    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card bg-light mb-3">
                <div class="card-header">
                    <i class="fa fa-user-plus fa-lg"></i> User Registration
                </div>
                <div class="card-body">
                    <form method="POST" action="app/add-user.php" enctype="multipart/form-data">
                        <?php if (isset($_GET['error'])) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?= htmlspecialchars(stripcslashes($_GET['error'])); ?>
                            </div>
                        <?php } ?>

                        <?php if (isset($_GET['success'])) { ?>
                            <div class="alert alert-success" role="alert">
                                <?= htmlspecialchars(stripcslashes($_GET['success'])); ?>
                            </div>
                        <?php } ?>

                        <!-- Grouped Fields -->
                        <div class="input-group mb-3">
                            <input type="text" name="full_name" id="full_name" class="form-control" placeholder="Full Name" required>
                            <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Username" required>
                        </div>

                        <div class="input-group mb-3">
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                            <input type="file" name="profile_image" id="profile_image" class="form-control" accept="image/*">
                        </div>

                        <div class="input-group mb-3">
                            <input type="number" name="salary" id="salary" class="form-control" placeholder="Salary" step="0.01" required>
                            <input type="text" name="department" id="department" class="form-control" placeholder="Department" required>
                        </div>

                        <div class="input-group mb-3">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                            <select class="form-select" name="role" id="role" required>
                                <option value="" disabled selected>Role</option>
                                <option value="employee">employee</option>
                                <option value="admin">admin</option>
                                <option value="evaluator">evaluator</option>
                            </select>
                        </div>

                        <!-- New Fields -->
                        <div class="input-group mb-3">
                            <input type="date" name="dob" id="dob" class="form-control" placeholder="Date of Birth" required>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="" disabled selected>Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="input-group mb-3">
                            <select class="form-select" id="marital_status" name="marital_status" required>
                                <option value="" disabled selected>Marital Status</option>
                                <option value="single">Single</option>
                                <option value="married">Married</option>
                                <option value="divorced">Divorced</option>
                                <option value="widowed">Widowed</option>
                            </select>
                            <input type="text" name="nationality" id="nationality" class="form-control" placeholder="Nationality" required>
                        </div>

                        <div class="input-group mb-3">
                            <input type="tel" name="phone_number" id="phone_number" class="form-control" placeholder="Phone Number" required>
                            <textarea name="address" id="address" class="form-control" placeholder="Residential Address" rows="2" required></textarea>
                        </div>

                        <div class="input-group mb-3">
                            <textarea name="emergency_contact" id="emergency_contact" class="form-control" placeholder="Emergency Contact" rows="2" required></textarea>
                            <input type="text" name="work_location" id="work_location" class="form-control" placeholder="Work Location" required>
                        </div>

                        <div class="input-group mb-3">
                            <select class="form-select" id="employment_type" name="employment_type" required>
                                <option value="" disabled selected>Employment Type</option>
                                <option value="full-time">Full-Time</option>
                                <option value="part-time">Part-Time</option>
                                <option value="contractual">Contractual</option>
                                <option value="intern">Intern</option>
                            </select>
                            <input type="text" name="account_number" id="account_number" class="form-control" placeholder="Bank Account Number" required>
                        </div>

                        <div class="input-group mb-3">
                            <input type="text" name="bank_name" id="bank_name" class="form-control" placeholder="Bank Name" required>
                            <input type="text" name="ifsc_code" id="ifsc_code" class="form-control" placeholder="IFSC/Sort Code" required>
                        </div>

                        <div class="input-group mb-3">
                            <input type="text" name="tin" id="tin" class="form-control" placeholder="Tax Identification Number (TIN)" required>
                            <input type="text" name="insurance_number" id="insurance_number" class="form-control" placeholder="National Insurance Number" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Add User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="mt-auto mb-4">
    <div class="text-center">
        <span>&copy; <script>document.write(new Date().getFullYear())</script> PatMactech UK.</span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
<?php 
} else { 
    $em = "First login";
    header("Location: login.php?error=$em");
    exit();
}
?>
