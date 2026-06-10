<?php
session_start();
include("config/db.php");

$result = mysqli_query($conn, "SELECT * FROM products");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sofa Customizer</title>

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

        header{
            background:#4e73df;
            color:white;
            padding:20px;
            text-align:center;
        }

        .menu{
            background:white;
            padding:15px;
            text-align:center;
            box-shadow:0 2px 10px rgba(0,0,0,0.1);
        }

        .menu a{
            text-decoration:none;
            color:#4e73df;
            font-weight:bold;
            margin:0 20px;
        }

        .menu a:hover{
            color:#375ac2;
        }

        .container{
            width:90%;
            margin:30px auto;
        }

        .products{
            display:flex;
            flex-wrap:wrap;
            gap:25px;
            justify-content:center;
        }

        .card{
            background:white;
            width:320px;
            border-radius:15px;
            overflow:hidden;
            box-shadow:0 5px 15px rgba(0,0,0,0.1);
            transition:0.3s;
        }

        .card:hover{
            transform:translateY(-5px);
        }

        .card img{
            width:100%;
            height:250px;
            object-fit:contain;
            background:#fff;
        }

        .card-body{
            padding:20px;
        }

        .card h3{
            color:#333;
            margin-bottom:10px;
        }

        .card p{
            color:#666;
            margin-bottom:15px;
            min-height:50px;
        }

        .price{
            color:#1cc88a;
            font-size:22px;
            font-weight:bold;
            margin-bottom:15px;
        }

        .btn{
            display:block;
            text-align:center;
            text-decoration:none;
            background:#4e73df;
            color:white;
            padding:12px;
            border-radius:8px;
        }

        .btn:hover{
            background:#375ac2;
        }

    </style>

</head>

<body>

<header>
    <h1>Interactive Sofa Customizer</h1>
    <p>Choose, Customize and Order Your Dream Sofa</p>
</header>

<!-- MENU MOVED OUTSIDE THE LOOP -->
<div class="menu">

    <a href="index.php">Home</a>

    <?php if(isset($_SESSION['user_id'])) { ?>
        <a href="my_orders.php">My Orders</a>
        <a href="logout.php">Logout</a>
    <?php } else { ?>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    <?php } ?>

</div>

<div class="container">

    <div class="products">

        <?php while($row = mysqli_fetch_assoc($result)) { ?>

        <div class="card">

            <img
                src="assets/images/<?php echo $row['image']; ?>"
                alt="<?php echo $row['name']; ?>"
            >

            <div class="card-body">

                <h3><?php echo $row['name']; ?></h3>

                <p><?php echo $row['description']; ?></p>

                <div class="price">
                    Ksh <?php echo number_format($row['price']); ?>
                </div>

                <a
                    class="btn"
                    href="customize.php?id=<?php echo $row['id']; ?>"
                >
                    Customize Sofa
                </a>

            </div>

        </div>

        <?php } ?>

    </div>

</div>

</body>
</html>