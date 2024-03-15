<?php
session_start();

require dirname(__DIR__, 1) . '/connect_db.php';
if (!isset($_SESSION["logined"])) {

    header("location: /pages/login.php");
} else 
else {
    echo "Unauthenticated";
}
$conn->close();
