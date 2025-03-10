<?php

require_once(__DIR__ . '/../connect.config.php');
require_once(__DIR__ . '/../model/user.model.php');

/**
 * Class BaseController
 * This serves as a parent class for all controllers, providing a base structure.
 */
class BaseController
{
    protected $userModel;
    protected $locatorModel;
    public $errors = [];

    public function __construct()
    {
        $this->userModel = new User(); // Initialize the User model
        $this->locatorModel = new Locator();
    }
}

/**
 * Class UserDisplayController
 * Handles fetching and displaying user-related data (e.g., lists of users, pagination).
 */
class UserDisplayController extends BaseController
{
    // Fetch all users with pagination
    public function showAllUsersPage($page, $limit)
    {
        $offset = ($page - 1) * $limit;
        return $this->userModel->getAllUsers($offset, $limit);
    }

    // Get total users count for pagination
    public function getTotalUsers()
    {
        return $this->userModel->getNumUsers();
    }

    public function getOngoingLocators($page, $limit)
    {
        $offset = ($page - 1) * $limit;
        return $this->locatorModel->fetchOngoingLocators($offset, $limit);
    }

    public function getExpiredLocators($page, $limit)
    {
        $offset = ($page - 1) * $limit;
        return $this->locatorModel->fetchExpiredLocators($offset, $limit);
    }

    public function getTotalOngoingLocators()
    {
        return $this->locatorModel->countOngoingLocators();
    }

    public function getTotalExpiredLocators()
    {
        return $this->locatorModel->countExpiredLocators();
    }
}

/**
 * Class UserAuthController
 * Handles authentication (login, logout, password reset).
 */
class UserAuthController extends BaseController
{
    public function loginUser()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $this->userModel->getUserByLogin($email);

        if (password_get_info($user['Password'])['algo'] === null) {
            $passwordNot = password_hash($user['Password'], PASSWORD_DEFAULT);
        } else {
            $passwordNot = $user['Password'];
        }

        if ($user && password_verify($password, $passwordNot)) {
            $_SESSION['email'] = $user['UserID'];
            $_SESSION['Access'] = $user['Access'];
            header("Location: view/main.view.php");
            exit();
        } else {
            $_SESSION['errors']["password"] = "Username and password do not match";
            header("Location: view/login.view.php");
            exit();
        }
    }

    public function logoutUser()
    {
        session_unset();
        session_destroy();
        sleep(2);
        header("Location: view/login.view.php");
        exit();
    }

    public function resetUserPass($userId)
    {
        $this->userModel->setUserPassDef($userId);
        header("Location: view/main.view.php?page=user");
        exit();
    }
}

/**
 * Class UserManagementController
 * Handles user-related actions such as creating, updating, and deleting users.
 */
class UserManagementController extends BaseController
{
    public function getIdUser($userID)
    {
        $user = $this->userModel->getUserById($userID);

        if ($user) {
            $_SESSION['edit_user'] = $user;
            header("Location: view/main.view.php?page=edit");
            exit();
        } else {
            echo "User not found.";
        }
    }

    public function deleteUser($userID)
    {
        $this->userModel->deleteUser($userID);
        header("Location: view/main.view.php?page=user");
        exit();
    }

    public function updateUser()
    {
        $id = $_POST['pk'];
        $user = $_POST['username'];
        $name = $_POST['completename'];
        $access = $_POST['access'];

        $userCheck = $this->userModel->getUserByUserID($user);
        if ($userCheck) {
            $this->errors['email'] = "Email is already registered";
        } else {
            if ($this->userModel->updateUser($id, $user, $name, $access)) {
                $_SESSION['success'] = "User updated successfully!";
            } else {
                $_SESSION['errors'] = "Failed to update user!";
            }
        }

        $_SESSION['errors'] = $this->errors;
        header("Location: route.config.php?action=edit&editId=$id");
        exit();
    }

    public function updateSingleUser()
    {
        $pk = $_POST['pk'];
        $id = $_POST['userID'];
        $name = $_POST['completename'];
        $password = $_POST['password'];

        if ($this->userModel->updateSingleUser($pk, $name, $password)) {
            $_SESSION['success'] = "User updated successfully!";
        } else {
            $_SESSION['errors'] = "Failed to update user!";
        }

        $_SESSION['errors'] = $this->errors;
        header("Location: route.config.php?action=settings&userId=$id");
        exit();
    }
}

/**
 * Class UserSettingsController
 * Handles user settings and profile management.
 */
class UserSettingsController extends BaseController
{
    public function setting($userID)
    {
        $user = $this->userModel->getUserByUserID($userID);
        $_SESSION['user'] = $user;
        header("Location: view/main.view.php?page=settings");
        exit();
    }
}
