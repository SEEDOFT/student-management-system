<?php
namespace Controllers;

use Connections\Connection;
use Models\Student;

session_start();

require_once '../Connections/Connection.php';
require_once '../Models/Student.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    if (empty($_POST['stuId']) || !is_numeric($_POST['stuId'])) {
        $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Invalid Student ID.'];
        header("Location: ../index.php");
        exit();
    }

    $studentId = intval($_POST['stuId']);
    $redirect_location = "../Views/edit_student.php?id=" . $studentId;

    try {
        $conn = Connection::getInstance();

        $student = new Student($conn);
        $student->stuId = $studentId;
        $student->stuName = $_POST['stuName'];
        $student->gender = $_POST['gender'];
        $student->dob = $_POST['dob'];
        $student->pob = $_POST['pob'];
        $student->phone = $_POST['phone'];
        $student->email = $_POST['email'];
        $student->addr = $_POST['address'];

        if ($student->updatePersonalInfo()) {
            $_SESSION['flash_message'] = ['type' => 'success', 'message' => 'Student information updated successfully.'];
        } else {
            $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Failed to update student information.'];
        }

    } catch (\Exception $e) {
        $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()];
    }

    header("Location: " . $redirect_location);
    exit();
}
?>