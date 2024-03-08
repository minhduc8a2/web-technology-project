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

    $sql = $conn->prepare("UPDATE bills SET status = 'cancel' WHERE id=? and userId=? ;");
    $sql->bind_param('ii', $billId, $userId);
    if ($role == 'admin') {
        $sql = $conn->prepare("UPDATE bills SET status = 'cancel' WHERE id=? ;");
        $sql->bind_param('i', $billId);
    } else {
    }
    try {

        if ($sql->execute() === TRUE) {
            $_SESSION["cancel_bill"] = true;
        } else {
            $_SESSION["cancel_bill"] = false;
        }
    } catch (\Throwable $th) {
        $_SESSION["cancel_bill"] = false;
    }
    header("location: /pages/billDetail.php?id=$billId");
}
