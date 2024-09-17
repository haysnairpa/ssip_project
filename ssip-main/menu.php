<?php include 'layout/header.php'; ?>
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'config.php';

// Ambil data menu dari database dan kelompokkan berdasarkan kategori
$stmt = $pdo->query("SELECT * FROM menu ORDER BY category, name");
$menu_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
$menu_by_category = [];
foreach ($menu_items as $item) {
    $menu_by_category[$item['category']][] = $item;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Makanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .category-title {
            background-color: #4a5568;
            color: white;
            padding: 10px;
            margin-top: 20px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-8 px-4">
        <h1 class="text-3xl font-bold mb-6 text-center">Menu Makanan</h1>
        <?php foreach ($menu_by_category as $category => $items): ?>
            <h2 class="category-title text-xl font-semibold"><?= htmlspecialchars($category) ?></h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <?php foreach ($items as $item): ?>
                    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300">
                        <h3 class="text-xl font-semibold mb-2"><?= htmlspecialchars($item['name']) ?></h3>
                        <p class="text-gray-600 mb-4"><?= htmlspecialchars($item['description']) ?></p>
                        <p class="text-lg font-bold mb-4">Rp <?= number_format($item['price'], 0, ',', '.') ?></p>
                        <form action="add_to_cart.php" method="post" class="flex items-center">
                            <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                            <input type="hidden" name="name" value="<?= htmlspecialchars($item['name']) ?>">
                            <input type="hidden" name="price" value="<?= $item['price'] ?>">
                            <input type="number" name="quantity" value="1" min="1" class="w-16 border rounded p-1 mr-2">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300">Tambah ke Keranjang</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>