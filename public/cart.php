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
CartItem::updateQuantity();
CartItem::delete();

$categoryList = Category::getAll();
$userId = $_SESSION['logined']->id;
$mixList = Shoe::getShoesAndQuantityInCart($userId);

Utility::renderView('cart', ["categoryList" => $categoryList, 'mixList' => $mixList]);
