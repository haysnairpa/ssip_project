<?php

include __DIR__ . "/database.php";
session_start();

if (isset($_POST["logoutBtn"])) {

    session_destroy();
    header("location: login.html");
    exit();
}

if (isset($_SESSION["is_login"]) && $_SESSION["is_login"]) {
    header("location: landing.php");
}

$message = "";

if (isset($_POST["loginBtn"])) {
    if ($_POST["username"] ===  "" || $_POST["password"] ===  "") {
        $message = "Please fill in the blank!";
    } else {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $sql = "SELECT 'admin' AS user_type, id, username, password FROM admin 
                WHERE username = '$username' AND password = '$password'
                UNION
                SELECT 'customer' AS user_type, customer_id, username, password FROM customers 
                WHERE username = '$username' AND password = '$password'";
                
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
        
            $_SESSION["is_login"] = true;
            $_SESSION["username"] = $data["username"];
            
            // Check the user type and redirect accordingly
            if ($data["user_type"] === 'admin') {
                header("location: landing.php");
            } else {
                $insertquery=$db->query("INSERT INTO login (customer_id)
                SELECT customer_id FROM customers WHERE username ='$username'");
                header("location: landing2.php");
            }
        } else {
            $message = "INVALID USERNAME OR PASSWORD";
            // Redirect back to the login page with the error message
            header("location: submit-login.php?message=" . urlencode($message));
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
<?php if (isset($_SESSION["is_login"]) && $_SESSION["is_login"]) { ?>
    <div class="logout-container">
        <form action="submit-login.php" method="POST">
            <input type="submit" name="logoutBtn" value="Logout" class="logout-button"></input>
        </form>
    </div>
    <i><b><?= $message ?></b></i>
<?php } else { ?>
<div class="login-container">
    <form action="submit-login.php" method="POST" class="login-form  p-5">
        <h2>Login</h2>
        <?php if (!empty($message)) { ?>
            <p class="error-message"><?php echo htmlspecialchars($message); ?></p>
        <?php } ?>
        <div class="">
            <label for="username">Username</label>
            <input type="text" class="form-control mt-3" id="username" name="username" required>
        </div>
        <div class="">
            <label for="password">Password</label>
            <input type="password" class="form-control mt-3" id="password" name="password" required>
        </div>
        <div class="text-center">
            <input type="submit" class="btn btn-primary align-center mt-3 px-5" name="loginBtn" value="Login"></input>
        </div>
        <p class="mt-3">Belum punya akun? <a href="register.php" class="text-dark">Daftar Sekarang</a></p>
    </form>
</div>
<?php } ?>
</body>
</html>