<!DOCTYPE html>
<html>

<head>
    <title>Edit Booking</title>
</head>

<body>

    <?php
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'ssip_db';

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $booking_id = $_POST['booking_id'];
        $booking_date = $_POST['booking_date'];
        $booking_time = $_POST['booking_time'];
        $booking_name = $_POST['booking_name'];
        $num_persons = $_POST['num_persons'];

        $stmt = $conn->prepare("UPDATE bookings SET booking_date = ?, booking_time = ?, booking_name = ?, num_persons = ? WHERE id = ?");
        $stmt->bind_param("sssii", $booking_date, $booking_time, $booking_name, $num_persons, $booking_id);

        if ($stmt->execute()) {
            header('location: calendar.php');
            exit;
        } else {
            $error = "Error updating record: " . $stmt->error;
        }
    }

    if (isset($_GET['id'])) {
        $booking_id = $_GET['id'];
        $stmt = $conn->prepare("SELECT id, booking_date, booking_time, booking_name, num_persons FROM bookings WHERE id = ?");
        $stmt->bind_param("i", $booking_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $booking_date = $row["booking_date"];
            $booking_time = $row["booking_time"];
            $booking_name = $row["booking_name"];
            $num_persons = $row["num_persons"];
        } else {
            $error = "Booking not found.";
        }
    }

    $conn->close();
    ?>

    <h2>Edit Booking</h2>
    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">
        <label for="booking_date">Tanggal:</label>
        <input type="date" id="booking_date" name="booking_date" value="<?php echo $booking_date; ?>" required><br><br>
        <label for="booking_time">Waktu:</label>
        <input type="time" id="booking_time" name="booking_time" value="<?php echo $booking_time; ?>" required><br><br>
        <label for="booking_name">Nama:</label>
        <input type="text" id="booking_name" name="booking_name" value="<?php echo $booking_name; ?>" required><br><br>
        <label for="num_persons">Jumlah Orang:</label>
        <input type="number" id="num_persons" name="num_persons" value="<?php echo $num_persons; ?>" required min="1"><br><br>
        <input type="submit" name="simpan" value="Simpan">
    </form>

</body>

</html>