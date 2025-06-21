<?php

namespace Models;

class Score
{
    private $conn;
    private const table_name = TBLSCORE;
    public int $scId;
    public int $regId;
    public int $subId;
    public int $score;
    public string $regDate;
    public string $ModifiedDate;

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
        $query = "INSERT INTO " . Score::table_name . " SET regId=:regId, " .
            " subId=:subId, score=:score, regDate=:regDate, ModifiedDate=:ModifiedDate";

        $stmt = $this->conn->prepare($query);

        $this->regId = intval(htmlspecialchars(strip_tags($this->regId)));
        $this->subId = intval(htmlspecialchars(strip_tags($this->subId)));
        $this->score = intval(htmlspecialchars(strip_tags($this->score)));
        $this->regDate = htmlspecialchars(strip_tags($this->regDate));
        $this->ModifiedDate = date('Y-m-d H:i:s');

        $stmt->bindParam(":regId", $this->regId);
        $stmt->bindParam(":subId", $this->subId);
        $stmt->bindParam(":score", $this->score);
        $stmt->bindParam(":regDate", $this->regDate);
        $stmt->bindParam(":ModifiedDate", $this->ModifiedDate);

        if ($stmt->execute()) {
            return true;
        }

        error_log("Error register student: " . implode(" ", $stmt->errorInfo()));
        return false;
    }

    /**
     * Summary of readAll
     * @return bool|\PDOStatement
     */
    public function readAll()
    {
        $query = "SELECT * FROM " . Year::table_name . " ORDER BY scId ASC";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    /**
     * Summary of readByRegistration
     * @param mixed $regId
     * @return array
     */
    public function readByRegistration($regId)
    {
        $query = "SELECT 
                    sc.score,
                    sub.subjectName
                  FROM " . self::table_name . " AS sc
                  JOIN tblSubjects AS sub ON sc.subId = sub.subId
                  WHERE sc.regId = :regId
                  ORDER BY sub.subjectName ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":regId", $regId);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}