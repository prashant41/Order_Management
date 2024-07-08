<?php
session_start();
include("db.php"); // Adjust as per your database connection file

// Check if user is logged in as admin (or implement role-based checks)
if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php"); // Redirect unauthorized users
    exit();
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $orderId = $_POST['order_id'];
    $orderDate = $_POST['order_date'];
    $itemName = $_POST['item_name'];
    $quantity = $_POST['quantity'];
    $amount = $_POST['amount'];
    $shopName = $_POST['shop_name'];
    $deliveryBoy = $_POST['delivery_boy_name'];
    $adminName = $_SESSION['username']; // Assuming admin name is logged in user

    // Prepare SQL statement to update order details
    $sql = "UPDATE orders SET order_date = ?, item_name = ?, quantity = ?, amount = ?, shop_name = ?, delivery_boy_name = ?, admin_name = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);

    // Bind parameters and execute the statement
    $stmt->execute([$orderDate, $itemName, $quantity, $amount, $shopName, $deliveryBoy, $adminName, $orderId]);

    // Redirect back to display_orders.php after update
    header("Location: display_orders.php");
    exit();
} else {
    // Check if order ID is provided via GET request
    if (isset($_GET['id'])) {
        $orderId = $_GET['id'];

        // Fetch existing order details by ID
        $sql = "SELECT * FROM orders WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$orderId]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        // Display the update form with pre-filled values
        if ($order) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order</title>
</head>
<body>
    <h2>Update Order</h2>
    <form action="update_order.php" method="POST">
        <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
        
        <label for="order_date">Order Date:</label>
        <input type="date" id="order_date" name="order_date" value="<?php echo $order['order_date']; ?>" required><br><br>
        
        <label for="item_name">Item Name:</label>
        <input type="text" id="item_name" name="item_name" value="<?php echo $order['item_name']; ?>" required><br><br>
        
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" value="<?php echo $order['quantity']; ?>" required><br><br>
        
        <label for="amount">Amount:</label>
        <input type="text" id="amount" name="amount" value="<?php echo $order['amount']; ?>" required><br><br>
        
        <label for="shop_name">Shop Name:</label>
        <input type="text" id="shop_name" name="shop_name" value="<?php echo $order['shop_name']; ?>"><br><br>
        
        <label for="delivery_boy_name">Delivery Boy Name:</label>
        <input type="text" id="delivery_boy_name" name="delivery_boy_name" value="<?php echo $order['delivery_boy_name']; ?>"><br><br>
        
        <input type="submit" value="Update">
    </form>
</body>
</html>
<?php
        } else {
            echo "Order not found.";
        }
    } else {
        echo "Order ID not specified.";
    }
}
?>
