```php
<?php
include "config/db.php";

$message = "";

if(isset($_POST['register']))
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "INSERT INTO users(name,email,password,role)
            VALUES('$name','$email','$password','customer')";

    if(mysqli_query($conn,$sql))
    {
        $message = "Registration Successful!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sofa Customizer - Register</title>

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

        .message{
            background:#d4edda;
            color:#155724;
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

        .login-link{
            text-align:center;
            margin-top:15px;
        }

        .login-link a{
            text-decoration:none;
            color:#4e73df;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>Create Account</h2>

    <?php if($message != "") { ?>
        <div class="message"><?php echo $message; ?></div>
    <?php } ?>

    <form method="POST">

        <input type="text"
               name="name"
               placeholder="Full Name"
               required>

        <input type="email"
               name="email"
               placeholder="Email Address"
               required>

        <input type="password"
               name="password"
               placeholder="Password"
               required>

        <button type="submit" name="register">
            Register
        </button>

    </form>

    <div class="login-link">
        Already have an account?
        <a href="login.php">Login</a>
    </div>

</div>

</body>
</html>

