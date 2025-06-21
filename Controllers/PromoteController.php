<?php
namespace Controllers;

use Connections\Connection;
use Models\Registration;
use Models\Semester;
use Models\Year;

session_start();

require_once '../Connections/Connection.php';
require_once '../Models/Registration.php';
require_once '../Models/Semester.php';
require_once '../Models/Year.php';

$redirect_location = '../Views/StudentPromoteForm.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_POST['stuId']) || empty($_POST['semester']) || empty($_POST['year'])) {
        $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Invalid registration data provided.'];
        header("Location: " . $redirect_location);
        exit();
    }

    try {
        $conn = Connection::getInstance();
        $registration = new Registration($conn);

        $semester_model = new Semester($conn);
        $semId = $semester_model->findIdByNumber($_POST['semester']);

        $year_model = new Year($conn);
        $yearId = $year_model->findIdByNumber($_POST['year']);

        if (!$semId || !$yearId) {
            throw new \Exception("Invalid semester or year number.");
        }

        $registration->stuId = intval($_POST['stuId']);
        $registration->semId = $semId;
        $registration->yearId = $yearId;
        $registration->regDate = date('Y-m-d H:i:s');

        if ($registration->exists()) {
            $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Student is already registered for this semester.'];
        } else {
            $registration->startDate = date('Y-m-d');
            $registration->endDate = date('Y-m-d', strtotime('+4 months'));

            if ($registration->create()) {
                $_SESSION['flash_message'] = ['type' => 'success', 'message' => 'Student successfully promoted to the next semester.'];
            } else {
                $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Failed to register student.'];
            }
        }
    } catch (\Exception $e) {
        $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()];
    }

    header("Location: " . $redirect_location);
    exit();
}