<?php
require_once 'auth.php';
requireAdminLogin();
require_once 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        $pdo->beginTransaction();
        
        // Hapus item terkait di tabel bookings
        $stmt = $pdo->prepare("DELETE FROM bookings WHERE id = ?");
        $stmt->execute([$id]);
        
        $pdo->commit();
        header("Location: admin_dashboard.php?booking_deleted=1");
        exit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        header("Location: admin_dashboard.php?booking_notdeleted=1");
        exit();
    }
} else {
    header("Location: admin_dashboard.php");
    exit();
}
