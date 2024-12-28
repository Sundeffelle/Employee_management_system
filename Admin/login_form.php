<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" IE="edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <h3 class="text-center m-4">Admin Login</h3>
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
        <div class="col-4">
            <div class="card bg-light mb-3">
                <div class="card-header">
                    <i class="fa fa-sign-in fa-lg"></i> Admin Login
                </div>
                <div class="card-body">
                    <form method="POST" action="admin_login.php">
                        <div class="mb-3">
                            <label for="username" class="form-label">Admin Username</label>
                            <input type="text" name="username" id="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Admin Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login as Admin</button>
                    </form>
                    <a href="request_password_reset.php">Forgot your password?</a>
                    <a href="admin_register_form.php">Create account</a>
                    
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
