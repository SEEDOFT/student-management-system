<?php
namespace Controllers;

use Connections\Connection;
use Models\Attendance;

session_start();

require_once '../Connections/Connection.php';
require_once '../Models/Attendance.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['attendance']) || !is_array($_POST['attendance']) || empty($_POST['attendance_date']) || empty($_POST['subject_id'])) {
        $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Invalid data submitted.'];
        header('Location: ../Views/StudentAttendanceForm.php');
        exit();
    }

    $conn = Connection::getInstance();
    $attendance_model = new Attendance($conn);
    $attendance_data = $_POST['attendance'];
    $attendance_date = $_POST['attendance_date'];
    $subject_id = intval($_POST['subject_id']);
    $semester_id = intval($_POST['semester_id']);
    $year_id = intval($_POST['year_id']);

    $success_count = 0;
    $error_count = 0;

    foreach ($attendance_data as $student_id => $status) {
        $student_id = intval($student_id);
        try {
            $reg_stmt = $conn->prepare("SELECT regId FROM tblRegistrations WHERE stuId = :stuId AND semId = :semId AND yearId = :yearId LIMIT 1");
            $reg_stmt->bindParam(":stuId", $student_id);
            $reg_stmt->bindParam(":semId", $semester_id);
            $reg_stmt->bindParam(":yearId", $year_id);
            $reg_stmt->execute();

            if ($reg_stmt->rowCount() > 0) {
                $registration = $reg_stmt->fetch(\PDO::FETCH_ASSOC);

                $attendance_model->stuId = $student_id;
                $attendance_model->regId = $registration['regId'];
                $attendance_model->subId = $subject_id;
                $attendance_model->regAtt = $status;
                $attendance_model->regDate = $attendance_date;

                if ($attendance_model->create()) {
                    $success_count++;
                } else {
                    $error_count++;
                }
            } else {
                $error_count++;
            }
        } catch (\Exception $e) {
            error_log("Attendance Submission Error: " . $e->getMessage());
            $error_count++;
        }
    }

    $_SESSION['flash_message'] = ['type' => 'success', 'message' => "Attendance submitted. Success: $success_count. Failures: $error_count."];

    $redirect_url = sprintf(
        "../Views/StudentAttendanceForm.php?faculty_id=%s&year_id=%s&semester_id=%s&subject_id=%s",
        urlencode($_POST['faculty_id']),
        urlencode($_POST['year_id']),
        urlencode($_POST['semester_id']),
        urlencode($_POST['subject_id'])
    );

    header("Location: " . $redirect_url);
    exit();
}
?>