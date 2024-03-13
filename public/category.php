<?php
require dirname(__DIR__, 1) . '/vendor/autoload.php';

session_start();

use Classes\Models\Category as Category;
use Classes\Models\Shoe as Shoe;
use Classes\Others\Utility as Utility;
use Classes\Others\Paginator as Paginator;


$categoryList = Category::getAll();

if (isset($_GET['categoryId'])) {
    $categoryId = $_GET['categoryId'];
} else {
    echo "No category";
    exit();
}

$categoryName = Category::getOne($categoryId)?->name;
$limit = $_GET['limit'] ?? 12;
$page = $_GET['page'] ?? 1;
$offset = $page ? ($page - 1) * $limit : 0;
$totalShoes = Shoe::getShoesCount('where category = ?', [$categoryName]);
$paginator = new Paginator($limit, $totalShoes, $page);
$pages = $paginator->getPages(length: 3);

$shoeList = Shoe::getShoesByCategory($categoryId);
Utility::renderView('category', ["shoeList" => $shoeList, "categoryList" => $categoryList, 'categoryName' => $categoryName, 'paginator' => $paginator, 'pages' => $pages, 'categoryId' => $categoryId]);
