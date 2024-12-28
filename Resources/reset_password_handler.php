<?php
include "../inc/DB_connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    $sql = "SELECT email, expires_at FROM employee_password_resets WHERE token = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$token]);
    $reset = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($reset && strtotime($reset['expires_at']) > time()) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $updateSql = "UPDATE users SET password = ? WHERE email = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->execute([$hashed_password, $reset['email']]);

        $deleteSql = "DELETE FROM employee_password_resets WHERE token = ?";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->execute([$token]);

        echo "Password has been reset. <a href='login_form.php'>Login</a>";
    } else {
        echo "Invalid or expired token.";
    }
}
?>
