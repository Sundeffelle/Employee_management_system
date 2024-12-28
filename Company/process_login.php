<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
      
        $conn = new PDO("mysql:host=localhost;dbname=task_management_db;charset=utf8mb4", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $company_email = htmlspecialchars(trim($_POST['company_email'] ?? ''));
        $password = htmlspecialchars(trim($_POST['password'] ?? ''));

        if (empty($company_email) || empty($password)) {
            throw new Exception("Email and password are required.");
        }

        // Fetch the company details
        $sql = "SELECT company_id, company_name, company_email, password, role FROM companies WHERE company_email = :company_email LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':company_email' => $company_email]);

        $company = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$company || !password_verify($password, $company['password'])) {
            throw new Exception("Invalid credentials.");
        }

        // Regenerate session ID
        session_regenerate_id(true);

        // Store data in session
        $_SESSION['company_id'] = $company['company_id'];
        $_SESSION['company_name'] = $company['company_name'];
        $_SESSION['company_email'] = $company['company_email'];
        $_SESSION['role'] = $company['role'] ?? 'company';

        header("Location: subscription_plan.php");
        exit();
    } catch (Exception $e) {
        error_log("Login error: " . $e->getMessage());
        echo "Invalid login attempt. Please try again.";
    }
}
