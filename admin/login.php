<?php

include __DIR__ . "/../service/database.php";
session_start();

if (isset($_SESSION["is_login"]) && $_SESSION["is_login"]) {
    header("location: /../admin/dashboard.php");
}

$message = "";

if (isset($_POST["loginBtn"])) {
    if ($_POST["username"] ===  "" || $_POST["password"] ===  "") {
        $message = "Please fill in the blank!";
    } else {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $sql = "SELECT * FROM admin where
        username = '$username' and
        password = '$password'";

        $result = $db -> query($sql);

        if ($result -> num_rows > 0) {
            $data = $result -> fetch_assoc();

            // $_SESSION["username"] = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
            $_SESSION["is_login"] = true;
            $_SESSION["username"] = $data["username"];

            header("location: ../admin/dashboard.php");
        } else {
            $message = "INVALID USERNAME OR PASSWORD";
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../layout/style.css">
    <title>Admin</title>
</head>
<body>
    <?php include __DIR__ . "/../layout/header.php"; ?>
    <form action="login.php" method="post">
        <i><b><?= $message ?></b></i>
        <table width="25%" border="0">
            <tr>
                <td>username : </td>
                <td><input type="text" name="username"></td>
            </tr>
            <tr>
                <td>password : </td>
                <td><input type="password" name="password"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="loginBtn" value="login"></td>
            </tr>
        </table>
    </form>
</body>
</html>