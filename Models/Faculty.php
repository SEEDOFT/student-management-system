<?php

namespace Models;

class Faculty
{
    private $conn;
    private const table_name = TBLFACULTY;
    public int $facId;
    public string $facultyName;

    /**
     * Summary of __construct
     * @param \PDO $db
     */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * Reads all faculty records from the database.
     * @return array An array of associative arrays, each representing a faculty.
     */
    public function readAll()
    {
        $query = "SELECT * FROM " . self::table_name . " ORDER BY facultyName ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}