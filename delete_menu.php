<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM menu WHERE id = ?");
    if ($stmt->execute([$id])) {
        header("Location: admin_dashboard.php?success=1");
    } else {
        header("Location: admin_dashboard.php?error=1");
    }
    exit();
}

header("Location: admin_dashboard.php");
exit();