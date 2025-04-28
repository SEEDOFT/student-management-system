<?php
class StuRegistration
{
    private $conn;
    private $tblName = "tblRegistrations";

    public $regId;
    public $stuId;
    public $semId;
    public $yearId;
    public $regDate;
    public $ModifiedDate;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function StuRegisterNew()
    {

        $query = "INSERT INTO " . $this->tblName . " SET StuId=:stuId, SemId=:semId, YearId=:yearId, RegDate=:regDate";
        $cmd = $this->conn->prepare($query);

        // Sanitize input
        $this->stuId = htmlspecialchars(strip_tags($this->stuId));
        $this->semId = htmlspecialchars(strip_tags($this->semId));
        $this->yearId = htmlspecialchars(strip_tags($this->yearId));
        $this->regDate = htmlspecialchars(strip_tags($this->regDate));

        // Bind parameters
        $cmd->bindParam(":stuId", $this->stuId);
        $cmd->bindParam(":semId", $this->semId);
        $cmd->bindParam(":yearId", $this->yearId);
        $cmd->bindParam(":regDate", $this->regDate);

        if ($cmd->execute()) {
            return true;
        }
        return false;
        //print_r($cmd->errorInfo()); // To See What ERROR
    }
}
?>