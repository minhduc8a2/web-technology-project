<?php

$servername = "localhost";
$username = "root";
$password = "root";


$conn = new mysqli($servername, $username, $password);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "<br>Connect successfully";

try {
    $sql = "CREATE DATABASE webtechdb";
    if ($conn->query($sql) === TRUE) {
        echo "<br>Database created successfully";
    }
} catch (Throwable $th) {
    //throw $th;
    echo "<br>'Database exists";
}
