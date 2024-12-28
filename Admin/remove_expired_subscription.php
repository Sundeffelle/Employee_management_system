<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login_form.php?error=Unauthorized access.");
    exit();
}

include "../inc/DB_connection.php";
require "../vendor/autoload.php"; // Ensure PHPMailer is installed via Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $subscription_id = $_POST['subscription_id'] ?? null;

        if (!$subscription_id) {
            throw new Exception("Invalid subscription ID.");
        }

        // Fetch subscription details for email notification
        $query = "SELECT company_name, company_email FROM subscriptions 
                  JOIN companies ON subscriptions.company_id = companies.company_id 
                  WHERE subscriptions.id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$subscription_id]);
        $subscription = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$subscription) {
            throw new Exception("Subscription not found.");
        }

        // Delete the subscription
        $delete_query = "DELETE FROM subscriptions WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_query);
        $delete_stmt->execute([$subscription_id]);

        // Send email notification using PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'mail.one.com'; // Replace with your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'customsupport@patmactech.co.uk'; // Replace with your email
            $mail->Password = 'PatMacTech123##'; // Replace with your email password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // Recipients
            $mail->setFrom('customsupport@patmactech.co.uk', 'PatMacTech Support');
            $mail->addAddress($subscription['company_email'], $subscription['company_name']);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Subscription Removed';
            $mail->Body = "
                <p>Dear {$subscription['company_name']},</p>
                <p>Your subscription has been removed by the administrator.</p>
                <p>Best regards,<br>PATMACTECH</p>
            ";

            $mail->send();

            header("Location: expired_subscriptions.php?success=Subscription removed and notification sent.");
        } catch (Exception $e) {
            header("Location: expired_subscriptions.php?error=Subscription removed but email notification failed: " . $mail->ErrorInfo);
        }
    } catch (Exception $e) {
        header("Location: expired_subscriptions.php?error=" . urlencode($e->getMessage()));
    }
} else {
    header("Location: expired_subscriptions.php?error=Invalid request method.");
    exit();
}
?>
