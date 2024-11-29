<?php 
session_start();
if ($_SESSION['user'] != 'cus') {
    header("Location: index.php?accessdenied=true");
    die();
}

include("config.php"); 
if (isset($_GET['id'])) {
    $sql = "DELETE FROM cart WHERE id=" . $_GET['id'];
    mysqli_query($conn, $sql);
}

if (isset($_GET['order'])) {
    $sql = "SELECT * FROM cart WHERE user_id=" . $_SESSION['id'];
    $result = mysqli_query($conn, $sql);
    $price = 0;

    while ($row = mysqli_fetch_assoc($result)) {
        $food_sql = "SELECT * FROM food WHERE id=" . $row['food_id'];
        $food_result = mysqli_query($conn, $food_sql);
        $food = mysqli_fetch_assoc($food_result);

        $price += $row['quantity'] * $food['price'];
        $order_sql = "INSERT INTO orders VALUES (NULL," . $food['id'] . "," . $row['quantity'] . "," . $row['user_id'] . ",current_timestamp())";
        mysqli_query($conn, $order_sql);
    }

    $cart_del = "DELETE FROM cart WHERE user_id=" . $_SESSION['id'];
    mysqli_query($conn, $cart_del);

    echo '<script type="text/javascript">alert("Successfully ordered. Pay a total of ' . $price . ' rs on delivery.");</script>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
    <style>
    body {
        margin: 0;
        font-family: 'Arial', sans-serif;
        background-image: url('images/background.jpg');
        background-size: cover;
        background-attachment: fixed;
        color: white;
        display: flex;
        flex-direction: column;
        height: 100vh;
        justify-content: space-between;
    }

    h3, h2, p {
        margin: 0;
    }

    .back-link {
        margin: 15px;
        font-size: 1.2em;
        color: #00bcd4;
        text-decoration: none;
    }

    .back-link:hover {
        text-decoration: underline;
    }

    .menu {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        padding: 20px;
        gap: 20px;
        flex-grow: 1;
    }

    .food {
        background-color: rgba(0, 0, 0, 0.8);
        border-radius: 10px;
        padding: 15px;
        width: 250px;
        max-height: 450px;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .food:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.5);
    }

    .food img {
        border-radius: 10px;
        width: 100%;
        height: auto;
        margin-bottom: 10px;
    }

    .food h2 {
        font-size: 1.2em;
        margin: 10px 0;
    }

    .food p {
        font-size: 1em;
        margin: 5px 0;
    }

    .food a {
        display: inline-block;
        padding: 10px 20px;
        margin-top: 10px;
        background-color: crimson;
        color: white;
        text-decoration: none;
        font-size: 1em;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .food a:hover {
        background-color: darkred;
    }

    .order-button-container {
        width: 100%;
        text-align: center;
        margin-top: 30px;
        margin-bottom: 20px;
    }

    .order-button {
        display: inline-block;
        padding: 15px 25px;
        font-size: 1.5em;
        color: white;
        background-color: #4caf50;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .order-button:hover {
        background-color: #388e3c;
    }

    .empty-cart {
        text-align: center;
        font-size: 1.5em;
        margin-top: 50px;
        color: lightgray;
    }
</style>
</head>
<body>

<a href="res_home.php" class="back-link"><< Back</a>

<div class="menu">
    <?php 
    $sql = "SELECT * FROM cart WHERE user_id=" . $_SESSION['id'];
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $food_sql = "SELECT * FROM food WHERE id=" . $row['food_id'];
            $food_result = mysqli_query($conn, $food_sql);
            $food = mysqli_fetch_assoc($food_result);

            $res_sql = "SELECT * FROM restaurents WHERE id=" . $food['res_id'];
            $res_result = mysqli_query($conn, $res_sql);
            $res = mysqli_fetch_assoc($res_result);

            $pref = $food['pref'] ? "Non-veg" : "Veg";

            echo "<div class='food'>";
            echo "<img src='" . $food['image'] . "' alt='Food Image'>";
            echo "<h2>" . $food['name'] . "</h2>";
            echo "<p>Price: Rs." . $food['price'] . "</p>";
            echo "<p>Type: " . $pref . "</p>";
            echo "<p>Quantity: " . $row['quantity'] . "</p>";
            echo "<p>Restaurant: " . $res['name'] . "</p>";
            echo "<p>Location: " . $res['location'] . "</p>";
            echo "<a href='cart.php?id=" . $row['id'] . "'>Delete</a>";
            echo "</div>";
        }
    } else {
        echo "<p class='empty-cart'>Your cart is empty.</p>";
    }
    ?>
</div>

<div class="order-button-container">
    <button class="order-button" onclick="window.location.href='cart.php?order=true'">Order Now</button>
</div>

</body>
</html>
