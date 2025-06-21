</div>
</main>

<footer class="bg-gray-50">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 border-t border-gray-200">
        <p class="text-center text-sm text-gray-500">&copy; 2025 Student Management System. All rights reserved.</p>
    </div>
</footer>

<script>
    const menuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const openIcon = menuButton.querySelector('svg:first-of-type');
    const closeIcon = menuButton.querySelector('svg:last-of-type');

    menuButton.addEventListener('click', () => {
        const isMenuOpen = mobileMenu.classList.toggle('hidden');
        openIcon.classList.toggle('hidden', !isMenuOpen);
        closeIcon.classList.toggle('hidden', isMenuOpen);
    });
</script>

</body>

</html>