<?php
session_start();
if ($_SESSION['user'] != 'res') {
    header("Location: index.php?accessdenied=true");
    die();
} 
include("config.php");
$sql = "SELECT name FROM restaurents WHERE id = " . $_SESSION['id'];
$result = mysqli_query($conn, $sql);

$name_ = mysqli_fetch_assoc($result);
$name = $name_['name'];

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.18.1/build/cssnormalize/cssnormalize-min.css">
    <style>
        body {
            background-color: white;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #333;
        }

        nav h1 {
            font-family: "Comic Sans MS", cursive, sans-serif;
            font-style: oblique;
            font-weight: bold;
            font-size: 3em;
            color: white;
            margin: 0;
        }

        .nav-buttons {
            display: flex;
        }

        .nav-buttons li {
            list-style: none;
            margin-left: 20px;
        }

        .nav-buttons li a {
            color: white;
            text-align: center;
            padding: 15px;
            text-decoration: none;
            border: 1px solid #bbb;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .nav-buttons li a:hover {
            background-color: #ddd;
            color: #333;
        }

        .container {
            margin-top: 100px;
            text-align: center;
        }

        h3 {
            color: #333;
            font-size: 1.5em;
        }

        h1 {
            font-family: "Comic Sans MS", cursive, sans-serif;
            font-style: oblique;
            font-weight: bold;
            font-size: 6em;
            color: #333;
            margin-top: 20px;
        }
    </style>
    <title>Home</title>
</head>
<body>

    <nav>
        <h1>FOODSHALA</h1>
        <ul class="nav-buttons">
            <li><a href="menu.php">Menu</a></li>
            <li><a href="add_food.php">Add Menu Item</a></li>
            <li><a href="delete_food.php">My Food</a></li>
            <li><a href="res_orders.php">View Orders</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="container">
        <h3>Welcome <?php echo htmlspecialchars($name); ?></h3>
        <h1>FOODSHALA</h1>
    </div>

</body>
</html>
