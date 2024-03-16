<?php
require dirname(__DIR__, 1) . '/vendor/autoload.php';

session_start();

use Classes\Models\Category as Category;
use Classes\Models\Bill as Bill;
use Classes\Others\Utility as Utility;
use Classes\Others\Paginator as Paginator;
use Cloudinary\Configuration\Configuration;



Configuration::instance('cloudinary://698573158872163:pP_wRfiJ4vOcPPuJ2985ULdZXp8@dqqetbr1m?secure=true');

if (!isset($_SESSION['logined']) || (isset($_SESSION['logined']) && $_SESSION['logined']->role != 'admin')) {
    unset($_SESSION['logined']);
    header('location: login.php');
    exit();
}

//check if admin want to delete bill

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"]) && isset($_POST["id"]) && !empty($_POST["id"])) {

    $billId = $_POST["id"];
    $check = bill::deleteOne($billId);
    if ($check) {
        $_SESSION["delete_bill"] = true;
    } else {
        $_SESSION["delete_bill"] = false;
    }
}
//end of check if admin want to delete shoe
// check if admin want to update status of bill


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && !empty($_POST["id"]) && isset($_POST["status"])) {

    $billId = $_POST["id"];
    $status = $_POST["status"];

    $check = Bill::changeStatus($billId, $status);
    $_SESSION["change_status_bill"] = $check;
}
// end of check if admin want to update status of bill

$categoryList = Category::getAll();
$limit = $_GET['limit'] ?? 12;
$page = $_GET['page'] ?? 1;
$offset = $page ? ($page - 1) * $limit : 0;
$totalBills = Bill::getCount();
$paginator = new Paginator($limit, $totalBills, $page);
$pages = $paginator->getPages(length: 3);

$billList = Bill::getAll($limit, $offset);
Utility::renderView('adminBill', ["billList" => $billList, "categoryList" => $categoryList, 'pages' => $pages, 'paginator' => $paginator]);
