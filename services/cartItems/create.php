<?php
require dirname(__DIR__, 1) . '\connect_db.php';
session_start();
if (!isset($_SESSION["logined"])) {

    header("location: /pages/login.php");
} else 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && !empty($_POST["id"])) {
    $userId = "1";
    $shoeId = $_POST["id"];

    $sql = "INSERT INTO cartItems (userId,shoeId) VALUES ('$userId','$shoeId');";
    try {
        $conn->query($sql);
    } catch (\Throwable $th) {
        //throw $th;
    }

    $_SESSION['add_to_cart'] = true;
    header("location: /pages/product.php?id=$shoeId");
} else {
    echo "Unauthenticated";
}
$conn->close();
