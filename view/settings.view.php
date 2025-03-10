<?php
require_once(__DIR__ . '/../connect.config.php');
require_once(__DIR__ . '/../auth.config.php');


$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$success = isset($_SESSION['success']) ? $_SESSION['success'] : "";
unset($_SESSION['errors']); // Clear errors after displaying them
unset($_SESSION['success']);

$userId = $_SESSION['user']['PK'];
$userEmail = $_SESSION['user']['UserID'];
$userCN = $_SESSION['user']['CompleteName'];
$userAccess = $_SESSION['user']['Access'];
?>

<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h2 class="text-center mb-4">Edit User</h2>

        <form action="../route.config.php?action=singleEdit" method="POST">
            <input type="hidden" name="pk" value="<?php echo $userId; ?>">
            <input type="hidden" name="userID" value="<?php echo $userEmail; ?>">

            <div class="mb-3">
                <label for="email" class="form-label">Complete Name</label>
                <input placeholder="<?php echo $userCN ?>" class="form-control" name="completename" value="">
                <small class="text-muted">Leave blank if you don't want to change the complete name.</small>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input placeholder="Password" class="form-control" type="password" id="password" name="password"
                    value="">
                <small class="text-muted">Leave blank if you don't want to change the password</small>
            </div>

            <div class="mb-2">
                <input type="checkbox" id="showPassword" onclick="togglePasswordVisibility()">
                <label for="showPassword">Show Password</label>
            </div>

            <div class="mb-3">
                <label for="access" class="form-label">Access</label>
                <input type="hidden" name="access" value="<?php echo $userAccess; ?>">
                <input type="text" class="form-control" value="<?php echo ($userAccess == '1') ? 'Admin' : 'User'; ?>"
                    readonly>
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

            <div class="text-center mt-2">
                <button type="submit" id="singleUser" name="singleUser" class="btn btn-success">Update</button>
                <a href="main.view.php?page=dashboard" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
    // Function to toggle password visibility
    function togglePasswordVisibility() {
        var passwordField = document.getElementById("password");
        if (passwordField.type === "password") {
            passwordField.type = "text";  // Show password
        } else {
            passwordField.type = "password";  // Hide password
        }
    }
</script>