<?php

namespace Classes\Models;

require dirname(__DIR__, 2) . '/vendor/autoload.php';


use Classes\Models\DatabaseConnector as DatabaseConnector;
use Classes\Others\Utility as Utility;

class CartItem
{
    public static function create()
    {

        $database = new DatabaseConnector();

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && !empty($_POST["id"])) {
            if (!isset($_SESSION["logined"])) {

                header("location: /login.php");
            }
            $userId = $_SESSION['logined']->id;
            $shoeId = $_POST["id"];

            $sql = $database->queryNotExecuted("call create_cartitem( ? , ? )", [$userId, $shoeId]);
            if ($sql->execute() == true) {
                $_SESSION['add_to_cart'] = true;
            }
        }
    }

    public static function delete()
    {
        $database = new DatabaseConnector();
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"]) && isset($_POST["id"]) && !empty($_POST["id"])) {

            $shoeId = $_POST["id"];
            $userId = $_SESSION['logined']->id;

            $sql = $database->queryNotExecuted("delete from cartItems WHERE shoeId=? and userId=?", [$shoeId, $userId]);
            try {

                if ($sql->execute() === TRUE) {
                    $_SESSION["delete_shoe"] = true;
                } else {
                    $_SESSION["delete_shoe"] = false;
                }
            } catch (\Throwable $th) {
                $_SESSION["delete_shoe"] = false;
            }
        }
    }
    public static function updateQuantity()
    {
        $database = new DatabaseConnector();

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["changeQuantity"]) &&  isset($_POST["id"]) && !empty($_POST["id"]) && isset($_POST["quantity"]) && !empty($_POST["quantity"])) {
            $input_quantity = $_POST["quantity"];
            $shoeId = $_POST["id"];
            $userId = $_SESSION['logined']->id;

            $sql = $database->queryNotExecuted("UPDATE cartItems SET quantity=? WHERE shoeId=? and userId=?", [$input_quantity, $shoeId, $userId]);

            try {
                if ($sql->execute() === TRUE) {
                    $_SESSION["update_quantity"] = true;
                } else {
                    $_SESSION["update_quantity"] = false;
                }
            } catch (\Throwable $th) {
                $_SESSION["update_quantity"] = false;
            }
        }
    }
}
