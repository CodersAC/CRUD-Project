<?php
require_once(__DIR__ . '/control/user.control.php');


// Check for the action and call the corresponding method
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $userAuthController = new UserAuthController();
    $userManagementController = new UserManagementController();
    $userSettingsController = new UserSettingsController();

    if ($action == 'login') {
        $userAuthController->loginUser();
    } elseif ($action == 'settings' && isset($_GET['userId'])) {
        $userId = trim($_GET['userId']);
        $userSettingsController->setting($userId);
    } elseif ($action == 'singleEdit' && isset($_POST['singleUser'])) {
        $userManagementController->updateSingleUser();
    } elseif ($action == 'logout') {
        $userAuthController->logoutUser();
    } elseif ($action == 'edit' && isset($_GET['editId'])) {
        $userId = trim($_GET['editId']);
        $userManagementController->getIdUser($userId);
    } elseif ($action == 'update' && isset($_POST['updateUser'])) {
        $userManagementController->updateUser();
    } elseif ($action == 'delete' && isset($_GET['deleteId'])) {
        $userId = trim($_GET['deleteId']);
        $userManagementController->deleteUser($userId);
    } elseif ($action == 'reset' && isset($_GET['resetId'])) {
        $userId = trim($_GET['resetId']);
        $userAuthController->resetUserPass($userId);
    }
}

?>