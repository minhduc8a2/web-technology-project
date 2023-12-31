<?php
require_once dirname(__DIR__, 1) . '\connect_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    $input_quantity = $_POST["quantity"];
    $shoeId = $_POST["id"];
    $userId = $_SESSION['logined']['id'];;

    $sql = "UPDATE cartItems SET quantity=$input_quantity WHERE shoeId=$shoeId and userId=$userId";
    try {
        //code...
        if ($conn->query($sql) === TRUE) {
            $_SESSION["update_quantity"] = true;
        } else {
            $_SESSION["update_quantity"] = false;
        }
    } catch (\Throwable $th) {
        $_SESSION["update_quantity"] = false;
    }
    header("location: /pages/cart.php");
}
