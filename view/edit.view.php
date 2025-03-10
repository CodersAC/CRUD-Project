<?php
require_once(__DIR__ . '/../connect.config.php');
require_once(__DIR__ . '/../auth.config.php');

$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$success = isset($_SESSION['success']) ? $_SESSION['success'] : "";
unset($_SESSION['errors']); // Clear errors after displaying them
unset($_SESSION['success']);

$userId = $_SESSION['edit_user']['PK'];
$userEmail = $_SESSION['edit_user']['UserID'];
$userCN = $_SESSION['edit_user']['CompleteName'];
$userAccess = $_SESSION['edit_user']['Access']; // Ensure role is fetched
$userCreate = $_SESSION['edit_user']['DateAdded'];

?>

<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h2 class="text-center mb-4">Edit User</h2>

        <form action="../route.config.php?action=update" method="POST">
            <input type="hidden" name="pk" value="<?php echo $userId; ?>">

            <div class="mb-3">
                <label for="email" class="form-label">Username : <?php echo $userEmail; ?></label>
                <input placeholder="<?php echo $userEmail ?>" class="form-control" name="username" value="">
                <small class="text-muted">Leave blank if you don't want to change the username.</small>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Complete Name</label>
                <input placeholder="<?php echo $userCN ?>" class="form-control" name="completename" value="">
                <small class="text-muted">Leave blank if you don't want to change the complete name</small>
            </div>

            <div class="mb-3">
                <label for="access" class="form-label">Access</label>
                <select class="form-control" name="access" required>
                    <option value="0" <?php echo ($userAccess == '0') ? 'selected' : ''; ?>>User</option>
                    <option value="1" <?php echo ($userAccess == '1') ? 'selected' : ''; ?>>Admin</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="created_at" class="form-label">Created At</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars($userCreate); ?>" readonly>
            </div>

            <div class="mb-3 text-center">
                <?php if (!empty($errors)): ?>
                    <span style="color: red;"><?php echo implode("<br>", $errors); ?></span>
                <?php elseif (!empty($success)): ?>
                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            Swal.fire({
                                icon: "success",
                                title: "Success!",
                                text: "<?php echo addslashes($success); ?>",
                                showConfirmButton: true
                            });
                        });
                    </script>
                <?php endif; ?>
            </div>

            <div class="text-center">
                <button type="submit" id="updateUser" name="updateUser" class="btn btn-success">Update</button>
                <a href="main.view.php?page=user" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>