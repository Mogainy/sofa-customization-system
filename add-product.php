<?php
include("../config/db.php");

$message = "";

if(isset($_POST['add_product']))
{
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $image = $_FILES['image']['name'];
    $temp = $_FILES['image']['tmp_name'];

    move_uploaded_file($temp, "../assets/images/".$image);

    $sql = "INSERT INTO products(name, description, price, image)
            VALUES('$name','$description','$price','$image')";

    if(mysqli_query($conn, $sql))
    {
        $message = "Product Added Successfully!";
    }
    else
    {
        $message = "Error: ".mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Product</title>

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
    width:500px;
    margin:40px auto;
    background:white;
    padding:30px;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

h2{
    text-align:center;
    margin-bottom:20px;
    color:#333;
}

.success{
    background:#d4edda;
    color:#155724;
    padding:10px;
    border-radius:5px;
    margin-bottom:15px;
    text-align:center;
}

label{
    display:block;
    margin-bottom:5px;
    font-weight:bold;
    color:#333;
}

input,
textarea{
    width:100%;
    padding:12px;
    margin-bottom:15px;
    border:1px solid #ccc;
    border-radius:8px;
}

textarea{
    height:100px;
    resize:none;
}

input[type="file"]{
    padding:8px;
}

button{
    width:100%;
    padding:12px;
    background:#4e73df;
    color:white;
    border:none;
    border-radius:8px;
    font-size:16px;
    cursor:pointer;
}

button:hover{
    background:#375ac2;
}

.back{
    display:block;
    text-align:center;
    margin-top:15px;
    text-decoration:none;
    color:#4e73df;
    font-weight:bold;
}

</style>
</head>

<body>

<div class="header">
    <h1>Admin Panel</h1>
</div>

<div class="container">

    <h2>Add New Sofa Product</h2>

    <?php if($message != "") { ?>
        <div class="success">
            <?php echo $message; ?>
        </div>
    <?php } ?>

    <form method="POST" enctype="multipart/form-data">

        <label>Product Name</label>
        <input type="text" name="name" required>

        <label>Description</label>
        <textarea name="description" required></textarea>

        <label>Price (Ksh)</label>
        <input type="number" name="price" required>

        <label>Product Image</label>
        <input type="file" name="image" required>

        <button type="submit" name="add_product">
            Add Product
        </button>

    </form>

    <a class="back" href="dashboard.php">
        ← Back to Dashboard
    </a>

</div>

</body>
</html>