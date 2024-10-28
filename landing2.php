<?php
include "database.php";
session_start();

if (isset($_POST["reserveBtn"])) {
    if (isset($_SESSION["is_login"]) && $_SESSION["is_login"] == true) {
        header("location:calender2.php");
        exit;
    } else {
        header("location:submit-login.php");
        exit;
    }
}

?>


<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- ===== CSS ===== -->
        <link rel="stylesheet" href="landing.css">

        <!-- ===== BOX ICONS ===== -->
        <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>

        <title>Uncle’s Warmination</title>
    </head>
    <body>
        <?php include 'layout/header.php'; ?>
        <main class="l-main">
        <!--===== home =====-->
        <section class="home" id="home">
            <div class="home__container bd-grid">
                <h1 class="home__title"><span>Uncle’s Warmination</span></h1>

                <div class="home__scroll">
                    <a href="#reserve" class="home__scroll-link"><i class='bx bx-up-arrow-alt' ></i>Scroll down</a>
                </div>

                <img src="" alt="" class="home__img">
            </div>
        </section>
            
        <!--===== reserve =====-->
        <section class="reserve section" id="reserve">
            <h2 class="section-title">Reserve</h2>
            <div class="reserve__container bd-grid">
                <div class="reserve__img">
                    <img src="./image/image5.jpg" alt="">
                </div>
                <div>
                    <h2 class="reserve__subtitle">Wanna Reserve?</h2>
                    <p class="reserve__text">Click The button👇bellow to make a reservation</p>

                    <div class="reserve__button">
                        <!-- <a href="calendar.php" class="reserve__button-link">Reservation</a> -->
                        <form action="landing.php" method="post">
                            <input type="submit" name="reserveBtn" value="Reservation" class="reserve__button-link">    
                        </form>
                        </div>
                </div>
            </div>
        </section>
            <!--===== menu =====-->
            <section class="menu section" id="menu" >
                <h2 class="section-title">Menu</h2>

                <div class="menu__container bd-grid">
                    <div class="menu__box">
                        <h3 class="menu__subtitle">Food</h3>
                        <span class="menu__name">Noodle</span>
                        <span class="menu__name">Pizza</span>
                        <span class="menu__name">Dessert</span>
                        <span class="menu__name">Apetaizer</span>

                        <h3 class="menu__subtitle">Drink</h3>
                        <span class="menu__name">Juice</span>
                    </div>
                    <div class="menu__img">
                        <img src="./image/image1.png" alt="">
                        <img src="./image/image2.png" alt="">
                        <img src="./image/image3.png" alt="">
                    </div>
                </div>
            </section>
        </main>
        
        <?php include 'layout/footer.php';?>
    </body>
</html>