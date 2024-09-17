<?php
session_start();
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&display=swap");


        :root {
            --header-height: 3rem;
            --font-medium: 500;
        }


        :root {
            --first-color: rgb(0, 140, 255);
            --white-color: rgb(255, 255, 255);
            --dark-color: #13232e;
            --text-color: rgb(150, 150, 150);
        }


        :root {
            --body-font: 'Montserrat', sans-serif;
            --big-font-size: 6.25rem;
            --h2-font-size: 1.25rem;
            --normal-font-size: .938rem;
            --small-font-size: .813rem;
        }

        @media screen and (min-width: 768px) {
            :root {
                --big-font-size: 9rem;
                --h2-font-size: 2rem;
                --normal-font-size: 1rem;
                --small-font-size: .875rem;
            }
        }

        :root {
            --mb-1: .5rem;
            --mb-2: 1rem;
            --mb-3: 1.5rem;
            --mb-4: 2rem;
        }


        :root {
            --z-fixed: 100;
        }


        *,
        ::before,
        ::after {
            box-sizing: menu-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: var(--header-height) 0 0 0;
            font-family: var(--body-font);
            font-size: var(--normal-font-size);
            font-weight: var(--font-medium);
            color: var(--text-color);
            line-height: 1.6;

        }

        h1,
        h2,
        p {
            margin: 0;
        }

        ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        a {
            text-decoration: none;
            color: var(--text-color);
        }

        img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        /*===== CLASS CSS ===== */
        .section {
            padding: 3rem 0;
        }


        .bd-grid {
            max-width: 1024px;
            display: grid;
            grid-template-columns: 100%;
            grid-column-gap: 2rem;
            width: calc(100% - 2rem);
            margin-left: var(--mb-2);
            margin-right: var(--mb-2);
        }


        .l-header {
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: var(--z-fixed);
            background-color: var(--first-color);
            display: flex;
            justify-content: center;
        }


        .active::after {
            position: absolute;
            content: "";
            width: 100%;
            height: .18rem;
            left: 0;
            top: 2rem;
            background-color: var(--first-color);
        }


        .nav {
            height: var(--header-height);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }


        @media screen and (max-width: 768px) {
            .nav__home {
                position: fixed;
                top: var(--header-height);
                right: -100%;
                width: 80%;
                height: 100%;
                padding: 2rem;
                background-color: rgba(255, 255, 255, .3);
                transition: .5s;
                backdrop-filter: blur(10px);
            }
        }

        .nav__item {
            margin-bottom: var(--mb-4);
        }

        .nav__link {
            position: relative;
            color: var(--dark-color);
        }

        .nav__link:hover {
            color: var(--first-color);
        }

        .nav__logo {
            color: var(--white-color);
        }

        .nav__toggle {
            color: var(--white-color);
            font-size: 1.5rem;
            cursor: pointer;
        }


        /* ===== MEDIA QUERIES =====*/
        @media screen and (min-width: 768px) {

            body {
                margin: 0;
            }


            .nav {
                height: calc(var(--header-height) + 1rem);
            }

            .nav__list {
                display: flex;
            }

            .nav__item {
                margin-left: var(--mb-4);
                margin-bottom: 0;
            }

            .nav__toggle {
                display: none;
            }

            .nav__link {
                color: var(--white-color);
            }

            .nav__link:hover {
                color: var(--white-color);
            }

            .active::after {
                background-color: var(--white-color);
            }
        }

        .calendar {
            width: 400px;
            border-collapse: collapse;
            position: relative;
            top: 120px;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-items: center;
        }

        .calendar td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            border-radius: 10px;
        }

        .calendar th {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            border-radius: 10px;
        }

        .booking-schedule h3 {
            position: relative;
            top: 120px;
            left: 600px;
    font-family: 'Montserrat', sans-serif;
}


        .booking-form {
            position: relative;
            top: 120px;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-items: center;
        }
    </style>
</head>

<body>
    <?php include 'layout/header.php'; ?>


    <?php
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'ssip_db';

    $msg = '';

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['action'])) {
            if ($_POST['action'] == "add") {
                $booking_date = $_POST['booking_date'];
                $booking_time = $_POST['booking_time'];
                $booking_name = $_POST['booking_name'];

                $sql = "SELECT COUNT(*) AS total_bookings FROM bookings WHERE booking_date='$booking_date' AND booking_name='$booking_name'";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                $total_bookings = $row['total_bookings'];

                if ($total_bookings > 0) {
                    $msg = "<p>This name is already in that date.</p>";
                } else {
                    $sql = "SELECT COUNT(*) AS total_bookings FROM bookings WHERE booking_date='$booking_date' AND booking_time='$booking_time'";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $total_bookings_same_time = $row['total_bookings'];

                    if ($total_bookings_same_time >= 3) {
                        $msg = "<p>Udah 3 booking brooo.</p>";
                    } else {
                        $sql = "INSERT INTO bookings (booking_date, booking_time, booking_name) VALUES ('$booking_date', '$booking_time', '$booking_name')";

                        if ($conn->query($sql) === TRUE) {
                            $msg = "<p>Booking successs.</p>";
                        } else {
                            $msg = "Error: " . $sql . "<br>" . $conn->error;
                        }
                    }
                }
            } elseif ($_POST['action'] == "edit") {
                header("Location: edit_booking.php?id=" . $_POST['booking_id']);
            } elseif ($_POST['action'] == "delete") {
                $booking_id = $_POST['booking_id'];

                $sql = "DELETE FROM bookings WHERE id='$booking_id'";

                if ($conn->query($sql) === TRUE) {
                    $msg = "<p>Booking berhasil dihapus.</p>";
                } else {
                    $msg = "Error deleting record: " . $conn->error;
                }
            }
        }
    }

    ?>


    <section class="booking-form">
        <h2>Booking Calendar</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="action" value="add">
            <label for="booking_date">Tanggal:</label>
            <input type="date" id="booking_date" name="booking_date" min="<?php echo date("Y-m-d"); ?>" required><br><br>
            <label for="booking_time">Waktu:</label>
            <input type="time" id="booking_time" name="booking_time" required><br><br>
            <label for="booking_name">Nama:</label>
            <input type="text" id="booking_name" name="booking_name" required><br><br>
            <input class="btn" type="submit" value="Tambah Booking">
        </form>
        <?= $msg ?>
    </section>
    <section class="booking-schedule">
        <h3>Jadwal Booking</h3>

        <table class="calendar">
            <tr>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Nama</th>
                <th>Action</th>
            </tr>
    </section>

    <?php
    $sql = "SELECT id, booking_date, booking_time, booking_name FROM bookings";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["booking_date"] . "</td><td>" . $row["booking_time"] . "</td><td>" . $row["booking_name"] . "</td>";
            echo "<td>";
            echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
            echo "<input type='hidden' name='action' value='edit'>";
            echo "<input type='hidden' name='booking_id' value='" . $row["id"] . "'>";
            echo "<input type='hidden' name='booking_date' value='" . $row["booking_date"] . "'>";
            echo "<input type='hidden' name='booking_time' value='" . $row["booking_time"] . "'>";
            echo "<input type='hidden' name='booking_name' value='" . $row["booking_name"] . "'>";
            echo "<input type='submit' value='Edit'>";
            echo "</form>";
            echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
            echo "<input type='hidden' name='action' value='delete'>";
            echo "<input type='hidden' name='booking_id' value='" . $row["id"] . "'>";
            echo "<input type='submit' value='Delete'>";
            echo "</form>";
            echo "</td></tr>";
        }
    } else {
        echo "<tr><td colspan='4'>Tidak ada booking tersedia.</td></tr>";
    }

    $conn->close();
    ?>
    </table>
</body>

</html>