<?php
session_start();

require_once dirname(__DIR__, 1) . '/connect_db.php';

if (!isset($_SESSION["logined"])) {

    header("location: /pages/login.php");
} else
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && !empty($_POST["id"])) {
    $billId = $_POST["id"];
    $userId = $_SESSION['logined']['id'];
    $role = $_SESSION['logined']['role'];

    $sql = "UPDATE bills SET status = 'cancel' WHERE id='$billId' and userId='$userId' ;";
    if ($role == 'admin') {
        $sql = "UPDATE bills SET status = 'cancel' WHERE id='$billId' ;";
    }
    try {

        if ($conn->query($sql) === TRUE) {
            $_SESSION["cancel_bill"] = true;
        } else {
            $_SESSION["cancel_bill"] = false;
        }
    } catch (\Throwable $th) {
        $_SESSION["cancel_bill"] = false;
    }
    header("location: /pages/billDetail.php?id=$billId");
}
