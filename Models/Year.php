<?php

namespace Models;

class Year
{
    private $conn;
    private const table_name = TBLYEAR;

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
        $query = "SELECT * FROM " . self::table_name . " ORDER BY yearId ASC";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    /**
     * Summary of findIdByNumber
     * @param mixed $yearNumber
     * @return bool|int
     */
    public function findIdByNumber($yearNumber)
    {
        $query = "SELECT yearId FROM " . self::table_name . " WHERE YearsS = :yearNumber LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":yearNumber", $yearNumber);
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? (int) $row['yearId'] : false;
    }
}