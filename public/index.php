<?php
require dirname(__DIR__, 1) . '/vendor/autoload.php';

session_start();
use Classes\Models\Category as Category;
use Classes\Models\Shoe as Shoe;
use Classes\Others\Utility as Utility;

$categoryList = Category::getAll();
$shoeList = Shoe::getAll();
Utility::renderView('index', ["shoeList" => $shoeList, "categoryList" => $categoryList]);
