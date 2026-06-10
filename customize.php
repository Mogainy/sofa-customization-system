<?php
include("config/db.php");

$id = $_GET['id'];

$product = mysqli_query($conn,"SELECT * FROM products WHERE id='$id'");
$row = mysqli_fetch_assoc($product);
?>

<!DOCTYPE html>
<html>
<head>
<title>Customize Sofa</title>

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
    text-align:center;
    padding:20px;
}

.container{
    width:90%;
    max-width:1100px;
    margin:30px auto;
    display:flex;
    gap:30px;
    background:white;
    padding:30px;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

.sofa-preview{
    position:relative;
    width:500px;
    margin:auto;
}

#sofaImage{
    width:500px;
    display:block;
}

#textureLayer{
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;

    background-image:url('assets/images/textures/velvet.jpg');
    background-size:cover;
    background-position:center;

    opacity:0.9;
mix-blend-mode:overlay;

    -webkit-mask-image:url('assets/masks/sofa-mask.svg');
    -webkit-mask-repeat:no-repeat;
    -webkit-mask-size:contain;
    -webkit-mask-position:center;

    mask-image:url('assets/masks/sofa-mask.svg');
    mask-repeat:no-repeat;
    mask-size:contain;
    mask-position:center;
}

.details{
    flex:1;
}

.details h2{
    margin-bottom:15px;
    color:#333;
}

.details p{
    color:#666;
    margin-bottom:15px;
}

.price{
    font-size:28px;
    color:#1cc88a;
    font-weight:bold;
    margin-bottom:25px;
}

.section-title{
    margin-top:20px;
    margin-bottom:10px;
    font-weight:bold;
    color:#333;
}

.colors{
    display:flex;
    gap:15px;
    margin-bottom:20px;
}

.color-btn{
    width:45px;
    height:45px;
    border-radius:50%;
    border:3px solid #ddd;
    cursor:pointer;
}

.red{
    background:red;
}

.blue{
    background:blue;
}

.green{
    background:green;
}

.black{
    background:black;
}

.texture-btn{
    padding:10px 20px;
    margin:10px;
    border:none;
    cursor:pointer;
    border-radius:5px;
}

.order-btn{
    margin-top:25px;
    width:100%;
    padding:15px;
    background:#4e73df;
    color:white;
    border:none;
    border-radius:8px;
    font-size:16px;
    cursor:pointer;
}

.order-btn:hover{
    background:#375ac2;
}

</style>
</head>

<body>

<div class="header">
    <h1>Customize Your Sofa</h1>
</div>

<div class="container">

   <div class="sofa-preview">

    <img
    id="sofaImage"
    src="assets/images/<?php echo $row['image']; ?>"
    >

    <div id="textureLayer"></div>

</div>

    <div class="details">

        <h2><?php echo $row['name']; ?></h2>

        <p><?php echo $row['description']; ?></p>

        <div class="price">
            Ksh <?php echo number_format($row['price']); ?>
        </div>

        <div class="section-title">
            Select Color
        </div>

        <div class="colors">

            <button class="color-btn red"
onclick="changeColor('red')"></button>

<button class="color-btn blue"
onclick="changeColor('blue')"></button>

<button class="color-btn green"
onclick="changeColor('green')"></button>

<button class="color-btn black"
onclick="changeColor('black')"></button>

<h3>Select Texture</h3>

<button onclick="changeTexture('velvet')">
Velvet
</button>

<button onclick="changeTexture('leather')">
Leather
</button>

<button onclick="changeTexture('linen')">
Linen
</button>
        </div>

        <div class="section-title">
            Select Fabric Texture
        </div>

        <select class="texture">
            <option>Velvet</option>
            <option>Leather</option>
            <option>Linen</option>
            <option>Cotton</option>
        </select>

       <form action="place_order.php" method="POST">

    <input type="hidden"
           name="product_id"
           value="<?php echo $row['id']; ?>">

    <input type="hidden"
           id="selectedColor"
           name="color"
           value="default">

    <input type="hidden"
           id="selectedTexture"
           name="texture"
           value="default">

    <button type="submit" class="order-btn">
        Place Order
    </button>

</form>

    </div>

</div>

<script>

let currentColor = "";
let currentTexture = "";

function changeColor(color)
{
    document.getElementById("selectedColor").value = color;
    currentColor = color;
    applyCustomization();
}

function changeTexture(texture)
{
    document.getElementById("selectedTexture").value = texture;
    currentTexture = texture;

    document.getElementById("textureLayer")
        .style.backgroundImage =
        "url('assets/images/textures/" + texture + ".jpg')";

    applyCustomization();
}
function applyCustomization()
{
    let layer = document.getElementById("textureLayer");

    switch(currentColor)
    {
        case "red":
            layer.style.filter =
            "sepia(100%) saturate(500%) hue-rotate(-40deg)";
            break;

        case "blue":
            layer.style.filter =
            "sepia(100%) saturate(500%) hue-rotate(180deg)";
            break;

        case "green":
            layer.style.filter =
            "sepia(100%) saturate(500%) hue-rotate(70deg)";
            break;

        case "black":
            layer.style.filter =
            "grayscale(100%) brightness(40%)";
            break;

        default:
            layer.style.filter = "none";
    }
}

</script>

</body>
</html>