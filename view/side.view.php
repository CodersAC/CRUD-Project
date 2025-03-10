<!--Sidebar-->
<?php require_once(__DIR__ . '/../connect.config.php');
require_once(__DIR__ . '/../auth.config.php'); ?>

<div class="sidebar" id="sidebar" style="width: 200px; padding-left: 10px; padding-right: 10px;">
    <div class="list-group list-group-flush">
        <a href="main.view.php?page=dashboard" class="list-group-item list-group-item-action">Dashboard</a>
        <?php if ($_SESSION['Access'] == 1): ?>
            <a href="main.view.php?page=user" class="list-group-item list-group-item-action">Users</a>
        <?php endif; ?>
    </div>
</div>