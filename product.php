<?php
session_start();
include("config/db.php");

// Get product ID safely
$id = intval($_GET['id'] ?? 0);

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$product = $stmt->get_result()->fetch_assoc();

if(!$product){
    die("Product not found.");
}

$loggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($product['name']) ?> | Gikomba Sofa Workshop</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial,sans-serif;
}

body{
    background:#f4f6f9;
}

.header{
    background:#4e73df;
    color:white;
    padding:20px;
    text-align:center;
}

.menu{
    background:white;
    padding:15px;
    text-align:center;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
}

.menu a{
    text-decoration:none;
    color:#4e73df;
    margin:0 20px;
    font-weight:bold;
}

.container{
    width:90%;
    max-width:1100px;
    margin:30px auto;
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:30px;
    background:white;
    padding:25px;
    border-radius:12px;
    box-shadow:0 5px 20px rgba(0,0,0,.1);
}

.image{
    display:flex;
    justify-content:center;
    align-items:center;
}

.image img{
    width:100%;
    max-width:500px;
    object-fit:contain;
}

.details h2{
    margin-bottom:15px;
    color:#333;
}

.details p{
    margin-bottom:20px;
    color:#666;
    line-height:1.6;
}

.price{
    font-size:30px;
    color:#1cc88a;
    font-weight:bold;
    margin-bottom:20px;
}

.section{
    margin-bottom:18px;
}

.section h4{
    margin-bottom:8px;
}

input,
textarea,
select{
    width:100%;
    padding:10px;
    border:1px solid #ccc;
    border-radius:8px;
}

textarea{
    resize:vertical;
    min-height:80px;
}

button{
    width:100%;
    padding:14px;
    border:none;
    border-radius:8px;
    background:#4e73df;
    color:white;
    font-size:16px;
    cursor:pointer;
}

button:hover{
    background:#375ac2;
}

button:disabled{
    background:#999;
    cursor:not-allowed;
}

.login-note{
    background:#fff3cd;
    padding:12px;
    border-radius:8px;
    margin-top:20px;
    text-align:center;
}

.login-note a{
    color:#856404;
    font-weight:bold;
}

@media(max-width:900px){

.container{
    grid-template-columns:1fr;
}

}

</style>

</head>

<body>

<div class="header">
<h1>GIKOMBA SOFA WORKSHOP</h1>
</div>

<div class="menu">

<a href="index.php">Home</a>

<?php if($loggedIn){ ?>

<a href="my_orders.php">My Orders</a>

<a href="logout.php">Logout</a>

<?php }else{ ?>

<a href="login.php">Login</a>

<a href="register.php">Register</a>

<?php } ?>

</div>

<div class="container">

<div class="image">

<img
src="assets/images/<?= htmlspecialchars($product['image']) ?>"
alt="<?= htmlspecialchars($product['name']) ?>"
>

</div>

<div class="details">

<h2><?= htmlspecialchars($product['name']) ?></h2>

<p><?= htmlspecialchars($product['description']) ?></p>

<div class="price">
Ksh <?= number_format($product['price']) ?>
</div>

<form action="place_order.php" method="POST">

<input
type="hidden"
name="product_id"
value="<?= $product['id'] ?>"
>

<input
type="hidden"
name="color"
value="Standard"
>

<input
type="hidden"
name="texture"
value="Standard"
>

<input
type="hidden"
name="total_price"
value="<?= $product['price'] ?>"
>

<div class="section">

<h4>Phone Number</h4>

<input
type="text"
name="phone"
placeholder="07XX XXX XXX"
required
>

</div>

<div class="section">

<h4>Delivery Address</h4>

<textarea
name="delivery_address"
required
placeholder="Enter delivery address..."
></textarea>

</div>

<div class="section">

<h4>Payment Method</h4>

<select name="payment_method">

<option>M-Pesa</option>

<option>Cash On Delivery</option>

<option>Bank Transfer</option>

</select>

</div>

<?php if($loggedIn){ ?>

<button type="submit">
Order Now
</button>

<?php }else{ ?>

<div class="login-note">

Please
<a href="login.php">Login</a>
or
<a href="register.php">Register</a>
to place an order.

</div>

<button disabled>
Order Now
</button>

<?php } ?>

</form>

</div>

</div>

</body>
</html>