<?php

namespace Controllers;

use Connections\Connection;
use Models\Registration;

session_start();

require_once '../Connections/Connection.php';
require_once '../Models/Registration.php';

$redirect_location = '../Views/SemesterRegistrationForm.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['stuId']) || empty($_POST['semId']) || empty($_POST['yearId']) || empty($_POST['startDate']) || empty($_POST['endDate'])) {
        $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'All fields are required.'];
        header("Location: " . $redirect_location);
        exit();
    }

    $conn = Connection::getInstance();
    $registration = new Registration($conn);

    $registration->stuId = intval($_POST['stuId']);
    $registration->semId = intval($_POST['semId']);
    $registration->yearId = intval($_POST['yearId']);

    if ($registration->exists()) {
        $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'This student is already registered for the selected semester and year.'];
        header("Location: " . $redirect_location);
        exit();
    }

    $registration->startDate = $_POST['startDate'];
    $registration->endDate = $_POST['endDate'];

    if ($registration->create()) {
        $_SESSION['flash_message'] = ['type' => 'success', 'message' => 'Student successfully registered for the semester.'];
    } else {
        $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Failed to register student for the semester.'];
    }

    header("Location: " . $redirect_location);
    exit();
}
?>