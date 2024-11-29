<?php 
session_start();
if ($_SESSION['user'] != 'cus') {
    header("Location: index.php?accessdenied=true");
    die();
}
include("config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <style>
        body {
            background-image: url('images/background.jpg');
            background-size: cover;
            background-position: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            color: white;
        }

        h3 {
            color: white;
            margin-left: 20px;
        }

        .menu {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin: 20px;
            justify-content: center;
        }

        .food {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            width: 300px;
            height: auto;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s ease-in-out;
        }

        .food:hover {
            transform: scale(1.05);
        }

        .food img {
            width: 250px;
            height: 250px;
            border-radius: 10px;
            object-fit: cover;
        }

        .food h2 {
            font-size: 1.2em;
            margin: 5px 0;
            color: #fff;
        }

        .food h2 span {
            font-weight: bold;
        }

        .back-button {
            font-size: 1.2em;
            color: white;
            text-decoration: none;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: rgba(0, 0, 0, 0.7);
        }

    </style>
</head>
<body>
    <a href="res_home.php" class="back-button"><< Back</a>
    <div class="menu">
        <?php 
            include("config.php");

            // Fetch orders for the logged-in user
            $sql = "SELECT * FROM orders WHERE user_id = " . $_SESSION['id'] . " ORDER BY time DESC;";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // Get the food details
                    $foodQuery = "SELECT * FROM food WHERE id = " . $row['food_id'];
                    $foodResult = mysqli_query($conn, $foodQuery);
                    $food = mysqli_fetch_assoc($foodResult);

                    // Get the restaurant details
                    $resQuery = "SELECT * FROM restaurents WHERE id = " . $food['res_id'];
                    $resResult = mysqli_query($conn, $resQuery);
                    $res = mysqli_fetch_assoc($resResult);

                    // Display preference
                    $pref = $food['pref'] ? "Non-veg" : "Veg";

                    // Format the date and time
                    $dt = explode(" ", $row['time']);
                    $date = $dt[0];
                    $time = $dt[1];

                    // Display each order
                    echo "<div class='food'>";
                    echo "<img src='" . $food['image'] . "' alt='Food Image'>";
                    echo "<h2>Name: <span>" . $food["name"] . "</span></h2>";
                    echo "<h2>Price: <span>" . $food["price"] . " rs</span></h2>";
                    echo "<h2>Food Type: <span>" . $pref . "</span></h2>";
                    echo "<h2>Quantity: <span>" . $row["quantity"] . "</span></h2>";
                    echo "<h2>Restaurant: <span>" . $res["name"] . "</span></h2>";
                    echo "<h2>Location: <span>" . $res["location"] . "</span></h2>";
                    echo "<h2>Date: <span>" . $date . "</span></h2>";
                    echo "<h2>Time: <span>" . $time . " hrs</span></h2>";
                    echo "</div>";
                }
            } else {
                echo "<h2>No orders yet.</h2>";
            }

            mysqli_close($conn);
        ?>
    </div>
</body>
</html>
