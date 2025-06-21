<?php
session_start();

use Connections\Connection;
use Models\Faculty;
use Models\Semester;
use Models\Year;
use Models\Generation;
use Models\StudyGroup;

require_once '../Models/Faculty.php';
require_once '../Models/Semester.php';
require_once '../Models/Year.php';
require_once '../Models/Generation.php';
require_once '../Models/StudyGroup.php';
require_once '../Connections/Connection.php';
require_once 'header.php';

$conn = Connection::getInstance();

$fac_model = new Faculty($conn);
$facData = $fac_model->readAll();

$semester_model = new Semester($conn);
$semesterData = $semester_model->readAll();

$year_model = new Year($conn);
$yearData = $year_model->readAll();

$generation_model = new Generation($conn);
$genData = $generation_model->readAll();

$group_model = new StudyGroup($conn);
$groupData = $group_model->readAll();

?>
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
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-8 py-6">
        <h2 class="text-2xl font-bold text-white">Student Registration</h2>
        <p class="text-sm text-blue-100 mt-1">Please fill out the form below to register a new student.</p>
    </div>

    <div class="p-8">
        <form action="../Controllers/RegistrationController.php" method="post">
            <div class="space-y-8">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Personal Information</h3>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                        <div>
                            <label for="stuName" class="block text-sm font-medium text-gray-700 mb-1">Full
                                Name</label>
                            <input type="text" id="stuName" name="stuName"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                            <select id="gender" name="gender"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div>
                            <label for="dob" class="block text-sm font-medium text-gray-700 mb-1">Date of
                                Birth</label>
                            <input type="date" id="dob" name="dob"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                        <div>
                            <label for="pob" class="block text-sm font-medium text-gray-700 mb-1">Place of
                                Birth</label>
                            <input type="text" id="pob" name="pob"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-8">
                    <h3 class="text-lg font-medium text-gray-900">Contact Information</h3>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Contact
                                Number</label>
                            <input type="tel" id="phone" name="phone"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email
                                Address</label>
                            <input type="email" id="email" name="email"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                            <textarea id="address" name="address" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required></textarea>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-8">
                    <h3 class="text-lg font-medium text-gray-900">Academic & Initial Semester Information</h3>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <label for="facId" class="block text-sm font-medium text-gray-700 mb-1">Faculty</label>
                            <select id="facId" name="facId"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                                <option value="" disabled selected>Select a faculty</option>
                                <?php foreach ($facData as $faculty): ?>
                                    <option value="<?php echo htmlspecialchars($faculty['facId']); ?>">
                                        <?php echo htmlspecialchars($faculty['facultyName']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label for="genId" class="block text-sm font-medium text-gray-700 mb-1">Generation</label>
                            <select id="genId" name="genId"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                                <option value="" disabled selected>Select a generation</option>
                                <?php foreach ($genData as $gen): ?>
                                    <option value="<?php echo htmlspecialchars($gen['genId']); ?>">
                                        <?php echo htmlspecialchars($gen['Generation']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label for="gId" class="block text-sm font-medium text-gray-700 mb-1">Study Group</label>
                            <select id="gId" name="gId"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                                <option value="" disabled selected>Select a group</option>
                                <?php foreach ($groupData as $group): ?>
                                    <option value="<?php echo htmlspecialchars($group['gId']); ?>">
                                        <?php echo htmlspecialchars($group['StudyGroup']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label for="semId" class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                            <select id="semId" name="semId"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                                <option value="" disabled selected>Select a semester</option>
                                <?php foreach ($semesterData as $semester): ?>
                                    <option value="<?php echo htmlspecialchars($semester['semId']); ?>">
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
                                <option value="" disabled selected>Select a year</option>
                                <?php foreach ($yearData as $year): ?>
                                    <option value="<?php echo htmlspecialchars($year['yearId']); ?>">
                                        <?php echo htmlspecialchars($year['YearsS']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label for="startDate" class="block text-sm font-medium text-gray-700 mb-1">Start
                                Date</label>
                            <input type="date" id="startDate" name="startDate" value="<?php echo date('Y-m-d'); ?>"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                        <div>
                            <label for="endDate" class="block text-sm font-medium text-gray-700 mb-1">End Date
                                Date</label>
                            <input type="date" id="endDate" name="endDate"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end">
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-md shadow-sm hover:bg-blue-700">
                    Register Student
                </button>
            </div>
        </form>
    </div>
</div>

<?php
require_once 'footer.php';
?>