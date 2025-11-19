<?php
$host = "localhost";
$user = "root";
$pass = "";
$name = "apple";

$conn = mysqli_connect($host, $user, $pass, $name);

if ($conn) {
    echo "<script>console.log('Povezano!')</script>";
}
