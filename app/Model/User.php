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

// Fetch all users (employees) with profile images
function get_all_users($conn) {
    $sql = "SELECT id, full_name, username, email, salary, department, role, 
                   COALESCE(profile_image, 'img/user.png') AS profile_image,
                   dob, gender, marital_status, nationality, phone_number,
                   address, emergency_contact, work_location, employment_type,
                   account_number, bank_name, ifsc_code, tin, insurance_number
            FROM users 
            WHERE role = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(["employee"]);

    if ($stmt->rowCount() > 0) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return [];
    }
}

// Insert a new user into the database
function insert_user($conn, $data) {
    try {
        $sql = "INSERT INTO users (
                    full_name, username, email, password, salary, department, 
                    role, profile_image, dob, gender, marital_status, 
                    nationality, phone_number, address, emergency_contact, 
                    work_location, employment_type, account_number, 
                    bank_name, ifsc_code, tin, insurance_number
                ) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute($data);
    } catch (PDOException $e) {
        error_log("Insert User Error: " . $e->getMessage());
        throw $e; // Optional: rethrow for handling in the calling code.
    }
}


// Update user details
function update_user($conn, $data) {
    $sql = "UPDATE users 
            SET full_name = ?, username = ?, password = ?, role = ?, 
                dob = ?, gender = ?, marital_status = ?, nationality = ?, 
                phone_number = ?, address = ?, emergency_contact = ?, 
                work_location = ?, employment_type = ?, account_number = ?, 
                bank_name = ?, ifsc_code = ?, tin = ?, insurance_number = ? 
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute($data);
}

// Delete a user by ID
function delete_user($conn, $data) {
    $sql = "DELETE FROM users WHERE id = ? AND role = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute($data);
}

// Fetch a single user by ID
function get_user_by_id($conn, $id) {
    $sql = "SELECT id, full_name, username, email, salary, department, role, 
                   COALESCE(profile_image, 'img/user.png') AS profile_image,
                   dob, gender, marital_status, nationality, phone_number,
                   address, emergency_contact, work_location, employment_type,
                   account_number, bank_name, ifsc_code, tin, insurance_number
            FROM users 
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        return null;
    }
}

// Update user profile (including profile image)
function update_profile($conn, $data) {
    $sql = "UPDATE users 
            SET full_name = ?, email = ?, password = ?, profile_image = ?, 
                dob = ?, gender = ?, marital_status = ?, nationality = ?, 
                phone_number = ?, address = ?, emergency_contact = ?, 
                work_location = ?, employment_type = ?, account_number = ?, 
                bank_name = ?, ifsc_code = ?, tin = ?, insurance_number = ? 
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute($data);
}

// Count all employees
function count_users($conn) {
    $sql = "SELECT COUNT(*) AS count FROM users WHERE role = 'employee'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'];
}

// Additional Helper Functions (Payroll)
function calculate_net_pay($gross_salary, $total_allowances, $total_deductions) {
    return $gross_salary + $total_allowances - $total_deductions;
}

function insert_payroll_record($conn, $user_id, $gross_salary, $total_allowances, $total_deductions, $pay_date) {
    $net_salary = calculate_net_pay($gross_salary, $total_allowances, $total_deductions);
    $sql = "INSERT INTO payroll (user_id, gross_salary, total_allowances, total_deductions, net_salary, pay_date)
            VALUES (:user_id, :gross_salary, :total_allowances, :total_deductions, :net_salary, :pay_date)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':gross_salary', $gross_salary);
    $stmt->bindParam(':total_allowances', $total_allowances);
    $stmt->bindParam(':total_deductions', $total_deductions);
    $stmt->bindParam(':net_salary', $net_salary);
    $stmt->bindParam(':pay_date', $pay_date);
    $stmt->execute();
}

function get_all_payroll_records($conn) {
    $sql = "SELECT * FROM payroll";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>
