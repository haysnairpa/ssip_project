<?php
require_once 'auth.php';
requireAdminLogin();
require_once 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking_date = $_POST['booking_date'];
    $booking_time = $_POST['booking_time'];
    $booking_name = $_POST['booking_name'];
    $num_persons = $_POST['num_persons'];

    $stmt = $pdo->prepare("INSERT INTO bookings (booking_date, booking_time, booking_name, num_persons) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$booking_date, $booking_time, $booking_name, $num_persons])) {
        $success = "Booking berhasil ditambahkan.";
    } else {
        $error = "Terjadi kesalahan saat menambahkan booking.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Booking Baru</title>
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
        <h1 class="text-3xl font-bold mb-6 text-center">Tambah Booking Baru</h1>
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
        <form action="add_booking.php" method="post" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="booking_date">
                    Tanggal Booking
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="booking_date" type="date" name="booking_date" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="booking_time">
                    Waktu Booking
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="booking_time" type="time" name="booking_time" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="booking_name">
                    Nama Pemesan
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="booking_name" type="text" name="booking_name" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="num_persons">
                    Jumlah Tamu
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="num_persons" type="number" name="num_persons" required>
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Tambah Booking
                </button>
                <a href="admin_dashboard.php" class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-                    800">
                    Kembali ke Dashboard
                </a>
            </div>
        </form>
    </div>
</body>
</html>