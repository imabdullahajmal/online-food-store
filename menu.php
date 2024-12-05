<?php 
session_start();
include("config.php");

if (isset($_POST['submit'])) {
    if ($_SESSION['user'] == 'cus') {
        if ($_POST['quantity'] > 0) {
            $sql = "INSERT INTO cart VALUES ('', " . $_POST['id'] . "," . $_POST['quantity'] . "," . $_SESSION['id'] . ");";
            mysqli_query($conn, $sql);
            echo '<script type="text/javascript">alert("Added to cart");</script>';
        } else {
            echo '<script type="text/javascript">alert("Quantity should be greater than 0");</script>';
        }
    } else if ($_SESSION['user'] == 'res') {
        echo '<script type="text/javascript">alert("Restaurants cannot order");</script>';
    } else {
        header("Location: login_usr.php?login=false");
        die(); 
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <style>
        body {
            background-image: url('images/background.jpg');
            background-size: cover;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .menu {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
        }
        .food {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 300px;
            margin: 20px;
            text-align: center;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .food:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }
        .food img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .food h2 {
            font-size: 1.2em;
            margin: 10px 0;
            color: #333;
        }
        .food p {
            font-size: 1em;
            color: #555;
        }
        .food form {
            margin: 15px 0;
        }
        .food input[type="number"] {
            width: 80%;
            padding: 8px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: center;
        }
        .food button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.2s ease;
        }
        .food button:hover {
            background-color: #0056b3;
        }
        .back-link {
            display: inline-block;
            margin: 20px;
            font-size: 1.2em;
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
            transition: color 0.2s ease;
        }
        .back-link:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>

<?php
if (isset($_SESSION['user'])) {
    if ($_SESSION['user'] == 'cus') {
        echo "<a class='back-link' href='cus_home.php'><< Back</a>";
    } else if ($_SESSION['user'] == 'res') {
        echo "<a class='back-link' href='res_home.php'><< Back</a>";
    } else {
        echo "<a class='back-link' href='index.php'><< Back</a>";
    }
}
?>

<div class="menu">
    <?php 
    include("config.php");

    if (isset($_SESSION['user']) && $_SESSION['user'] == 'cus') {
        $pref_result = mysqli_query($conn, "SELECT pref FROM customers WHERE id =" . $_SESSION['id']);
        $pref = mysqli_fetch_assoc($pref_result);
        $sql = "SELECT * FROM food ORDER BY pref=" . $pref['pref'] . " DESC";
    } else {
        $sql = "SELECT * FROM food";
    }

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $res_result = mysqli_query($conn, "SELECT * FROM restaurents WHERE id =" . $row['res_id']);
            $res = mysqli_fetch_assoc($res_result);
            $pref = $row['pref'] ? "Non-veg" : "Veg";

            echo "<div class='food'>";
            echo "<img width='250' height='250' style='vertical-align:top;' src=" . $row['image'] . "> 
                  <h2>Name: " . $row["name"] . "</h2>
                  <h2>Price: " . $row["price"] . " rs</h2>
                  <h2>Food type: " . $pref . "</h2>
                  <h2>Restaurant: " . $res["name"] . "</h2>
                  <h2>Location: " . $res["location"] . "</h2>
                  <form action='menu.php' method='POST'>
                  <input type='number' step='1' id='price' name='quantity' placeholder='Enter quantity'>
                  <input type='hidden' name='id' value='" . $row['id'] . "'>
                  <button type='submit' id='button' name='submit'>Order</button></form>";
            echo "</div>";
        }
    } else {
        echo "NO FOOD";
    }

    mysqli_close($conn);
    ?>
</div>
</body>
</html>
