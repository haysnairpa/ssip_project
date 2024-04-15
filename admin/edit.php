<?php

include __DIR__ . "/../service/database.php";
session_start();

if (isset($_GET["dish_id"])) {
    $id = $_GET["dish_id"];
    $result = mysqli_query($db, "SELECT * FROM menu WHERE dish_id = '$id'");

    if ($result) {

        if (mysqli_num_rows($result) > 0) {
        
            $menu = mysqli_fetch_array($result);
            $dish_name = $menu["dish_name"];
            $price = $menu["price"];
        }        
    }
}

if (isset($_POST["updateBtn"])) {
    $id = $_POST["dish_id"];
    $dish_name = $_POST["dish_name"];
    $price = $_POST["price"];

    $result = mysqli_query($db, "UPDATE menu SET
        dish_name = '$dish_name',
        price = '$price' 
        WHERE dish_id = '$id'");
        
    if ($result) {
        header("location: dashboard.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu</title>
</head>
<body>
    <form action="edit.php" method="post">
        <table>
            <tr>
                <td>Menu Name : </td>
                <td><input type="text" name="dish_name" value=" <?php echo $dish_name ?> "></td>
            </tr>
            <tr>
                <td>Price : </td>
                <td><input type="number" name="price" value="<?= $price ?>"></td>
            </tr>
            <tr>
                <td><input type="hidden" name="dish_id" value="<?= $_GET["dish_id"] ?>"></td>
                <td><input type="submit" value="Update" name="updateBtn"></td>
            </tr>
        </table>
    </form>
</body>
</html>