<?php

class FacultyClass
{
    private $conn;
    private $tblName = "tblfaculties";

    public $facId;
    public $facName;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function index()
    {
        try {
            $query = "SELECT * FROM {$this->tblName}";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}