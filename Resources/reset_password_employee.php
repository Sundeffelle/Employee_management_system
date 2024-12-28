<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/autoload.php';

include "../inc/DB_connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars(trim($_POST['email']));

    if (empty($email)) {
        $em = "Email is required.";
        header("Location: login.php?error=" . urlencode($em));
        exit();
    }

    try {
        // Check if the email exists
        $sql = "SELECT * FROM users WHERE email = ? AND role = 'employee' LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $reset_token = bin2hex(random_bytes(50));
            $reset_expires = date("Y-m-d H:i:s", strtotime("+1 hour"));

            // Store reset token in the database
            $sql = "INSERT INTO employee_password_resets (email, reset_token, reset_expires) VALUES (?, ?, ?) 
                    ON DUPLICATE KEY UPDATE reset_token = VALUES(reset_token), reset_expires = VALUES(reset_expires)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$email, $reset_token, $reset_expires]);

            // Email configuration
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host       = 'send.one.com'; // Your SMTP server
                $mail->SMTPAuth   = true;
                $mail->Username   = 'passwordreset@patmactech.co.uk'; // Your SMTP username
                $mail->Password   = 'PatMacTech123##'; // Your SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Use 'tls' or 'ssl' depending on your SMTP provider
                $mail->Port       = 465; // Port 465 for SSL, or 587 for TLS

                // Recipients
                $mail->setFrom('passwordreset@patmactech.co.uk', 'PatMacTech Support');
                $mail->addAddress($email, $user['full_name']); // Add a recipient

                // Content
                $domain = 'http://localhost/Softwares/Employee_management_system';
                $reset_link = "$domain/reset_password.php?token=$reset_token";

                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Request';
                $mail->Body    = "Hi {$user['full_name']},<br><br>Click <a href='{$reset_link}'>here</a> to reset your password.<br><br>This link will expire in one hour.";

                $mail->send();
                header("Location: login.php?success=" . urlencode("Password reset link has been sent to your email."));
                exit();
            } catch (Exception $e) {
                error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
                header("Location: login.php?error=" . urlencode("Email could not be sent. Please try again later."));
                exit();
            }
        } else {
            $em = "Email not found or not associated with an employee account.";
            header("Location: login.php?error=" . urlencode($em));
            exit();
        }
    } catch (Exception $e) {
        error_log("Error in password reset request: " . $e->getMessage());
        $em = "An error occurred. Please try again.";
        header("Location: login.php?error=" . urlencode($em));
        exit();
    }
} else {
    $em = "Invalid request.";
    header("Location: login.php?error=" . urlencode($em));
    exit();
}
