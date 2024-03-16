<?php
require dirname(__DIR__, 1) . '/vendor/autoload.php';

session_start();

use Classes\Models\Category as Category;
use Classes\Models\Bill;
use Classes\Models\Shoe;
use Classes\Others\Utility as Utility;

$categoryList = Category::getAll();
// configure from here
if (!isset($_SESSION['logined'])) {

    header('location: /login.php');
}

// check if cancel bill button is clicked
if (isset($_POST['cancelBill']) && isset($_POST['id']) && !empty($_POST['id'])) {
    $id = $_POST['id'];
    $_SESSION['cancel_bill'] = Bill::cancel($id);
}

$billId = $_GET['id'];
$userId = $_SESSION['logined']->id;
$role = $_SESSION['logined']->role;


if ($role == 'admin') {
    $bill = Bill::getOne($billId);
} else {
    $bill = Bill::getOneForUser($billId, $userId);
}

$mixList = Shoe::getShoesByBill($billId);



Utility::renderView('billDetail', ["categoryList" => $categoryList, 'mixList' => $mixList, 'bill' => $bill]);
