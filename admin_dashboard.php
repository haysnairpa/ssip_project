<?php
require_once 'auth.php';
requireAdminLogin();
require_once 'config.php';

// Initialize search and sorting variables
$search_query = '';
$search_menu_items = [];
$search_booking_items = [];
$menu_sort = 'name';
$booking_sort = 'booking_date';

// Check if a search query has been submitted
if (isset($_GET['search'])) {
    $search_query = trim($_GET['search']);
}

// Handle sorting for menu items
if (isset($_GET['menu_sort'])) {
    $menu_sort = $_GET['menu_sort'];
}

// Handle sorting for booking items
if (isset($_GET['booking_sort'])) {
    $booking_sort = $_GET['booking_sort'];
}

// Prepare the SQL statement for menu items with sorting
$menu_sort_query = match ($menu_sort) {
    'price_high' => 'ORDER BY price DESC',
    'price_low' => 'ORDER BY price ASC',
    'category' => 'ORDER BY category, name',
    'stock_high' => 'ORDER BY stock DESC',
    'stock_low' => 'ORDER BY stock ASC',
    'all' => 'ORDER BY id',  // Sort by ID
    default => 'ORDER BY name',
};

$stmt = $pdo->prepare("SELECT id, name, category, price, stock FROM menu WHERE name LIKE :search $menu_sort_query");
$stmt->execute([':search' => "%$search_query%"]);
$search_menu_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare the SQL statement for bookings with sorting
$booking_sort_query = match ($booking_sort) {
    'time' => 'ORDER BY booking_time, booking_date',
    'name' => 'ORDER BY booking_name',
    'num_persons' => 'ORDER BY num_persons',
    'date' => 'ORDER BY booking_date, booking_time',
    'all' => 'ORDER BY id',  // Sort by ID
    default => 'ORDER BY booking_date, booking_time',
};

$stmt2 = $pdo->prepare("SELECT id, booking_date, booking_time, booking_name, num_persons FROM bookings WHERE booking_name LIKE :search $booking_sort_query");
$stmt2->execute([':search' => "%$search_query%"]);
$search_booking_items = $stmt2->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap');
        body {
            font-family: 'Space Grotesk', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-8 px-4">
        <h1 class="text-3xl font-bold mb-6"><a href="admin_dashboard.php">Admin Dashboard</a></h1>

        <div class="mb-4">
            <form method="GET" class="flex items-center">
                <input type="text" name="search" value="<?= htmlspecialchars($search_query) ?>" placeholder="Search by name..." class="border border-gray-300 rounded py-2 px-4 mr-2">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Search</button>
            </form>
        </div>

        <div class="mb-4">
            <a href="add_menu.php" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Tambah Menu Baru</a>
            <a href="add_booking.php" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded ml-2">Tambah Booking Baru</a>
            <a href="admin_logout.php" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded ml-2">Logout</a>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                Menu berhasil dihapus.
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                Terjadi kesalahan saat menghapus menu.  
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['booking_deleted'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                Booking berhasil dihapus.
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['booking_notdeleted'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                Terjadi kesalahan saat menghapus booking.  
            </div>
        <?php endif; ?>

        <h2 class="text-xl font-bold mb-4">Menu Items</h2>
        <div class="mb-4">
            <span>Sort by:</span>
            <a href="?search=<?= urlencode($search_query) ?>&menu_sort=all" class="text-blue-500 hover:text-blue-700 mx-2">All</a>
            <a href="?search=<?= urlencode($search_query) ?>&menu_sort=price_low" class="text-blue-500 hover:text-blue-700 mx-2">Price Low to High</a>
            <a href="?search=<?= urlencode($search_query) ?>&menu_sort=price_high" class="text-blue-500 hover:text-blue-700 mx-2">Price High to Low</a>
            <a href="?search=<?= urlencode($search_query) ?>&menu_sort=category" class="text-blue-500 hover:text-blue-700 mx-2">Category</a>
            <a href="?search=<?= urlencode($search_query) ?>&menu_sort=stock_low" class="text-blue-500 hover:text-blue-700 mx-2">Stock Low to High</a>
            <a href="?search=<?= urlencode($search_query) ?>&menu_sort=stock_high" class="text-blue-500 hover:text-blue-700 mx-2">Stock High to Low</a>
        </div>

        <table class="w-full bg-white shadow-md rounded mb-6">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Nama</th>
                    <th class="py-3 px-6 text-left">Kategori</th>
                    <th class="py-3 px-6 text-right">Harga</th>
                    <th class="py-3 px-6 text-center">Stok</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                <?php foreach ($search_menu_items as $item): ?>
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap"><?= htmlspecialchars($item['name']) ?></td>
                        <td class="py-3 px-6 text-left"><?= htmlspecialchars($item['category']) ?></td>
                        <td class="py-3 px-6 text-right">Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                        <td class="py-3 px-6 text-center"><?= htmlspecialchars($item['stock']) ?></td>
                        <td class="py-3 px-6 text-center">
                            <a href="edit_menu.php?id=<?= $item['id'] ?>" class="text-blue-500 hover:text-blue-700 mr-2">Edit</a>
                            <a href="delete_menu.php?id=<?= $item['id'] ?>" class="text-red-500 hover:text-red-700" onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2 class="text-xl font-bold mb-4">Booking Items</h2>
        <div class="mb-4">
            <span>Sort by:</span>
            <a href="?search=<?= urlencode($search_query) ?>&booking_sort=all" class="text-blue-500 hover:text-blue-700 mx-2">All</a>
            <a href="?search=<?= urlencode($search_query) ?>&booking_sort=time" class="text-blue-500 hover:text-blue-700 mx-2">Time</a>
            <a href="?search=<?= urlencode($search_query) ?>&booking_sort=name" class="text-blue-500 hover:text-blue-700 mx-2">Name</a>
            <a href="?search=<?= urlencode($search_query) ?>&booking_sort=num_persons" class="text-blue-500 hover:text-blue-700 mx-2">Number of Persons</a>
            <a href="?search=<?= urlencode($search_query) ?>&booking_sort=date" class="text-blue-500 hover:text-blue-700 mx-2">Date</a>
        </div>

        <table class="w-full bg-white shadow-md rounded mb-6">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Tanggal</th>
                    <th class="py-3 px-6 text-left">Waktu</th>
                    <th class="py-3 px-6 text-left">Nama</th>
                    <th class="py-3 px-6 text-center">Jumlah Tamu</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                <?php foreach ($search_booking_items as $booking): ?>
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left"><?= htmlspecialchars($booking['booking_date']) ?></td>
                        <td class="py-3 px-6 text-left"><?= htmlspecialchars($booking['booking_time']) ?></td>
                        <td class="py-3 px-6 text-left"><?= htmlspecialchars($booking['booking_name']) ?></td>
                        <td class="py-3 px-6 text-center"><?= htmlspecialchars($booking['num_persons']) ?></td>
                        <td class="py-3 px-6 text-center">
                            <a href="edit_booking.php?id=<?= $booking['id'] ?>" class="text-blue-500 hover:text-blue-700 mr-2">Edit</a>
                            <a href="delete_booking.php?id=<?= $booking['id'] ?>" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this booking?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</body>
</html>
