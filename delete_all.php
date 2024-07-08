<?php
session_start();
include("db.php"); // Adjust as per your database connection file

// Check if user is logged in as admin
if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php"); // Redirect unauthorized users
    exit();
}

// Delete all data
$sql = "UPDATE orders SET deleted = 1";
$stmt = $pdo->prepare($sql);

if ($stmt->execute()) {
    header("Location: display_orders.php?message=All+orders+marked+as+deleted");
    exit();
} else {
    echo "Error deleting all orders.";
}
?>
