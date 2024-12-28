<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Ensure PHPMailer is available
include "../inc/DB_connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address.";
    } else {
        try {
            // Check if the email exists for an admin
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role = 'admin'");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Generate reset token and expiry
                $reset_token = bin2hex(random_bytes(50));
                $reset_expires = date('Y-m-d H:i:s', strtotime('+1 day'));

                // Save the token in the admin_password_resets table
                $stmt = $conn->prepare("INSERT INTO admin_password_resets (email, reset_token, reset_expires) 
                                        VALUES (?, ?, ?) 
                                        ON DUPLICATE KEY UPDATE reset_token = VALUES(reset_token), reset_expires = VALUES(reset_expires)");
                $stmt->execute([$email, $reset_token, $reset_expires]);

                // Send the reset email
                $mail = new PHPMailer(true);

                try {
                    // Server settings
                    $mail->isSMTP();
                    $mail->Host       = 'send.one.com'; // Your SMTP server
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'passwordreset@patmactech.co.uk'; // Your SMTP username
                    $mail->Password   = 'PatMacTech123##'; // Your SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port       = 465;

                    // Recipients
                    $mail->setFrom('passwordreset@patmactech.co.uk', 'PatMacTech Support');
                    $mail->addAddress($email, $user['full_name']);

                    // Email content
                    $domain = $_SERVER['HTTP_HOST'];
                    $reset_link = "http://$domain/Softwares/Employee_management_system/Admin/reset_password_admin.php?token=$reset_token";
                    $mail->isHTML(true);
                    $mail->Subject = 'Admin Password Reset Request';
                    $mail->Body    = "Hi {$user['full_name']},<br><br>Click <a href='{$reset_link}'>here</a> to reset your password.<br>This link will expire in 24 hours.";

                    $mail->send();
                    $success = "Password reset link has been sent to your email.";
                } catch (Exception $e) {
                    error_log("Mailer Error: {$mail->ErrorInfo}");
                    $error = "Email could not be sent. Please try again later.";
                }
            } else {
                $error = "No admin account found with that email.";
            }
        } catch (Exception $e) {
            error_log("Error in password reset request: " . $e->getMessage());
            $error = "An error occurred. Please try again.";
        }
    }
}
?>
