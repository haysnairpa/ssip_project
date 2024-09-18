<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $item_id = $_POST['item_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Cek apakah item sudah ada di keranjang
    $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = ? AND item_id = ?");
    $stmt->execute([$user_id, $item_id]);
    $existing_item = $stmt->fetch();

    if ($existing_item) {
        // Update quantity jika item sudah ada
        $stmt = $pdo->prepare("UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND item_id = ?");
        $stmt->execute([$quantity, $user_id, $item_id]);
    } else {
        // Tambahkan item baru ke keranjang
        $stmt = $pdo->prepare("INSERT INTO cart (user_id, item_id, name, price, quantity) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $item_id, $name, $price, $quantity]);
    }

    header("Location: cart.php");
    exit();
}