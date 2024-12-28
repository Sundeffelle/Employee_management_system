<?php
// Function to get all KPIs with the revised schema fields
function get_all_kpis($conn) {
    $sql = "SELECT id, kpi_name, employee_id, target_value, current_value, evaluation_period, status FROM kpis";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

// Function to insert a new KPI with revised fields
function insert_kpi($conn, $data) {
    $sql = "INSERT INTO kpis (kpi_name, employee_id, target_value, current_value, evaluation_period, status) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute($data);
}

// Function to update a KPI with revised fields
function update_kpi($conn, $data) {
    $sql = "UPDATE kpis SET kpi_name=?, target_value=?, current_value=?, evaluation_period=?, status=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute($data);
}

// Function to delete a KPI
function delete_kpi($conn, $id) {
    $sql = "DELETE FROM kpis WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
}

// Function to calculate the performance score for a KPI
function calculate_performance_score($target_value, $current_value) {
    // Calculate the performance score based on the formula provided
    $performance_score = ($current_value * $target_value) / 100;
    return round($performance_score, 2);
}

function update_kpi_metrics($conn, $kpi_id, $current_value) {
    // Retrieve the target value from the KPI
    $sql = "SELECT target_value FROM kpis WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$kpi_id]);
    $kpi = $stmt->fetch();

    if ($kpi) {
        $target_value = $kpi['target_value'];
        
        // Calculate the performance score using the new formula
        $performance_score = calculate_performance_score($target_value, $current_value);
        
        // Determine status based on the performance score directly
        if ($performance_score > 50) {
            $status = 'on_track';
        } elseif ($performance_score >= 25) {
            $status = 'at_risk';
        } else {
            $status = 'behind_schedule';
        }

        // Update the KPI record with the calculated performance score and status
        $sql_update = "UPDATE kpis SET current_value = ?, performance_score = ?, status = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->execute([$current_value, $performance_score, $status, $kpi_id]);
    }
}

function set_current_value_and_update_metrics($conn, $kpi_id, $current_value) {
    // Update the KPI's current value and other metrics
    update_kpi_metrics($conn, $kpi_id, $current_value);
}
?>
