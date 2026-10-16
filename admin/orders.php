<?php
session_start();
include("../config/db.php");
if(isset($_POST['update_status']))
{
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    // Update the order
    mysqli_query($conn,
    "UPDATE orders
     SET status='$status'
     WHERE id='$order_id'");

    // Get customer information
    $sql = "
    SELECT users.name, users.email, products.name AS sofa
    FROM orders
    JOIN users ON orders.user_id = users.id
    JOIN products ON orders.product_id = products.id
    WHERE orders.id='$order_id'
    ";

    $result = mysqli_query($conn,$sql);

    if($row = mysqli_fetch_assoc($result))
    {
        $customerName = $row['name'];
        $customerEmail = $row['email'];
        $sofa = $row['sofa'];

        include("../config/send_email.php");

        $subject = "Your Sofa Order Status Has Changed";

        $body = "
        <h2>Hello $customerName,</h2>

        <p>Your order for <b>$sofa</b> has been updated.</p>

        <h3>New Status:</h3>

        <p style='color:#4e73df;font-size:18px;'>
        <b>$status</b>
        </p>

        <br>

        Thank you for shopping with Sofa Customizer.
        ";

        sendEmail(
            $customerEmail,
            $customerName,
            $subject,
            $body
        );
    }
}
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin')
{
    header("Location: ../login.php");
    exit();
}
$revenue = mysqli_fetch_assoc(
    mysqli_query($conn,"
        SELECT SUM(total_price) AS total
        FROM orders
        WHERE payment_status='Paid'
    ")
);
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
<h1>Customer Orders</h1>

<div style="margin:20px 0;">
    <a href="dashboard.php" class="dashboard-btn">
        ← Back to Dashboard
    </a>
</div>
<table>

<tr>

<th>Customer</th>
<th>Product</th>
<th>sofa_color</th>
<th>sofa_texture</th>
<th>pillow_color</th>
<th>pillow_texture</th>
<th>Customized Sofa</th>
<th>Status</th>
<th>Date</th>
</tr>

<?php while($row=mysqli_fetch_assoc($result)) { ?>

<tr>

<td><?php echo $row['customer']; ?></td>
<td><?php echo $row['product']; ?></td>
<td><b>Body:</b> <?= colorName($row['sofa_color']); ?><br></td>
<td><b>Body:</b> <?= ucfirst($row['sofa_texture']); ?></td>
<td><b>Pillows:</b> <?= colorName($row['pillow_color']); ?></td>
<td><b>Pillows:</b> <?= ucfirst($row['pillow_texture']); ?></td>

<td>

<?php if(!empty($row['custom_image'])){ ?>

<img src="../<?= $row['custom_image']; ?>"
     width="120"
     style="border-radius:8px;">

<?php } ?>

</td>
<td>

<form method="POST">

<input type="hidden"
       name="order_id"
       value="<?php echo $row['id']; ?>">

<select name="status">

<option value="Pending Payment"
<?= $row['status']=="Pending Payment" ? "selected" : "" ?>>
Pending Payment
</option>

<option value="Payment Confirmed"
<?= $row['status']=="Payment Confirmed" ? "selected" : "" ?>>
Payment Confirmed
</option>

<option value="Processing"
<?= $row['status']=="Processing" ? "selected" : "" ?>>
Processing
</option>

<option value="Ready for Delivery"
<?= $row['status']=="Ready for Delivery" ? "selected" : "" ?>>
Ready for Delivery
</option>

<option value="Delivered"
<?= $row['status']=="Delivered" ? "selected" : "" ?>>
Delivered
</option>

<option value="Cancelled"
<?= $row['status']=="Cancelled" ? "selected" : "" ?>>
Cancelled
</option>

</select>

<button type="submit"
        name="update_status">
Update
</button>

</form>

</td>
<td><?= date("d M Y, h:i A", strtotime($row['date'])); ?></td>
</tr>

<?php } ?>

</table>

</div>

</body>
</html>