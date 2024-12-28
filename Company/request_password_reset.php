<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Make sure you have PHPMailer installed via Composer
include "../inc/DB_connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars(trim($_POST['email']));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address.";
    } else {
        try {
            // Check if the company email exists
            $stmt = $conn->prepare("SELECT * FROM companies WHERE company_email = ?");
            $stmt->execute([$email]);
            $company = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($company) {
                // Generate reset token and expiry
                $token = bin2hex(random_bytes(50));
                $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));

                // Insert into `company_password_resets`
                $stmt = $conn->prepare("INSERT INTO company_password_resets (email, reset_token, reset_expires) VALUES (?, ?, ?) 
                                        ON DUPLICATE KEY UPDATE reset_token = VALUES(reset_token), reset_expires = VALUES(reset_expires)");
                $stmt->execute([$email, $token, $expires_at]);

                // Send email with reset link
                $mail = new PHPMailer(true);

                try {
                    $mail->isSMTP();
                    $mail->Host = 'send.one.com'; // Replace with your SMTP host
                    $mail->SMTPAuth = true;
                    $mail->Username = 'passwordreset@patmactech.co.uk'; // Replace with your email
                    $mail->Password = 'PatMacTech123##'; // Replace with your password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port = 465;

                    // Email details
                    $mail->setFrom('passwordreset@patmactech.co.uk', 'PatMacTech Support');
                    $mail->addAddress($email);

                    $reset_link = "http://localhost/Softwares/Employee_management_system/Company/reset_password_company.php?token=$token";
                    $mail->isHTML(true);
                    $mail->Subject = 'Password Reset Request';
                    $mail->Body = "Hi,<br>Click <a href='$reset_link'>here</a> to reset your password.<br>This link will expire in 1 hour.";

                    $mail->send();
                    $success = "Password reset link sent to your email.";
                } catch (Exception $e) {
                    $error = "Failed to send the email.";
                }
            } else {
                $error = "No account found with that email.";
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
    <title>Request Password Reset</title>
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="card p-4 shadow-sm" style="width: 400px;">
        <h3 class="text-center">Request Password Reset</h3>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success); ?></div>
        <?php endif; ?>
        <form method="POST" action="request_password_reset.php">
            <div class="mb-3">
                <label for="email" class="form-label">Company Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
        </form>
        <div class="mt-3 text-center">
            <a href="login.php" class="text-decoration-none">Back to Login</a>
        </div>
    </div>
</body>
</html>

