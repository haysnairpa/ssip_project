<?php

    include "service/database.php";
    session_start();

    if ($_SESSION["is_order"] == false) {
        header("location: index.php");
    }

    $table_query = "SELECT * FROM meja";
    $table = $db->query($table_query);

    $customer_query = "SELECT * FROM customers";
    $customer = $db->query($customer_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="layout/style.css">
    <title>RAB Resto</title>
</head>
<body>
    <header style="display: flex; justify-content: space-between;">
                <h3 style="margin: 0;">
                    <a href="/../ssip_project/index.php" style="text-decoration: none; color: black;">RAB Resto</a>
                </h3>
                <h3 style="margin: 0;">
                    <a href="/../../ssip_project/admin/logout.php" style="text-decoration: none; color: black;">Logout</a>
                </h3>
            </header>
    <div class="container">
        <?php foreach ($table as $tbl): ?>
            <div class="card" onclick="goToMeja()">
                <b><?= $tbl['set_no'] . " " . $tbl['set_type'] ?></b>
                <p>
                    <?= $tbl['customer_name'] == NULL && $tbl['total_people'] == NULL ? "SET EMPTY" :
                    $tbl['customer_name'] . " " . "(" . $tbl['total_people'] . " person )"
                    ?>
                </p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
