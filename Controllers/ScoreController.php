<?php

namespace Controllers;

use Connections\Connection;
use Models\Score;

session_start();

require_once '../Connections/Connection.php';
require_once '../Models/Score.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['scores']) || !is_array($_POST['scores']) || empty($_POST['subject_id']) || empty($_POST['regDate'])) {
        $_SESSION['flash_message'] = 'Error: Invalid or incomplete data submitted. Please try again.';
        header('Location: ../Views/StudentScoreForm.php');
        exit();
    }

    $conn = Connection::getInstance();
    $score_model = new Score($conn);
    $scores_data = $_POST['scores'];
    $subject_id = intval($_POST['subject_id']);
    $record_date = $_POST['regDate'];
    $success_count = 0;
    $error_count = 0;

    foreach ($scores_data as $student_id => $score) {
        if ($score === '' || $score === null) {
            continue;
        }

        $student_id = intval($student_id);
        $score_value = floatval($score);

        try {
            $reg_stmt = $conn->prepare("SELECT regId FROM tblRegistrations WHERE stuId = :stuId ORDER BY regDate DESC, regId DESC LIMIT 1");
            $reg_stmt->bindParam(":stuId", $student_id);
            $reg_stmt->execute();

            if ($reg_stmt->rowCount() > 0) {
                $registration = $reg_stmt->fetch(\PDO::FETCH_ASSOC);

                $score_model->regId = $registration['regId'];
                $score_model->subId = $subject_id;
                $score_model->score = $score_value;
                $score_model->regDate = $record_date;

                if ($score_model->create()) {
                    $success_count++;
                } else {
                    $error_count++;
                }
            } else {
                $error_count++;
            }
        } catch (\Exception $e) {
            error_log("Score Submission Error: " . $e->getMessage());
            $error_count++;
        }
    }

    $_SESSION['flash_message'] = "Success! Scores submitted. Successful records: $success_count. Failed records: $error_count.";

    header('Location: ../Views/StudentScoreForm.php?generation_id=' . $_POST['generation_id'] . '&subject_id=' . $_POST['subject_id']);
    exit();
}
?>