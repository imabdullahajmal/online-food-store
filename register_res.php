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
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('images/background.jpg');
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
        }
        
        h3 {
            color: #4CAF50;
            margin-left: 20px;
            font-size: 1.2em;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
        }
        
        h2 {
            color: darkslategray;
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

        .form-container input {
            width: 100%;
            padding: 12px;
            margin: 8px 0 16px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 1em;
        }

        .form-container input[type="text"], .form-container input[type="email"], .form-container input[type="password"] {
            background-color: #f7f7f7;
        }

        .form-container button {
            background-color: #4CAF50;
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
            background-color: #45a049;
        }

        .form-container a {
            display: block;
            text-align: center;
            color: #4CAF50;
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
    <title>Restaurant Registration</title>
</head>
<body>
    <a href="index.php"><h3>&lt;&lt; Back</h3></a>
    
    <div class="form-container">
        <h2>Register Restaurant</h2>
        
        <?php
        include("config.php");
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $location = $_POST['location'];

            $sql_check = "SELECT * FROM restaurents WHERE email LIKE '$email'";
            $result_chk = mysqli_query($conn, $sql_check);
            
            if (mysqli_num_rows($result_chk) > 0) {
                echo '<script type="text/javascript">alert("Restaurant account with that email already exists!");</script>';
            } else {
                $hashedpass = hash('sha256', $password . $email);
                $sql = "INSERT INTO restaurents (name, email, password, location) VALUES ('$name', '$email', '$hashedpass', '$location')";
                mysqli_query($conn, $sql);
                header("Location: index.php?reg_success=yes");
                die();
            }
        }

        mysqli_close($conn);
        ?>

        <form action="register_res.php" method="POST">
            <label for="name">Restaurant Name</label>
            <input type="text" id="name" name="name" placeholder="Enter restaurant Name" required>
            
            <label for="InputEmail">Email Address</label>
            <input type="email" id="InputEmail" name="email" placeholder="Enter your Email" required>
            
            <label for="InputPassword">Password</label>
            <input type="password" id="InputPassword" name="password" placeholder="Enter password" required>
            
            <label for="location">Location</label>
            <input type="text" id="location" name="location" placeholder="Enter restaurant location" required>
            
            <button type="submit" id="button" name="submit">Register</button>
        </form>
        
        <a href="index.php">Already have an account? Login here</a>
    </div>
</body>
</html>
