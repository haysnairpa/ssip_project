<?php
include "database.php"; // Include the database connection file

$query = "SELECT m.dish_id, m.dish_name, m.price, m.description,
m.category, s.quantity
FROM menu m
INNER JOIN stock s ON m.dish_id = s.dish_id
ORDER BY m.price
ASC
";

$query2 = "SELECT m.dish_id, m.dish_name, m.price, m.description,
m.category, s.quantity
FROM menu m
LEFT JOIN stock s ON m.dish_id = s.dish_id
GROUP BY m.dish_id
HAVING quantity < 5
ORDER BY m.category, m.price DESC";

// Process form submission
if (isset($_POST['add_to_cart'])) {
    $dish_name = $_POST['dish_name'];
    $price = $_POST['price'];
    $quantity = isset($_POST['total_amount']) ? intval($_POST['total_amount']) : 1;
    
    $customer_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    if ($customer_id) {
        $check_query = mysqli_query($db, "SELECT * FROM orders WHERE customer_id = '$customer_id' AND name = '$dish_name'");
        
        if (mysqli_num_rows($check_query) > 0) {
            $update_query = mysqli_query($db, "UPDATE orders SET quantity = quantity + $quantity, total_amount = total_amount + ($price * $quantity) WHERE customer_id = '$customer_id' AND name = '$dish_name'");
        } else {
            $insert_query = mysqli_query($db, "INSERT INTO orders (customer_id, name, price, quantity, total_amount) VALUES ('$customer_id', '$dish_name', '$price', '$quantity', '$price' * '$quantity')");
        }
        
        if ($update_query || $insert_query) {
            echo "<script>alert('Item added to cart successfully!');</script>";
        } else {
            echo "<script>alert('Error adding item to cart.');</script>";
        }
    } else {
        echo "<script>alert('Please login to add items to cart.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="menu2.css">
    <title>Menu</title>
</head>
<body>
    <?php include "layout/header2.php"; ?>

    <div class="menu-container">
        <?php
        $result = mysqli_query($db, $query); 

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
                <div class="menu-item">
                    <h2><?= $row["dish_name"] ?></h2>
                    <p>Price: <?= $row["price"] ?></p>
                    <p>Description: <?= $row["description"] ?></p>
                    <p>Category: <?= $row["category"] ?></p>
                    <p>Quantity: <?= $row["quantity"] ?></p>
                    <form action="" method="post">
                        <input type="hidden" name="dish_name" value="<?= htmlspecialchars($row["dish_name"]) ?>">
                        <input type="hidden" name="price" value="<?= $row["price"] ?>">
                        
                        <input type="hidden" name="total_amount" value="<?= isset($_POST['total_amount']) ? htmlspecialchars($_POST['total_amount']) : '1' ?>">
                        <input type="submit" name="add_to_cart" value="Order">
                    </form>
                </div>
        <?php
            }
        } else {
            echo "Menu is empty.";
        }
        ?>
    </div>

    <!-- Customer selection form -->
    <form method="post" action="">
        <label for="customer_id">Select Customer:</label>
        <select name="customer_id" id="customer_id">
            <?php
            $customer_query = "SELECT customer_id, customer_name FROM customers";
            $customer_result = mysqli_query($db, $customer_query);

            if ($customer_result && mysqli_num_rows($customer_result) > 0) {
               

                while ($row = mysqli_fetch_assoc($customer_result)) {
                    echo "<option value='" . $row["customer_id"] . "'>" . $row["customer_name"] . "</option>";
                }
            }
            ?>
        </select>
    </form>

</body>
</html>
