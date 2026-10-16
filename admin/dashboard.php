<?php
session_start();
include("../config/db.php");
// Total users
$users = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) AS total FROM users")
);

// Total orders
$orders = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) AS total FROM orders")
);

// Pending orders
$pending = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) AS total FROM orders WHERE status='Pending Payment'")
);

// Processing orders
$processing = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) AS total FROM orders WHERE status='Processing'")
);

// Delivered orders
$delivered = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) AS total FROM orders WHERE status='Delivered'")
);

// Total revenue
$revenue = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT SUM(total_price) AS total FROM orders WHERE payment_status='Paid'")
);

if(!isset($_SESSION['user_id']))
{
    header("Location: ../login.php");
}

$product_count = mysqli_num_rows(
    mysqli_query($conn,"SELECT * FROM products")
);

$user_count = mysqli_num_rows(
    mysqli_query($conn,"SELECT * FROM users")
);
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
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

.container{
    width:90%;
    margin:30px auto;
}

.cards{
    display:flex;
    gap:20px;
    flex-wrap:wrap;
    margin-bottom:30px;
}

.card{
    flex:1;
    min-width:250px;
    background:white;
    padding:25px;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    text-align:center;
}

.card h2{
    color:#4e73df;
    margin-bottom:10px;
}

.card p{
    font-size:28px;
    font-weight:bold;
    color:#333;
}

.actions{
    display:flex;
    gap:20px;
    flex-wrap:wrap;
}

.btn{
    text-decoration:none;
    background:#4e73df;
    color:white;
    padding:15px 25px;
    border-radius:10px;
    display:inline-block;
}

.btn:hover{
    background:#375ac2;
}

.logout{
    background:#dc3545;
}

.logout:hover{
    background:#b52a37;
}
.dashboard-cards{

display:grid;
grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
gap:20px;
margin:30px 0;

}

.card{

background:white;
padding:25px;
border-radius:12px;
box-shadow:0 5px 15px rgba(0,0,0,.1);
text-align:center;
transition:.3s;

}

.card:hover{

transform:translateY(-5px);

}

.card h2{

color:#666;
margin-bottom:15px;

}

.card h1{

font-size:34px;
color:#4e73df;

}
</style>

</head>

<body>

<div class="header">
    <h1>Admin Dashboard</h1>
    <p>Sofa Customizer Management System</p>
</div>
<div class="dashboard-cards">

<div class="card">
<h2>👥 Users</h2>
<h1><?= $users['total'] ?></h1>
</div>

<div class="card">
<h2>📦 Orders</h2>
<h1><?= $orders['total'] ?></h1>
</div>

<div class="card">
<h2>💰 Revenue</h2>
<h1>Ksh <?= number_format($revenue['total'] ?? 0) ?></h1>
</div>

<div class="card">
<h2>⏳ Pending</h2>
<h1><?= $pending['total'] ?></h1>
</div>

<div class="card">
<h2>🚚 Processing</h2>
<h1><?= $processing['total'] ?></h1>
</div>

<div class="card">
<h2>✅ Delivered</h2>
<h1><?= $delivered['total'] ?></h1>
</div>

</div>
<div class="container">

    <div class="cards">

        <div class="card">
            <h2>Total Products</h2>
            <p><?php echo $product_count; ?></p>
        </div>

        <div class="card">
            <h2>Total Customers</h2>
            <p><?php echo $user_count; ?></p>
        </div>

        <div class="card">
            <h2>System Status</h2>
            <p>Active</p>
        </div>

    </div>

    <div class="actions">

        <a href="add-product.php" class="btn">
            Add Product
        </a>

        <a href="../index.php" class="btn">
            View Website
        </a>

        <a href="orders.php" class="btn">Manage Orders</a>

        <a href="../logout.php" class="btn logout">
            Logout
        </a>

    </div>

</div>

</body>
</html>