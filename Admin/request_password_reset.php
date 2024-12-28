<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
include "../inc/DB_connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address.";
    } else {
        try {
            // Check if the email exists for an admin
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role = 'admin'");
            $stmt->execute([$email
        ]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Generate a unique reset token
            $reset_token = bin2hex(random_bytes(50));
            $reset_expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

            // Insert the reset token into the admin_password_resets table
            $stmt = $conn->prepare("INSERT INTO admin_password_resets (email, reset_token, reset_expires) VALUES (?, ?, ?) 
                                     ON DUPLICATE KEY UPDATE reset_token = VALUES(reset_token), reset_expires = VALUES(reset_expires)");
            $stmt->execute([$email, $reset_token, $reset_expires]);

            // Send the reset link via email
            $mail = new PHPMailer(true);
            try {
                // SMTP server configuration
                $mail->isSMTP();
                $mail->Host = 'send.one.com'; // Your SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = 'passwordreset@patmactech.co.uk'; // SMTP username
                $mail->Password = 'PatMacTech123##'; // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Use TLS or SSL
                $mail->Port = 465; // Port 465 for SSL, or 587 for TLS

                // Email details
                $mail->setFrom('passwordreset@patmactech.co.uk', 'PatMacTech Support');
                $mail->addAddress($email, $user['full_name']);

                // Construct the reset link
                $domain = $_SERVER['HTTP_HOST'];
                $reset_link = "http://$domain/Softwares/Employee_management_system/Admin/reset_password_admin.php?token=$reset_token";

                // Email content
                $mail->isHTML(true);
                $mail->Subject = 'Admin Password Reset Request';
                $mail->Body = "Hi {$user['full_name']},<br><br>
                               Click <a href='{$reset_link}'>here</a> to reset your password.<br>
                               This link will expire in one hour.";

                $mail->send();

                $success = "Password reset link has been sent to your email.";
            } catch (Exception $e) {
                error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
                $error = "Failed to send the password reset email. Please try again.";
            }
        } else {
            $error = "No admin account found with that email.";
        }
    } catch (Exception $e) {
        error_log("Error during password reset request: " . $e->getMessage());
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
    <title>Admin Password Reset</title>
    <style>
        /* General body styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f9;
        }

        /* Card styling */
        .reset-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 400px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .reset-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
        }

        /* Header styling */
        .reset-card h3 {
            margin: 0 0 20px;
            font-size: 24px;
            color: #333;
            text-align: center;
        }

        /* Form input styling */
        .reset-card input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .reset-card input:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }

        /* Button styling */
        .reset-card button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: #fff;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .reset-card button:hover {
            background-color: #0056b3;
        }

        /* Error and success messages */
        .message {
            text-align: center;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .message.error {
            color: #ff4d4f;
        }

        .message.success {
            color: #28a745;
        }

        /* Responsive styling */
        @media (max-width: 600px) {
            .reset-card {
                padding: 20px;
            }

            .reset-card h3 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="reset-card">
        <h3>Admin Password Reset</h3>
        <?php if (isset($error)): ?>
            <p class="message error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <p class="message success"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Enter your email" required>
            <button type="submit">Request Reset</button>
        </form>
    </div>
</body>
</html>
