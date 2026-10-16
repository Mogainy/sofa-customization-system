<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}
function colorName($hex){

    $colors = [

        "#ffffff"=>"White",
        "#000000"=>"Black",
        "#2d2d2d"=>"Charcoal",
        "#b22222"=>"Firebrick Red",
        "#1e4fb8"=>"Royal Blue",
        "#228b22"=>"Forest Green",
        "#8b4513"=>"Brown",
        "#808080"=>"Gray",
        "#ffd700"=>"Gold",
        "#f5deb3"=>"Beige"

    ];

    return $colors[strtolower($hex)] ?? $hex;

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
    width:98%;
    max-width:1400px;
    margin:20px auto;
}

table{
    width:100%;
    border-collapse:collapse;
    table-layout:fixed;
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

.cancel-btn{
    display:inline-block;
    margin-top:8px;
    padding:6px 12px;
    background:#e74a3b;
    color:white;
    text-decoration:none;
    border-radius:5px;
    font-size:13px;
}

.cancel-btn:hover{
    background:#c0392b;
}
.status{
    padding:8px 15px;
    border-radius:30px;
    color:#fff;
    font-weight:bold;
    display:inline-block;
    font-size:14px;
}

.pending{
    background:#f39c12;
}

.confirmed{
    background:#3498db;
}

.processing{
    background:#9b59b6;
}

.delivery{
    background:#16a085;
}

.delivered{
    background:#27ae60;
}

.cancelled{
    background:#e74c3c;
}
.tracker{

display:flex;
align-items:center;
margin-top:15px;

}

.circle{

width:18px;
height:18px;
border-radius:50%;
background:#ccc;

}

.circle.active{

background:#27ae60;

}

.line{

width:45px;
height:4px;
background:#ccc;

}

.line.active{

background:#27ae60;

}
table{
    width:100%;
    border-collapse:collapse;
    table-layout:auto;
}

th,
td{
    word-wrap:break-word;
    overflow-wrap:break-word;
}

td img{
    width:110px;
    height:auto;
    border-radius:8px;
}

.container{
    width:98%;
    max-width:1400px;
    margin:20px auto;
}
.customization{

text-align:left;
min-width:230px;
line-height:1.8;

}

.customization hr{

margin:10px 0;
border:none;
border-top:1px solid #ddd;

}

.customization .label{

font-weight:bold;
color:#666;

}

.part{

padding:4px 0;

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
    
    <th>Sofa</th>
    <th>Customization</th>
    <th>Price</th>
    <th>Payment</th>
    <th>Payment Status</th>
    <th>Delivery Address</th>
    <th>Customized Sofa</th>
    <th>Order Status</th>
   <th>Date</th>
</tr>

<?php while($order = mysqli_fetch_assoc($result)){ ?>

<tr>
    
  <td><?= htmlspecialchars($order['name']) ?></td>
  <td class="customization">

<div class="part">

<strong>🛋 Sofa Body</strong><br>

<span class="label">Color:</span>

<?= colorName($order['sofa_color']) ?>

<br>

<span class="label">Material:</span>

<?= ucfirst($order['sofa_texture']) ?>

</div>

<hr>

<div class="part">

<strong>🛏 Pillows</strong><br>

<span class="label">Color:</span>

<?= colorName($order['pillow_color']) ?>

<br>

<span class="label">Material:</span>

<?= ucfirst($order['pillow_texture']) ?>

</div>

</td>
    <td>Ksh <?= number_format($order['total_price']) ?></td>
    <td><?= htmlspecialchars($order['payment_method']) ?></td>
    <td><?= htmlspecialchars($order['payment_status']) ?></td>
    
    <td><?= htmlspecialchars($order['delivery_address']) ?></td>
   <td>

<?php if(!empty($order['custom_image'])){ ?>

<img
    src="<?= htmlspecialchars($order['custom_image']) ?>"
    width="180"
    style="border-radius:10px;">

<?php } else { ?>

No Image

<?php } ?>

</td>
    <td>

<?= htmlspecialchars($order['status']) ?>

<?php

$status = $order['status'];

$class = "";

switch($status){

    case "Pending Payment":
        $class = "pending";
        break;

    case "Payment Confirmed":
        $class = "confirmed";
        break;

    case "Processing":
        $class = "processing";
        break;

    case "Ready for Delivery":
        $class = "delivery";
        break;

    case "Delivered":
        $class = "delivered";
        break;

    case "Cancelled":
        $class = "cancelled";
        break;
}

?>

<span class="status <?= $class ?>">
    <?= htmlspecialchars($status) ?>
</span>
<?php

$step = 1;

switch($status){

    case "Pending Payment":
        $step = 1;
        break;

    case "Payment Confirmed":
        $step = 2;
        break;

    case "Processing":
        $step = 3;
        break;

    case "Ready for Delivery":
        $step = 4;
        break;

    case "Delivered":
        $step = 5;
        break;

    case "Cancelled":
        $step = 0;
        break;
}

?>

<?php if($status!="Cancelled"){ ?>

<div class="tracker">

<div class="circle <?= $step>=1?'active':'' ?>"></div>
<div class="line <?= $step>=2?'active':'' ?>"></div>

<div class="circle <?= $step>=2?'active':'' ?>"></div>
<div class="line <?= $step>=3?'active':'' ?>"></div>

<div class="circle <?= $step>=3?'active':'' ?>"></div>
<div class="line <?= $step>=4?'active':'' ?>"></div>

<div class="circle <?= $step>=4?'active':'' ?>"></div>
<div class="line <?= $step>=5?'active':'' ?>"></div>

<div class="circle <?= $step>=5?'active':'' ?>"></div>

</div>

<?php } ?>

</td>
  <td><?= date("d M Y, h:i A", strtotime($order['date'])); ?></td>
</tr>

<?php } ?>
</table>

</div>

</body>
</html>