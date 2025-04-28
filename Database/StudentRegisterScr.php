<?php
require_once "DBClass.php";
require_once "StudentClass.php";
require_once "RegisterClass.php";
//Conncet to Database
$conn1 = new Database();
$conn = $conn1->getConnection();
// End Connect to Database

$student = new Students($conn);
$registration = new StuRegistration($conn);

//New Student .................................................//
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // First create student
    $student->stuName = $_POST['txtStuName'];
    $student->gender = $_POST['stuGender'];
    $student->dob = $_POST['stuDOB'];
    $student->pob = $_POST['stuPOB'];
    $student->phone = $_POST['txtPhone'];
    $student->email = $_POST['email'];
    $student->addr = $_POST['stuAddr'];
    $student->facId = $_POST['cboFaculty'];
    $student->genId = $_POST['cboGeneration'];
    $student->regDate = date('Y-m-d');

    if ($student->StuAddNew()) {
        $registration->stuId = $conn->lastInsertId();
        $registration->semId = $_POST['cboSemester'];
        $registration->yearId = $_POST['cboYear'];
        $registration->regDate = date('Y-m-d');

        if ($registration->StuRegisterNew()) {
            echo "<div class='alert alert-success'> Student registered successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'> Unable to register student.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Unable to create the new student.</div>";
    }
}
// End New Student 
?>