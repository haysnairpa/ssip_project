<?php

include __DIR__ . "/../service/database.php";

if (isset($_POST["addBtn"])) {
    $dishid = $_POST["menu_id"];
    $name = $_POST["menu_name"];
    $price = $_POST["price"];

    // Check if the dish_id already exists in the database
    $check_query = mysqli_query($db, "SELECT * FROM menu WHERE dish_id='$dishid'");
    if (mysqli_num_rows($check_query) > 0) {
        // Redirect back to the add menu page with an error message
        header("location: add.php?error=existing_id");
        exit(); // Stop further execution
    }

    // Insert new menu into the database
    $result = mysqli_query($db, "INSERT INTO menu (dish_id, dish_name, price) VALUES ('$dishid','$name', '$price')");
    $result2 = mysqli_query($db, "INSERT INTO stock (stock_id, dish_id, quantity) VALUES ('$dishid','$dishid', 0)");
    
    // Redirect to dashboard after successful insertion
    header("location: dashboard.php");
    exit(); // Stop further execution
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

<?php 
// Display error message if dish_id already exists
if (isset($_GET['error']) && $_GET['error'] == 'existing_id') {
    echo "<p style='color: red;'>Menu with the same ID already exists!</p>";
}
?>

<form action="add.php" method="post" >
    <table width="25%" border="0">
        <tr>
            <td><label for="menu_id">ID :</label></td>
            <td><input type="text" name="menu_id" id="menu_id" required ></td>
        </tr>
        <tr>
            <td><label for="menu_name">Menu Name :</label></td>
            <td><input type="text" id="menu_name" name="menu_name" required ></td>
        </tr>
        <tr>
            <td><label for="price">Price :</label></td>
            <td><input type="text" id="price" name="price" required ></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="Add" name="addBtn"></td>
        </tr>
    </table>
</form>
</body>
</html>
