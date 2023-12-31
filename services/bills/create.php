<?php
require dirname(__DIR__, 1) . '\connect_db.php';
session_start();
if (!isset($_SESSION["logined"])) {

    header("location: /pages/login.php");
} else 
if (isset($_SESSION['shoeList'])) {
    $userId = $_SESSION['logined']['id'];
    $userName = $_SESSION['logined']['name'];
    $phoneNumber = $_SESSION['logined']['phoneNumber'];
    $address = $_SESSION['logined']['address'];
    $total = $_SESSION['order_total']; //need unset
    $shoeList = $_SESSION['shoeList'];  //need unset
    $sql = "INSERT INTO bills (userId,userName,phoneNumber, address, total) VALUES ('$userId','$userName','$phoneNumber','$address',$total);";
    echo "doing";
    try {
        if ($conn->query($sql) === TRUE) {
            $bill_id = $conn->insert_id;
            echo $bill_id;
            $length = count($shoeList);
            for ($i = 0; $i < $length; $i++) {
                $shoeId = $shoeList[$i]['id'];
                $price = $shoeList[$i]['price'];
                $quantity = $shoeList[$i]['quantity'];
                $sql = "INSERT INTO billItems (billId,shoeId,price, quantity) VALUES ('$bill_id','$shoeId','$price','$quantity');";
                if ($conn->query($sql) !== TRUE) {
                    $_SESSION['create_bill'] = FALSE;
                }
            }
        }
    } catch (\Throwable $th) {
        //throw $th;
        echo $th;
        $_SESSION['create_bill'] = FALSE;
    }
    unset($_SESSION['order_total']); //need unset
    unset($_SESSION['shoeList']);  //need unset
    if (isset($_SESSION['create_bill'])) {
        header("location: /pages/order.php");
    } else {
        unset($_SESSION['create_bill']);
        header("location: /pages/billDetail.php?id=$bill_id");
    }
} else {
    echo "Unauthenticated";
}
$conn->close();
