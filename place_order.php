<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$product_id = $_POST['product_id'];
$sofa_color = $_POST['sofa_color'];
$sofa_texture = $_POST['sofa_texture'];

$pillow_color = $_POST['pillow_color'];
$pillow_texture = $_POST['pillow_texture'];

$total_price = $_POST['total_price'];

$phone = mysqli_real_escape_string(
    $conn,
    $_POST['phone']
);

$delivery_address = mysqli_real_escape_string(
    $conn,
    $_POST['delivery_address']
);

$payment_method = mysqli_real_escape_string(
    $conn,
    $_POST['payment_method']
);
$custom_image = $_POST['custom_image'];

$sql = "INSERT INTO orders
(
user_id,
product_id,
sofa_color,
sofa_texture,
pillow_color,
pillow_texture,
total_price,
phone,
delivery_address,
payment_method,
payment_status,
status,
custom_image
)
VALUES
(
'$user_id',
'$product_id',
'$sofa_color',
'$sofa_texture',
'$pillow_color',
'$pillow_texture',
'$total_price',
'$phone',
'$delivery_address',
'$payment_method',
'Pending Payment',
'Pending Payment',
'$custom_image'
)";

if(mysqli_query($conn,$sql))
{
?>
<!DOCTYPE html>
<html>
<head>
<title>Order Success</title>

<style>

body{
    font-family:Arial;
    background:#f4f6f9;
}

.success{
    width:600px;
    margin:80px auto;
    background:white;
    padding:40px;
    text-align:center;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

h2{
    color:#1cc88a;
}

.btn{
    display:inline-block;
    margin-top:20px;
    background:#4e73df;
    color:white;
    padding:12px 25px;
    text-decoration:none;
    border-radius:8px;
}

</style>
</head>

<body>

<div class="success">

<h2>✓ Order Placed Successfully</h2>

<p>
Thank you for your order.
Our team will contact you shortly.
</p>

<a href="my_orders.php" class="btn">
View My Orders
</a>

</div>

</body>
</html>

<?php
}
else
{
    echo mysqli_error($conn);
}
?>