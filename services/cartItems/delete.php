<?php
require_once dirname(__DIR__, 1) . '\connect_db.php';
session_start();
if (!isset($_SESSION["logined"])) {

    header("location: /pages/login.php");
} else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && !empty($_POST["id"])) {

    $shoeId = $_POST["id"];
    $userId = $_SESSION['logined']['id'];;

    $sql = "delete from cartItems WHERE shoeId=$shoeId and userId=$userId";
    try {

        if ($conn->query($sql) === TRUE) {
            $_SESSION["delete_shoe"] = true;
        } else {
            $_SESSION["delete_shoe"] = false;
        }
    } catch (\Throwable $th) {
        $_SESSION["delete_shoe"] = false;
    }
    header("location: /pages/cart.php");
}
