<?php
require_once(__DIR__ . '/../connect.config.php');
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
unset($_SESSION['errors']); // Clear errors after displaying them

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CSS -->
    <link href="src/frontstyles.css?v=<?php echo time(); ?>" rel="stylesheet"> <!-- External CSS -->
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row w-100">
            <div class="col-lg-6 col-md-8 col-sm-10 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <img src="src/ciacblue.png" class="img-fluid"
                            alt="Clark International Airport Corporation Logo">
                        <h1 class="fw-bold text-center mb-4">Log in</h1>
                        <h6 class="fw-bold custom-color text-center mb-4">Welcome, please login.</h6>
                        <form method="POST" action="../route.config.php?action=login">
                            <div class="mb-4">
                                <input name="email" class="form-control" id="email" placeholder="Username" required>
                            </div>
                            <div class="mb-4">
                                <input name="password" type="password" class="form-control" id="password"
                                    placeholder="Password">
                            </div>
                            <!-- Checkbox to toggle password visibility -->
                            <div class="mb-2">
                                <input type="checkbox" id="showPassword" onclick="togglePasswordVisibility()">
                                <label for="showPassword">Show Password</label>
                            </div>
                            <div class='mb-2 text-center'>
                                <?php if (isset($errors['password'])): ?>
                                    <span style="color: red; "><?php echo $errors['password']; ?></span>
                                <?php endif; ?>
                            </div>
                            <div class='mb-2'>
                                <button type="submit" name="submit " class="btn w-100"><i class="fas fa-sign-in-alt"
                                        style="padding-right: 3px;"></i> Login</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Footer -->
                <footer class="text-center" style="font-size: 14px; color: white;">
                    &copy; <?php echo date("Y"); ?> MIS/GIS Division
                </footer>
            </div>
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
</body>

</html>