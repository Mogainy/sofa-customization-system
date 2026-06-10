<?php
session_start();
include("../config/db.php");

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

</style>

</head>

<body>

<div class="header">
    <h1>Admin Dashboard</h1>
    <p>Sofa Customizer Management System</p>
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

        <a href="orders.php">Manage Orders</a>

        <a href="../logout.php" class="btn logout">
            Logout
        </a>

    </div>

</div>

</body>
</html>