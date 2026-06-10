```php
<?php
session_start();
include "config/db.php";

$message = "";

if(isset($_POST['login']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users
            WHERE email='$email'
            AND password='$password'";

    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_assoc($result);

        $_SESSION['user_id'] = $row['id'];
        $_SESSION['role'] = $row['role'];

        if($row['role'] == 'admin')
        {
            header("Location: admin/dashboard.php");
        }
        else
        {
            header("Location: index.php");
        }
    }
    else
    {
        $message = "Invalid Email or Password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sofa Customizer - Login</title>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial, sans-serif;
        }

        body{
            background:linear-gradient(135deg,#4e73df,#1cc88a);
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .container{
            background:white;
            width:400px;
            padding:30px;
            border-radius:15px;
            box-shadow:0 10px 25px rgba(0,0,0,0.2);
        }

        h2{
            text-align:center;
            margin-bottom:20px;
            color:#333;
        }

        .error{
            background:#f8d7da;
            color:#721c24;
            padding:10px;
            border-radius:5px;
            margin-bottom:15px;
            text-align:center;
        }

        input{
            width:100%;
            padding:12px;
            margin-bottom:15px;
            border:1px solid #ccc;
            border-radius:8px;
            outline:none;
        }

        input:focus{
            border-color:#4e73df;
        }

        button{
            width:100%;
            padding:12px;
            background:#4e73df;
            color:white;
            border:none;
            border-radius:8px;
            cursor:pointer;
            font-size:16px;
        }

        button:hover{
            background:#375ac2;
        }

        .register-link{
            text-align:center;
            margin-top:15px;
        }

        .register-link a{
            text-decoration:none;
            color:#4e73df;
            font-weight:bold;
        }

    </style>
</head>

<body>

<div class="container">

    <h2>Welcome Back</h2>

    <?php if($message != "") { ?>
        <div class="error">
            <?php echo $message; ?>
        </div>
    <?php } ?>

    <form method="POST">

        <input type="email"
               name="email"
               placeholder="Email Address"
               required>

        <input type="password"
               name="password"
               placeholder="Password"
               required>

        <button type="submit" name="login">
            Login
        </button>

    </form>

    <div class="register-link">
        Don't have an account?
        <a href="register.php">Register Here</a>
    </div>

</div>

</body>
</html>

