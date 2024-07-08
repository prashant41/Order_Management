<?php
session_start();
include("db.php"); // Adjust as per your database connection file

if(!isset($_SESSION["username"])){
    header("Location:login.php");
    exit();
}

// Query to fetch the 15 latest orders
$sql = "SELECT * FROM orders ORDER BY created_at DESC LIMIT 15";
$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Query to fetch deleted orders from the backup table
$backup_sql = "SELECT * FROM orders_backup ORDER BY created_at DESC";
$backup_stmt = $pdo->query($backup_sql);
$backup_rows = $backup_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Orders</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
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
    
    <h2>Latest Orders</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Order Date</th>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Amount</th>
                <th>Shop Name</th>
                <th>Delivery Boy</th>
                <th>Admin Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                <td><?php echo htmlspecialchars($row['amount']); ?></td>
                <td><?php echo htmlspecialchars($row['shop_name']); ?></td>
                <td><?php echo htmlspecialchars($row['delivery_boy_name']); ?></td>
                <td><?php echo htmlspecialchars($row['admin_name']); ?></td>
                <td>
                    <a href="update_order.php?id=<?php echo htmlspecialchars($row['id']); ?>">Update</a> | 
                    <a href="delete_order.php?id=<?php echo htmlspecialchars($row['id']); ?>" onclick="return confirm('Are you sure you want to delete this order?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <form action="delete_all.php" method="post" onsubmit="return confirm('Are you sure you want to delete all orders?');">
        <input type="submit" value="Delete All Orders">
    </form>

    </body>
</html>
