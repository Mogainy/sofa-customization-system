<?php
$conn = mysqli_connect("localhost", "root", "", "sofa_customizer");

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>