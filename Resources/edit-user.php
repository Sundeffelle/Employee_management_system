<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
    include "../inc/DB_connection.php";
    include "../app/Model/User.php";
    
    if (!isset($_GET['id'])) {
        header("Location: user.php");
        exit();
    }
    $id = $_GET['id'];
    $user = get_user_by_id($conn, $id);

    if ($user == 0) {
        header("Location: user.php");
        exit();
    }

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit User</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/style.css">
</head>
<body>
	<input type="checkbox" id="checkbox">
	<?php include "../inc/header.php" ?>
	<div class="body">
		<?php include "../inc/nav.php" ?>
		<section class="section-1">
			<h4 class="title">Edit User <a href="user.php">Users</a></h4>
			<form class="form-1"
			      method="POST"
			      action="../app/update-user.php"
			      enctype="multipart/form-data">
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
				<div class="input-holder">
					<label>Full Name</label>
					<input type="text" name="full_name" class="input-1" placeholder="Full Name" value="<?= htmlspecialchars($user['full_name']) ?>" required><br>
				</div>
				<div class="input-holder">
					<label>Username</label>
					<input type="text" name="user_name" value="<?= htmlspecialchars($user['username']) ?>" class="input-1" placeholder="Username" required><br>
				</div>
				<div class="input-holder">
					<label>Email</label>
					<input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" class="input-1" placeholder="Email" required><br>
				</div>
				<div class="input-holder">
					<label>Password</label>
					<input type="password" name="password" class="input-1" placeholder="Password (leave blank to keep current)" autocomplete="new-password"><br>
				</div>
                <div class="input-holder">
					<label>Department</label>
					<input type="text" name="department" class="input-1" value="<?= htmlspecialchars($user['department']) ?>" required><br>
				</div>
                <div class="input-holder">
					<label>Salary</label>
					<input type="number" name="salary" class="input-1" step="0.01" value="<?= htmlspecialchars($user['salary']) ?>" required><br>
				</div>
                <div class="input-holder">
					<label>Date of Birth</label>
					<input type="date" name="dob" class="input-1" value="<?= htmlspecialchars($user['dob']) ?>" required><br>
				</div>
                <div class="input-holder">
					<label>Gender</label>
					<select name="gender" class="input-1" required>
                        <option value="Male" <?= $user['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= $user['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                    </select><br>
				</div>
				<div class="input-holder">
					<label>Marital Status</label>
					<select name="marital_status" class="input-1" required>
                        <option value="Single" <?= $user['marital_status'] == 'Single' ? 'selected' : '' ?>>Single</option>
                        <option value="Married" <?= $user['marital_status'] == 'Married' ? 'selected' : '' ?>>Married</option>
                    </select><br>
				</div>
				<div class="input-holder">
					<label>Nationality</label>
					<input type="text" name="nationality" class="input-1" value="<?= htmlspecialchars($user['nationality']) ?>" required><br>
				</div>
				<div class="input-holder">
					<label>Phone Number</label>
					<input type="text" name="phone_number" class="input-1" value="<?= htmlspecialchars($user['phone_number']) ?>" required><br>
				</div>
				<div class="input-holder">
					<label>Residential Address</label>
					<input type="text" name="address" class="input-1" value="<?= htmlspecialchars($user['address']) ?>" required><br>
				</div>
				<div class="input-holder">
					<label>Emergency Contact</label>
					<input type="text" name="emergency_contact" class="input-1" value="<?= htmlspecialchars($user['emergency_contact']) ?>" required><br>
				</div>
				<div class="input-holder">
					<label>Work Location</label>
					<input type="text" name="work_location" class="input-1" value="<?= htmlspecialchars($user['work_location']) ?>" required><br>
				</div>
				<div class="input-holder">
					<label>Employment Type</label>
					<select name="employment_type" class="input-1" required>
                        <option value="Full-Time" <?= $user['employment_type'] == 'Full-Time' ? 'selected' : '' ?>>Full-Time</option>
                        <option value="Part-Time" <?= $user['employment_type'] == 'Part-Time' ? 'selected' : '' ?>>Part-Time</option>
                        <option value="Contractual" <?= $user['employment_type'] == 'Contractual' ? 'selected' : '' ?>>Contractual</option>
                        <option value="Intern" <?= $user['employment_type'] == 'Intern' ? 'selected' : '' ?>>Intern</option>
                    </select><br>
				</div>
				<div class="input-holder">
					<label>Bank Account Number</label>
					<input type="text" name="account_number" class="input-1" value="<?= htmlspecialchars($user['account_number']) ?>" required><br>
				</div>
				<div class="input-holder">
					<label>Bank Name</label>
					<input type="text" name="bank_name" class="input-1" value="<?= htmlspecialchars($user['bank_name']) ?>" required><br>
				</div>
				<div class="input-holder">
					<label>IFSC/Sort Code</label>
					<input type="text" name="ifsc_code" class="input-1" value="<?= htmlspecialchars($user['ifsc_code']) ?>" required><br>
				</div>
				<div class="input-holder">
					<label>Tax Identification Number (TIN)</label>
					<input type="text" name="tin" class="input-1" value="<?= htmlspecialchars($user['tin']) ?>" required><br>
				</div>
				<div class="input-holder">
					<label>National Insurance Number</label>
					<input type="text" name="insurance_number" class="input-1" value="<?= htmlspecialchars($user['insurance_number']) ?>" required><br>
				</div>
                <div class="input-holder">
					<label>Profile Image</label>
					<input type="file" name="profile_image" class="input-1"><br>
					<img src="<?= htmlspecialchars($user['profile_image']) ?>" alt="Profile Image" style="width: 100px; height: 100px;">
				</div>

				<input type="hidden" name="id" value="<?= $user['id'] ?>">

				<button class="edit-btn">Update</button>
			</form>
		</section>
	</div>

<script type="text/javascript">
	var active = document.querySelector("#navList li:nth-child(2)");
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
