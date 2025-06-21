<?php

use Connections\Connection;
use Models\Faculty;
use Models\Generation;
use Models\Student;
use Models\StudyGroup;

require_once 'Connections/Connection.php';
require_once 'Models/Faculty.php';
require_once 'Models/Year.php';
require_once 'Models/Student.php';
require_once 'Models/Generation.php';
require_once 'Models/StudyGroup.php';

$conn = Connection::getInstance();

$student = new Student($conn);
$students = $student->readAll();

$fac = new Faculty($conn);
$faculties = $fac->readAll();

$gen = new Generation($conn);
$gens = $gen->readAll();

$group = new StudyGroup($conn);
$groups = $group->readAll();

$facMap = array_column($faculties, 'facultyName', 'facId');
$genMap = array_column($gens, 'Generation', 'genId');
$groupMap = array_column($groups, 'StudyGroup', 'gId');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Directory</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <?php require_once 'Views/header.php' ?>
    <div class="bg-gray-50 min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-6 bg-white rounded-lg shadow-sm p-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Students</label>
                        <input type="text" id="search" placeholder="Search by name..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="facultyFilter" class="block text-sm font-medium text-gray-700 mb-2">Faculty</label>
                        <select id="facultyFilter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Faculties</option>
                            <?php foreach ($faculties as $faculty): ?>
                                <option value="<?php echo htmlspecialchars($faculty['facId']); ?>">
                                    <?php echo htmlspecialchars($faculty['facultyName']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="generationFilter"
                            class="block text-sm font-medium text-gray-700 mb-2">Generation</label>
                        <select id="generationFilter"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Generations</option>
                            <?php foreach ($gens as $generation): ?>
                                <option value="<?php echo htmlspecialchars($generation['genId']); ?>">
                                    <?php echo htmlspecialchars($generation['Generation']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button onclick="clearFilters()"
                            class="w-full px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                            Clear Filters
                        </button>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 rounded-lg mr-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Students</p>
                            <p class="text-2xl font-bold text-gray-900"><?php echo count($students); ?></p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-100 rounded-lg mr-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Faculties</p>
                            <p class="text-2xl font-bold text-gray-900"><?php echo count($faculties); ?></p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-purple-100 rounded-lg mr-3">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Study Groups</p>
                            <p class="text-2xl font-bold text-gray-900"><?php echo count($groups); ?></p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-orange-100 rounded-lg mr-3">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3a4 4 0 118 0v4m-4 7v4m0-4a4 4 0 11-8 0v4"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Generations</p>
                            <p class="text-2xl font-bold text-gray-900"><?php echo count($gens); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Student Cards Grid -->
            <div id="studentsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <?php foreach ($students as $stu): ?>
                    <div class="student-card bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200 overflow-hidden"
                        data-name="<?php echo strtolower(htmlspecialchars($stu['stuName'])); ?>"
                        data-faculty="<?php echo htmlspecialchars($stu['facId']); ?>"
                        data-generation="<?php echo htmlspecialchars($stu['genId']); ?>">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                            <div class="flex items-center">
                                <div
                                    class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-lg font-bold text-white">
                                        <?php echo strtoupper(substr($stu['stuName'], 0, 1)); ?>
                                    </span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-white truncate">
                                        <?php echo htmlspecialchars($stu['stuName']); ?>
                                    </h3>
                                    <p class="text-blue-100 text-sm">
                                        <?php echo htmlspecialchars($stu['gender']); ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="space-y-3 mb-4">
                                <div class="flex items-center text-sm">
                                    <svg class="w-4 h-4 text-gray-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3a4 4 0 118 0v4m-4 7v4m0-4a4 4 0 11-8 0v4"></path>
                                    </svg>
                                    <span class="text-gray-600"><?php echo date('M j, Y', strtotime($stu['dob'])); ?></span>
                                </div>

                                <div class="flex items-center text-sm">
                                    <svg class="w-4 h-4 text-gray-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="text-gray-600 truncate"><?php echo htmlspecialchars($stu['pob']); ?></span>
                                </div>
                            </div>

                            <div class="border-t pt-4 mb-4">
                                <div class="space-y-2">
                                    <div class="flex items-center text-sm">
                                        <svg class="w-4 h-4 text-gray-400 mr-2 flex-shrink-0" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                            </path>
                                        </svg>
                                        <span class="text-gray-600"><?php echo htmlspecialchars($stu['phone']); ?></span>
                                    </div>

                                    <div class="flex items-center text-sm">
                                        <svg class="w-4 h-4 text-gray-400 mr-2 flex-shrink-0" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span
                                            class="text-gray-600 truncate"><?php echo htmlspecialchars($stu['email']); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t pt-4 mb-4">
                                <div class="space-y-2">
                                    <div class="bg-blue-50 rounded-md p-2">
                                        <p class="text-xs text-blue-600 font-medium">Faculty</p>
                                        <p class="text-sm font-semibold text-blue-800 truncate">
                                            <?php echo htmlspecialchars($facMap[$stu['facId']] ?? 'N/A'); ?>
                                        </p>
                                    </div>

                                    <div class="grid grid-cols-2 gap-2">
                                        <div class="bg-green-50 rounded-md p-2">
                                            <p class="text-xs text-green-600 font-medium">Generation</p>
                                            <p class="text-sm font-semibold text-green-800">
                                                <?php echo htmlspecialchars($genMap[$stu['genId']] ?? 'N/A'); ?>
                                            </p>
                                        </div>

                                        <div class="bg-purple-50 rounded-md p-2">
                                            <p class="text-xs text-purple-600 font-medium">Group</p>
                                            <p class="text-sm font-semibold text-purple-800">
                                                <?php echo htmlspecialchars($groupMap[$stu['gId']] ?? 'N/A'); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t pt-4">
                                <div class="flex space-x-2">
                                    <button onclick="viewStudent(<?php echo $stu['stuId']; ?>)"
                                        class="flex-1 px-3 py-2 bg-blue-500 text-white text-sm rounded-md hover:bg-blue-600 transition-colors">
                                        View Details
                                    </button>
                                    <button onclick="editStudent(<?php echo $stu['stuId']; ?>)"
                                        class="flex-1 px-3 py-2 bg-gray-500 text-white text-sm rounded-md hover:bg-gray-600 transition-colors">
                                        Edit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div id="noResults" class="hidden text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c2.34 0 4.464-.896 6.065-2.365.34-.312.65-.651.914-1.014.22-.3.416-.617.579-.943.163-.326.295-.668.394-1.026.099-.358.151-.729.151-1.107 0-.378-.052-.749-.151-1.107a7.978 7.978 0 00-.394-1.026c-.163-.326-.359-.643-.579-.943-.264-.363-.574-.702-.914-1.014C16.464 3.896 14.34 3 12 3S7.536 3.896 5.935 5.365c-.34.312-.65.651-.914 1.014-.22.3-.416.617-.579.943-.099.358-.151.729-.151 1.107s.052.749.151 1.107c.099.358.231.7.394 1.026.163.326.359.643.579.943.264.363.574.702.914 1.014z">
                    </path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No students found</h3>
                <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter criteria.</p>
            </div>
        </div>
    </div>

    <?php require_once 'Views/footer.php'; ?>

    <script>
        function filterStudents() {
            const searchTerm = document.getElementById('search').value.toLowerCase();
            const facultyFilter = document.getElementById('facultyFilter').value;
            const generationFilter = document.getElementById('generationFilter').value;

            const studentCards = document.querySelectorAll('.student-card');
            let visibleCount = 0;

            studentCards.forEach(card => {
                const name = card.getAttribute('data-name');
                const faculty = card.getAttribute('data-faculty');
                const generation = card.getAttribute('data-generation');

                const matchesSearch = name.includes(searchTerm);
                const matchesFaculty = !facultyFilter || faculty === facultyFilter;
                const matchesGeneration = !generationFilter || generation === generationFilter;

                if (matchesSearch && matchesFaculty && matchesGeneration) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            const noResults = document.getElementById('noResults');
            if (visibleCount === 0) {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }
        }

        function clearFilters() {
            document.getElementById('search').value = '';
            document.getElementById('facultyFilter').value = '';
            document.getElementById('generationFilter').value = '';
            filterStudents();
        }

        function viewStudent(studentId) {
            window.location.href = `Views/student_detail.php?id=${studentId}`;
        }

        function editStudent(studentId) {
            window.location.href = `Views/edit_student.php?id=${studentId}`;
        }

        document.getElementById('search').addEventListener('input', filterStudents);
        document.getElementById('facultyFilter').addEventListener('change', filterStudents);
        document.getElementById('generationFilter').addEventListener('change', filterStudents);

        document.addEventListener('DOMContentLoaded', function () {
            const cards = document.querySelectorAll('.student-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 50);
            });
        });
    </script>
</body>

</html>