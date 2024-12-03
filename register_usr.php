<?php 
session_start();
include("redirect_to_home.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.18.1/build/cssnormalize/cssnormalize-min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('images/background.jpg');
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
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

        h3 {
            color: #fff;
            margin-left: 20px;
            font-size: 1.2em;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
            display: inline-block;
            padding: 10px;
            text-decoration: none;
            cursor: pointer;
        }

        h3:hover {
            text-decoration: underline;
        }

        h2 {
            color: darkslategray;
            text-decoration: underline;
            margin-left: 20px;
            font-size: 2em;
            font-weight: bold;
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.8);
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .form-container label {
            font-size: 1.1em;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }

        .form-container input, .form-container fieldset {
            width: 100%;
            padding: 12px;
            margin: 8px 0 16px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 1em;
            background-color: #f7f7f7;
        }

        .form-container input[type="radio"] {
            width: auto;
            margin-right: 10px;
        }

        .form-container button {
            background-color: #800303;
            color: white;
            padding: 15px;
            width: 100%;
            font-size: 1.2em;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-container button:hover {
            background-color: #660303;
        }

        .form-container a {
            display: block;
            text-align: center;
            color: #00bcd4;
            font-size: 1.1em;
            text-decoration: none;
            margin-top: 20px;
        }

        .form-container a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            h2 {
                font-size: 1.6em;
            }

            .form-container {
                padding: 15px;
                width: 90%;
            }
        }
    </style>
    <title>Customer Registration</title>
</head>
<body>
    <nav>
        <h1>GrubGrab</h1>
        <ul class="nav-buttons">
            <li><a href="menu.php">Menu</a></li>
            <li><a href="login_usr.php">Login (Customer)</a></li>
            <li><a href="login_res.php">Login (Restaurant)</a></li>
            <li><a href="register_usr.php">Register (Customer)</a></li>
            <li><a href="register_res.php">Register (Restaurant)</a></li>
        </ul>
    </nav>

    <a href="index.php"><h3><i class="fas fa-arrow-left"></i> Back</h3></a>
    
    <div class="form-container">
        <h2>Register Customer</h2>
        
        <?php
        include("config.php");
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone_no = $_POST['phone_no'];
            $password = $_POST['password'];
            $pref = NULL;
            if ($_POST['pref'] == "veg")
                $pref = 0;
            else
                $pref = 1;

            $sql_check = "SELECT * FROM customers WHERE email LIKE '$email'";
            $result_chk = mysqli_query($conn, $sql_check);
            
            if (mysqli_num_rows($result_chk) > 0) {
                echo '<script type="text/javascript">alert("User account with that email already exists!");</script>';
            } else if (strlen($phone_no) != 10) {
                echo '<script type="text/javascript">alert("Phone number should be of 10 digits.");</script>';
            } else {
                $hashedpass = hash('sha256', $password . $email);
                $sql = "INSERT INTO customers (name, email, password, preference, phone_no) 
                        VALUES ('$name', '$email', '$hashedpass', $pref, '$phone_no')";
                mysqli_query($conn, $sql);
                header("Location: index.php?reg_success=yes");
                die();
            }
        }

        mysqli_close($conn);
        ?>

        <form action="register_usr.php" method="POST">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your Name" required>
            
            <label for="InputEmail">Email Address</label>
            <input type="email" id="InputEmail" name="email" placeholder="Enter your Email" required>
            
            <label for="phone_no">Phone Number</label>
            <input type="text" id="phone_no" name="phone_no" placeholder="Phone Number" required>
            
            <label for="InputPassword">Password</label>
            <input type="password" id="InputPassword" name="password" placeholder="Enter password" required>
            
            <fieldset>
                <label>Preferred Diet</label>
                <input type="radio" id="veg" name="pref" value="veg" checked>
                <label for="veg">Veg</label>
                <input type="radio" id="non_veg" name="pref" value="non_veg">
                <label for="non_veg">Non-veg</label>
            </fieldset>
            
            <button type="submit" id="button" name="submit">Register</button>
        </form>

        <a href="login_usr.php">Already have an account? Login here</a>
    </div>
</body>
</html>
