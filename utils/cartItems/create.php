<?php
session_start();

require dirname(__DIR__, 1) . '/connect_db.php';
if (!isset($_SESSION["logined"])) {

    header("location: /pages/login.php");
} else 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && !empty($_POST["id"])) {
    $userId = $_SESSION['logined']['id'];;
    $shoeId = $_POST["id"];

    $sql = $conn->prepare("INSERT INTO cartItems (userId,shoeId) VALUES (?,?);");
    $sql->bind_param('ii', $userId, $shoeId);
    try {
        $sql->execute();
    } catch (\Throwable $th) {
        //throw $th;
    }

    $_SESSION['add_to_cart'] = true;
    header("location: /pages/product.php?id=$shoeId");
} else {
    echo "Unauthenticated";
}
$conn->close();