<?php
require dirname(__DIR__, 1) . '/vendor/autoload.php';

use Classes\Models\Category as Category;
use Classes\Models\Shoe as Shoe;
use Classes\Models\Bill as Bill;
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



if (!isset($_SESSION['mixList']) && !isset($_SESSION['create_bill'])) { //the reason of 'create_bill' is we need to check if we created the bill successfully in 'order' page, if we don't add 'create_bill', we will not know if we created the bill successfully
    header("location: /cart.php");
    exit();
}
$mixList = $_SESSION['mixList'] ?? [];

//check if user want to create bill 
if (isset($_SESSION['mixList']) && isset($_POST['createBill'])) {
    $userId = $_SESSION['logined']->id;
    $userName = $_SESSION['logined']->name;
    $phoneNumber = $_SESSION['logined']->phoneNumber;
    $address = $_SESSION['logined']->address;
    $total = $_SESSION['order_total']; //need unset // total price of bill
    $mixList = $_SESSION['mixList'];  //need unset // shoeList in order

    $check = Bill::create($userId, $userName, $phoneNumber, $address, $total, $mixList);
    $_SESSION['create_bill'] = $check; // creating bill is not successful
    unset($_SESSION['order_total']); //need unset
    unset($_SESSION['mixList']);  //need unset
    unset($_POST['createBill']); //check if the action needs to create a bill
    if ($_SESSION['create_bill']) { //creating bill successfully
        $bill_id = $check['billId'];
        header("location: /billDetail.php?id=$bill_id");
    }
}
// end of check if user want to create bill



//
Utility::renderView('order', ["categoryList" => $categoryList, 'mixList' => $mixList, "userName" => $userName, "phoneNumber" => $phoneNumber, "address" => $address]);
