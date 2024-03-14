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


$categoryList = Category::getAll();
$userId = $_SESSION['logined']->id;


Shoe::getShoesAndQuantityInOrder($userId);

$userName = $_SESSION['logined']->name;
$phoneNumber = $_SESSION['logined']->phoneNumber;
$address = $_SESSION['logined']->address;


if (!isset($_SESSION['mixList']) && !isset($_SESSION['create_bill'])) {
    header("location: /cart.php");
    exit();
}
$mixList = $_SESSION['mixList'] ?? [];
Utility::renderView('order', ["categoryList" => $categoryList, 'mixList' => $mixList, "userName" => $userName, "phoneNumber" => $phoneNumber, "address" => $address]);
