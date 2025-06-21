<?php
namespace Views;

use Connections\Connection;
use Models\Student;
use Models\Faculty;
use Models\Generation;
use Models\StudyGroup;
use Models\Registration;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../Connections/Connection.php';
require_once '../Models/Student.php';
require_once '../Models/Faculty.php';
require_once '../Models/Generation.php';
require_once '../Models/StudyGroup.php';
require_once '../Models/Registration.php';
require_once 'header.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8'><div class='bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md' role='alert'><p class='font-bold'>Error</p><p>No student ID provided.</p></div></div>";
    require_once '../footer.php';
    exit();
}

$studentId = intval($_GET['id']);
$conn = Connection::getInstance();

$student = new Student($conn);
$student->stuId = $studentId;
$student->readOne();

if (empty($student->stuName)) {
    echo "<div class='max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8'><div class='bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md' role='alert'><p class='font-bold'>Error</p><p>Student not found.</p></div></div>";
    require_once '../footer.php';
    exit();
}

$faculty_model = new Faculty($conn);
$faculties = $faculty_model->readAll();
$generation_model = new Generation($conn);
$generations = $generation_model->readAll();
$group_model = new StudyGroup($conn);
$groups = $group_model->readAll();

$registration_check = new Registration($conn);
$registration_check->stuId = $studentId;
$has_registrations = $registration_check->countByStudent() > 0;
$academic_info_disabled = $has_registrations ? 'disabled' : '';
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

    <form action="../Controllers/UpdateController.php" method="post">
        <input type="hidden" name="stuId" value="<?php echo $student->stuId; ?>">

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-8 py-6">
                <h2 class="text-2xl font-bold text-white">Edit Student Information</h2>
                <p class="text-sm text-blue-100 mt-1">Update the core details for
                    <?php echo htmlspecialchars($student->stuName); ?>.
                </p>
            </div>
            <div class="p-8 space-y-8">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Personal Information</h3>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div><label for="stuName" class="block text-sm font-medium text-gray-700">Full
                                Name</label><input type="text" id="stuName" name="stuName"
                                value="<?php echo htmlspecialchars($student->stuName); ?>"
                                class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md" required></div>
                        <div><label for="gender" class="block text-sm font-medium text-gray-700">Gender</label><select
                                id="gender" name="gender"
                                class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md" required>
                                <option value="Male" <?php echo ($student->gender === 'Male') ? 'selected' : ''; ?>>Male
                                </option>
                                <option value="Female" <?php echo ($student->gender === 'Female') ? 'selected' : ''; ?>>
                                    Female</option>
                            </select></div>
                        <div><label for="dob" class="block text-sm font-medium text-gray-700">Date of
                                Birth</label><input type="date" id="dob" name="dob"
                                value="<?php echo htmlspecialchars($student->dob); ?>"
                                class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md" required></div>
                        <div><label for="pob" class="block text-sm font-medium text-gray-700">Place of
                                Birth</label><input type="text" id="pob" name="pob"
                                value="<?php echo htmlspecialchars($student->pob); ?>"
                                class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md" required></div>
                        <div><label for="phone" class="block text-sm font-medium text-gray-700">Phone
                                Number</label><input type="text" id="phone" name="phone"
                                value="<?php echo htmlspecialchars($student->phone); ?>"
                                class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md" required></div>
                        <div><label for="email" class="block text-sm font-medium text-gray-700">Email </label><input
                                type="text" id="email" name="email"
                                value="<?php echo htmlspecialchars($student->email); ?>"
                                class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md" required></div>
                        <div class="md:col-span-2"><label for="address"
                                class="block text-sm font-medium text-gray-700">Address</label><textarea id="address"
                                name="address" rows="3" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md"
                                required><?php echo htmlspecialchars($student->addr); ?></textarea></div>
                    </div>
                </div>
            </div>
            <div class="p-6 bg-gray-50 border-t flex justify-end">
                <button type="submit"
                    class="px-8 py-3 bg-blue-600 text-white font-bold rounded-md shadow-lg hover:bg-blue-700">
                    Update Student Info
                </button>
            </div>
        </div>
    </form>
</div>

<?php
require_once 'footer.php';
?>