<?php

namespace Views;

use Connections\Connection;
use Models\Student;
use Models\Semester;
use Models\Year;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../Connections/Connection.php';
require_once '../Models/Student.php';
require_once '../Models/Semester.php';
require_once '../Models/Year.php';
require_once 'header.php';

$conn = Connection::getInstance();

$student_model = new Student($conn);
$students = $student_model->readAll();

$semester_model = new Semester($conn);
$semesters = $semester_model->readAll();

$year_model = new Year($conn);
$years = $year_model->readAll();
?>

<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <?php
    if (isset($_SESSION['flash_message'])):
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

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6">
            <h2 class="text-2xl font-bold text-white">Semester Registration</h2>
            <p class="text-sm text-blue-100 mt-1">Register an existing student for a new semester and year.</p>
        </div>
        <div class="p-8">
            <form action="../Controllers/SemesterRegistrationController.php" method="POST">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="stuId" class="block text-sm font-medium text-gray-700 mb-1">Select Student</label>
                        <select id="stuId" name="stuId"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="">-- Choose a Student --</option>
                            <?php foreach ($students as $student): ?>
                                <option value="<?php echo $student['stuId']; ?>">
                                    <?php echo htmlspecialchars($student['stuName']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label for="semId" class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                        <select id="semId" name="semId"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="">-- Choose a Semester --</option>
                            <?php foreach ($semesters as $semester): ?>
                                <option value="<?php echo $semester['semId']; ?>">
                                    <?php echo htmlspecialchars($semester['semester']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label for="yearId" class="block text-sm font-medium text-gray-700 mb-1">Year</label>
                        <select id="yearId" name="yearId"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="">-- Choose a Year --</option>
                            <?php foreach ($years as $year): ?>
                                <option value="<?php echo $year['yearId']; ?>">
                                    <?php echo htmlspecialchars($year['YearsS']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label for="startDate" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                        <input type="date" id="startDate" name="startDate" value="<?php echo date('Y-m-d'); ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>
                    <div>
                        <label for="endDate" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                        <input type="date" id="endDate" name="endDate"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end">
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-md shadow-sm hover:bg-blue-700">Register
                        for Semester</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require_once 'footer.php';
?>