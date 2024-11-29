<?php 
session_start();
if($_SESSION['user'] != 'res') {
    header("Location: index.php?accessdenied=true");
    die();
} 

include("config.php");

if(isset($_POST['submit'])) {
    if($_POST['price'] > 0) {
        $ImageName = $_FILES['image']['name'];
        $fileElementName = 'image';
        $path = 'images/'; 
        $location = $path . $_FILES['image']['name']; 
        move_uploaded_file($_FILES['image']['tmp_name'], $location);
        
        $foodname = $_POST['foodname'];
        $price = $_POST['price'];
        $pref = NULL;
        if($_POST['pref'] == "veg")
            $pref = 0;
        else
            $pref = 1;

        $sql = "INSERT INTO food VALUES ('', '$foodname', ".$price.", ".$_SESSION['id'].", ".$pref.", '$location');";
        $conn->query($sql);
        echo '<script type="text/javascript">alert("Food Added");</script>';
    } else {
        echo '<script type="text/javascript">alert("Enter valid price amount");</script>';
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.18.1/build/cssnormalize/cssnormalize-min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image: url('images/background.jpg');
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
        }

        h2 {
            color: darkslategray;
            text-decoration: underline;
            margin-top: 30px;
            text-align: center;
            font-size: 2em;
        }

        .back-link {
            font-size: 1.2em;
            color: #800303;
            text-decoration: none;
            font-weight: bold;
            position: absolute;
            top: 20px;
            left: 20px;
        }

        .back-link:hover {
            color: #660303;
        }

        form {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            margin: 50px auto;
        }

        form > * {
            margin: 10px 0;
            width: 100%;
        }

        label {
            font-size: 1.1em;
            color: #333;
            margin-bottom: 5px;
            font-weight: 600;
        }

        input[type="text"], input[type="number"], input[type="file"] {
            padding: 12px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 8px;
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 20px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus, input[type="number"]:focus, input[type="file"]:focus {
            border-color: #00bcd4;
            outline: none;
        }

        fieldset {
            border: none;
            padding: 0;
            margin: 0;
        }

        input[type="radio"] {
            margin-right: 10px;
        }

        button[type="submit"] {
            background-color: #800303;
            color: white;
            padding: 15px;
            font-size: 1.2em;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        button[type="submit"]:hover {
            background-color: #660303;
        }
    </style>
    <title>Add Menu Item</title>
</head>
<body>

    <a class="back-link" href="res_home.php">&lt;&lt; Back</a>
    <h2>Add Food</h2>

    <form action="add_food.php" method="POST" enctype="multipart/form-data">
        <label for="foodname">Food Name</label>
        <input type="text" id="foodname" name="foodname" placeholder="Food Name" required>

        <label for="price">Price</label>
        <input type="number" step="1" id="price" name="price" placeholder="Enter price" required>

        <fieldset>
            <label>Food Preference</label>
            <input type="radio" id="veg" name="pref" value="veg" checked>
            <label for="veg">Veg</label>
            <input type="radio" id="non_veg" name="pref" value="non_veg">
            <label for="non_veg">Non-Veg</label>
        </fieldset>

        <label for="image">Food Image</label>
        <input type="file" id="image" name="image">

        <button type="submit" id="button" name="submit">Add Food</button>
    </form>

</body>
</html>
