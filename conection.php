<?php
$servername = "localhost";
$database = "stock";
$username = "root";
$password = "";
$mysql = new mysqli($servername, $username, $password,$database);
if (!$mysql) {
    die("Connection failed: " . mysqli_connect_error());
}
//mysql_close($conn);
?>