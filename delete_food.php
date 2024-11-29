<?php 
session_start();

if ($_SESSION['user'] != 'res') {
    header("Location: index.php?accessdenied=true");
    die();
}

include("config.php");

if (isset($_GET['id'])) {
    $food_id = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "DELETE FROM food WHERE id = $food_id";
    mysqli_query($conn, $sql);

    $sql2 = "DELETE FROM orders WHERE food_id = $food_id";
    mysqli_query($conn, $sql2);
    
    $sql3 = "DELETE FROM cart WHERE food_id = $food_id";
    mysqli_query($conn, $sql3);
    
    header("Location: res_food.php?delete_success=true");
    die();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Food</title>
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
            font-size: 1.2em;
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
            width: 250px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s ease-in-out;
            margin: 10px;
        }

        .food:hover {
            transform: scale(1.05);
        }

        .food img {
            width: 100%;
            height: 200px;
            border-radius: 10px;
            object-fit: cover;
        }

        .food h2 {
            font-size: 1.1em;
            margin: 5px 0;
        }

        .food h2 span {
            font-weight: bold;
        }

        .food a {
            display: inline-block;
            margin-top: 10px;
            color: red;
            text-decoration: none;
            font-size: 1.2em;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 8px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .food a:hover {
            background-color: rgba(255, 0, 0, 0.7);
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
    $sql = "SELECT * FROM food WHERE res_id = " . $_SESSION['id'];
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $pref = $row['pref'] ? "Non-veg" : "Veg";

            echo "<div class='food'>";
            echo "<img src='" . $row['image'] . "' alt='Food Image'> 
                  <h2>Name: <span>" . $row["name"] . "</span></h2>
                  <h2>Price: <span>" . $row["price"] . " rs</span></h2>
                  <h2>Food type: <span>" . $pref . "</span></h2>
                  <a href='?id=" . $row["id"] . "'>Delete</a>";
            echo "</div>";
        }
    } else {
        echo "<h2>No food items added yet.</h2>";
    }

    mysqli_close($conn);
    ?>
</div>

</body>
</html>
