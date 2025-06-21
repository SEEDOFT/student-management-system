<?php
namespace Models;

class Subject
{
    private $conn;
    private const table_name = TBLSUBJECT;
    public int $subId;
    public string $subjectName;
    public int $semId;
    public int $facId;
    public int $yearId;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function readOne()
    {
        $query = "SELECT * FROM " . self::table_name . " WHERE subId = :subId LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':subId', $this->subId);
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($row) {
            $this->subjectName = $row['subjectName'];
        }
    }

    /**
     * Summary of readByFacultyYearSemester
     * @param mixed $facId
     * @param mixed $yearId
     * @param mixed $semId
     */
    public function readByFacultyYearSemester($facId, $yearId, $semId)
    {
        $query = "SELECT subId, subjectName FROM " . self::table_name . " 
                  WHERE facId = :facId AND yearId = :yearId AND semId = :semId 
                  ORDER BY subjectName ASC";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":facId", $facId);
        $stmt->bindParam(":yearId", $yearId);
        $stmt->bindParam(":semId", $semId);

        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}