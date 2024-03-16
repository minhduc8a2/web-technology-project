<?php
require dirname(__DIR__, 1) . '/vendor/autoload.php';

use Classes\Models\Category as Category;
use Classes\Models\Shoe as Shoe;
use Classes\Models\CartItem as CartItem;
use Classes\Others\Utility as Utility;


session_start();
$categoryList = Category::getAll();
$shoeId = $_GET['id'];
$shoe = Shoe::getOne($shoeId);

//create cart item
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && !empty($_POST["id"])) {
    if (!isset($_SESSION["logined"])) {

        header("location: /login.php");
    }
    $userId = $_SESSION['logined']->id;
    $shoeId = $_POST["id"];

    if (CartItem::create($shoeId, $userId)) {
        $_SESSION['add_to_cart'] = true;
    }
}

// end of create cart item





Utility::renderView('product', ['shoe' => $shoe, "categoryList" => $categoryList]);
