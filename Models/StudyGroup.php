<?php

namespace Models;

class StudyGroup
{
    private $conn;
    private const table_name = TBLGROUP;
    public int $gId;
    public int $StudyGroup;
    public ?int $genId;
    public ?int $facId;

    /**
     * Summary of __construct
     * @param \PDO $db
     */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * Summary of create
     * @return bool
     */
    public function create()
    {
        $query = "INSERT INTO " . self::table_name . " SET StudyGroup=:StudyGroup, " .
            "genId=:genId, facId=:facId";

        $stmt = $this->conn->prepare($query);

        $this->StudyGroup = intval(htmlspecialchars(strip_tags($this->StudyGroup)));
        $this->genId = intval(htmlspecialchars(strip_tags($this->genId)));
        $this->facId = intval(htmlspecialchars(strip_tags($this->facId)));

        $stmt->bindParam(":StudyGroup", $this->StudyGroup);
        $stmt->bindParam(":genId", $this->genId);
        $stmt->bindParam(":facId", $this->facId);

        if ($stmt->execute()) {
            $this->gId = $this->conn->lastInsertId();
            return true;
        }

        error_log("Error creating student: " . implode(" ", $stmt->errorInfo()));
        return false;
    }

    /**
     * Summary of readAll
     * @return array
     */
    public function readAll()
    {
        $query = "SELECT * FROM " . self::table_name . " ORDER BY gId ASC";

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
        $query = "SELECT * FROM " . self::table_name . " WHERE gId = :gId LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':gId', $this->gId);
        $stmt->execute();

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($row) {
            $this->StudyGroup = $row['StudyGroup'];
            $this->genId = $row['genId'];
            $this->facId = $row['facId'];
        }

    }

    /**
     * Summary of update
     * @return bool
     */
    public function update()
    {
        $query = "UPDATE " . self::table_name . " SET StudyGroup = :StudyGroup, genId = :genId, facId = :facId WHERE gId = :gId";

        $stmt = $this->conn->prepare($query);

        $this->StudyGroup = intval(htmlspecialchars(strip_tags($this->StudyGroup)));
        $this->genId = intval(htmlspecialchars(strip_tags($this->genId)));
        $this->facId = intval(htmlspecialchars(strip_tags($this->facId)));
        $this->gId = intval(htmlspecialchars(strip_tags($this->gId)));

        $stmt->bindParam(":StudyGroup", $this->StudyGroup);
        $stmt->bindParam(":genId", $this->genId);
        $stmt->bindParam(":facId", $this->facId);
        $stmt->bindParam(":gId", $this->gId);

        if ($stmt->execute()) {
            return true;
        }

        error_log("Error updating study group: " . implode(" ", $stmt->errorInfo()));
        return false;
    }

}