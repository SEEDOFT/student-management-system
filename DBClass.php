<?php
class Database
{
    public $host = "localhost";
    public $dbName = "studb";
    public $username = "root";
    public $password = "";
    public $conn;

    public function getConnection()
    {
        $this->conn = null;
        //echo "Starting Connection";
        //$this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->dbName) or die ("Not Connected");
        try {
            //$this->conn = new PDO("mysql:host = localhost; dbName = studb", $this->username, $this->password);
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbName, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }
        //echo "End Connection"; ++
        return $this->conn;
    }
}
?>