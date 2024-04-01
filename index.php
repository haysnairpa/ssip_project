<?php

include "service/database.php";
session_start();

$_SESSION["is_login"] = false;

if (isset($_SESSION["is_order"]) && $_SESSION["is_order"]) {
    header("location: order.php");
}

// if ($_SESSION["is_order"] == false) {
//     header("location: index.php");
// }

$message = "";

if (isset($_POST["customerBtn"])) {
    if ($_POST["customer_name"] === null || $_POST["email"] === null || $_POST["phone"] === "") {
        $message = "Please fill all";
    } else {
        $customer_name = $_POST["customer_name"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
    
        $sql = "INSERT INTO customers(customer_name, email, phone) VALUES('$customer_name', '$email', '$phone') ";
    
        $db->query($sql);

        $_SESSION["is_order"] = true;

        header("location: order.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="layout/style.css">
    <title>RAB</title>
</head>
<body>
    <header>
    <?php include "layout/header.php" ?>
            <h3 style="margin: 0;">
                <a href="/../../ssip_project/admin/login.php" style="text-decoration: none; color: black;">Login</a>
            </h3>
        </header>
    <i><b><?= $message ?></b></i>
    <form action="index.php" method="post" name="customer">
            <table width="25%" border="0">
                <tr>
                    <td>Enter Name : </td>
                    <td><input type="text" name="customer_name"></td?>
                </tr>
                <tr>
                    <td>Enter Email : </td>
                    <td><input type="email" name="email"></td?>
                </tr>
                <tr>
                    <td>Phone Number : </td>
                    <td><input type="number" name="phone"></td?>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="customerBtn" value="Enter"></td?>
                </tr>
</body>
</html>