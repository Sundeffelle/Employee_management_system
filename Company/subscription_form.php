
<head>
    <link rel="stylesheet" href="css/form_subscription.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
    <div class="container-fluid vh-100 d-flex align-items-center justify-content-center">
        <div class="card bg-light" style="width: 40rem;">
            <div class="card-header text-center">
                <h4>PatMactech UK</h4>
            </div>
            <div class="card-body">
                <h4 class="card-title text-center mb-4">Registration Is Free</h4>
                <form action="process_subscription.php" method="POST" class="shadow p-4">
                    <h3 class="display-6 text-center mb-4">Register Your Company</h3>

                    <!-- Company Information -->
                    <h5 class="mt-4">Company Information</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="company_name" class="form-label">Company Name</label>
                            <input type="text" class="form-control" id="company_name" name="company_name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="company_email" class="form-label">Company Email</label>
                            <input type="email" class="form-control" id="company_email" name="company_email" required>
                        </div>
                    </div>
                    <div class="row g-3 mt-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="col-md-6">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                    </div>

                    <div class="row g-3 mt-3">
                        <div class="col-md-6">
                            <label for="industry" class="form-label">Industry</label>
                            <input type="text" class="form-control" id="industry" name="industry" required>
                        </div>
                        <div class="col-md-6">
                            <label for="company_size" class="form-label">Company Size</label>
                            <select class="form-select" id="company_size" name="company_size" required>
                                <option value="Small">Small</option>
                                <option value="Medium">Medium</option>
                                <option value="Large">Large</option>
                            </select>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <h5 class="mt-4">Contact Information</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="contact_email" class="form-label">Contact Email</label>
                            <input type="email" class="form-control" id="contact_email" name="contact_email" required>
                        </div>
                        <div class="col-md-6">
                            <label for="contact_phone" class="form-label">Contact Phone</label>
                            <input type="tel" class="form-control" id="contact_phone" name="contact_phone" required>
                        </div>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="4" required></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary mt-4">Register</button>
                    
                    </div>
                    <a href="request_password_reset.php" class="text-white">Forgot Password?</a>
    <a href="subscription_form.php" class="text-white">Create Account</a>
                </form>
            </div>
        </div>
    </div>
</body>