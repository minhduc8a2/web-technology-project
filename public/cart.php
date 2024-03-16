<?php
require dirname(__DIR__, 1) . '/vendor/autoload.php';

use Classes\Models\Category as Category;
use Classes\Models\Shoe as Shoe;
use Classes\Models\CartItem as CartItem;
use Classes\Others\Utility as Utility;

session_start();


if (!isset($_SESSION['logined'])) {
    header('location: /login.php');
}
// delete cart item
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"]) && isset($_POST["id"]) && !empty($_POST["id"])) {

    $shoeId = $_POST["id"];
    $userId = $_SESSION['logined']->id;
    if (CartItem::delete($shoeId, $userId)) {
        $_SESSION["delete_shoe"] = true;
    } else {
        $_SESSION["delete_shoe"] = false;
    }
}
// end of delete cart item
// update quantity of cart item
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["changeQuantity"]) &&  isset($_POST["id"]) && !empty($_POST["id"]) && isset($_POST["quantity"]) && !empty($_POST["quantity"])) {
    $input_quantity = $_POST["quantity"];
    $shoeId = $_POST["id"];
    $userId = $_SESSION['logined']->id;
    if (CartItem::updateQuantity($input_quantity,  $shoeId, $userId)) {
        $_SESSION["update_quantity"] = true;
    } else {
        $_SESSION["update_quantity"] = false;
    }
}
// end of update quantity of cart item

$categoryList = Category::getAll();
$userId = $_SESSION['logined']->id;
$mixList = Shoe::getShoesAndQuantityInCart($userId);
Utility::renderView('cart', ["categoryList" => $categoryList, 'mixList' => $mixList]);
