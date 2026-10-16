<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$order_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

$sql = "UPDATE orders
        SET status='Cancelled'
        WHERE id='$order_id'
        AND user_id='$user_id'
        AND status='Pending'";

mysqli_query($conn,$sql);

header("Location: my_orders.php");
exit();
?>