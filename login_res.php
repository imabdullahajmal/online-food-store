<?php session_start(); 
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
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
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
    </style>
    <title>Restaurant Login</title>
</head>
<body>
    <a href="index.php"><h3><i class="fas fa-arrow-left"></i> Back</h3></a>
    <h2>Restaurant Login</h2>
    <div class="form-container">
        <form action="login_res.php" method="POST">
            <?php
            include("config.php");

            if(isset($_POST['submit'])) {
                $email = $_POST['email'];
                $pass = $_POST['password'];
                $password = hash('sha256', $pass . $email);

                $email_chk = "SELECT * FROM restaurents WHERE email LIKE '$email' ";
                $result_email_chk = mysqli_query($conn, $email_chk);

                $pass_chk = "SELECT * FROM restaurents WHERE email LIKE '$email' AND password LIKE '$password'";
                $result_pass_chk = mysqli_query($conn, $pass_chk);

                if(mysqli_num_rows($result_email_chk) > 0) {
                    if(mysqli_num_rows($result_pass_chk) > 0) {
                        if(isset($_SESSION['id'])) {
                            header("Location: index.php?loggedin=true");
                            die();
                        } else {
                            if(isset($_POST['rememberme'])) {
                                setcookie("email_res", $email, time() + 3600); // 1 hr
                                setcookie("password_res", $pass, time() + 3600); // 1 hr
                            }
                            $get_id = "SELECT id FROM restaurents WHERE email LIKE '$email' AND password LIKE '$password'";
                            $id_ = mysqli_query($conn, $get_id);
                            $id = mysqli_fetch_assoc($id_);
                            $_SESSION['id'] = $id["id"];
                            $_SESSION['user'] = 'res';
                            header('Location: res_home.php');
                            die();
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

            <label for="InputEmail">Email address</label>
            <input type="email" id="InputEmail" name="email" placeholder="Enter your Email" value="<?php echo isset($_COOKIE['email_res']) ? $_COOKIE['email_res'] : ''; ?>" required>

            <label for="InputPassword">Password</label>
            <input type="password" id="InputPassword" name="password" placeholder="Enter password" value="<?php echo isset($_COOKIE['password_res']) ? $_COOKIE['password_res'] : ''; ?>" required>

            <div class="remember-me">
                <input type="checkbox" id="rememberme" name="rememberme">
                <label for="rememberme">Remember me</label>
            </div>

            <button type="submit" id="button" name="submit">Login</button>

            <div class="form-footer">
                <p>Don't have an account? <a href="signup_res.php">Sign Up</a></p>
            </div>
        </form>
    </div>
</body>
</html>
