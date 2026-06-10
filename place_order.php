<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['user_id']))
{
   header("Location: my_orders.php");
exit();
}

$user_id = $_SESSION['user_id'];

$product_id = $_POST['product_id'];
$color = $_POST['color'];
$texture = $_POST['texture'];

$sql = "INSERT INTO orders
        (user_id, product_id, color, texture)
        VALUES
        ('$user_id', '$product_id', '$color', '$texture')";

if(mysqli_query($conn, $sql))
{
    echo "
    <h2>Order Placed Successfully!</h2>
    <a href='index.php'>Back to Products</a>
    ";
}
else
{
    echo mysqli_error($conn);
}
?>