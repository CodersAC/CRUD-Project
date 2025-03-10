<?php
require_once(__DIR__ . '/../database.config.php');
// User Model Class
class User
{
    private $pdo;

    public function __construct()
    {
        $dbConnect = new DBConnect();
        $this->pdo = $dbConnect->connect();
    }

    // Get all users with pagination
    public function getAllUsers($offset, $limit)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM dbUsers ORDER BY UserID OFFSET :offset ROWS FETCH NEXT :limit ROWS ONLY");
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get a single user by their ID (Primary Key)
    public function getUserById($PK)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM dbUsers WHERE PK = :PK");
        $stmt->execute(['PK' => $PK]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get a user by UserID (to check if they exist)
    public function getUserByUserID($UserID)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM dbUsers WHERE UserID = :UserID");
        $stmt->execute(['UserID' => $UserID]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get user credentials for login
    public function getUserByLogin($UserID)
    {
        $stmt = $this->pdo->prepare("SELECT UserID, Password, Access FROM dbUsers WHERE UserID = :UserID");
        $stmt->execute(['UserID' => $UserID]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update user details
    public function updateUser($PK, $UserID, $CompleteName, $Access)
    {
        $stmt = $this->pdo->prepare("UPDATE dbUsers SET UserID = ?, CompleteName = ?, Access = ? WHERE PK = ?");
        return $stmt->execute([$UserID, $CompleteName, $Access, $PK]);
    }

    // Update user's complete name and/or password
    public function updateSingleUser($PK, $CompleteName, $Password)
    {
        if (!empty($CompleteName) && !empty($Password)) {
            $stmt = $this->pdo->prepare("UPDATE dbUsers SET CompleteName = ?, Password = ? WHERE PK = ?");
            return $stmt->execute([$CompleteName, $Password, $PK]);
        } elseif (!empty($CompleteName)) {
            $stmt = $this->pdo->prepare("UPDATE dbUsers SET CompleteName = ? WHERE PK = ?");
            return $stmt->execute([$CompleteName, $PK]);
        } elseif (!empty($Password)) {
            $stmt = $this->pdo->prepare("UPDATE dbUsers SET Password = ? WHERE PK = ?");
            return $stmt->execute([$Password, $PK]);
        }
    }

    // Reset user password to a default value
    public function setUserPassDef($PK)
    {
        $stmt = $this->pdo->prepare("UPDATE dbUsers SET Password = ? WHERE PK = ?");
        return $stmt->execute(["welcome123", $PK]);
    }

    // Delete a user by their ID
    public function deleteUser($PK)
    {
        $stmt = $this->pdo->prepare("DELETE FROM dbUsers WHERE PK = :PK");
        return $stmt->execute(['PK' => $PK]);
    }

    // Get total number of users
    public function getNumUsers()
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM dbUsers");
        return $stmt->fetchColumn();
    }
}

// Locator Model Class
class Locator
{
    private $pdo;

    public function __construct()
    {
        $dbConnect = new DBConnect();
        $this->pdo = $dbConnect->connect();
    }

    // Get all ongoing locators
    public function fetchOngoingLocators($offset, $limit)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM dbLocator 
            WHERE StartTerm <= GETDATE() AND EndTerm >= GETDATE() 
            ORDER BY EndTerm ASC 
            OFFSET :offset ROWS FETCH NEXT :limit ROWS ONLY");

        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all expired locators
    public function fetchExpiredLocators($offset, $limit)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM dbLocator 
            WHERE EndTerm < GETDATE() 
            ORDER BY EndTerm DESC 
            OFFSET :offset ROWS FETCH NEXT :limit ROWS ONLY");

        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Count ongoing locators
    public function countOngoingLocators()
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM dbLocator 
            WHERE StartTerm <= GETDATE() AND EndTerm >= GETDATE()");
        return $stmt->fetchColumn();
    }

    // Count expired locators
    public function countExpiredLocators()
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM dbLocator 
            WHERE EndTerm < GETDATE()");
        return $stmt->fetchColumn();
    }
}
?>