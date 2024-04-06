<?php
include __DIR__ . "/../service/database.php";
session_start();


    $id = $_GET["dish_id"];

    $result_stock = mysqli_query($db, "DELETE FROM stock WHERE dish_id = '$id'");

    $result_menu = mysqli_query($db, "DELETE FROM menu WHERE dish_id = '$id'");

    header("location: dashboard.php");
       
?>
