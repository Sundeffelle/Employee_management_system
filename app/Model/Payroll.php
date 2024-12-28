<?php
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
function insert_payroll_record($conn, $user_id, $gross_salary, $total_allowances, $total_deductions, $pay_date) {
    $net_salary = $gross_salary + $total_allowances - $total_deductions;
    $query = "INSERT INTO payroll (user_id, gross_salary, net_salary, total_deductions, pay_date)
              VALUES (:user_id, :gross_salary, :net_salary, :total_deductions, :pay_date)";
    $stmt = $conn->prepare($query);
    $stmt->execute([
        ':user_id' => $user_id,
        ':gross_salary' => $gross_salary,
        ':net_salary' => $net_salary,
        ':total_deductions' => $total_deductions,
        ':pay_date' => $pay_date
    ]);
    return $conn->lastInsertId();
}

function get_all_payroll_records($conn) {
    $query = "SELECT p.*, u.full_name, u.department 
              FROM payroll p 
              JOIN users u ON p.user_id = u.id";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insert_deduction($conn, $payroll_id, $deduction_amount, $deduction_type) {
    $query = "INSERT INTO deductions (payroll_id, deduction_amount, deduction_type)
              VALUES (:payroll_id, :deduction_amount, :deduction_type)";
    $stmt = $conn->prepare($query);
    $stmt->execute([
        ':payroll_id' => $payroll_id,
        ':deduction_amount' => $deduction_amount,
        ':deduction_type' => $deduction_type
    ]);
}

function insert_allowance($conn, $payroll_id, $allowance_amount, $allowance_type) {
    $query = "INSERT INTO allowances (payroll_id, allowance_amount, allowance_type)
              VALUES (:payroll_id, :allowance_amount, :allowance_type)";
    $stmt = $conn->prepare($query);
    $stmt->execute([
        ':payroll_id' => $payroll_id,
        ':allowance_amount' => $allowance_amount,
        ':allowance_type' => $allowance_type
    ]);
}
function get_total_allowances($conn, $payroll_id) {
    $query = "SELECT SUM(amount) AS total FROM allowances WHERE payroll_id = :payroll_id";
    $stmt = $conn->prepare($query);
    $stmt->execute([':payroll_id' => $payroll_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
}

function get_total_deductions($conn, $payroll_id) {
    $query = "SELECT SUM(amount) AS total FROM deductions WHERE payroll_id = :payroll_id";
    $stmt = $conn->prepare($query);
    $stmt->execute([':payroll_id' => $payroll_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
}

function update_payroll_totals($conn, $payroll_id, $total_allowances, $total_deductions) {
    $query = "UPDATE payroll SET total_allowances = :total_allowances, total_deductions = :total_deductions, 
              net_salary = (gross_salary + :total_allowances - :total_deductions)
              WHERE payroll_id = :payroll_id";
    $stmt = $conn->prepare($query);
    $stmt->execute([
        ':total_allowances' => $total_allowances,
        ':total_deductions' => $total_deductions,
        ':payroll_id' => $payroll_id,
    ]);
}




/*function get_payroll_details($conn) {
    $query = "SELECT p.*, u.full_name, u.department, 
                     (SELECT SUM(d.amount) FROM deductions d WHERE d.payroll_id = p.payroll_id) AS total_deductions,
                     (SELECT SUM(a.allowance_amount) FROM allowances a WHERE a.payroll_id = p.payroll_id) AS total_allowances
              FROM payroll p
              JOIN users u ON p.user_id = u.id";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}*/

/*function get_payroll_details($conn) {
    $query = "SELECT p.*, u.full_name, u.department, 
                     (SELECT SUM(d.amount) FROM deductions d WHERE d.payroll_id = p.payroll_id) AS total_deductions,
                     (SELECT SUM(a.allowance_amount) FROM allowances a WHERE a.payroll_id = p.payroll_id) AS total_allowances
              FROM payroll p
              JOIN users u ON p.user_id = u.id";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}*/


function get_payroll_details($conn) {
    $query = "SELECT p.*, u.full_name, u.department, 
                     (SELECT SUM(d.amount) FROM deductions d WHERE d.payroll_id = p.payroll_id) AS total_deductions,
                     (SELECT SUM(a.allowance_amount) FROM allowances a WHERE a.payroll_id = p.payroll_id) AS total_allowances
              FROM payroll p
              JOIN users u ON p.user_id = u.id";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}







function get_payroll_summary_by_department($conn) {
    $query = "SELECT u.department, SUM(p.net_salary) AS total_expense
              FROM payroll p
              JOIN users u ON p.user_id = u.id
              GROUP BY u.department";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


?>