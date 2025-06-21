<?php

namespace Models;

class Generation
{
    private $conn;
    private const table_name = TBLGENERATION;
    public int $genId;
    public ?int $facId;
    public int $Generation;

    /**
     * Summary of __construct
     * @param \PDO $db
     */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * Summary of readAll
     * @return array
     */
    public function readAll()
    {
        $query = "SELECT * FROM " . self::table_name . " ORDER BY genId ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Summary of readOne
     * @return void
     */
    public function readOne()
    {
        $query = "SELECT * FROM " . self::table_name . " WHERE genId = :genId LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':genId', $this->genId);
        $stmt->execute();

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($row) {
            $this->Generation = $row['Generation'];
            $this->facId = $row['facId'];
        }

    }

    /**
     * Summary of update
     * @return bool
     */
    public function update()
    {
        $query = "UPDATE " . self::table_name . " SET Generation = :Generation, facId = :facId WHERE genId = :genId";

        $stmt = $this->conn->prepare($query);

        $this->Generation = intval(htmlspecialchars(strip_tags($this->Generation)));
        $this->facId = intval(htmlspecialchars(strip_tags($this->facId)));
        $this->genId = intval(htmlspecialchars(strip_tags($this->genId)));

        $stmt->bindParam(":Generation", $this->Generation);
        $stmt->bindParam(":facId", $this->facId);
        $stmt->bindParam(":genId", $this->genId);

        if ($stmt->execute()) {
            return true;
        }

        error_log("Error updating generation: " . implode(" ", $stmt->errorInfo()));
        return false;

    }
}