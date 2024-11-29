<?php 
session_start();
include("redirect_to_home.php");
if(isset($_GET['reg_success'])){ 
    echo '<script type="text/javascript">alert("Registered successfully");</script>';
}
if(isset($_GET['accessdenied'])){ 
    echo '<script type="text/javascript">alert("Access Denied");</script>';
}
if(isset($_GET['loggedout'])){
    echo '<script type="text/javascript">alert("No one logged in!");</script>';
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
    </style>
    <title>FoodShala</title>
</head>
<body>
    <nav>
        <h1>FOODSHALA</h1>
        <ul class="nav-buttons">
            <li><a href="menu.php">Menu</a></li>
            <li><a href="login_usr.php">Login (Customer)</a></li>
            <li><a href="login_res.php">Login (Restaurant)</a></li>
            <li><a href="register_usr.php">Register (Customer)</a></li>
            <li><a href="register_res.php">Register (Restaurant)</a></li>
        </ul>
    </nav>
</body>
</html>
