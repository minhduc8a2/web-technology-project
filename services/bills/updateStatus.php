<?php
require_once dirname(__DIR__, 1) . '\connect_db.php';

session_start();

if (!isset($_SESSION["logined"]) || (isset($_SESSION["logined"]) && $_SESSION["logined"]['role'] != "admin")) {

    header("location: /pages/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && !empty($_POST["id"]) && isset($_POST["status"])) {

    $billId = $_POST["id"];
    $status = $_POST["status"];

    $sql = "UPDATE bills SET status = '$status' WHERE id='$billId';";
    try {

        if ($conn->query($sql) === TRUE) {
            $_SESSION["change_status_bill"] = true;
        } else {
            $_SESSION["change_status_bill"] = false;
        }
    } catch (\Throwable $th) {
        echo $th;
        exit();
    }
    header("location: /pages/adminBill.php");
} else echo 'Unauthenticated';
