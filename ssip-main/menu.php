<?php include 'layout/header.php'; ?>
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'config.php';

// Ambil data menu dari database
$stmt = $pdo->query("SELECT * FROM menu");
$menu_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Makanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="index.php" class="text-white text-2xl font-bold">FoodOrder</a>
            <div>
                <a href="cart.php" class="text-white mr-4">Keranjang</a>
                <a href="logout.php" class="text-white">Keluar</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-8">
        <h1 class="text-3xl font-bold mb-6">Menu Makanan</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($menu_items as $item): ?>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-2"><?= htmlspecialchars($item['name']) ?></h2>
                    <p class="text-gray-600 mb-4"><?= htmlspecialchars($item['description']) ?></p>
                    <p class="text-lg font-bold mb-4">Rp <?= number_format($item['price'], 0, ',', '.') ?></p>
                    <form action="add_to_cart.php" method="post">
                        <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                        <input type="number" name="quantity" value="1" min="1" class="w-16 border rounded p-1 mr-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Tambah ke Keranjang</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>