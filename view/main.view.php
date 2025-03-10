<?php require_once(__DIR__ . '/../auth.config.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="src/dashstyles.css?v=<?php echo time(); ?>" rel=" stylesheet">
    <!-- jQuery for AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</head>

<body>

    <!-- Sidebar (Navigation) -->
    <div class="d-flex" id="wrapper">
        <!-- Content Area -->
        <div id="page-content-wrapper" class="container-fluid">
            <!-- Top Bar -->
            <?php include 'nav.view.php' ?>

            <!-- Main Content -->
            <div class="content">
                <?php
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                    $allowed_pages = ['dashboard', 'settings', 'user', 'edit', 'register'];

                    if (in_array($page, $allowed_pages)) {
                        include "$page.view.php";
                    } else {
                        echo "<h2>Page Not Found</h2>";
                    }
                } else {
                    include "dashboard.view.php"; // Default Page
                }
                ?>
            </div>
        </div>
        <!--Sidebar-->
        <?php include "side.view.php" ?>
    </div>
    <!-- Footer -->
    <footer class="text-center mt-auto py-2" style="font-size: 14px; border-top: 1px solid #ddd;">
        &copy; <?php echo date("Y"); ?> MIS/GIS Division
    </footer>
</body>

</html>