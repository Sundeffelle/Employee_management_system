<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


// Insert new leave request
function insert_leave_request($conn, $data) {
    $sql = "INSERT INTO leaves (employee_id, leave_type, start_date, end_date, reason) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute($data);
}

// Get leave requests for an employee
function get_employee_leaves($conn, $employee_id) {
    $sql = "SELECT * FROM leaves WHERE employee_id = ? ORDER BY start_date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$employee_id]);

    if ($stmt->rowCount() > 0) {
        return $stmt->fetchAll();
    } else {
        return 0;
    }
}

// Get all leave requests for admin
function get_all_leaves($conn) {
    $sql = "SELECT l.*, u.full_name FROM leaves l JOIN users u ON l.employee_id = u.id ORDER BY l.start_date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute([]);

    if ($stmt->rowCount() > 0) {
        return $stmt->fetchAll();
    } else {
        return 0;
    }
}

// Update leave request status (admin)
function update_leave_status($conn, $data) {
    $sql = "UPDATE leaves SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute($data);
}

?>