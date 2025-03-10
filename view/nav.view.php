<?php
require_once(__DIR__ . '/../connect.config.php');
require_once(__DIR__ . '/../auth.config.php');


$email = $_SESSION['email'];

// Split the email by '@' and get the first part
$emailParts = explode('@', $email);
$username = ucfirst($emailParts[0]); // Capitalize first letter
?>

<nav class="navbar navbar-expand-lg fixed-top ">
    <div class="container-fluid d-flex align-items-center">
        <!-- Logo (Left) -->
        <a class="navbar-brand" href="#" style="padding-left: 30px;">
            <img src="src/ciacw.png" style="height: 50px;">
        </a>

        <!-- Icons (Right) -->
        <div class="d-flex">
            <ul class="navbar-nav ms-5">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center bg-light p-2 rounded shadow-sm"
                        href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"
                        style="border: 1px solid #ccc; min-width: 180px;">
                        <i class="fas fa-user-circle me-2"></i> <?php echo htmlspecialchars($username); ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item"
                                href="../route.config.php?action=settings&userId= <?php echo $email; ?>"><i
                                    class="fas fa-cog"></i>
                                Settings</a></li>
                        <li><a class="dropdown-item text-danger" href="../route.config.php?action=logout"><i
                                    class="fas fa-sign-out-alt"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>