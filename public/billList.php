<?php
require dirname(__DIR__, 1) . '/vendor/autoload.php';

session_start();

use Classes\Models\Category as Category;
use Classes\Models\Bill;
use Classes\Others\Utility as Utility;

$categoryList = Category::getAll();
// configure from here
if (!isset($_SESSION['logined'])) {

    header('location: /pages/login.php');
}
$userId = $_SESSION['logined']->id;

$billList = Bill::getAllForUser($userId);

Utility::renderView('billList', ["categoryList" => $categoryList, 'billList' => $billList]);
