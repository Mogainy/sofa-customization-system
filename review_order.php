<?php
session_start();


if (!isset($_POST['custom_image']) || empty($_POST['custom_image'])) {
    die("No customized image received.");
}

$customImage = $_POST['custom_image'];

$imageName = "sofa_" . time() . ".png";
$imagePath = "uploads/customized_sofas/" . $imageName;

$imageData = explode(',', $customImage);

if (count($imageData) < 2) {
    die("Invalid image data.");
}

$imageData = base64_decode($imageData[1]);

file_put_contents($imagePath, $imageData);

include("config/db.php");
function colorName($hex){

    $colors = [

"#000000"=>"Black",
"#2d2d2d"=>"Charcoal",
"#555555"=>"Dark Gray",
"#808080"=>"Gray",
"#ffffff"=>"White",

"#b22222"=>"Firebrick Red",
"#ff0000"=>"Red",
"#800000"=>"Maroon",

"#1e4fb8"=>"Royal Blue",
"#0000ff"=>"Blue",
"#87ceeb"=>"Sky Blue",

"#228b22"=>"Forest Green",
"#008000"=>"Green",
"#90ee90"=>"Light Green",

"#8b4513"=>"Brown",
"#f5deb3"=>"Beige",
"#ffd700"=>"Gold"

];
    return $colors[strtolower($hex)] ?? $hex;

}

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$product_id = $_POST['product_id'];

$stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
$stmt->bind_param("i",$product_id);
$stmt->execute();

$product = $stmt->get_result()->fetch_assoc();

$sofa_color = $_POST['sofa_color'];
$sofa_texture = $_POST['sofa_texture'];

$pillow_color = $_POST['pillow_color'];
$pillow_texture = $_POST['pillow_texture'];
$total=$_POST['total_price'];
?>

<!DOCTYPE html>
<html>
<head>

<title>Review Order</title>

<style>

body{
font-family:Arial;
background:#f5f5f5;
}

.container{
width:900px;
margin:40px auto;
background:white;
padding:30px;
border-radius:10px;
box-shadow:0 0 15px rgba(0,0,0,.1);
}

img{
width:350px;
display:block;
margin:auto;
}

table{
width:100%;
margin-top:30px;
border-collapse:collapse;
}

td{
padding:12px;
border-bottom:1px solid #ddd;
}

button{
background:#4e73df;
color:white;
padding:15px 30px;
border:none;
font-size:18px;
border-radius:5px;
cursor:pointer;
margin-top:25px;
}

button:hover{
background:#3456c4;
}
.review-table{
    width:100%;
    border-collapse:collapse;
    margin-top:30px;
}

.review-table th{
    background:#4e6fd8;
    color:white;
    padding:15px;
}

.review-table td{
    padding:15px;
    border-bottom:1px solid #ddd;
}

.color-circle{
    width:18px;
    height:18px;
    display:inline-block;
    border-radius:50%;
    border:1px solid #888;
    vertical-align:middle;
    margin-right:8px;
}
</style>

</head>

<body>

<div class="container">

<h1 align="center">Review Your Order</h1>

<img src="<?php echo $imagePath; ?>">

<table class="review-table">

<tr>
    <th>Component</th>
    <th>Color</th>
    <th>Material</th>
</tr>

<tr>
    <td><strong>Sofa Body</strong></td>

    <td>
        <span class="color-circle"
              style="background:<?= $sofa_color ?>"></span>

        <?= colorName($sofa_color) ?>
    </td>

    <td><?= ucfirst($sofa_texture) ?></td>
</tr>

<tr>
    <td><strong>Pillows</strong></td>

    <td>
        <span class="color-circle"
              style="background:<?= $pillow_color ?>"></span>

        <?= colorName($pillow_color) ?>
    </td>

    <td><?= ucfirst($pillow_texture) ?></td>
</tr>

<tr>
    <td colspan="2"><strong>Total Price</strong></td>

    <td>
        <strong>Ksh <?= number_format($total) ?></strong>
    </td>
</tr>

</table>

<form action="place_order.php" method="POST">

<input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
<input type="hidden" name="sofa_color" value="<?php echo $sofa_color; ?>">
<input type="hidden" name="sofa_texture" value="<?php echo $sofa_texture; ?>">
<input type="hidden" name="total_price" value="<?php echo $total; ?>">
<input type="hidden" name="phone" value="<?php echo htmlspecialchars($_POST['phone']); ?>">
<input type="hidden" name="delivery_address" value="<?php echo htmlspecialchars($_POST['delivery_address']); ?>">
<input type="hidden" name="payment_method" value="<?php echo htmlspecialchars($_POST['payment_method']); ?>">

<input type="hidden" name="custom_image" value="<?= $imagePath ?>">
<input type="hidden" name="pillow_color" value="<?php echo $pillow_color; ?>">
<input type="hidden" name="pillow_texture" value="<?php echo $pillow_texture; ?>">

<button>

Proceed to Payment

</button>

</center>

</form>

</div>

</body>

</html>