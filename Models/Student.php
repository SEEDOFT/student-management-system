<?php

namespace Models;

class Student
{
    private $conn;
    private const table_name = "tblStudents"; // Using the actual table name
    public int $stuId;
    public string $stuName;
    public string $gender;
    public string $dob;
    public string $pob;
    public string $phone; // Changed to string to support various formats
    public string $email;
    public string $addr;
    public int $facId;
    public int $genId;
    public int $gId;
    public string $regDate;
    public string $modifiedDate;

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
        $query = "INSERT INTO " . self::table_name . " SET stuName=:stuName, gender=:gender, " .
            "dob=:dob, pob=:pob, phone=:phone, email=:email, address=:address, " .
            "facId=:facId, gId=:gId, genId=:genId, regDate=:regDate, modifiedDate=:modifiedDate";

        $stmt = $this->conn->prepare($query);

        $this->stuName = htmlspecialchars(strip_tags($this->stuName));
        $this->gender = htmlspecialchars(strip_tags($this->gender));
        $this->dob = htmlspecialchars(strip_tags($this->dob));
        $this->pob = htmlspecialchars(strip_tags($this->pob));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->addr = htmlspecialchars(strip_tags($this->addr));
        $this->facId = intval(htmlspecialchars(strip_tags($this->facId)));
        $this->gId = intval(htmlspecialchars(strip_tags($this->gId)));
        $this->genId = intval(htmlspecialchars(strip_tags($this->genId)));
        $this->regDate = htmlspecialchars(strip_tags($this->regDate));
        $this->modifiedDate = date('Y-m-d H:i:s');

        $stmt->bindParam(":stuName", $this->stuName);
        $stmt->bindParam(":gender", $this->gender);
        $stmt->bindParam(":dob", $this->dob);
        $stmt->bindParam(":pob", $this->pob);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":address", $this->addr);
        $stmt->bindParam(":facId", $this->facId);
        $stmt->bindParam(":gId", $this->gId);
        $stmt->bindParam(":genId", $this->genId);
        $stmt->bindParam(":regDate", $this->regDate);
        $stmt->bindParam(":modifiedDate", $this->modifiedDate);

        if ($stmt->execute()) {
            $this->stuId = $this->conn->lastInsertId();
            return true;
        }

        error_log("Error creating student: " . implode(" ", $stmt->errorInfo()));
        return false;
    }

    /**
     * Summary of readAll
     */
    public function readAll()
    {
        $query = "SELECT * FROM " . self::table_name . " ORDER BY stuId ASC";
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
        $query = "SELECT * FROM " . self::table_name . " WHERE stuId = :stuId LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':stuId', $this->stuId);
        $stmt->execute();

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($row) {
            $this->stuName = $row['stuName'];
            $this->gender = $row['gender'];
            $this->dob = $row['dob'];
            $this->pob = $row['pob'];
            $this->phone = $row['phone'];
            $this->email = $row['email'];
            $this->addr = $row['address'];
            $this->facId = $row['facId'];
            $this->gId = $row['gId'];
            $this->genId = $row['genId'];
            $this->regDate = $row['regDate'];
            $this->modifiedDate = $row['ModifiedDate'];
        }
    }

    /**
     * Summary of update
     * @return bool
     */
    public function update()
    {
        $query = "UPDATE " . self::table_name . " SET stuName=:stuName, gender=:gender, dob=:dob, pob=:pob, phone=:phone, " .
            "email=:email, address=:address, facId=:facId, gId=:gId, genId=:genId, ModifiedDate=:modifiedDate WHERE stuId = :stuId";

        $stmt = $this->conn->prepare($query);

        $this->stuName = htmlspecialchars(strip_tags($this->stuName));
        $this->gender = htmlspecialchars(strip_tags($this->gender));
        $this->dob = htmlspecialchars(strip_tags($this->dob));
        $this->pob = htmlspecialchars(strip_tags($this->pob));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->addr = htmlspecialchars(strip_tags($this->addr));
        $this->facId = intval(htmlspecialchars(strip_tags($this->facId)));
        $this->gId = intval(htmlspecialchars(strip_tags($this->gId)));
        $this->genId = intval(htmlspecialchars(strip_tags($this->genId)));
        $this->stuId = intval(htmlspecialchars(strip_tags($this->stuId)));
        $this->modifiedDate = date('Y-m-d H:i:s');

        $stmt->bindParam(":stuName", $this->stuName);
        $stmt->bindParam(":gender", $this->gender);
        $stmt->bindParam(":dob", $this->dob);
        $stmt->bindParam(":pob", $this->pob);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":address", $this->addr);
        $stmt->bindParam(":facId", $this->facId);
        $stmt->bindParam(":gId", $this->gId);
        $stmt->bindParam(":genId", $this->genId);
        $stmt->bindParam(":modifiedDate", $this->modifiedDate);
        $stmt->bindParam(":stuId", $this->stuId);

        if ($stmt->execute()) {
            return true;
        }

        error_log("Error updating student: " . implode(" ", $stmt->errorInfo()));
        return false;
    }

    /**
     * Updates an existing student's personal information only.
     * Academic information (faculty, generation, group) is not changed.
     * @return bool True on success, false on failure.
     */
    public function updatePersonalInfo()
    {
        $query = "UPDATE " . self::table_name . "
                    SET
                        stuName = :stuName,
                        gender = :gender,
                        dob = :dob,
                        pob = :pob,
                        phone = :phone,
                        email = :email,
                        address = :address,
                        ModifiedDate = :modifiedDate
                    WHERE
                        stuId = :stuId";

        $stmt = $this->conn->prepare($query);

        $this->stuName = htmlspecialchars(strip_tags($this->stuName));
        $this->gender = htmlspecialchars(strip_tags($this->gender));
        $this->dob = htmlspecialchars(strip_tags($this->dob));
        $this->pob = htmlspecialchars(strip_tags($this->pob));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->addr = htmlspecialchars(strip_tags($this->addr));
        $this->stuId = intval(htmlspecialchars(strip_tags($this->stuId)));
        $this->modifiedDate = date('Y-m-d H:i:s');

        $stmt->bindParam(":stuName", $this->stuName);
        $stmt->bindParam(":gender", $this->gender);
        $stmt->bindParam(":dob", $this->dob);
        $stmt->bindParam(":pob", $this->pob);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":address", $this->addr);
        $stmt->bindParam(":modifiedDate", $this->modifiedDate);
        $stmt->bindParam(":stuId", $this->stuId);

        if ($stmt->execute()) {
            return true;
        }

        error_log("Error updating student personal info: " . implode(" ", $stmt->errorInfo()));
        return false;
    }

    /**
     * Summary of delete
     * @return bool
     */
    public function delete()
    {
        $query = "DELETE FROM " . self::table_name . " WHERE stuId = :stuId";
        $stmt = $this->conn->prepare($query);
        $this->stuId = intval(htmlspecialchars(strip_tags($this->stuId)));
        $stmt->bindParam(':stuId', $this->stuId);

        if ($stmt->execute()) {
            return true;
        }

        error_log("Error deleting student: " . implode(" ", $stmt->errorInfo()));
        return false;
    }

    /**
     * Reads a single student's full details by joining with related tables.
     * @return array|false An associative array of the student's details or false if not found.
     */
    public function readOneWithDetails()
    {
        $query = "SELECT
                    s.stuId, s.stuName, s.gender, s.dob, s.pob, s.phone, s.email, s.address, s.regDate AS student_reg_date,
                    f.facultyName, g.Generation, sg.StudyGroup
                  FROM " . self::table_name . " AS s
                  LEFT JOIN tblFaculties AS f ON s.facId = f.facId
                  LEFT JOIN tblGenerations AS g ON s.genId = g.genId
                  LEFT JOIN tblStudyGroups AS sg ON s.gId = sg.gId
                  WHERE s.stuId = :stuId
                  LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":stuId", $this->stuId);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Reads all scores for the current student.
     * @return array An array of the student's scores.
     */
    public function readScores()
    {
        $query = "SELECT sub.subjectName, sc.score, sem.semester, y.YearsS
                  FROM tblScores AS sc
                  JOIN tblRegistrations AS r ON sc.regId = r.regId
                  JOIN tblSubjects AS sub ON sc.subId = sub.subId
                  JOIN tblSemesters AS sem ON r.semId = sem.semId
                  JOIN tblYears AS y ON r.yearId = y.yearId
                  WHERE r.stuId = :stuId
                  ORDER BY y.YearsS DESC, sem.semester DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":stuId", $this->stuId);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Reads all attendance records for the current student.
     * @return array An array of the student's attendance records.
     */
    public function readAttendance()
    {
        $query = "SELECT att.regAtt AS status, att.regDate AS date
                  FROM tblAttendance AS att
                  JOIN tblRegistrations AS r ON att.regId = r.regId
                  WHERE r.stuId = :stuId
                  ORDER BY att.regDate DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":stuId", $this->stuId);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Summary of readByGeneration
     * @param mixed $genId
     */
    public function readByGeneration($genId)
    {
        $query = "SELECT stuId, stuName FROM " . self::table_name . " WHERE genId = :genId ORDER BY stuName ASC";

        $stmt = $this->conn->prepare($query);

        $genId = intval(htmlspecialchars(strip_tags($genId)));
        $stmt->bindParam(":genId", $genId);

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Summary of readByGenerationAndSemester
     * @param mixed $genId
     * @param mixed $semId
     */
    public function readByGenerationAndSemester($genId, $semId)
    {
        $query = "SELECT DISTINCT
                    s.stuId,
                    s.stuName
                  FROM " . self::table_name . " AS s
                  JOIN tblRegistrations AS r ON s.stuId = r.stuId
                  WHERE s.genId = :genId AND r.semId = :semId
                  ORDER BY s.stuName ASC";

        $stmt = $this->conn->prepare($query);

        $genId = intval(strip_tags($genId));
        $semId = intval(strip_tags($semId));

        $stmt->bindParam(":genId", $genId);
        $stmt->bindParam(":semId", $semId);

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Summary of readBySemesterAndYear
     * @param mixed $semId
     * @param mixed $yearId
     */
    public function readBySemesterAndYear($semId, $yearId)
    {
        $query = "SELECT DISTINCT s.stuId, s.stuName
                  FROM " . self::table_name . " AS s
                  JOIN tblRegistrations AS r ON s.stuId = r.stuId
                  WHERE r.semId = :semId AND r.yearId = :yearId
                  ORDER BY s.stuName ASC";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":semId", $semId);
        $stmt->bindParam(":yearId", $yearId);

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function readByFacultyAndRegistration($facId, $semId, $yearId)
    {
        // This query now correctly joins registrations AND filters by the student's primary faculty.
        $query = "SELECT DISTINCT s.stuId, s.stuName
                  FROM " . self::table_name . " AS s
                  JOIN tblRegistrations AS r ON s.stuId = r.stuId
                  WHERE s.facId = :facId AND r.semId = :semId AND r.yearId = :yearId
                  ORDER BY s.stuName ASC";

        $stmt = $this->conn->prepare($query);

        // Bind all three parameters for accurate filtering
        $stmt->bindParam(":facId", $facId);
        $stmt->bindParam(":semId", $semId);
        $stmt->bindParam(":yearId", $yearId);

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}