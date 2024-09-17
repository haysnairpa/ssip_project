<?php include 'layout/header.php'; ?>

<?php

include "database.php";
include "layout/header2.php";

if(isset($_POST['update_update_btn'])){
    $update_amount = $_POST['update_amount'];
    $update_name = $_POST['update_amount_name'];
    $update_quantity_query = mysqli_query($db, "UPDATE `orders` SET total_amount = '$update_amount' WHERE name = '$update_name'");
    if($update_quantity_query){
       header('location:cart.php');
    };
 };

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cart.css">
    <title>Shopping Cart</title>

</head>

<body>
    <h4>Shopping Cart</h4>
    <div class="cart-container">
        <?php

        ?>
        <table class="table">
            <thead class="text-center">
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Action</th>
            </thead>
            <tbody class="text-center">
                <?php

                $select_cart = mysqli_query($db, "SELECT * FROM `orders`");
                $grand_total = 0;
                if (mysqli_num_rows($select_cart) > 0) {
                    while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                ?>
                        <tr>
                            <td><?php echo $fetch_cart['name']; ?></td>
                            <td>$<?php echo number_format($fetch_cart['price']); ?>/-</td>
                            <td>
                                <form action="" method="post">
                                    <input type="hidden" name="update_amount_name" value="<?= $fetch_cart['name']; ?>">
                                    <input type="number" name="update_amount" min="1" value="<?php echo $fetch_cart['total_amount']; ?>">
                                    <input type="submit" class="btn btn-success" value="update" name="update_update_btn">
                                </form>
                            </td>
                            <td>$<?php echo $sub_total = number_format($fetch_cart['price'] * $fetch_cart['total_amount']); ?>/-</td>
                            <td><a href="cart.php?remove=<?php  ?>" class="btn btn-danger delete-btn">remove</a></td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>