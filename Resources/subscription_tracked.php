<?php 
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "Access denied. Kindly Subscription to Custom Flow For advance Feature Like this.";
    exit;
}


try {
    $sName = "localhost";
    $uName = "root";
    $pass  = "";
    $db_name = "task_management_db";

    $conn = new PDO("mysql:host=$sName;dbname=$db_name;charset=utf8mb4", $uName, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch company details
    $sql = "SELECT company_id, company_name, company_email, industry, company_size, 
                   contact_email, contact_phone, address, registration_date 
            FROM companies 
            ORDER BY registration_date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $companies = $stmt->fetchAll();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Company Registration Details</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 16px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        table th {
            background-color: #f4f4f4;
            text-align: left;
        }
        .delete-btn {
            color: #fff;
            background-color: #dc3545;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .delete-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Company Registration Details</h1>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Company Name</th>
                    <th>Company Email</th>
                    <th>Industry</th>
                    <th>Size</th>
                    <th>Contact Email</th>
                    <th>Contact Phone</th>
                    <th>Address</th>
                    <th>Registration Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($companies as $index => $company): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars($company['company_name']); ?></td>
                    <td><?php echo htmlspecialchars($company['company_email']); ?></td>
                    <td><?php echo htmlspecialchars($company['industry']); ?></td>
                    <td><?php echo htmlspecialchars($company['company_size']); ?></td>
                    <td><?php echo htmlspecialchars($company['contact_email']); ?></td>
                    <td><?php echo htmlspecialchars($company['contact_phone']); ?></td>
                    <td><?php echo htmlspecialchars($company['address']); ?></td>
                    <td><?php echo htmlspecialchars($company['registration_date']); ?></td>
                    <td>
                        <form action="delete_company.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this company?');">
                            <input type="hidden" name="company_id" value="<?php echo $company['company_id']; ?>">
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
