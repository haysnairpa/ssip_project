<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>RAB Resto</title>
</head>

<body>
    <?php if (isset($_SESSION["is_login"]) && $_SESSION["is_login"]) :
        if (basename($_SERVER["SCRIPT_FILENAME"]) === "dashboard.php") : ?>
            <header style="display: flex; justify-content: space-between;">
                <h3 style="margin: 0;">
                    <a href="/../../ssip_project/admin/logout.php" style="text-decoration: none; color: black;">Logout</a>
                </h3>
            </header>
        <?php else : ?>
            <header style="display: flex; justify-content: space-between;">
                <h3 style="margin: 0;">
                    <a href="/../ssip_project/index.php" style="text-decoration: none; color: black;">RAB Resto</a>
                </h3>
                <h3 style="margin: 0;">
                    <a href="/../../ssip_project/admin/logout.php" style="text-decoration: none; color: black;">Logout</a>
                </h3>
            </header>
        <?php endif; ?>
    <?php else : ?>
        <h3 style="margin: 0;">
            <a href="/../ssip_project/index.php" style="text-decoration: none; color: black;">RAB Resto</a>
        </h3>
    <?php endif; ?>
</body>

</html>