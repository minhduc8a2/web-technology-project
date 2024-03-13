<?php
require dirname(__DIR__, 1) . '/vendor/autoload.php';

session_start();

use Classes\Models\Category as Category;
use Classes\Models\Shoe as Shoe;
use Classes\Others\Utility as Utility;

$categoryList = Category::getAll();

$searchTerm = $_GET['search'];
$shoeList = Shoe::search($searchTerm);


Utility::renderView('search', ["shoeList" => $shoeList, "categoryList" => $categoryList, "searchTerm" => $searchTerm]);
