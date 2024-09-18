<?php
require_once 'auth.php';
requireAdminLogin();
require_once 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        $pdo->beginTransaction();
        
        // Hapus terlebih dahulu item terkait di tabel cart
        $stmt = $pdo->prepare("DELETE FROM cart WHERE item_id = ?");
        $stmt->execute([$id]);
        
        // Kemudian hapus item dari tabel menu
        $stmt = $pdo->prepare("DELETE FROM menu WHERE id = ?");
        $stmt->execute([$id]);
        
        $pdo->commit();
        header("Location: admin_dashboard.php?success=1");
        exit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        header("Location: admin_dashboard.php?error=1");
        exit();
    }
} else {
    header("Location: admin_dashboard.php");
    exit();
}