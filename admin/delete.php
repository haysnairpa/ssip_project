<?php

include __DIR__ . "/../service/database.php";

$id = $_GET["dish_id"];

$result = mysqli_query($db, "DELETE FROM menu WHERE dish_id = $id");

header("location: dashboard.php");

?>