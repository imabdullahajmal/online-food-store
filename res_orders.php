
<?php session_start();
if($_SESSION['user'] != 'res')
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
    <title>View Orders</title>
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
    $sql = "SELECT * FROM orders WHERE food_id = ANY
                                    (SELECT id FROM food WHERE res_id =". $_SESSION['id'].") ORDER BY time DESC;";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $food = $conn->query("SELECT * FROM food WHERE id =".$row['food_id'])->fetch_assoc();
            $user = $conn->query("SELECT * FROM customers WHERE id =".$row['user_id'])->fetch_assoc();
            $pref = $food['pref']?"Non-veg":"Veg";
            $dt = explode(" ",$row['time']);
            $date = $dt[0];
            $time = $dt[1];
            echo "<div class='food'>";
            echo "<img width = '250' height = '250' style='vertical-align:top;' src=".$food['image']."> 
                 <h2>Name: " . $food["name"]. "<h2><h2>Price: " . $food["price"]." rs</h2><h2>Food type: ".$pref."<h2>".
                 "<h2>Quantity: " . $row["quantity"]. "<h2><h2>Ordered by: " . $user["name"]."</h2>".
                 "<h2>Phone no: " . $user["phone_no"].
                 "<h2>Date: ".$date."</h2><h2> Time: ".$time." hrs</h2>";
            echo "</div>";
        }
    } else {
        echo "NO ORDERS YET";
    }
    $conn->close();
    ?>
  </div>
</body>
</html>
  
    