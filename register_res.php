<?php 
session_start();
include("redirect_to_home.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        h3 {
            color: #4CAF50;
            margin-left: 20px;
            margin-top: 15px;
            font-size: 1.2em;
        }

        h2 {
            text-decoration: underline;
            color: darkslategray;
            margin: 20px 0;
            font-size: 2em;
            text-align: center;
        }

        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        form {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            border: 1px solid #ddd;
        }

        form > * {
            margin: 15px 0;
            width: 100%;
        }

        label {
            font-weight: bold;
            color: #333;
        }

        input[type="text"], input[type="email"], input[type="password"] {
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1.1em;
            width: 100%;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus {
            border-color: #4CAF50;
            outline: none;
        }

        button[type="submit"] {
            background-color: #800303;
            color: white;
            padding: 15px;
            font-size: 1.2em;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        button[type="submit"]:hover {
            background-color: #660303;
        }

        .form-footer {
            text-align: center;
            margin-top: 15px;
        }

        .form-footer a {
            text-decoration: none;
            color: #660303;
            font-size: 1.1em;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            h2 {
                font-size: 1.6em;
            }

            form {
                padding: 15px;
                width: 90%;
            }
        }
    </style>
    <title>Restaurant Registration</title>
</head>
<body>
    <a href="index.php"><h3><i class="fas fa-arrow-left"></i> Back</h3></a>
    <h2>Register Restaurant</h2>
    <div class="form-container">
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

            <div class="form-footer">
                <a href="index.php">Already have an account? Login here</a>
            </div>
        </form>
    </div>
</body>
</html>
