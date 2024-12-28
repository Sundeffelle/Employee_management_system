<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/form_subscription.css">
    <title>Company Login</title>
</head>
<body>
    <div class="container-fluid vh-100 d-flex align-items-center justify-content-center">
        <div class="card text-white bg-success" style="width: 30rem;">
            <div class="card-header text-center">
                <h4>Company Login</h4>
            </div>
            <div class="card-body">
                <h5 class="card-title text-center mb-4">Welcome Back!</h5>
                <form action="process_login.php" method="POST">
                    <div class="mb-3">
                        <label for="company_email" class="form-label">Email:</label>
                        <input type="email" id="company_email" name="company_email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-light btn-lg">Login</button>
                        <div class="d-flex justify-content-between mt-3">
                        <a href="request_password_reset.php" class="text-white">Forgot Password?</a>
                        <a href="subscription_form.php" class="text-white">Create Account</a>
                    </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>