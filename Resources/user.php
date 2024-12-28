<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

// Check if the user is logged in and has the appropriate role
if (isset($_SESSION['role']) && isset($_SESSION['id']) && ($_SESSION['role'] == "admin" || $_SESSION['role'] == "company")) {
    include "../inc/DB_connection.php";
    include "../app/Model/User.php";
    include "../inc/navbar.php";

    $users = get_all_users($conn); // Fetch all users from the database
?>

<div class="container-fluid">
    <h3 class="m-4"><i class="fa fa-users fa-lg"></i> Manage Users</h3>

    <div class="row">
        <div class="col-12">
            <?php if (isset($_GET['success'])) { ?>
                <div class="alert alert-success ms-4 me-4" role="alert">
                    <?= htmlspecialchars(stripcslashes($_GET['success'])); ?>
                </div>
            <?php } ?>

            <?php if ($users) { ?>
                <div class="card bg-light ms-4 me-4 mb-4">
                    <div class="card-header">
                        <i class="fa fa-user-circle fa-lg"></i> Employee Records
                        <?php if ($_SESSION['role'] == "admin") { ?>
                            <a href="add-user.php" class="btn btn-primary btn-sm float-end">Add Employee</a>
                        <?php } ?>
                    </div>
                    <a href="index.php" class="btn btn-primary btn-sm float-end">Previous Page</a>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Profile Image</th>
                                        <th scope="col">Full Name</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Salary</th>
                                        <th scope="col">Department</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Date of Birth</th>
                                        <th scope="col">Gender</th>
                                        <th scope="col">Marital Status</th>
                                        <th scope="col">Nationality</th>
                                        <th scope="col">Phone Number</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Emergency Contact</th>
                                        <th scope="col">Work Location</th>
                                        <th scope="col">Employment Type</th>
                                        <th scope="col">Bank Account</th>
                                        <th scope="col">Bank Name</th>
                                        <th scope="col">IFSC/Sort Code</th>
                                        <th scope="col">TIN</th>
                                        <th scope="col">Insurance Number</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $index => $user) { ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td>
                                                <?php
                                                $base_dir = 'uploads/profile_images/';
                                                $profile_image = !empty($user['profile_image']) ? $base_dir . $user['profile_image'] : 'img/user.png';
                                                ?>
                                                <img src="<?= htmlspecialchars($profile_image) ?>" alt="Profile Image" class="img-fluid rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                            </td>
                                            <td><?= htmlspecialchars($user['full_name']) ?></td>
                                            <td><?= htmlspecialchars($user['username']) ?></td>
                                            <td><?= htmlspecialchars($user['email']) ?></td>
                                            <td><?= htmlspecialchars(number_format($user['salary'], 2)) ?></td>
                                            <td><?= htmlspecialchars($user['department']) ?></td>
                                            <td><?= htmlspecialchars($user['role']) ?></td>
                                            <td><?= htmlspecialchars($user['dob']) ?></td>
                                            <td><?= htmlspecialchars($user['gender']) ?></td>
                                            <td><?= htmlspecialchars($user['marital_status']) ?></td>
                                            <td><?= htmlspecialchars($user['nationality']) ?></td>
                                            <td><?= htmlspecialchars($user['phone_number']) ?></td>
                                            <td><?= htmlspecialchars($user['address']) ?></td>
                                            <td><?= htmlspecialchars($user['emergency_contact']) ?></td>
                                            <td><?= htmlspecialchars($user['work_location']) ?></td>
                                            <td><?= htmlspecialchars($user['employment_type']) ?></td>
                                            <td><?= htmlspecialchars($user['account_number']) ?></td>
                                            <td><?= htmlspecialchars($user['bank_name']) ?></td>
                                            <td><?= htmlspecialchars($user['ifsc_code']) ?></td>
                                            <td><?= htmlspecialchars($user['tin']) ?></td>
                                            <td><?= htmlspecialchars($user['insurance_number']) ?></td>
                                            <td>
                                                <a href="edit-user.php?id=<?= $user['id'] ?>" class="btn btn-success btn-sm me-1">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                <?php if ($_SESSION['role'] == "admin") { ?>
                                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $user['id'] ?>">
                                                        <i class="fa fa-trash"></i> Delete
                                                    </button>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <!-- Delete Confirmation Modal -->
                                        <div class="modal fade" id="deleteModal<?= $user['id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel">Delete User</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to delete <?= htmlspecialchars($user['full_name']) ?>?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form method="POST" action="delete-user.php">
                                                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <h5 class="alert alert-primary ms-4 me-4">No Users Found</h5>
            <?php } ?>
        </div>
    </div>
</div>

<footer class="mt-auto mb-4">
    <div class="text-center">
        <span>&copy; <script>document.write(new Date().getFullYear())</script> PatMactech UK.</span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

<?php 
} else { 
    $em = "First login";
    header("Location: login.php?error=$em");
    exit();
} 
?>
