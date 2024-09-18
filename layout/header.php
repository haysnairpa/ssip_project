<?php
session_start();
$is_logged_in = isset($_SESSION["user_id"]);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <link rel="stylesheet" href="landing.css">

    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<title>Radatouli</title>
</head>
<body>

<header class="l-header">
    <nav class="nav bd-grid">
        <div>
            <a href="landing.php" class="nav__logo">Radatouli</a>
        </div>

        <div class="nav__menu" id="nav-menu">
            <ul class="nav__list">
                <li class="nav__item"><a href="landing.php" class="nav__link">Home</a></li>
                <?php if ($is_logged_in): ?>
                    <li class="nav__item"><a href="menu.php" class="nav__link">Menu</a></li>
                    <li class="nav__item"><a href="calender2.php" class="nav__link">Reserve</a></li>
                    <li class="nav__item"><a href="cart.php" class="nav__link">Keranjang</a></li>
                    <li class="nav__item"><a href="logout.php" class="nav__link">Keluar</a></li>
                <?php else: ?>
                    <li class="nav__item"><a href="login.php" class="nav__link">Login</a></li>
                    <li class="nav__item"><a href="register.php" class="nav__link">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>

        <div class="nav__toggle" id="nav-toggle">
            <i class='bx bx-menu'></i>
        </div>
    </nav>
</header>

    
</body>
</html>