<?php
include("db.php");
session_start();
if(!isset($_SESSION["username"])){
    header("Location:login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard</title>
    <style>
        /* Basic CSS for navigation */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        nav {
            background-color: #333;
            overflow: hidden;
        }
        nav a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }
        nav a:hover {
            background-color: #ddd;
            color: black;
        }
    </style>
</head>
<body>
    <nav>
        <a href="client_display_order.php">Display Orders</a>
        <a href="client_filter.php">Filter Orders</a>
        <a href="commision.php">Commision</a>
        <a href="logout.php">Log Out</a>
        <!-- Add more links as needed -->
    </nav>

    <div style="padding: 20px;">
        <!-- Admin dashboard content will go here -->
        <h1>Welcome to Client Dashboard</h1>
        <h2>Hello <?php print $_SESSION["username"]; ?>, welcome back!!!</h2>
        <p>This is where you check your orders, and more.</p>
    </div>

    <!-- Add footer or other content as needed -->
</body>
</html>
