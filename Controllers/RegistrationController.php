<?php

namespace Controllers;

use Models\Student;
use Connections\Connection;
use Models\Registration;

session_start();

require_once '../Connections/Connection.php';
require_once '../Models/Student.php';
require_once '../Models/Registration.php';

$redirect_location = "../Views/StudentRegisterForm.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    try {
        $conn = Connection::getInstance();
        $student = new Student($conn);
        $registration = new Registration($conn);

        $errors = [];

        if (empty($_POST['stuName']))
            $errors[] = "Student Name is required.";
        if (empty($_POST['gender']))
            $errors[] = "Gender is required.";
        if (empty($_POST['dob']))
            $errors[] = 'Date of birth is required';
        if (empty($_POST['pob']))
            $errors[] = 'Place of birth is required';
        if (empty($_POST['phone']))
            $errors[] = 'Phone number is required';
        if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
            $errors[] = "Valid Email is required.";
        if (empty($_POST['address']))
            $errors[] = 'Address is required';

        if (empty($_POST['facId']))
            $errors[] = "Faculty is required.";
        if (empty($_POST['genId']))
            $errors[] = "Generation is required.";
        if (empty($_POST['gId']))
            $errors[] = 'Study Group is required.';
        if (empty($_POST['semId']))
            $errors[] = "Semester is required.";
        if (empty($_POST['yearId']))
            $errors[] = "Year is required.";
        if (empty($_POST['startDate']))
            $errors[] = "Start Date is required.";

        if (!empty($errors)) {
            $_SESSION['flash_message'] = ['type' => 'error', 'message' => implode('<br>', $errors)];
            header("Location: " . $redirect_location);
            exit();
        }

        $student->stuName = $_POST['stuName'];
        $student->gender = $_POST['gender'];
        $student->dob = $_POST['dob'];
        $student->pob = $_POST['pob'];
        $student->phone = $_POST['phone'];
        $student->email = $_POST['email'];
        $student->addr = $_POST['address'];
        $student->facId = intval($_POST['facId']);
        $student->genId = intval($_POST['genId']);
        $student->gId = intval($_POST['gId']);
        $student->regDate = $_POST['startDate'];

        if (!$student->create()) {
            $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Failed to create the new student profile.'];
            header("Location: " . $redirect_location);
            exit();
        }

        $registration->stuId = $student->stuId;
        $registration->semId = intval($_POST['semId']);
        $registration->yearId = intval($_POST['yearId']);
        $registration->regDate = $_POST['startDate'];
        $registration->startDate = $_POST['startDate'];
        $registration->endDate = date('Y-m-d');

        if (!$registration->create()) {
            $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Student profile was created, but failed to create the initial semester registration.'];
            header("Location: " . $redirect_location);
            exit();
        }

        $_SESSION['flash_message'] = ['type' => 'success', 'message' => 'Student and initial semester registration created successfully!'];
        header("Location: " . $redirect_location);
        exit();

    } catch (\Exception $e) {
        $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'An unexpected error occurred: ' . $e->getMessage()];
        header("Location: " . $redirect_location);
        exit();
    }

} else {
    $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Invalid request method.'];
    header("Location: " . $redirect_location);
    exit();
}