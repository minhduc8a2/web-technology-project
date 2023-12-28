<?php

$servername = "localhost";
$username = "root";
$password = "12345678";


$conn = new mysqli($servername, $username, $password);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "<script>console.log('Connect successfully')</script>";

try {
    $sql = "CREATE DATABASE webtechdb";
    if ($conn->query($sql) === TRUE) {
        echo "<script>console.log('Database created successfully')</script>";
    }
} catch (Throwable $th) {
    //throw $th;
    echo "<script>console.log('Database exists')</script>";
}


