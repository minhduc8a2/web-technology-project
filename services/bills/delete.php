<?php
require_once dirname(__DIR__, 1) . '\connect_db.php';


session_start();

if (!isset($_SESSION["logined"]) || (isset($_SESSION["logined"]) && $_SESSION["logined"]['role'] != "admin")) {

    header("location: /pages/login.php");
    exit('Unauthenticated');
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && !empty($_POST["id"])) {

    $billId = $_POST["id"];

    $sql = "delete from bills WHERE id=$billId;";
    try {

        if ($conn->query($sql) === TRUE) {
            $_SESSION["delete_bill"] = true;
        } else {
            $_SESSION["delete_bill"] = false;
        }
    } catch (\Throwable $th) {
        echo $th;
        exit();
    }
    header("location: /pages/adminBill.php");
}
