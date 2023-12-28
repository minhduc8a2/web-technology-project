<?php
$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "webtechdb";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "<script>console.log('Connect successfully')</script>";
