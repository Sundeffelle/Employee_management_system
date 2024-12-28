<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../inc/DB_connection.php";

if (!isset($_GET['token']) && !isset($_POST['token'])) {
    die("Invalid or missing reset token.");
}

$token = htmlspecialchars($_GET['token'] ?? $_POST['token']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        try {
            $stmt = $conn->prepare("SELECT email, reset_expires FROM company_password_resets WHERE reset_token = ? LIMIT 1");
            $stmt->execute([$token]);
            $reset = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($reset && strtotime($reset['reset_expires']) > time()) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Update the company's password
                $stmt = $conn->prepare("UPDATE companies SET password = ? WHERE company_email = ?");
                $stmt->execute([$hashed_password, $reset['email']]);

                // Delete the reset token
                $stmt = $conn->prepare("DELETE FROM company_password_resets WHERE reset_token = ?");
                $stmt->execute([$token]);

                header("Location: subscription_success.php?success=Password reset successfully.");
                exit();
            } else {
                $error = "Invalid or expired token.";
            }
        } catch (Exception $e) {
            $error = "An error occurred. Please try again.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <title>Reset Password</title>
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="card p-4 shadow-sm" style="width: 400px;">
        <h3 class="text-center">Reset Password</h3>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success); ?></div>
        <?php endif; ?>
        <form method="POST" action="reset_password_company.php">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token); ?>">
            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your new password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm your new password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Reset Password</button>
        </form>
        <div class="mt-3 text-center">
            <a href="login.php" class="text-decoration-none">Back to Login</a>
        </div>
    </div>
</body>
</html>

