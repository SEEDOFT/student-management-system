<?php

namespace Models;

class Attendance
{
    private $conn;
    private const table_name = TBLATTENDACE;
    public int $attId;
    public int $stuId;
    public int $regId;
    public int $subId;
    public string $regAtt;
    public string $regDate;
    public string $ModifiedDate;

    /**
     * Constructor for the Attendance class.
     * @param \PDO $db The PDO database connection object.
     */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * Creates a new attendance record in the database.
     * @return bool True on success, false on failure.
     */
    public function create()
    {
        $query = "INSERT INTO " . self::table_name . "
                    SET
                        stuId = :stuId,
                        regId = :regId,
                        subId = :subId,
                        regAtt = :regAtt,
                        regDate = :regDate,
                        ModofiedDate = :ModifiedDate";

        $stmt = $this->conn->prepare($query);

        $this->stuId = intval(htmlspecialchars(strip_tags($this->stuId)));
        $this->regId = intval(htmlspecialchars(strip_tags($this->regId)));
        $this->regAtt = htmlspecialchars(strip_tags($this->regAtt));
        $this->subId = intval(htmlspecialchars(strip_tags($this->subId)));
        $this->regDate = htmlspecialchars(strip_tags($this->regDate));
        $this->ModifiedDate = date('Y-m-d H:i:s');

        $stmt->bindParam(":stuId", $this->stuId);
        $stmt->bindParam(":regId", $this->regId);
        $stmt->bindParam(":regAtt", $this->regAtt);
        $stmt->bindParam(":subId", $this->subId);
        $stmt->bindParam(":regDate", $this->regDate);
        $stmt->bindParam(":ModifiedDate", $this->ModifiedDate);

        if ($stmt->execute()) {
            $this->attId = $this->conn->lastInsertId();
            return true;
        }

        error_log("Error creating attendance record: " . implode(" ", $stmt->errorInfo()));
        return false;
    }

    /**
     * Reads all attendance records for a specific registration.
     * @param int $regId The registration ID.
     * @return array An array of attendance records.
     */
    public function readByRegistration($regId)
    {
        $query = "SELECT 
                    att.regAtt AS status,
                    att.regDate AS date,
                    sub.subjectName
                  FROM " . self::table_name . " AS att
                  INNER JOIN tblSubjects AS sub ON att.subId = sub.subId
                  WHERE att.regId = :regId
                  ORDER BY sub.subjectName, att.regDate";

        $stmt = $this->conn->prepare($query);
        $regId = intval(htmlspecialchars(strip_tags($regId)));
        $stmt->bindParam(":regId", $regId);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Updates an existing attendance record.
     * @return bool True on success, false on failure.
     */
    public function update()
    {
        $query = "UPDATE " . self::table_name . "
                    SET
                        regAtt = :regAtt,
                        regDate = :regDate,
                        subId = :subId,
                        ModofiedDate = :ModifiedDate
                    WHERE
                        attId = :attId";

        $stmt = $this->conn->prepare($query);

        $this->attId = intval(htmlspecialchars(strip_tags($this->attId)));
        $this->subId = intval(htmlspecialchars(strip_tags($this->subId)));
        $this->regAtt = htmlspecialchars(strip_tags($this->regAtt));
        $this->regDate = htmlspecialchars(strip_tags($this->regDate));
        $this->ModifiedDate = date('Y-m-d H:i:s');

        $stmt->bindParam(":attId", $this->attId);
        $stmt->bindParam(":regAtt", $this->regAtt);
        $stmt->bindParam(":subId", $this->subId);
        $stmt->bindParam(":regDate", $this->regDate);
        $stmt->bindParam(":ModifiedDate", $this->ModifiedDate);

        if ($stmt->execute()) {
            return true;
        }

        error_log("Error updating attendance record: " . implode(" ", $stmt->errorInfo()));
        return false;
    }
}