<?php
include("db.php"); // Adjust as per your database connection file
session_start();
if(!isset($_SESSION["username"])){
    header("Location:login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $item_name = $_POST["item_name"];
    $quantity = $_POST["quantity"];
    $amount = $_POST["amount"];
    $shop_name = $_POST["shop_name"];
    $delivery_boy_name = $_POST["delivery_boy_name"];
    
    // Retrieve admin name from session (assuming admin is logged in)
    $admin_name = $_SESSION["username"]; // Adjust according to your session structure

    // Prepare and execute SQL statement to insert order data into orders table
    $sql = "INSERT INTO orders (order_date, item_name, quantity, amount, shop_name, delivery_boy_name, admin_name) 
            VALUES (CURDATE(), ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$item_name, $quantity, $amount, $shop_name, $delivery_boy_name, $admin_name]);

    // Check if insertion was successful
    if ($stmt) {
        echo "Order successfully placed.";
        // Optionally, redirect to a success page or back to the order form
        // header("Location: order_form.php");
        // exit();
    } else {
        echo "Failed to place order. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Form</title>
    <link rel="stylesheet" href="style.css">
    <style>
        label {
            display: inline-block;
            width: 150px;
            margin-bottom: 10px;
        }
        input[type="text"], input[type="number"], input[type="date"] {
            width: 250px;
            padding: 5px;
            font-size: 16px;
        }
        input[type="submit"],input[type="reset"]{
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
    
</head>
<body>

    <nav>
        <a href="order_form.php">Order Form</a>
        <a href="display_orders.php">Display Orders</a>
        <a href="admin_filter.php">Filter Orders</a>
        <a href="report.php">Report</a>
        <a href="raw_materials.php">Raw Material Data</a>
        <a href="logout.php">Log Out</a>
        <!-- Add more links as needed -->
    </nav><br>

    
    <h2>Order Form</h2>
    <form action="order_form.php" method="POST">
        <label for="item_name">Item Name:</label>
        <input type="text" id="item_name" name="item_name" required><br><br>
        
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" min="1" required><br><br>
        
        <label for="amount">Amount:</label>
        <input type="text" id="amount" name="amount" required><br><br>
        
        <label for="shop_name">Shop Name:</label>
        <input type="text" id="shop_name" name="shop_name" required><br><br>
        
        <label for="delivery_boy_name">Delivery Boy Name:</label>
        <input type="text" id="delivery_boy_name" name="delivery_boy_name"><br><br>
        
        <input type="submit" value="Submit Order">
        <input type="reset" value="Reset">
    </form>
</body>
</html>
