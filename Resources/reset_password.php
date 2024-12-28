<?php
// Display errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_management_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();  
}

// Initialize variables
$message = "";

// Check if the reset token exists
if (!isset($_GET['token']) && !isset($_POST['token'])) {
    die("Invalid or missing reset token.");
}

$token = htmlspecialchars($_GET['token'] ?? $_POST['token']);

// Process the form when submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $message = "Passwords do not match.";
    } else {
        try {
            // Fetch email using the reset token
            $sql = "SELECT email, reset_expires FROM employee_password_resets WHERE reset_token = ? LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$token]);
            $reset = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify the token and expiry
            if ($reset && strtotime($reset['reset_expires']) > time()) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Update the user's password
                $updateSql = "UPDATE users SET password = ? WHERE email = ?";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->execute([$hashed_password, $reset['email']]);

                // Delete the used reset token
                $deleteSql = "DELETE FROM employee_password_resets WHERE reset_token = ?";
                $deleteStmt = $conn->prepare($deleteSql);
                $deleteStmt->execute([$token]);

                // Redirect to login page
                header("Location: login.php?success=" . urlencode("Password has been reset successfully. Please log in."));
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
    <title>Reset Password</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(to bottom right, #6a11cb, #2575fc);
        }

        .card {
            background-color: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .card h1 {
            margin-bottom: 1rem;
            color: #333;
        }

        .card form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .card form label {
            text-align: left;
            font-size: 0.9rem;
            color: #666;
        }

        .card form input {
            padding: 0.8rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
        }

        .card form button {
            padding: 0.8rem;
            background-color: #6a11cb;
            color: #fff;
            font-size: 1rem;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .card form button:hover {
            background-color: #2575fc;
        }

        .error-message {
            color: red;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .success-message {
            color: green;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Reset Password</h1>
        <?php if (isset($message) && $message): ?>
            <p class="error-message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <form method="POST" action="reset_password.php">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            <label for="password">New Password:</label>
            <input type="password" name="password" id="password" placeholder="Enter new password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm new password" required>

            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>

