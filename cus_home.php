<?php
session_start();

if ($_SESSION['user'] != 'cus') {
    header("Location: index.php?accessdenied=true");
    die();
}

include("config.php");

$name_query = "SELECT name FROM customers WHERE id = " . $_SESSION['id'];
$name_result = mysqli_query($conn, $name_query);

if ($name_result) {
    $name_row = mysqli_fetch_assoc($name_result);
    $name = $name_row['name'];
} else {
    die("Error fetching user data.");
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-image: url('images/background.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #fff;
        }

        h1 {
            font-family: "Comic Sans MS", cursive, sans-serif;
            font-style: oblique;
            font-weight: bold;
            font-size: 3.5em;
            text-align: center;
            margin-top: 1em;
            text-shadow: 3px 3px 10px rgba(0, 0, 0, 0.7);
        }

        h3 {
            font-size: 1.4em;
            color: white;
            text-align: center;
            margin-top: 1em;
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.5);
        }

        nav {
            position: fixed;
            top: 0;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 15px 0;
            z-index: 100;
        }

        nav .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
        }

        nav .container .logo {
            font-size: 2em;
            font-weight: bold;
            color: #fff;
        }

        nav .container .logo a {
            text-decoration: none;
            color: #fff;
        }

        nav .container ul {
            display: flex;
            list-style: none;
            padding: 0;
        }

        nav .container ul li {
            margin: 0 1em;
        }

        nav .container ul li a {
            color: #fff;
            text-align: center;
            font-size: 1.2em;
            font-weight: bold;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        nav .container ul li a:hover {
            background-color: #fff;
            color: #444;
            border-color: #444;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.8);
        }

        nav .container ul li a i {
            margin-right: 8px;
        }

        .hero {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            color: #fff;
            padding: 0 15px;
        }

        .hero h1 {
            font-size: 4.5em;
            font-weight: 900;
            text-shadow: 4px 4px 10px rgba(0, 0, 0, 0.6);
            margin: 0;
        }

        .hero h3 {
            font-size: 1.5em;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.5);
            margin: 1em 0;
        }

        @media (max-width: 768px) {
            nav .container ul {
                flex-direction: column;
                align-items: center;
            }

            nav .container ul li {
                margin: 10px 0;
            }

            .hero h1 {
                font-size: 3.5em;
            }

            .hero h3 {
                font-size: 1.2em;
            }
        }
    </style>
    <title>Home</title>
</head>
<body>
    <nav>
        <div class="container">
            <div class="logo">
                <a href="index.php">GrubGrab</a>
            </div>
            <ul>
                <li><a href="menu.php"><i class="fas fa-utensils"></i>Menu</a></li>
                <li><a href="cart.php"><i class="fas fa-shopping-cart"></i>My Cart</a></li>
                <li><a href="cus_orders.php"><i class="fas fa-box"></i>My Orders</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
            </ul>
        </div>
    </nav>

    <section class="hero">
        <h1>Welcome, <?php echo $name; ?></h1>
        <h3>Your journey to the best food starts here!</h3>
    </section>
</body>
</html>


