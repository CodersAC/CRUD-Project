<?php
require_once(__DIR__ . '/connect.config.php'); // Ensure session is started

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['email'])) {
    header('Location: login.view.php');
    exit();
}
?>