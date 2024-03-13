<?php
session_start();

require_once dirname(__DIR__, 1) . '/connect_db.php';


if (!isset($_SESSION["logined"]) || (isset($_SESSION["logined"]) && $_SESSION["logined"]['role'] != "admin")) {

    header("location: /pages/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && !empty($_POST["id"]) && isset($_POST["status"])) {

    $billId = $_POST["id"];
    $status = $_POST["status"];

    $sql = $conn->prepare("UPDATE bills SET status = ? WHERE id=?;");
    $sql->bind_param('si',$status,$billId);
    try {

        if ($sql->execute() === TRUE) {
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