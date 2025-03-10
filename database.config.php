<?php
//Connection on MSSQL
class DBConnect
{
    private $serverName = ""; // Change to your server name
    private $database = ""; // Change to your database name
    private $username = ""; // Change to your SQL Server username
    private $password = ""; // Change to your password

    public function connect()
    {
        try {
            $pdo = new PDO("sqlsrv:Server=$this->serverName;Database=$this->database", "$this->username", "$this->password");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}


?>