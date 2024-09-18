<?php

include "database.php";

if (isset($_POST["addButton"])) {
    $dishid = $_POST["menuId"];
    $name = $_POST["menuname"];
    $price = $_POST["price"];
    $desc = $_POST["desc"];
    $quantity = $_POST["quantity"];
    $category = $_POST["category"];

    // Check if the dish_id already exists in the database
    $check_query = mysqli_prepare($db, "SELECT * FROM menu WHERE dish_id = ?");
    mysqli_stmt_bind_param($check_query, "s", $dishid);
    mysqli_stmt_execute($check_query);
    $result = mysqli_stmt_get_result($check_query);

    if (mysqli_num_rows($result) > 0) {
        // Redirect back to the add menu page with an error message
        header("location: addmenu.php?error=existing_id");
        exit();
    }

    // Insert new menu into the database
    $insert_menu = mysqli_prepare($db, "INSERT INTO menu (dish_id, dish_name, price, description, category) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($insert_menu, "ssdss", $dishid, $name, $price, $desc, $category);
    
    $insert_stock = mysqli_prepare($db, "INSERT INTO stock (stock_id, dish_id, quantity) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($insert_stock, "ssi", $dishid, $dishid, $quantity);

    if (mysqli_stmt_execute($insert_menu) && mysqli_stmt_execute($insert_stock)) {
        // Redirect to dashboard after successful insertion
        header("location: menu.php");
        exit();
    } else {
        // Handle error
        echo "Error: " . mysqli_error($db);
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .container {
            width: 50%;
            margin: 100px auto;
            background-color: rgba(255, 255, 255, 0.5);
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            backdrop-filter: blur(5px);
            padding: 20px;
        }

        input[type="text"],
        input[type="number"],
        input[type="textarea"] {
            width: 100%;
            padding: 8px 12px;
            margin: 4px 0;
            box-sizing: border-box;
            border: 2px solid #ccc;
            border-radius: 10px;
            background-color: #f8f8f8;
        }

        .register-button {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            width: 100%;
        }

        .register-button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <?php include 'layout/header.php' ?>
    <div class="container">
        <form action="" method="post">
    <form action="" method="post">

        <div class="mb-3">
            <label for="menuname" class="form-label">Menu ID</label>
            <input type="text" class="form-control" id="menuId" name="menuId" required>
        </div>
        <div class="mb-3">
            <label for="menuname" class="form-label">Menu Name</label>
            <input type="text" class="form-control" id="menuname" name="menuname" required>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control" id="price" name="price" required>
        </div>
        <div class="mb-3">
            <label for="desc" class="form-label">Description</label>
            <input type="textarea" class="form-control" id="desc" name="desc" required>
        </div>
        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity" required>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <input type="text" class="form-control" id="category" name="category" required>
        </div>

        <!-- <div class="mb-3">
            <label for="d" class="form-label">Insert Image: </label>
            <input type="file" class="form-control" id="photo" name="photo" required>
        </div> -->

        <button type="submit" name="addButton" class="register-button">Add</button>


    </form>
    </div>

</body>

</html>