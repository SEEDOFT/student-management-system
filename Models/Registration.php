<?php

namespace Models;

class Registration
{
    private $conn;
    private const table_name = TBLREGISTRATION;
    public int $regId;
    public int $stuId;
    public int $semId;
    public int $yearId;
    public string $regDate;
    public string $ModifiedDate;
    public string $startDate;
    public string $endDate;

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
        $query = "INSERT INTO " . Registration::table_name . " SET stuId=:stuId, " .
            " semId=:semId, yearId=:yearId, regDate=:regDate, ModifiedDate=:ModifiedDate, startDate=:startDate, endDate=:endDate";

        $stmt = $this->conn->prepare($query);

        $this->stuId = intval(htmlspecialchars(strip_tags($this->stuId)));
        $this->semId = intval(htmlspecialchars(strip_tags($this->semId)));
        $this->yearId = intval(htmlspecialchars(strip_tags($this->yearId)));
        $this->regDate = htmlspecialchars(strip_tags($this->regDate));
        $this->ModifiedDate = date('Y-m-d H:i:s');
        $this->startDate = htmlspecialchars(strip_tags($this->startDate));
        $this->endDate = htmlspecialchars(strip_tags($this->endDate));

        $stmt->bindParam(":stuId", $this->stuId);
        $stmt->bindParam(":semId", $this->semId);
        $stmt->bindParam(":yearId", $this->yearId);
        $stmt->bindParam(":regDate", $this->regDate);
        $stmt->bindParam(":ModifiedDate", $this->ModifiedDate);
        $stmt->bindParam(":startDate", $this->startDate);
        $stmt->bindParam(":endDate", $this->endDate);

        if ($stmt->execute()) {
            $this->regId = $this->conn->lastInsertId();
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
        $query = "SELECT * FROM " . Registration::table_name . " ORDER BY regId ASC";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    /**
     * Summary of exists
     * @return bool
     */
    public function exists()
    {
        $query = "SELECT regId FROM " . self::table_name . " WHERE stuId = :stuId AND semId = :semId AND yearId = :yearId";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":stuId", $this->stuId);
        $stmt->bindParam(":semId", $this->semId);
        $stmt->bindParam(":yearId", $this->yearId);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    /**
     * Summary of readByStudent
     * @param mixed $stuId
     * @return array
     */
    public function readByStudent($stuId)
    {
        $query = "SELECT 
                    r.regId, r.startDate, r.endDate,
                    r.semId,      
                    r.yearId,     
                    s.semester,
                    y.YearsS
                  FROM " . self::table_name . " AS r
                  JOIN tblSemesters as s ON r.semId = s.semId
                  JOIN tblYears as y ON r.yearId = y.yearId
                  WHERE r.stuId = :stuId
                  ORDER BY y.YearsS DESC, s.semester DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":stuId", $stuId);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Summary of countByStudent
     * @return int
     */
    public function countByStudent()
    {
        $query = "SELECT COUNT(regId) as registration_count FROM " . self::table_name . " WHERE stuId = :stuId";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":stuId", $this->stuId);
        $stmt->execute();

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return (int) $row['registration_count'];
    }

    /**
     * Summary of readLatestByStudent
     * @param mixed $stuId
     */
    public function readLatestByStudent($stuId)
    {
        $query = "SELECT r.semId, r.yearId, s.semester, y.YearsS
                  FROM " . self::table_name . " AS r
                  JOIN tblSemesters as s ON r.semId = s.semId
                  JOIN tblYears as y ON r.yearId = y.yearId
                  WHERE r.stuId = :stuId
                  ORDER BY y.YearsS DESC, s.semester DESC
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":stuId", $stuId);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

}