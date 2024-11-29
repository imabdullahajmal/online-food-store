<?php 
session_start();
if($_SESSION['user'] != 'cus')
{
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
         body{
            background-image: url('images/background.jpg');
            background-size: cover;
            
            }
        .menu {
            width: 75em;
            height: fit-content;
            border: solid lightblue 2px;
            margin: 10px;
            display: flex;
            flex-wrap: wrap;
            }
        .food{
            width: fit-content;
            height: fit-content;
            padding: 5px ; 
            margin: 18px; 
            display: block; 
            border: dashed  2px; 
        }
        
    </style>
</head>
<body>
<a  href="res_home.php"><h3 style = "margin-left: 10px;"><< Back</h3></a>
<div class="menu">
<?php 
    include("config.php");
    $sql = "SELECT * FROM orders WHERE user_id = " . $_SESSION['id'] . " ORDER BY time DESC;";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $foodQuery = "SELECT * FROM food WHERE id = " . $row['food_id'];
            $foodResult = mysqli_query($conn, $foodQuery);
            $food = mysqli_fetch_assoc($foodResult);

            $resQuery = "SELECT * FROM restaurents WHERE id = " . $food['res_id'];
            $resResult = mysqli_query($conn, $resQuery);
            $res = mysqli_fetch_assoc($resResult);

            $pref = $food['pref'] ? "Non-veg" : "Veg";
            $dt = explode(" ", $row['time']);
            $date = $dt[0];
            $time = $dt[1];

            echo "<div class='food'>";
            echo "<img width='250' height='250' style='vertical-align:top;' src=" . $food['image'] . "> 
                 <h2>Name: " . $food["name"] . "</h2><h2>Price: " . $food["price"] . " rs</h2><h2>Food type: " . $pref . "</h2>" .
                 "<h2>Quantity: " . $row["quantity"] . "</h2><h2>Restaurent: " . $res["name"] . "</h2><h2>Location: " . $res["location"] .
                 "</h2><h2>Date: " . $date . "</h2><h2>Time: " . $time . " hrs</h2>";
            echo "</div>";
        }
    } else {
        echo "NO ORDERS YET";
    }

    mysqli_close($conn);
?>

  </div>
</body>
</html>
  
    