<?php

include __DIR__ . "/../service/database.php";
session_start();

if ($_SESSION["is_login"] == false) {
    header("location: login.php");
}

$count = mysqli_query($db, "SELECT COUNT(quantity) as quantity_rows FROM stock");

$row = mysqli_fetch_assoc($count);
$quantity_row = $row["quantity_rows"];

$select_menu = "SELECT * FROM menu";
$result = $db->query($select_menu);
$result2 = mysqli_query($db, "SELECT * FROM stock");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../layout/style.css">
    <title>Dashboard</title>
</head>

<body>
    <?php include __DIR__ . "/../layout/header.php"; ?>

    <h3>Welcome, <?= $_SESSION["username"] ?>! 😊</h3>

    <?php if (mysqli_num_rows($result) > 0) : ?>
        <h4>This is our Menu🍗</h4>

        <table border="1" style="margin-bottom: 15px;">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Action</th>
            </tr>
            <?php while ($stock = mysqli_fetch_array($result2)): ?>
                <?php while ($menu = mysqli_fetch_array($result)): ?>
                    <?php $id = $menu["dish_id"]; ?>
                    <tr>
                        <td><?= $menu["dish_id"] ?></td>
                        <td><?= $menu["dish_name"] ?></td>
                        <td><?= $menu["price"] ?></td>
                        <td><?= $stock["quantity"] ?></td>
                        <td>
                            <a href="edit.php?dish_id=<?= $id ?>" style='margin-right: 5px;'>Edit</a>
                            <a href="delete.php?dish_id=<?= $id ?>">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php endwhile; ?>
        </table>
    <?php else : ?>
        <p>No data.</p>
    <?php endif; ?>
    <a href="add.php">add menu</a>
    <!-- <a href="menu.php">Menu</a> 
    <a href="">Stock</a> <br> -->
    <!-- <a href="logout.php">logout</a> -->
</body>

</html>