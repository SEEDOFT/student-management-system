<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use Connections\Connection;
use Models\Faculty;
use Models\Year;
use Models\Semester;
use Models\Student;
use Models\Subject;

require_once '../Connections/Connection.php';
require_once '../Models/Faculty.php';
require_once '../Models/Year.php';
require_once '../Models/Semester.php';
require_once '../Models/Student.php';
require_once '../Models/Subject.php';
require_once 'header.php';

$conn = Connection::getInstance();

$faculty_model = new Faculty($conn);
$faculties = $faculty_model->readAll();
$year_model = new Year($conn);
$years = $year_model->readAll();
$semester_model = new Semester($conn);
$semesters = $semester_model->readAll();

$selected_fac_id = isset($_GET['faculty_id']) ? intval($_GET['faculty_id']) : 0;
$selected_year_id = isset($_GET['year_id']) ? intval($_GET['year_id']) : 0;
$selected_sem_id = isset($_GET['semester_id']) ? intval($_GET['semester_id']) : 0;
$selected_sub_id = isset($_GET['subject_id']) ? intval($_GET['subject_id']) : 0;

$subjects = [];
$students = [];
$subject_name = '';

if ($selected_fac_id > 0 && $selected_year_id > 0 && $selected_sem_id > 0) {
    $subject_model = new Subject($conn);
    $subjects = $subject_model->readByFacultyYearSemester($selected_fac_id, $selected_year_id, $selected_sem_id);
}

if ($selected_fac_id > 0 && $selected_year_id > 0 && $selected_sem_id > 0 && $selected_sub_id > 0) {
    $student_model = new Student($conn);
    $students = $student_model->readByFacultyAndRegistration($selected_fac_id, $selected_sem_id, $selected_year_id);

    $subject_model = new Subject($conn);
    $subject_model->subId = $selected_sub_id;
    $subject_model->readOne();
    $subject_name = $subject_model->subjectName;
}
?>
<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <?php
    if (isset($_SESSION['flash_message']) && is_array($_SESSION['flash_message'])):
        $flash = $_SESSION['flash_message'];
        $message_type = $flash['type'];
        $message_text = $flash['message'];

        $is_success = $message_type === 'success';
        $alert_bg_class = $is_success ? 'bg-green-100' : 'bg-red-100';
        $alert_border_class = $is_success ? 'border-green-500' : 'border-red-500';
        $alert_text_class = $is_success ? 'text-green-700' : 'text-red-700';
        $alert_title = $is_success ? 'Success' : 'Error';
        ?>
        <div class="mb-6 <?php echo $alert_bg_class; ?> border-l-4 <?php echo $alert_border_class; ?> <?php echo $alert_text_class; ?> p-4 rounded-md"
            role="alert">
            <p class="font-bold"><?php echo $alert_title; ?></p>
            <p><?php echo $message_text; ?></p>
        </div>
        <?php
        unset($_SESSION['flash_message']);
    endif;
    ?>

    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6">
            <h2 class="text-2xl font-bold text-white">Student Attendance</h2>
            <p class="text-sm text-blue-100 mt-1">Select faculty, year, and semester to find a class and take
                attendance.</p>
        </div>
        <div class="p-6">
            <form action="StudentAttendanceForm.php" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="faculty_id" class="block text-sm font-medium text-gray-700">Faculty</label>
                        <select id="faculty_id" name="faculty_id" class="mt-1 w-full px-3 py-2 border rounded-md"
                            required>
                            <option value="">-- Choose --</option>
                            <?php foreach ($faculties as $fac): ?>
                                <option value="<?php echo $fac['facId']; ?>" <?php echo ($selected_fac_id == $fac['facId']) ? 'selected' : ''; ?>><?php echo $fac['facultyName']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="year_id" class="block text-sm font-medium text-gray-700">Year</label>
                        <select id="year_id" name="year_id" class="mt-1 w-full px-3 py-2 border rounded-md" required>
                            <option value="">-- Choose --</option>
                            <?php foreach ($years as $year): ?>
                                <option value="<?php echo $year['yearId']; ?>" <?php echo ($selected_year_id == $year['yearId']) ? 'selected' : ''; ?>>
                                    <?php echo $year['YearsS']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="semester_id" class="block text-sm font-medium text-gray-700">Semester</label>
                        <select id="semester_id" name="semester_id" class="mt-1 w-full px-3 py-2 border rounded-md"
                            required>
                            <option value="">-- Choose --</option>
                            <?php foreach ($semesters as $sem): ?>
                                <option value="<?php echo $sem['semId']; ?>" <?php echo ($selected_sem_id == $sem['semId']) ? 'selected' : ''; ?>><?php echo $sem['semester']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <?php if (!empty($subjects)): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end pt-4 border-t mt-4">
                        <div>
                            <label for="subject_id" class="block text-sm font-medium text-gray-700">Subject</label>
                            <select id="subject_id" name="subject_id" class="mt-1 w-full px-3 py-2 border rounded-md"
                                required>
                                <option value="">-- Choose Subject --</option>
                                <?php foreach ($subjects as $sub): ?>
                                    <option value="<?php echo $sub['subId']; ?>" <?php echo ($selected_sub_id == $sub['subId']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($sub['subjectName']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="w-full px-6 py-2 bg-blue-600 text-white rounded-md shadow-sm">Load
                                Students</button>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="pt-4 border-t mt-4">
                        <button type="submit"
                            class="w-full md:w-auto px-6 py-2 bg-gray-600 text-white rounded-md shadow-sm">Find
                            Subjects</button>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <?php if (!empty($students) && $selected_sub_id > 0): ?>
        <div class="bg-white rounded-lg shadow-md mt-8">
            <form action="../Controllers/AttendanceController.php" method="POST">
                <input type="hidden" name="subject_id" value="<?php echo $selected_sub_id; ?>">
                <input type="hidden" name="faculty_id" value="<?php echo $selected_fac_id; ?>">
                <input type="hidden" name="year_id" value="<?php echo $selected_year_id; ?>">
                <input type="hidden" name="semester_id" value="<?php echo $selected_sem_id; ?>">

                <div class="p-6 border-b flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800">Attendance for: <span
                            class="text-blue-600"><?php echo htmlspecialchars($subject_name); ?></span></h3>
                    <div>
                        <label for="attendance_date" class="sr-only">Attendance Date</label>
                        <input type="date" name="attendance_date" value="<?php echo date('Y-m-d'); ?>"
                            class="px-3 py-2 border rounded-md">
                    </div>
                </div>

                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="py-3.5 pl-6 pr-3 text-left text-sm font-semibold text-gray-900">Student Name</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($students as $student): ?>
                            <tr>
                                <td class="py-4 pl-6 pr-3 text-sm font-medium text-gray-900">
                                    <?php echo htmlspecialchars($student['stuName']); ?>
                                </td>
                                <td class="px-3 py-4 text-sm">
                                    <div class="flex items-center space-x-4">
                                        <label><input type="radio" name="attendance[<?php echo $student['stuId']; ?>]"
                                                value="Present" checked> Present</label>
                                        <label><input type="radio" name="attendance[<?php echo $student['stuId']; ?>]"
                                                value="Absent"> Absent</label>
                                        <label><input type="radio" name="attendance[<?php echo $student['stuId']; ?>]"
                                                value="Late"> Late</label>
                                        <label><input type="radio" name="attendance[<?php echo $student['stuId']; ?>]"
                                                value="Excused"> Excused</label>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="p-6 bg-gray-50 border-t flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-md shadow-sm">Submit
                        Attendance</button>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'footer.php'; ?>