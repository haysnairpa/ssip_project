<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .menu-content {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .menu-row {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .menu-column {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-right: 20px;
        }

        .menu-column img {
            margin-left: 20px;
            margin-top: 20px;
            border-radius: 10px;
            transition: 0.3s ease;
            height: 300px;
            object-fit: cover;
            margin-bottom: 0px;
            display: block;
        }

        .menu-column-text {
            display: flex;
            flex-direction: column;
            align-items: center;
            border-radius: 20px;
            padding: 20px;
            text-align: center;
            background-color: #f0f0f0;
            margin: 20px 20px 0 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .menu-column-text p {
            margin: 0;
        }

        .number-column {
            margin-top: 10px;
        }

        .submit-button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 8px 26px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 12px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 20px;
        }

        /* Sticky footer styles */
        html {
            position: relative;
            min-height: 100%;
        }

        body {
            margin: 0;
            padding-bottom: 100px;
            /* Height of the footer */
        }

        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #25b3ff;
            color: white;
            text-align: center;
            height: 40px;
            padding-top: 5px;
            padding-bottom: 5px;
        }
    </style>
</head>

<body>
    <div class="menu-content">
        <div class="menu-row">
            <div class="menu-column">
                <img src="./image/image1.png" alt="./image/image 1">
                <input type="number" class="number-column">
            </div>
            <div class="menu-column-text">
                <p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum libero, vero, quos magni commodi repudiandae quaerat, repellendus autem tenetur dignissimos veniam quasi saepe nulla temporibus sit quas laudantium cum corrupti.</p>
            </div>
        </div>
        <div class="menu-row">
            <div class="menu-column">
                <img src="./image/image2.png" alt="./image/image 2">
                <input type="number" class="number-column">
            </div>
            <div class="menu-column-text">
                <p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores quisquam molestiae fuga ad animi quaerat tempora excepturi earum, assumenda nostrum, nesciunt fugit, nihil aspernatur dolor! Facilis accusantium obcaecati at architecto.</p>
            </div>
        </div>
        <div class="menu-row">
            <div class="menu-column">
                <img src="./image/image3.png" alt="./image/image 3">
                <input type="number" class="number-column">
            </div>
            <div class="menu-column-text">
                <p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae voluptatem excepturi facilis qui dicta dolorum quod porro laboriosam dolor quidem, corrupti pariatur reiciendis consequatur alias nam aliquid nulla perferendis! Atque?</p>
            </div>
        </div>
        <div class="menu-row">
            <div class="menu-column">
                <img src="./image/image4.png" alt="./image/image 4">
                <input type="number" class="number-column">
            </div>
            <div class="menu-column-text">
                <p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Non libero excepturi dolor quibusdam similique autem, alias laudantium doloremque impedit idsapiente qui, doloribus totam, fugit dicta sunt omnis cum error!</p>
            </div>
        </div>
        <div class="menu-row">
            <div class="menu-column">
                <img src="./image/image1.png" alt="./image/image 5">
                <input type="number" class="number-column">
            </div>
            <div class="menu-column-text">
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Suscipit perspiciatis quam odit facilis accusantium dolores explicabo reiciendis animi nulla amet, in vel qui ullam velit corrupti? Exercitationem magni necessitatibus iure?</p>
            </div>
        </div>
    </div>

    <div class="footer">
        <form method="post" action="order.php">
            <button type="submit" class="submit-button">Submit</button>
        </form>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get form data
        $quantity = $_POST['quantity'];

        // Connect to database
        $conn = mysqli_connect("localhost", "username", "password", "database");

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Insert data into database
        $sql = "INSERT INTO orders (quantity) VALUES ('$quantity')";
        if (mysqli_query($conn, $sql)) {
            echo "Data inserted successfully";
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        // Close connection
        mysqli_close($conn);
    }
    ?>
</body>

</html>