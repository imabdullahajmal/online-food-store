<?php 
session_start();
if($_SESSION['user'] != 'res') {
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
    <title>View Orders</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #424242;
            background-image: url("images/bg-scaled.jpg");
        }
        .back-button {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #1e88e5;
            font-size: 18px;
            margin: 20px 0;
            align-self: flex-start;
            margin-left: 20px;
        }
        .back-button .material-icons {
            font-size: 24px;
            margin-right: 8px;
        }
        .back-button:hover {
            text-decoration: underline;
        }
        .menu {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 20px;
            max-width: 1200px;
        }
        .food {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 320px;
            transition: box-shadow 0.3s ease-in-out;
        }
        .food:hover {
            box-shadow: 0px 8px 12px rgba(0, 0, 0, 0.2);
        }
        .food img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }
        .food h2 {
            margin: 10px 15px;
            font-size: 18px;
            color: #616161;
            line-height: 1.5;
        }
        .food h2 span {
            font-weight: bold;
            color: #424242;
        }
        .food .details {
            padding: 10px 15px;
            border-top: 1px solid #e0e0e0;
        }
        .food .details h2 {
            margin: 5px 0;
        }
        .no-orders {
            font-size: 24px;
            color: #9e9e9e;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <a href="res_home.php" class="back-button">
        <span class="material-icons">arrow_back</span> Back
    </a>
    <div class="menu">
        <?php 
        $sql = "SELECT * FROM orders WHERE food_id = ANY
                                    (SELECT id FROM food WHERE res_id =". $_SESSION['id'].") ORDER BY time DESC;";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $food = $conn->query("SELECT * FROM food WHERE id =".$row['food_id'])->fetch_assoc();
                $user = $conn->query("SELECT * FROM customers WHERE id =".$row['user_id'])->fetch_assoc();
                $pref = $food['pref'] ? "Non-veg" : "Veg";
                $dt = explode(" ", $row['time']);
                $date = $dt[0];
                $time = $dt[1];
                echo "<div class='food'>";
                echo "<img src='".$food['image']."' alt='Food Image'> 
                      <div class='details'>
                        <h2><span>Name:</span> " . $food["name"]. "</h2>
                        <h2><span>Price:</span> " . $food["price"]." rs</h2>
                        <h2><span>Food type:</span> ".$pref."</h2>
                        <h2><span>Quantity:</span> " . $row["quantity"]. "</h2>
                        <h2><span>Ordered by:</span> " . $user["name"]."</h2>
                        <h2><span>Phone no:</span> " . $user["phone_no"]."</h2>
                        <h2><span>Date:</span> ".$date."</h2>
                        <h2><span>Time:</span> ".$time." hrs</h2>
                      </div>";
                echo "</div>";
            }
        } else {
            echo "<div class='no-orders'>NO ORDERS YET</div>";
        }
        $conn->close();
        ?>
    </div>
</body>
</html>
