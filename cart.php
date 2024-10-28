<?php
session_start();
require_once 'config.php';
include 'layout/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data keranjang user
$stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = ?");
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll();

// Hitung total
$total = 0;
foreach ($cart_items as $item) {
    $total += $item['price'] * $item['quantity'];
}

// Proses update quantity
if (isset($_POST['update_quantity'])) {
    $item_id = $_POST['item_id'];
    $new_quantity = $_POST['quantity'];
    $stmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$new_quantity, $item_id, $user_id]);
    header("Location: cart.php");
    exit();
}

// Proses remove item
if (isset($_GET['remove'])) {
    $item_id = $_GET['remove'];
    $stmt = $pdo->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
    $stmt->execute([$item_id, $user_id]);
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap');

        body {
            font-family: 'Space Grotesk', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-24 px-4">
        <h1 class="text-3xl font-bold mb-6 text-center">Keranjang Belanja</h1>
        <?php if (count($cart_items) > 0): ?>
            <table class="w-full bg-white shadow-md rounded">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Nama</th>
                        <th class="py-3 px-6 text-left">Harga</th>
                        <th class="py-3 px-6 text-center">Jumlah</th>
                        <th class="py-3 px-6 text-right">Subtotal</th>
                        <th class="py-3 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    <?php foreach ($cart_items as $item): ?>
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left whitespace-nowrap"><?= htmlspecialchars($item['name']) ?></td>
                            <td class="py-3 px-6 text-left">Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                            <td class="py-3 px-6 text-center">
                                <form action="cart.php" method="post" class="flex items-center justify-center">
                                    <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                                    <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" class="w-16 text-center border rounded">
                                    <button type="submit" name="update_quantity" class="ml-2 bg-blue-500 text-white px-2 py-1 rounded text-xs">Update</button>
                                </form>
                            </td>
                            <td class="py-3 px-6 text-right">Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?></td>
                            <td class="py-3 px-6 text-center">
                                <a href="cart.php?remove=<?= $item['id'] ?>" class="text-red-500 hover:text-red-700">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="bg-gray-50 font-bold">
                        <td colspan="3" class="py-3 px-6 text-right">Total:</td>
                        <td class="py-3 px-6 text-right">Rp <?= number_format($total, 0, ',', '.') ?></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        <?php else: ?>
            <p class="text-center text-gray-600">Keranjang belanja Anda kosong.</p>
        <?php endif; ?>
    </div>
</body>
</html>