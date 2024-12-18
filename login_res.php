<?php
session_start();
include("redirect_to_home.php");
include("config.php");

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $password = hash('sha256', $pass . $email);

    $email_chk = "SELECT * FROM restaurents WHERE email LIKE '$email'";
    $result_email_chk = mysqli_query($conn, $email_chk);

    $pass_chk = "SELECT * FROM restaurents WHERE email LIKE '$email' AND password LIKE '$password'";
    $result_pass_chk = mysqli_query($conn, $pass_chk);

    if (mysqli_num_rows($result_email_chk) > 0) {
        if (mysqli_num_rows($result_pass_chk) > 0) {
            if (isset($_SESSION['id'])) {
                header("Location: index.php?loggedin=true");
                exit();
            } else {
                if (isset($_POST['rememberme'])) {
                    setcookie("email_res", $email, time() + 3600);
                    setcookie("password_res", $pass, time() + 3600);
                }
                $get_id = "SELECT id FROM restaurents WHERE email LIKE '$email' AND password LIKE '$password'";
                $id_ = mysqli_query($conn, $get_id);
                $id = mysqli_fetch_assoc($id_);
                $_SESSION['id'] = $id["id"];
                $_SESSION['user'] = 'res';
                header('Location: res_home.php');
                exit();
            }
        } else {
            echo '<script>alert("Password Incorrect");</script>';
        }
    } else {
        echo '<script>alert("Email not Found");</script>';
    }
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Restaurant Login</title>
    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            color: #444;
            margin-left: 20px;
            margin-top: 15px;
            font-size: 1.2em;
        }

        h2 {
            text-decoration: underline;
            color: darkslategray;
            margin-left: 5px;
            font-size: 2em;
            text-align: center;
            margin-top: 20px;
        }

        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
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

        input[type="email"], input[type="password"] {
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1.1em;
            width: 100%;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }

        input[type="email"]:focus, input[type="password"]:focus {
            border-color: #00bcd4;
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

        .remember-me {
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }

        .remember-me input {
            margin-right: 10px;
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

        .back-link {
            top: 20px;
            left: 20px;
            font-size: 1.1em;
            color: #800303;
            text-decoration: none;
        }

        .back-link:hover {
            color: #660303;
        }
    </style>
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

    <a href="index.php" class="back-link">
        <h3><i class="fas fa-arrow-left"></i> Back</h3>
    </a>

    <div class="form-container">
        <div>
            <h2>Restaurant Login</h2>
            <form action="login_res.php" method="POST">
                <label for="InputEmail">Email address</label>
                <input type="email" id="InputEmail" name="email" placeholder="Enter your Email" 
                    value="<?php echo isset($_COOKIE['email_res']) ? $_COOKIE['email_res'] : ''; ?>" required>

                <label for="InputPassword">Password</label>
                <input type="password" id="InputPassword" name="password" placeholder="Enter password" 
                    value="<?php echo isset($_COOKIE['password_res']) ? $_COOKIE['password_res'] : ''; ?>" required>

                <div class="remember-me">
                    <input type="checkbox" id="rememberme" name="rememberme">
                    <label for="rememberme">Remember me?</label>
                </div>

                <button type="submit" name="submit">Login</button>
                <div class="form-footer">
                    <a href="signup_res.php">Don't have an account? Register here</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
