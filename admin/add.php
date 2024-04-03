<?php

include __DIR__ . "/../service/database.php";

if (isset($_POST["addBtn"])) {
    $name = $_POST["menu_name"];
    $price = $_POST["price"];

    $result = mysqli_query($db, "INSERT INTO menu
    (dish_name, price) 
    VALUES('$name', '$price')");

    header("location: dashboard.php");

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../layout/style.css">
    <title>Add Menu</title>
</head>
<body>
<?php include __DIR__ . "/../layout/header.php"; ?>
    <form action="add.php" method="post">
        <table width="25%" border="0">
            <tr>
                <td>Menu Name : </td>
                <td><input type="text" name="menu_name"></td>
            </tr>
            <tr>
                <td>Price : </td>
                <td><input type="text" name="price"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Add" name="addBtn"></td>
            </tr>
            </table>
    </form>
</body>
</html>