<?php
require_once 'auth.php';
requireUserLogin();
require_once 'config.php';

if (isset($_POST["reserveBtn"])) {
    if (isset($_SESSION["user_id"])) {
        header("location: calender2.php");
        exit;
    } else {
        header("location: login.php");
        exit;
    }
}

$msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == "add") {
            $booking_date = $_POST['booking_date'];
            $booking_time = $_POST['booking_time'];
            $booking_name = $_POST['booking_name'];
            $number_persons = $_POST['num_persons'];

            $sql = "SELECT COUNT(*) AS total_bookings FROM bookings WHERE booking_date=? AND booking_name=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$booking_date, $booking_name]);
            $row = $stmt->fetch();
            $total_bookings = $row['total_bookings'];

            if ($total_bookings > 0) {
                $msg = "<p class='text-red-500'>Nama ini sudah ada pada tanggal tersebut.</p>";
            } else {
                $sql = "SELECT COUNT(*) AS total_bookings FROM bookings WHERE booking_date=? AND booking_time=?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$booking_date, $booking_time]);
                $row = $stmt->fetch();
                $total_bookings_same_time = $row['total_bookings'];

                if ($total_bookings_same_time >= 3) {
                    $msg = "<p class='text-red-500'>Sudah penuh untuk waktu ini.</p>";
                } else {
                    $sql = "INSERT INTO bookings (booking_date, booking_time, booking_name, num_persons) VALUES (?, ?, ?, ?)";
                    $stmt = $pdo->prepare($sql);
                    if ($stmt->execute([$booking_date, $booking_time, $booking_name, $number_persons])) {
                        $msg = "<p class='text-green-500'>Booking berhasil.</p>";
                    } else {
                        $msg = "<p class='text-red-500'>Terjadi kesalahan saat booking.</p>";
                    }
                }
            }
        } elseif ($_POST['action'] == "edit") {
            header("Location: edit_booking.php?id=" . $_POST['booking_id']);
        } elseif ($_POST['action'] == "delete") {
            $booking_id = $_POST['booking_id'];
            $sql = "DELETE FROM bookings WHERE id=?";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$booking_id])) {
                $msg = "<p class='text-green-500'>Booking berhasil dihapus.</p>";
            } else {
                $msg = "<p class='text-red-500'>Terjadi kesalahan saat menghapus booking.</p>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Calendar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Space Grotesk', 'sans-serif'],
                    },
                },
            },
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap');
        
        body {
            font-family: 'Space Grotesk', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <?php include 'layout/header.php'; ?>

    <div class="container mx-auto mt-24 px-4">
        <h1 class="text-3xl font-bold mb-6 text-center">Booking Calendar</h1>

        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="mb-4">
                <input type="hidden" name="action" value="add">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="booking_date">
                        Tanggal:
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="date" id="booking_date" name="booking_date" min="<?php echo date("Y-m-d"); ?>" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="booking_time">
                        Waktu:
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="time" id="booking_time" name="booking_time" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="booking_name">
                        Nama:
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" id="booking_name" name="booking_name" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="num_persons">
                        Jumlah Tamu:
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" id="num_persons" name="num_persons" required>
                </div>
                <div class="flex items-center justify-between">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Tambah Booking
                    </button>
                </div>
            </form>
            <?= $msg ?>
        </div>

        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <h2 class="text-xl font-bold mb-4">Jadwal Booking</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr>
                            <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Tanggal</th>
                            <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Waktu</th>
                            <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Nama</th>
                            <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Jumlah Tamu</th>
                            <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT id, booking_date, booking_time, booking_name, num_persons FROM bookings ORDER BY booking_date, booking_time";
                        $stmt = $pdo->query($sql);
                        if ($stmt->rowCount() > 0) {
                            while ($row = $stmt->fetch()) {
                                echo "<tr>";
                                echo "<td class='py-4 px-6 border-b border-grey-light'>" . htmlspecialchars($row["booking_date"]) . "</td>";
                                echo "<td class='py-4 px-6 border-b border-grey-light'>" . htmlspecialchars($row["booking_time"]) . "</td>";
                                echo "<td class='py-4 px-6 border-b border-grey-light'>" . htmlspecialchars($row["booking_name"]) . "</td>";
                                echo "<td class='py-4 px-6 border-b border-grey-light'>" . htmlspecialchars($row["num_persons"]) . "</td>";
                                echo "<td class='py-4 px-6 border-b border-grey-light'>";
                                echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' class='inline'>";
                                echo "<input type='hidden' name='action' value='edit'>";
                                echo "<input type='hidden' name='booking_id' value='" . $row["id"] . "'>";
                                echo "<button type='submit' class='text-blue-500 hover:text-blue-800 mr-2'>Edit</button>";
                                echo "</form>";
                                echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' class='inline'>";
                                echo "<input type='hidden' name='action'
                                                                value='delete'>";
                                echo "<input type='hidden' name='booking_id' value='" . $row["id"] . "'>";
                                echo "<button type='submit' class='text-red-500 hover:text-red-800' onclick='return confirm(\"Apakah Anda yakin ingin menghapus booking ini?\")'>Hapus</button>";
                                echo "</form>";
                                echo "</td></tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='py-4 px-6 border-b border-grey-light text-center'>Tidak ada booking tersedia.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
