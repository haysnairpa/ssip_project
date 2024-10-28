<?php
// session_start();
$is_logged_in = isset($_SESSION["user_id"]);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    <title>Uncle’s Warmination</title>
    <style>
        .mobile-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        .mobile-menu.active {
            max-height: 500px;
            transition: max-height 0.5s ease-in;
        }
        
        
        .mobile-menu a {
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
        
        .mobile-menu.active a {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Delay in each menu item */
        .mobile-menu a:nth-child(1) { transition-delay: 0.1s; }
        .mobile-menu a:nth-child(2) { transition-delay: 0.2s; }
        .mobile-menu a:nth-child(3) { transition-delay: 0.3s; }
        .mobile-menu a:nth-child(4) { transition-delay: 0.4s; }
        .mobile-menu a:nth-child(5) { transition-delay: 0.5s; }
    </style>
</head>
<body>
    <header class="fixed top-0 left-0 w-full bg-blue-500 shadow-md z-50">
        <nav class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <a href="landing.php" class="text-2xl font-bold text-white">Uncle’s Warmination</a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-6">
                    <a href="landing.php" class="text-white hover:text-gray-200 transition-colors duration-200">Home</a>
                    <?php if ($is_logged_in): ?>
                        <a href="menu.php" class="text-white hover:text-gray-200 transition-colors duration-200">Menu</a>
                        <a href="calender2.php" class="text-white hover:text-gray-200 transition-colors duration-200">Reserve</a>
                        <a href="cart.php" class="text-white hover:text-gray-200 transition-colors duration-200">Keranjang</a>
                        <a href="logout.php" class="text-white hover:text-gray-200 transition-colors duration-200">Keluar</a>
                    <?php else: ?>
                        <a href="login.php" class="text-white hover:text-gray-200 transition-colors duration-200">Login</a>
                        <a href="register.php" class="text-white hover:text-gray-200 transition-colors duration-200">Register</a>
                    <?php endif; ?>
                </div>

                <!-- Mobile Menu Button -->
                <button onclick="toggleMenu()" class="md:hidden text-white hover:text-gray-200 transition-colors duration-200">
                    <i class='bx bx-menu text-2xl'></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="mobile-menu md:hidden absolute top-full left-0 right-0 bg-blue-500 shadow-md">
                <div class="container mx-auto px-4 py-4 space-y-4">
                    <a href="landing.php" class="block text-white hover:text-gray-200 transition-colors duration-200">Home</a>
                    <?php if ($is_logged_in): ?>
                        <a href="menu.php" class="block text-white hover:text-gray-200 transition-colors duration-200">Menu</a>
                        <a href="calender2.php" class="block text-white hover:text-gray-200 transition-colors duration-200">Reserve</a>
                        <a href="cart.php" class="block text-white hover:text-gray-200 transition-colors duration-200">Keranjang</a>
                        <a href="logout.php" class="block text-white hover:text-gray-200 transition-colors duration-200">Keluar</a>
                    <?php else: ?>
                        <a href="login.php" class="block text-white hover:text-gray-200 transition-colors duration-200">Login</a>
                        <a href="register.php" class="block text-white hover:text-gray-200 transition-colors duration-200">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>

    <script>
        function toggleMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('active');
        }
    </script>
</body>
</html>
