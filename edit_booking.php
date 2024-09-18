<?php
require_once 'auth.php';
requireAdminLogin();
require_once 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$error = '';
$success = '';
$booking = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = $_POST['booking_id'];
    $booking_date = $_POST['booking_date'];
    $booking_time = $_POST['booking_time'];
    $booking_name = $_POST['booking_name'];
    $num_persons = $_POST['num_persons'];

    $stmt = $pdo->prepare("UPDATE bookings SET booking_date = ?, booking_time = ?, booking_name = ?, num_persons = ? WHERE id = ?");
    if ($stmt->execute([$booking_date, $booking_time, $booking_name, $num_persons, $booking_id])) {
        $success = "Booking berhasil diperbarui.";
    } else {
        $error = "Error updating record: " . $stmt->errorInfo()[2];
    }
}

if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT id, booking_date, booking_time, booking_name, IFNULL(num_persons, 1) as num_persons FROM bookings WHERE id = ?");
    $stmt->execute([$booking_id]);
    $booking = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$booking) {
        $error = "Booking tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking</title>
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
        <h2 class="text-2xl font-bold mb-4">Edit Booking</h2>
        <?php if ($error): ?>
            <p class="text-red-500 mb-4"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <?php if ($success): ?>
            <p class="text-green-500 mb-4"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>
        <?php if ($booking): ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="booking_date">Tanggal:</label>
                    <input type="date" id="booking_date" name="booking_date" value="<?= htmlspecialchars($booking['booking_date']) ?>" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="booking_time">Waktu:</label>
                    <input type="time" id="booking_time" name="booking_time" value="<?= htmlspecialchars($booking['booking_time']) ?>" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="booking_name">Nama:</label>
                    <input type="text" id="booking_name" name="booking_name" value="<?= htmlspecialchars($booking['booking_name']) ?>" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="num_persons">Jumlah Orang:</label>
                    <input type="number" id="num_persons" name="num_persons" value="<?= htmlspecialchars($booking['num_persons']) ?>" required min="1" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit" name="simpan" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Simpan</button>
                    <a href="admin_dashboard.php" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Kembali ke Dashboard</a>
                </div>
            </form>
        <?php else: ?>
            <p class="text-red-500">Booking tidak ditemukan atau terjadi kesalahan.</p>
            <a href="admin_dashboard.php" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Kembali ke Dashboard</a>
        <?php endif; ?>
    </div>
</body>
</html>