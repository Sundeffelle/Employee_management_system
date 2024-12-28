<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "employee") {
    include "../inc/DB_connection.php";
    include "../app/Model/User.php";
    $user = get_user_by_id($conn, $_SESSION['id']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <input type="checkbox" id="checkbox">
    <?php include "../inc/header.php" ?>
    <div class="body">
        <?php include "inc/nav.php" ?>
        <section class="section-1">
            <h4 class="title">Profile <a href="edit_profile.php">Edit Profile</a></h4>
            <table class="main-table" style="max-width: 600px;">
                <tr>
                    <td><strong>Full Name</strong></td>
                    <td><?=$user['full_name']?></td>
                </tr>
                <tr>
                    <td><strong>Username</strong></td>
                    <td><?=$user['username']?></td>
                </tr>
                <tr>
                    <td><strong>Email</strong></td>
                    <td><?=$user['email']?></td>
                </tr>
                <tr>
                    <td><strong>Phone Number</strong></td>
                    <td><?=$user['phone_number'] ?? 'Not provided'?></td>
                </tr>
                <tr>
                    <td><strong>Address</strong></td>
                    <td><?=$user['address'] ?? 'Not provided'?></td>
                </tr>
                <tr>
                    <td><strong>Department</strong></td>
                    <td><?=$user['department'] ?? 'Not provided'?></td>
                </tr>
                <tr>
                    <td><strong>Profile Picture</strong></td>
                    <td>
                        <?php if (!empty($user['profile_image'])): ?>
                            <img src="<?=$user['profile_image']?>" alt="Profile Picture" style="width: 100px; height: 100px;">
                        <?php else: ?>
                            <span>No Profile Picture</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td><strong>Joined At</strong></td>
                    <td><?=$user['created_at']?></td>
                </tr>
            </table>
        </section>
    </div>

    <script type="text/javascript">
        var active = document.querySelector("#navList li:nth-child(3)");
        active.classList.add("active");
    </script>
</body>
</html>
<?php 
} else { 
    $em = "First login";
    header("Location: login.php?error=$em");
    exit();
}
?>
