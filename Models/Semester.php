<?php

namespace Models;

class Semester
{
    private $conn;
    private const table_name = TBLSEMESTER;
    public int $semId;
    public int $semester;

    /**
     * Summary of __construct
     * @param mixed $db
     */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     *  readAll
     */
    public function readAll()
    {
        $query = "SELECT * FROM " . Semester::table_name . " ORDER BY semId ASC";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    /**
     * Summary of findIdByNumber
     * @param mixed $semesterNumber
     * @return bool|int
     */
    public function findIdByNumber($semesterNumber)
    {
        $query = "SELECT semId FROM " . self::table_name . " WHERE semester = :semesterNumber LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":semesterNumber", $semesterNumber);
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? (int) $row['semId'] : false;
    }
}