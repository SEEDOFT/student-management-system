<?php
namespace Views;

use Models\Student;
use Models\Registration;
use Models\Score;
use Models\Attendance;
use Connections\Connection;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../Connections/Connection.php';
require_once '../Models/Student.php';
require_once '../Models/Registration.php';
require_once '../Models/Score.php';
require_once '../Models/Attendance.php';
require_once 'header.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8'><div class='bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md' role='alert'><p class='font-bold'>Error</p><p>No student ID provided or ID is invalid.</p></div></div>";
    require_once 'footer.php';
    exit();
}

$studentId = intval($_GET['id']);

try {
    $conn = Connection::getInstance();

    $student = new Student($conn);
    $student->stuId = $studentId;
    $student_details = $student->readOneWithDetails();

    if (!$student_details) {
        echo "<div class='max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8'><div class='bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md' role='alert'><p class='font-bold'>Not Found</p><p>No student found.</p></div></div>";
        require_once 'footer.php';
        exit();
    }

    $registration_model = new Registration($conn);
    $registration_model->stuId = $studentId;
    $registrations = $registration_model->readByStudent($studentId);

    $score_model = new Score($conn);
    $attendance_model = new Attendance($conn);

    foreach ($registrations as $key => $reg) {
        $registrations[$key]['scores'] = $score_model->readByRegistration($reg['regId']);
        $registrations[$key]['attendance'] = $attendance_model->readByRegistration($reg['regId']);
    }

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>

<div class="bg-gray-50">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-8">
                <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-6">
                    <div
                        class="w-24 h-24 bg-white bg-opacity-30 rounded-full flex items-center justify-center ring-4 ring-white ring-opacity-50">
                        <span
                            class="text-4xl font-bold text-white"><?php echo strtoupper(substr($student_details['stuName'], 0, 1)); ?></span>
                    </div>
                    <div class="text-center md:text-left">
                        <h1 class="text-3xl font-bold text-white">
                            <?php echo htmlspecialchars($student_details['stuName']); ?>
                        </h1>
                        <p class="text-blue-100 text-lg">
                            <?php echo htmlspecialchars($student_details['facultyName'] ?? 'N/A'); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1 space-y-8">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6 border-b">
                        <h3 class="text-lg font-semibold text-gray-800">Personal Details</h3>
                    </div>
                    <div class="p-6 space-y-4 text-sm">
                        <div class="flex items-center"><svg class="w-5 h-5 text-gray-400 mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg><span class="text-gray-600 font-medium mr-2">Gender:</span><span
                                class="text-gray-800"><?php echo htmlspecialchars($student_details['gender']); ?></span>
                        </div>
                        <div class="flex items-center"><svg class="w-5 h-5 text-gray-400 mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4m-6 8h4m-4-4h4m-4-4h4m-10 8h12a1 1 0 001-1V7a1 1 0 00-1-1H5a1 1 0 00-1 1v12a1 1 0 001 1z" />
                            </svg><span class="text-gray-600 font-medium mr-2">Birthday:</span><span
                                class="text-gray-800"><?php echo date('F j, Y', strtotime($student_details['dob'])); ?></span>
                        </div>
                        <div class="flex items-start"><svg class="w-5 h-5 text-gray-400 mr-3 mt-1 flex-shrink-0"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg><span class="text-gray-600 font-medium mr-2">Birthplace:</span><span
                                class="text-gray-800"><?php echo htmlspecialchars($student_details['pob']); ?></span>
                        </div>
                        <div class="flex items-start"><svg class="w-5 h-5 text-gray-400 mr-3 mt-1 flex-shrink-0"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg><span class="text-gray-600 font-medium mr-2">Address:</span><span
                                class="text-gray-800"><?php echo htmlspecialchars($student_details['address']); ?></span>
                        </div>
                    </div>
                    <div class="border-t p-6 space-y-4 text-sm">
                        <div class="flex items-center"><svg class="w-5 h-5 text-gray-400 mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg><span class="text-gray-600 font-medium mr-2">Phone:</span><span
                                class="text-gray-800"><?php echo htmlspecialchars($student_details['phone']); ?></span>
                        </div>
                        <div class="flex items-center"><svg class="w-5 h-5 text-gray-400 mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg><span class="text-gray-600 font-medium mr-2">Email:</span><span
                                class="text-gray-800 truncate"><?php echo htmlspecialchars($student_details['email']); ?></span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6 border-b">
                        <h3 class="text-lg font-semibold text-gray-800">Primary Academic Info</h3>
                    </div>
                    <div class="p-6 space-y-4 text-sm">
                        <div class="flex items-center"><svg class="w-5 h-5 text-gray-400 mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path
                                    d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-9.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-9.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            </svg><span class="text-gray-600 font-medium mr-2">Faculty:</span><span
                                class="text-gray-800"><?php echo htmlspecialchars($student_details['facultyName'] ?? 'N/A'); ?></span>
                        </div>
                        <div class="flex items-center"><svg class="w-5 h-5 text-gray-400 mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg><span class="text-gray-600 font-medium mr-2">Generation:</span><span
                                class="text-gray-800"><?php echo htmlspecialchars($student_details['Generation'] ?? 'N/A'); ?></span>
                        </div>
                        <div class="flex items-center"><svg class="w-5 h-5 text-gray-400 mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg><span class="text-gray-600 font-medium mr-2">Group:</span><span
                                class="text-gray-800"><?php echo htmlspecialchars($student_details['StudyGroup'] ?? 'N/A'); ?></span>
                        </div>
                        <div class="flex items-center"><svg class="w-5 h-5 text-gray-400 mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4m-6 8h4m-4-4h4m-4-4h4m-10 8h12a1 1 0 001-1V7a1 1 0 00-1-1H5a1 1 0 00-1 1v12a1 1 0 001 1z" />
                            </svg><span class="text-gray-600 font-medium mr-2">Initially Registered:</span><span
                                class="text-gray-800"><?php echo date('F j, Y', strtotime($student_details['student_reg_date'])); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-4">
                <?php if (!empty($registrations)): ?>
                    <?php foreach ($registrations as $index => $reg): ?>
                        <div class="accordion-item bg-white rounded-lg shadow-md overflow-hidden">
                            <button class="accordion-header w-full flex justify-between items-center text-left p-6">
                                <span class="text-lg font-semibold text-gray-800">Semester
                                    <?php echo htmlspecialchars($reg['semester']); ?> - Year
                                    <?php echo htmlspecialchars($reg['YearsS']); ?></span>
                                <svg class="accordion-icon w-6 h-6 text-gray-500 transform transition-transform" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="accordion-content hidden border-t">
                                <div class="p-6 space-y-6">
                                    <div>
                                        <h4 class="font-semibold mb-4 text-gray-800">Scores</h4>
                                        <?php if (!empty($reg['scores'])): ?>
                                            <ul class="space-y-2">
                                                <?php foreach ($reg['scores'] as $score): ?>
                                                    <li
                                                        class="flex justify-between items-center text-sm p-2 bg-white rounded-md border">
                                                        <span><?php echo htmlspecialchars($score['subjectName']); ?></span>
                                                        <span
                                                            class="font-bold <?php echo $score['score'] >= 50 ? 'text-green-600' : 'text-red-600'; ?>"><?php echo htmlspecialchars($score['score']); ?></span>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else: ?>
                                            <p class="text-sm text-gray-500">No scores recorded for this semester.</p>
                                        <?php endif; ?>
                                    </div>

                                    <div class="border-t pt-6">
                                        <h4 class="font-semibold mb-4 text-gray-800">Attendance Summary</h4>
                                        <?php
                                        if (!empty($reg['attendance'])) {
                                            $attendance_by_subject = [];
                                            foreach ($reg['attendance'] as $att_record) {
                                                $subject = $att_record['subjectName'] ?? 'General';
                                                if (!isset($attendance_by_subject[$subject])) {
                                                    $attendance_by_subject[$subject] = [
                                                        'records' => [],
                                                        'stats' => ['Present' => 0, 'Absent' => 0, 'Late' => 0, 'Excused' => 0, 'Total' => 0]
                                                    ];
                                                }
                                                $attendance_by_subject[$subject]['records'][] = $att_record;
                                                $status = $att_record['status'];
                                                if (array_key_exists($status, $attendance_by_subject[$subject]['stats'])) {
                                                    $attendance_by_subject[$subject]['stats'][$status]++;
                                                }
                                                $attendance_by_subject[$subject]['stats']['Total']++;
                                            }

                                            echo '<div class="space-y-4">';
                                            foreach ($attendance_by_subject as $subject => $data) {
                                                $stats = $data['stats'];
                                                $present_percentage = ($stats['Total'] > 0) ? ($stats['Present'] + $stats['Late']) / $stats['Total'] * 100 : 0;
                                                ?>
                                                <div class="p-4 bg-gray-50 rounded-lg border">
                                                    <div class="flex justify-between items-center">
                                                        <p class="font-bold text-gray-700"><?php echo htmlspecialchars($subject); ?></p>
                                                        <button class="attendance-details-btn text-sm text-blue-600 hover:underline"
                                                            data-target="details-<?php echo $index . '-' . md5($subject); ?>">Details</button>
                                                    </div>
                                                    <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                                                        <div class="bg-blue-600 h-2.5 rounded-full"
                                                            style="width: <?php echo $present_percentage; ?>%"></div>
                                                    </div>
                                                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 mt-2 text-xs">
                                                        <p><strong>Present:</strong> <?php echo $stats['Present']; ?></p>
                                                        <p><strong>Absent:</strong> <?php echo $stats['Absent']; ?></p>
                                                        <p><strong>Late:</strong> <?php echo $stats['Late']; ?></p>
                                                        <p><strong>Total:</strong> <?php echo $stats['Total']; ?></p>
                                                    </div>
                                                    <div id="details-<?php echo $index . '-' . md5($subject); ?>"
                                                        class="hidden mt-4 border-t pt-2 space-y-1">
                                                        <?php foreach ($data['records'] as $record): ?>
                                                            <div class="flex justify-between text-xs text-gray-600">
                                                                <span><?php echo date('M d, Y', strtotime($record['date'])); ?></span>
                                                                <span
                                                                    class="font-medium px-2 py-0.5 rounded-full <?php echo $record['status'] === 'Present' ? 'bg-green-100 text-green-800' : ($record['status'] === 'Absent' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800'); ?>"><?php echo htmlspecialchars($record['status']); ?></span>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            echo '</div>';
                                        } else {
                                            echo '<p class="text-sm text-gray-500">No attendance records for this semester.</p>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="bg-white rounded-lg shadow-md p-12 text-center">
                        <p class="text-gray-500">This student has no semester registration history.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.accordion-header').forEach(header => {
            header.addEventListener('click', () => {
                const content = header.nextElementSibling;
                const icon = header.querySelector('.accordion-icon');
                content.classList.toggle('hidden');
                icon.classList.toggle('rotate-180');
            });
        });

        document.querySelectorAll('.attendance-details-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                e.stopPropagation();
                const targetId = button.getAttribute('data-target');
                const targetDiv = document.getElementById(targetId);
                if (targetDiv) {
                    targetDiv.classList.toggle('hidden');
                    button.textContent = targetDiv.classList.contains('hidden') ? 'Details' : 'Hide';
                }
            });
        });
    });
</script>

<?php
require_once 'footer.php';
?>