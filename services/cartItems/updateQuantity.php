<?php
session_start();

require_once dirname(__DIR__, 1) . '/connect_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_quantity = $_POST["quantity"];
    $shoeId = $_POST["id"];
    $userId = $_SESSION['logined']['id'];;

    $sql = $conn->prepare("UPDATE cartItems SET quantity=? WHERE shoeId=? and userId=?");
    $sql->bind_param('iii', $input_quantity, $shoeId, $userId);
    try {
        //code...
        if ($sql->execute() === TRUE) {
            $_SESSION["update_quantity"] = true;
        } else {
            $_SESSION["update_quantity"] = false;
        }
    } catch (\Throwable $th) {
        $_SESSION["update_quantity"] = false;
    }
    header("location: /pages/cart.php");
}
