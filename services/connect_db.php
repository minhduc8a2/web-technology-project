<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "webtechdb";




try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        echo "connect errors";


        exit();
    }
} catch (\Throwable $th) {
    echo 'Error with server.';
    exit();
}
