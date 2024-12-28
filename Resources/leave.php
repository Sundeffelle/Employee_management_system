<?php
session_start();
session_regenerate_id(true);

if (isset($_SESSION['role']) && ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'company')) {
    include "../inc/DB_connection.php";
    include "../app/Model/request.php";
    include "../inc/navbar.php";

    $leaves = get_all_leaves($conn);
?>

<div class="container-fluid">
    <h3 class="m-4"><i class="fa-solid fa-list fa-lg"></i> Manage Leave Requests</h3>
    <div class="row">
        <div class="col-12">
            <?php if ($leaves) { ?>
                <div class="card bg-light ms-4 me-4 mb-4">
                    <div class="card-header">
                        <i class="fa-solid fa-list fa-lg"></i> Leave Requests Records
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                      <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Employee Name</th>
                                        <th scope="col">Leave Type</th>
                                        <th scope="col">Start Date</th>
                                        <th scope="col">End Date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($leaves as $index => $leave) { ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td><?= htmlspecialchars($leave['full_name']) ?></td>
                                            <td><?= htmlspecialchars($leave['leave_type']) ?></td>
                                            <td><?= htmlspecialchars($leave['start_date']) ?></td>
                                            <td><?= htmlspecialchars($leave['end_date']) ?></td>
                                            <td><?= htmlspecialchars($leave['status']) ?></td>
                                            <td>
                                                <button type="button" class="btn btn-success me-1" data-bs-toggle="modal" data-bs-target="#updateModal<?= $leave['id'] ?>">
                                                    <i class="fa-solid fa-circle-info fa-lg"></i>
                                                </button>

                                                <!-- Update Modal -->
                                                <div class="modal fade" id="updateModal<?= $leave['id'] ?>" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Update Leave Request</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST" action="manage_leave.php">
                                                                    <input type="hidden" name="leave_id" value="<?= $leave['id'] ?>">
                                                                    <div class="mb-3">
                                                                        <label for="status" class="form-label">Leave Status</label>
                                                                        <select class="form-select" name="status">
                                                                            <option value="approved" <?= $leave['status'] == 'approved' ? 'selected' : '' ?>>Approve</option>
                                                                            <option value="rejected" <?= $leave['status'] == 'rejected' ? 'selected' : '' ?>>Reject</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Delete Modal -->
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $leave['id'] ?>">
                                                    <i class="fa-solid fa-trash fa-lg"></i>
                                                </button>
                                                <div class="modal fade" id="deleteModal<?= $leave['id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Delete Leave Request</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to delete this leave request?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form method="POST" action="delete_leave.php">
                                                                    <input type="hidden" name="leave_id" value="<?= $leave['id'] ?>">
                                                                    <input type="submit" class="btn btn-danger" value="Delete">
                                                                </form>
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </p>
                    </div>
                </div>
            <?php } else { ?>
                <h5 class="alert alert-primary ms-4 me-4">No Leave Requests Found</h5>
            <?php } ?>
        </div>
    </div>
</div>

<footer class="mt-auto mb-4">
    <div class="text-center">
        <span>Copyright &copy; <script>document.write(new Date().getFullYear())</script> PatMactech UK.</span>
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
