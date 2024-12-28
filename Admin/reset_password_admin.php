<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../inc/DB_connection.php";

$message = "";     

if (!isset($_GET['token']) && !isset($_POST['token'])) {
    die("Invalid or missing reset token.");
}

$token = htmlspecialchars($_GET['token'] ?? $_POST['token']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $message = "Passwords do not match.";
    } else {
        try {
            $sql = "SELECT email, reset_expires FROM admin_password_resets WHERE reset_token = ? LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$token]);
            $reset = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($reset && strtotime($reset['reset_expires']) > time()) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Update the user's password
                $updateSql = "UPDATE users SET password = ? WHERE email = ?";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->execute([$hashed_password, $reset['email']]);

                // Delete the used reset token
                $deleteSql = "DELETE FROM admin_password_resets WHERE reset_token = ?";
                $deleteStmt = $conn->prepare($deleteSql);
                $deleteStmt->execute([$token]);

                // Redirect to login page after successful reset
                header("Location: login_form.php?success=" . urlencode("Password reset successfully. Please log in."));
                exit();
            } else {
                $message = "Invalid or expired reset token.";
            }
        } catch (Exception $e) {
            $message = "An error occurred. Please try again.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Admin Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Light background for contrast */
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Subtle shadow for elevation */
        }
        .btn-primary {
            background: linear-gradient(90deg, #007bff, #0056b3); /* Modern gradient for button */
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(90deg, #0056b3, #003f7f); /* Darker gradient on hover */
        }
        h3 {
            font-weight: 700;
            color: #333;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4" style="width: 100%; max-width: 400px;">
        <h3 class="text-center mb-3">Reset Password</h3>
        <?php if (isset($message)): ?>
            <div class="alert alert-warning"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <form method="POST" action="reset_password_admin.php">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input type="password" class="form-control" name="password" placeholder="Enter new password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" name="confirm_password" placeholder="Confirm new password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Reset Password</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
