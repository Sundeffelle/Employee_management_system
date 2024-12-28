<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" IE="edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container-fluid">
    <h3 class="text-center m-4">Admin Registration</h3>
    <?php if (isset($_GET['error'])) { ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($_GET['error']); ?>
        </div>
    <?php } ?>
    <?php if (isset($_GET['success'])) { ?>
        <div class="alert alert-success" role="alert">
            <?= htmlspecialchars($_GET['success']); ?>
        </div>
    <?php } ?>

    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card bg-light mb-3">
                <div class="card-header">
                    <i class="fa fa-user-plus fa-lg"></i> Admin Registration
                </div>
                <div class="card-body">
                    <form method="POST" action="registration_logic.php" enctype="multipart/form-data">
                        <!-- Same fields as employee registration but no role selection (role=admin by default) -->
                        <!-- Just reuse the exact fields from the original form -->
                        <!-- Grouped Fields -->
                        <div class="input-group mb-3">
                            <input type="text" name="full_name" class="form-control" placeholder="Full Name" required>
                            <input type="text" name="username" class="form-control" placeholder="Username" required>
                        </div>

                        <div class="input-group mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                            <input type="file" name="profile_image" class="form-control" accept="image/*">
                        </div>

                        <div class="input-group mb-3">
                            <input type="number" name="salary" class="form-control" placeholder="Salary" step="0.01" required>
                            <input type="text" name="department" class="form-control" placeholder="Department" required>
                        </div>

                        <div class="input-group mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                            <!-- No role dropdown here, role is set to admin in the code -->
                        </div>

                        <div class="input-group mb-3">
                            <input type="date" name="dob" class="form-control" placeholder="Date of Birth" required>
                            <select class="form-select" name="gender" required>
                                <option value="" disabled selected>Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="input-group mb-3">
                            <select class="form-select" name="marital_status" required>
                                <option value="" disabled selected>Marital Status</option>
                                <option value="single">Single</option>
                                <option value="married">Married</option>
                                <option value="divorced">Divorced</option>
                                <option value="widowed">Widowed</option>
                            </select>
                            <input type="text" name="nationality" class="form-control" placeholder="Nationality" required>
                        </div>

                        <div class="input-group mb-3">
                            <input type="tel" name="phone_number" class="form-control" placeholder="Phone Number" required>
                            <textarea name="address" class="form-control" placeholder="Residential Address" rows="2" required></textarea>
                        </div>

                        <div class="input-group mb-3">
                            <textarea name="emergency_contact" class="form-control" placeholder="Emergency Contact" rows="2" required></textarea>
                            <input type="text" name="work_location" class="form-control" placeholder="Work Location" required>
                        </div>

                        <div class="input-group mb-3">
                            <select class="form-select" name="employment_type" required>
                                <option value="" disabled selected>Employment Type</option>
                                <option value="full-time">Full-Time</option>
                                <option value="part-time">Part-Time</option>
                                <option value="contractual">Contractual</option>
                                <option value="intern">Intern</option>
                            </select>
                            <input type="text" name="account_number" class="form-control" placeholder="Bank Account Number" required>
                        </div>

                        <div class="input-group mb-3">
                            <input type="text" name="bank_name" class="form-control" placeholder="Bank Name" required>
                            <input type="text" name="ifsc_code" class="form-control" placeholder="IFSC/Sort Code" required>
                        </div>

                        <div class="input-group mb-3">
                            <input type="text" name="tin" class="form-control" placeholder="Tax Identification Number (TIN)" required>
                            <input type="text" name="insurance_number" class="form-control" placeholder="National Insurance Number" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Register as Admin</button>
                        <div>
                            <a href="login_form.php">already hava an account</a>
                        </div>
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
