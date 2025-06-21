<?php
namespace Views;

use Connections\Connection;
use Models\Student;
use Models\Registration;
use Models\Semester;
use Models\Year;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../Connections/Connection.php';
require_once '../Models/Student.php';
require_once '../Models/Registration.php';
require_once '../Models/Semester.php';
require_once '../Models/Year.php';
require_once 'header.php';

$conn = Connection::getInstance();

$student_model = new Student($conn);
$students = $student_model->readAll();

$registration_model = new Registration($conn);
$semester_model = new Semester($conn);
$year_model = new Year($conn);
$students_with_status = [];

foreach ($students as $student) {
    $registration_model->stuId = $student['stuId']; // Set student ID for model methods
    $latest_reg = $registration_model->readLatestByStudent($student['stuId']);

    $student['latest_registration'] = $latest_reg;
    $student['next_registration'] = null;
    $student['status'] = 'Ready for Promotion';

    if ($latest_reg) {
        $next_sem_num = $latest_reg['semester'] == 1 ? 2 : 1;
        $next_year_num = $latest_reg['semester'] == 1 ? $latest_reg['YearsS'] : $latest_reg['YearsS'] + 1;

        if ($next_year_num > 4) {
            $student['status'] = 'Completed';
        } else {
            // Check if student is already registered for the calculated next semester/year
            $next_sem_id = $semester_model->findIdByNumber($next_sem_num);
            $next_year_id = $year_model->findIdByNumber($next_year_num);

            if ($next_sem_id && $next_year_id) {
                $registration_model->semId = $next_sem_id;
                $registration_model->yearId = $next_year_id;
                if ($registration_model->exists()) {
                    $student['status'] = 'Up-to-date';
                } else {
                    $student['next_registration'] = ['semester' => $next_sem_num, 'year' => $next_year_num];
                }
            }
        }
    } else {
        $student['status'] = 'Not Registered';
    }
    $students_with_status[] = $student;
}
?>

<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">

    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6">
            <h2 class="text-2xl font-bold text-white">Promote Students to Next Semester</h2>
            <p class="text-sm text-blue-100 mt-1">Register students for their upcoming semester and year.</p>
        </div>
    </div>

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
        <div class="flow-root">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full align-middle">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th scope="col" class="py-3.5 pl-6 pr-3 text-left text-sm font-semibold text-gray-900">
                                    Student Name</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Current Status</th>
                                <th scope="col"
                                    class="relative py-3.5 pl-3 pr-6 text-right text-sm font-semibold text-gray-900">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <?php foreach ($students_with_status as $student): ?>
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-6 pr-3 text-sm font-medium text-gray-900">
                                        <?php echo htmlspecialchars($student['stuName']); ?>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <?php if (isset($student['latest_registration']['YearsS'])): ?>
                                            Year <?php echo $student['latest_registration']['YearsS']; ?>, Semester
                                            <?php echo $student['latest_registration']['semester']; ?>
                                        <?php else: ?>
                                            <span class="font-medium text-gray-800"><?php echo $student['status']; ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-6 text-right text-sm font-medium">
                                        <?php if ($student['status'] === 'Ready for Promotion' && $student['next_registration']): ?>
                                            <form action="../Controllers/PromoteController.php" method="POST">
                                                <input type="hidden" name="stuId" value="<?php echo $student['stuId']; ?>">
                                                <input type="hidden" name="semester"
                                                    value="<?php echo $student['next_registration']['semester']; ?>">
                                                <input type="hidden" name="year"
                                                    value="<?php echo $student['next_registration']['year']; ?>">
                                                <button type="submit" class="text-indigo-600 hover:text-indigo-900">
                                                    Promote to Y<?php echo $student['next_registration']['year']; ?>,
                                                    S<?php echo $student['next_registration']['semester']; ?> &rarr;
                                                </button>
                                            </form>
                                        <?php elseif ($student['status'] === 'Up-to-date'): ?>
                                            <span class="text-gray-500 font-semibold">Up-to-date</span>
                                        <?php else: ?>
                                            <span class="text-green-600 font-semibold"><?php echo $student['status']; ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once 'footer.php';
?>