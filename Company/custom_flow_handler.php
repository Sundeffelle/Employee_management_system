<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Load PHPMailer

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = htmlspecialchars($_POST['full_name']);
    $email = htmlspecialchars($_POST['email']);
    $telephone = htmlspecialchars($_POST['contact']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // Validate fields
    if (empty($full_name) || empty($email) || empty($telephone) || empty($subject) || empty($message)) {
        echo "All fields are required.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit;
    }

    // Prepare the email for the admin
    $adminEmail = "customsupport@patmactech.co.uk";
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'send.one.com'; // Corrected SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'customsupport@patmactech.co.uk'; // Correct SMTP username
        $mail->Password = 'PatMacTech123##'; // Correct SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Use PHPMailer::ENCRYPTION_SMTPS for port 465
        $mail->Port = 465; // Correct port for SMTPS (SSL)

        // Recipients
        $mail->setFrom('customsupport@patmactech.co.uk', 'PatMacTech Support'); // Set sender
        $mail->addAddress($adminEmail); // Admin email address

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = "<p><strong>From:</strong> $full_name ($email)</p>
                          <p><strong>Message:</strong></p>
                          <p>$message</p>";

        $mail->send();
        echo "Your request has been sent to the support team.";

        // Send acknowledgment to the user
        $mail->clearAddresses();
        $mail->addAddress($email);
        $mail->Subject = "Acknowledgment: Your Request Has Been Received";
        $mail->Body    = "<p>Dear $full_name,</p>
                          <p>Thank you for reaching out. Your request has been received and will be attended to shortly.</p>
                          <p>Best regards,<br>PatMacTech Support Team</p>";

        $mail->send();

        // Optional: Log request to database
        include '../inc/DB_connection.php';
        $stmt = $conn->prepare("INSERT INTO custom_requests (full_name, email, contact, subject, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$full_name, $email, $telephone , $subject, $message]);
    } catch (Exception $e) {
        echo "Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request method.";
}
?>
