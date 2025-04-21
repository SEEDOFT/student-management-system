<?php
class Students {
    private $conn;
    private $tblName = "tblstudents";
    
    public $stuId;
    public $stuName;
    public $gender;
    public $dob;
    public $pob;
    public $phone;
    public $email;
    public $addr;
    public $facId;
    public $genId;
    public $gId;
    public $regDate;
    public $ModifiedDate;

    public function __construct($db) {
        $this->conn = $db;
    }
    public function StuAddNew() {

        $query = "INSERT INTO " . $this->tblName . " SET StuName=:stuName, Gender=:gender, 
                    DOB=:dob, POB=:pob, Phone=:phone, Email=:email, Addr=:addr, 
                    FacId=:facId, GenId=:genId, RegDate=:regDate";
        $cmd = $this->conn->prepare($query);
        
        // Sanitize input
        $this->stuName = htmlspecialchars(strip_tags($this->stuName));
        $this->gender = htmlspecialchars(strip_tags($this->gender));
        $this->dob = htmlspecialchars(strip_tags($this->dob));
        $this->pob = htmlspecialchars(strip_tags($this->pob));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->addr = htmlspecialchars(strip_tags($this->addr));
        $this->facId = htmlspecialchars(strip_tags($this->facId));
        $this->genId = htmlspecialchars(strip_tags($this->genId));
        $this->regDate = htmlspecialchars(strip_tags($this->regDate));
        
        // Bind parameters
        $cmd->bindParam(":stuName", $this->stuName);
        $cmd->bindParam(":gender", $this->gender);
        $cmd->bindParam(":dob", $this->dob);
        $cmd->bindParam(":pob", $this->pob);
        $cmd->bindParam(":phone", $this->phone);
        $cmd->bindParam(":email", $this->email);
        $cmd->bindParam(":addr", $this->addr);
        $cmd->bindParam(":facId", $this->facId);
        $cmd->bindParam(":genId", $this->genId);
        $cmd->bindParam(":regDate", $this->regDate);
              
        if($cmd->execute()) {
            return true;
        }
        return false;
        //print_r($cmd->errorInfo()); // To See What ERROR
    }
}
?>