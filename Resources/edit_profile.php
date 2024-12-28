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
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <input type="checkbox" id="checkbox">
    <?php include "../inc/header.php"; ?>
    <div class="body">
        <?php include "../inc/nav.php"; ?>
        <section class="section-1">
            <h4 class="title">Edit Profile <a href="profile.php">Profile</a></h4>
            <form class="form-1" method="POST" action="../app/update-profile.php" enctype="multipart/form-data">
                <?php if (isset($_GET['error'])) { ?>
                    <div class="danger" role="alert">
                        <?= htmlspecialchars(stripcslashes($_GET['error'])); ?>
                    </div>
                <?php } ?>

                <?php if (isset($_GET['success'])) { ?>
                    <div class="success" role="alert">
                        <?= htmlspecialchars(stripcslashes($_GET['success'])); ?>
                    </div>
                <?php } ?>

                <!-- Full Name -->
                <div class="input-holder">
                    <label>Full Name</label>
                    <input type="text" name="full_name" class="input-1" placeholder="Full Name" value="<?= htmlspecialchars($user['full_name']); ?>"><br>
                </div>

                <!-- Email -->
                <div class="input-holder">
                    <label>Email</label>
                    <input type="email" name="email" class="input-1" placeholder="Email" value="<?= htmlspecialchars($user['email']); ?>"><br>
                </div>

                <!-- Phone Number -->
                <div class="input-holder">
                    <label>Phone Number</label>
                    <input type="text" name="phone_number" class="input-1" placeholder="Phone Number" value="<?= htmlspecialchars($user['phone_number'] ?? ''); ?>"><br>
                </div>

                <!-- Address -->
                <div class="input-holder">
                    <label>Address</label>
                    <textarea name="address" class="input-1" placeholder="Address"><?= htmlspecialchars($user['address'] ?? ''); ?></textarea><br>
                </div>

                <!-- Department -->
                <div class="input-holder">
                    <label>Department</label>
                    <input type="text" name="department" class="input-1" placeholder="Department" value="<?= htmlspecialchars($user['department'] ?? ''); ?>"><br>
                </div>

                <!-- Profile Picture -->
                <div class="input-holder">
                    <label>Profile Picture</label>
                    <input type="file" name="profile_image" class="input-1"><br>
                    <img src="<?= htmlspecialchars($user['profile_image']); ?>" alt="Current Profile Picture" style="width: 100px; height: 100px;">
                </div>

                <button class="edit-btn">Update Profile</button>
            </form>
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
    $em = "Unauthorized access. Please login.";
    header("Location: login.php?error=" . urlencode($em));
    exit();
}
?>
