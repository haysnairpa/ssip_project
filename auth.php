<?php
session_start();

function requireUserLogin() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
}

function requireAdminLogin() {
    if (!isset($_SESSION['admin_id'])) {
        header("Location: admin_login.php");
        exit();
    }
}

function redirectIfUserLoggedIn() {
    if (isset($_SESSION['user_id'])) {
        header("Location: menu.php");
        exit();
    }
}

function redirectIfAdminLoggedIn() {
    if (isset($_SESSION['admin_id'])) {
        header("Location: admin_dashboard.php");
        exit();
    }
}