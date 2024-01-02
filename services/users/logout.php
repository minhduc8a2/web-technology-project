<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logOut"])) {
    $_SESSION['logined'] = null;
    header('location: /pages/login.php');
}
