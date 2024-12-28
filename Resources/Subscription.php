<?php
// Insert a new subscription
function insert_subscription($conn, $data) {
    $sql = "INSERT INTO subscriptions (company_id, plan, start_date, end_date, status, payment_method) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute($data);
}

// Get subscription details by company ID
function get_subscription_by_company($conn, $company_id) {
    $sql = "SELECT * 
            FROM subscriptions 
            WHERE company_id = ? 
            ORDER BY id DESC 
            LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$company_id]);

    if ($stmt->rowCount() > 0) {
        return $stmt->fetch();
    } else {
        return null;
    }
}

// Check if a company has an active subscription
function has_active_subscription($conn, $company_id) {
    $sql = "SELECT id 
            FROM subscriptions 
            WHERE company_id = ? 
              AND status = 'active' 
              AND end_date >= CURDATE()";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$company_id]);

    return $stmt->rowCount() > 0;
}

// Update subscription status (e.g., activate, expire, cancel)
function update_subscription_status($conn, $subscription_id, $status) {
    $sql = "UPDATE subscriptions SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$status, $subscription_id]);
}

// Get all active subscriptions
function get_all_active_subscriptions($conn) {
    $sql = "SELECT * FROM subscriptions WHERE status = 'active' ORDER BY end_date ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        return $stmt->fetchAll();
    } else {
        return [];
    }
}

// Count total subscriptions for a specific plan
function count_subscriptions_by_plan($conn, $plan) {
    $sql = "SELECT id FROM subscriptions WHERE plan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$plan]);

    return $stmt->rowCount();
}

// Calculate the percentage of companies using each plan
function calculate_subscription_distribution($conn) {
    $plans = ['Testing','StarterFlow', 'GrowthFlow', 'PowerFlow', 'CustomFlow'];
    $distribution = [];
    $total_subscriptions = count_total_subscriptions($conn);

    foreach ($plans as $plan) {
        $plan_count = count_subscriptions_by_plan($conn, $plan);
        $distribution[$plan] = ($total_subscriptions > 0) ? round(($plan_count / $total_subscriptions) * 100, 2) : 0;
    }

    return $distribution;
}

// Count total subscriptions
function count_total_subscriptions($conn) {
    $sql = "SELECT id FROM subscriptions";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->rowCount();
}

// Retrieve free subscriptions due to expire within 48 hours
function get_expiring_free_subscriptions($conn) {
    $sql = "SELECT * FROM subscriptions 
            WHERE plan = 'StarterFlow' 
              AND status = 'active' 
              AND end_date <= DATE_ADD(CURDATE(), INTERVAL 2 DAY)";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        return $stmt->fetchAll();
    } else {
        return [];
    }
}

// Extend a subscription (e.g., upgrading a plan or renewal)
function extend_subscription($conn, $subscription_id, $new_end_date) {
    $sql = "UPDATE subscriptions SET end_date = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$new_end_date, $subscription_id]);
}

// Get all expired subscriptions
function get_expired_subscriptions($conn) {
    $sql = "SELECT * FROM subscriptions 
            WHERE status = 'expired' 
               OR end_date < CURDATE()";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        return $stmt->fetchAll();
    } else {
        return [];
    }
}

// Delete a subscription
function delete_subscription($conn, $subscription_id) {
    $sql = "DELETE FROM subscriptions WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$subscription_id]);
}

function check_active_subscription($conn, $company_id) {
    $sql = "SELECT id FROM subscriptions 
            WHERE company_id = :company_id AND status = 'active' AND end_date >= CURDATE()";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':company_id' => $company_id]);

    return $stmt->rowCount() > 0;
}
?>
