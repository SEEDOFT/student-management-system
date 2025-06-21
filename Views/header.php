<?php require_once __DIR__ . '/../Database/Credential.inc'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Management System</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<nav class="bg-white shadow-sm">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16">
      <div class="flex">
        <div class="flex-shrink-0 flex items-center">
          <a href="<?php echo BASE_URL; ?>index.php" class="text-xl font-bold text-gray-900">Student Management</a>
        </div>
      </div>
      <div class="hidden sm:ml-6 sm:flex sm:items-center sm:space-x-4">
        <a href="<?php echo BASE_URL; ?>index.php"
          class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100">Home</a>
        <a href="<?php echo BASE_URL; ?>Views/StudentPromoteForm.php"
          class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100">Promote</a>
        <a href="<?php echo BASE_URL; ?>Views/StudentRegisterForm.php"
          class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100">Registration</a>
        <a href="<?php echo BASE_URL; ?>Views/StudentAttendanceForm.php"
          class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100">Attendance</a>
        <a href="<?php echo BASE_URL; ?>Views/StudentScoreForm.php"
          class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100">Scores</a>
      </div>
      <div class="-mr-2 flex items-center sm:hidden">
        <button type="button" id="mobile-menu-button"
          class="bg-white inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
          aria-controls="mobile-menu" aria-expanded="false">
          <span class="sr-only">Open main menu</span>
          <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
          <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>
  </div>

  <div class="sm:hidden hidden" id="mobile-menu">
    <div class="pt-2 pb-3 space-y-1">
      <a href="../index.php"
        class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800">Home</a>
      <a href="Views/StudentRegisterForm.php"
        class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800">Registration</a>
      <a href="StudentAttendance.php"
        class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800">Attendance</a>
      <a href="StudentScoreForm.php"
        class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800">Scores</a>
    </div>
  </div>
</nav>

<div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8">
</div>

</body>