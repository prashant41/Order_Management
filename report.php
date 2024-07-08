<?php
include("db.php");
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// Handle report solved action
if (isset($_GET['action']) && $_GET['action'] == 'mark_solved' && isset($_GET['id'])) {
    $reportId = $_GET['id'];
    
    // Prepare SQL statement to delete the notification
    $sql = "DELETE FROM notifications WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $reportId]);
    
    // Redirect back to the report page after deletion
    header("Location: report.php");
    exit();
}

// Fetch notifications from database
$sql = "SELECT * FROM notifications ORDER BY created_at DESC";
$stmt = $pdo->query($sql);
$notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Page</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2, p {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
        }
        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table tbody tr:hover {
            background-color: #e0e0e0;
        }
        .action-btn {
            display: inline-block;
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            text-decoration: none;
            cursor: pointer;
            border-radius: 4px;
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

    <div class="container">
        <h1>Welcome to Admin Dashboard</h1>
        <h2>Latest Report By <?php echo $_SESSION["username"]; ?>!!!</h2>
     
        <h2>Notifications</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Message</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($notifications as $notification): ?>
                    <tr>
                        <td><?php echo $notification['id']; ?></td>
                        <td><?php echo $notification['message']; ?></td>
                        <td><?php echo $notification['created_at']; ?></td>
                        <td>
                            <a class="action-btn" href="report.php?action=mark_solved&id=<?php echo $notification['id']; ?>">Report Solved</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
