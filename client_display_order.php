<?php
session_start();
include("db.php"); // Adjust as per your database connection file

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION["username"];

// Query to fetch the 15 latest orders for the logged-in delivery boy (client)
$sql = "SELECT * FROM orders WHERE delivery_boy_name = :username ORDER BY created_at DESC LIMIT 15";
$stmt = $pdo->prepare($sql);
$stmt->execute(['username' => $username]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Orders</title>
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
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        .modal-content h3 {
            margin-top: 0;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
    <script>
        function goBack(){
            window.history.back();
        }

        function reportMistake(orderId) {
            var modal = document.getElementById('myModal');
            var span = document.getElementsByClassName('close')[0];
            
            modal.style.display = "block";
            
            span.onclick = function() {
                modal.style.display = "none";
            }
            
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
            
            var confirmButton = document.getElementById('confirmMistake');
            confirmButton.onclick = function() {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        alert("Mistake reported successfully!");
                        modal.style.display = "none";
                        // You can optionally update the UI here if needed
                    }
                };
                xhttp.open("POST", "order_mistake.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("order_id=" + orderId);
            };
        }
    </script>
</head>
<body>
    <button onclick="goBack()">Go Back</button>
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
                <th>Admin Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['order_date']; ?></td>
                <td><?php echo $row['item_name']; ?></td>
                <td><?php echo $row['quantity']; ?></td>
                <td><?php echo $row['amount']; ?></td>
                <td><?php echo $row['shop_name']; ?></td>
                <td><?php echo $row['admin_name']; ?></td>
                <td>
                    <button onclick="reportMistake(<?php echo $row['id']; ?>)">Mistake</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Report Mistake</h3>
            <p>Are you sure you want to report a mistake for this order?</p>
            <button id="confirmMistake">Confirm</button>
        </div>
    </div>

</body>
</html>
