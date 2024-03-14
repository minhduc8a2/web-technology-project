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
$shoe->price = Utility::moneyFormat($shoe->price);
CartItem::create();
Utility::renderView('product', array_merge($shoe->getArrayForExtraction(), ["categoryList" => $categoryList]));
