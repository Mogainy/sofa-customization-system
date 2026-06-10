<?php
session_start();
include("../config/db.php");
if(isset($_POST['update_status']))
{
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    mysqli_query($conn,
    "UPDATE orders
     SET status='$status'
     WHERE id='$order_id'");
}
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin')
{
    header("Location: ../login.php");
    exit();
}

$sql = "SELECT orders.*, users.name AS customer,
        products.name AS product
        FROM orders
        INNER JOIN users ON orders.user_id = users.id
        INNER JOIN products ON orders.product_id = products.id
        ORDER BY orders.id DESC";

$result = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Orders</title>

<style>

body{
    font-family:Arial;
    background:#f4f6f9;
}

.container{
    width:95%;
    margin:20px auto;
}

table{
    width:100%;
    border-collapse:collapse;
    background:white;
}

th{
    background:#4e73df;
    color:white;
    padding:12px;
}

td{
    padding:12px;
    border:1px solid #ddd;
}
select{
    padding:5px;
}

button{
    padding:5px 10px;
    background:#4e73df;
    color:white;
    border:none;
    cursor:pointer;
}
</style>
</head>
<body>

<div class="container">

<h2>Customer Orders</h2>

<table>

<tr>
<th>ID</th>
<th>Customer</th>
<th>Product</th>
<th>Color</th>
<th>Texture</th>
<th>Status</th>
<th>Date</th>
</tr>

<?php while($row=mysqli_fetch_assoc($result)) { ?>

<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['customer']; ?></td>
<td><?php echo $row['product']; ?></td>
<td><?php echo $row['color']; ?></td>
<td><?php echo $row['texture']; ?></td>
<td>

<form method="POST">

<input type="hidden"
       name="order_id"
       value="<?php echo $row['id']; ?>">

<select name="status">

<option value="Pending"
<?php if($row['status']=="Pending") echo "selected"; ?>>
Pending
</option>

<option value="Processing"
<?php if($row['status']=="Processing") echo "selected"; ?>>
Processing
</option>

<option value="Delivered"
<?php if($row['status']=="Delivered") echo "selected"; ?>>
Delivered
</option>

<option value="Cancelled"
<?php if($row['status']=="Cancelled") echo "selected"; ?>>
Cancelled
</option>

</select>

<button type="submit"
        name="update_status">
Update
</button>

</form>

</td>
<td><?php echo $row['date']; ?></td>
</tr>

<?php } ?>

</table>

</div>

</body>
</html>