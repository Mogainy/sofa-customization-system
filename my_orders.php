<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT orders.*, products.name
        FROM orders
        INNER JOIN products
        ON orders.product_id = products.id
        WHERE orders.user_id='$user_id'
        ORDER BY orders.id DESC";

$result = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>My Orders</title>

<style>

body{
    font-family:Arial,sans-serif;
    background:#f4f6f9;
    margin:0;
}

.header{
    background:#4e73df;
    color:white;
    text-align:center;
    padding:20px;
}

.container{
    width:90%;
    max-width:1000px;
    margin:30px auto;
}

table{
    width:100%;
    border-collapse:collapse;
    background:white;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

th{
    background:#4e73df;
    color:white;
    padding:12px;
}

td{
    padding:12px;
    border-bottom:1px solid #ddd;
    text-align:center;
}

tr:hover{
    background:#f5f5f5;
}

.back-btn{
    display:inline-block;
    margin-bottom:20px;
    padding:10px 20px;
    background:#1cc88a;
    color:white;
    text-decoration:none;
    border-radius:5px;
}

</style>

</head>
<body>

<div class="header">
    <h1>My Orders</h1>
</div>

<div class="container">

<a href="index.php" class="back-btn">
    Back to Products
</a>

<table>

<tr>
    <th>ID</th>
    <th>Sofa</th>
    <th>Color</th>
    <th>Texture</th>
    <th>Status</th>
    <th>Date</th>
</tr>

<?php while($row=mysqli_fetch_assoc($result)) { ?>

<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo ucfirst($row['color']); ?></td>
    <td><?php echo ucfirst($row['texture']); ?></td>
    <td><?php echo $row['status']; ?></td>
    <td><?php echo $row['date']; ?></td>
</tr>

<?php } ?>

</table>

</div>

</body>
</html>