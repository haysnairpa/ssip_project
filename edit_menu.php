<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$error = '';
$success = '';
$menu = null;

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM menu WHERE id = ?");
    $stmt->execute([$id]);
    $menu = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$menu) {
        $error = "Menu tidak ditemukan.";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];

    $stmt = $pdo->prepare("UPDATE menu SET name = ?, category = ?, price = ?, stock = ?, description = ? WHERE id = ?");
    if ($stmt->execute([$name, $category, $price, $stock, $description, $id])) {
        $success = "Menu berhasil diperbarui.";
    } else {
        $error = "Terjadi kesalahan saat memperbarui menu.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap');
        body {
            font-family: 'Space Grotesk', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-8 max-w-md">
        <h1 class="text-3xl font-bold mb-6 text-center">Edit Menu</h1>
        <?php if ($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>
        <form action="edit_menu.php" method="post" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <?php if ($menu): ?>
                <input type="hidden" name="id" value="<?= $menu['id'] ?>">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                        Nama Menu
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" name="name" value="<?= htmlspecialchars($menu['name']) ?>" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="category">
                        Kategori
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="category" type="text" name="category" value="<?= htmlspecialchars($menu['category']) ?>" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="price">
                        Harga
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="price" type="number" name="price" value="<?= $menu['price'] ?>" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="stock">
                        Stok
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="stock" type="number" name="stock" value="<?= $menu['stock'] ?>" required>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                        Deskripsi
                    </label>
                    <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" name="description" rows="3"><?= htmlspecialchars($menu['description']) ?></textarea>
                </div>
                <div class="flex items-center justify-between">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Perbarui Menu
                    </button>
                    <a href="admin_dashboard.php" class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-800">
                        Kembali ke Dashboard
                    </a>
                </div>
            <?php else: ?>
                <p class="text-red-500">Menu tidak ditemukan atau terjadi kesalahan.</p>
                <a href="admin_dashboard.php" class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-800">
                    Kembali ke Dashboard
                </a>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>