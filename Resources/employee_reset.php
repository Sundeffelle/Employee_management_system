<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../inc/DB_connection.php"; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = htmlspecialchars(trim($_POST['token']));
    $password = htmlspecialchars(trim($_POST['password']));
    $confirm_password = htmlspecialchars(trim($_POST['confirm_password']));

    if (empty($password) || empty($confirm_password)) {
        $em = "Both password fields are required.";
        header("Location: reset_password_employee.php?token=$token&error=" . urlencode($em));
        exit();
    }

    if ($password !== $confirm_password) {
        $em = "Passwords do not match.";
        header("Location: reset_password_employee.php?token=$token&error=" . urlencode($em));
        exit();
    }

    try {
        // Verify token
        $sql = "SELECT email FROM employee_password_resets WHERE reset_token = ? AND reset_expires > NOW() LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$token]);
        $reset = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($reset) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $email = $reset['email'];

            // Update password in the `users` table
            $sql = "UPDATE users SET password = ? WHERE email = ? AND role = 'employee'";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$hashed_password, $email]);

            // Delete the reset token
            $sql = "DELETE FROM employee_password_resets WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$email]);

            header("Location: login.php?success=" . urlencode("Password reset successfully! Please log in."));
            exit();
        } else {
            $em = "Invalid or expired token.";
            header("Location: reset_password_employee.php?error=" . urlencode($em));
            exit();
        }
    } catch (Exception $e) {
        error_log("Error resetting password: " . $e->getMessage());
        $em = "An error occurred. Please try again.";
        header("Location: reset_password_employee.php?error=" . urlencode($em));
        exit();
    }
} elseif (isset($_GET['token'])) {
    // Display the reset form if token is provided
    $token = htmlspecialchars($_GET['token']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <form method="POST" action="reset_password_employee.php">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        <label for="password">New Password:</label>
        <input type="password" name="password" required>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
<?php
} else {
    $em = "Invalid or missing token.";
    header("Location: login.php?error=" . urlencode($em));
    exit();
}
?>
