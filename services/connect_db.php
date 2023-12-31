<?php
$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "webtechdb";




try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        echo "<script>alert('Connection failed')</script>";

        die("Connection failed: " . $conn->connect_error);
        exit();
    }
    echo "<script>console.log('Connect successfully')</script>";
} catch (\Throwable $th) {
    echo 'Error with server.';
    exit();
}
