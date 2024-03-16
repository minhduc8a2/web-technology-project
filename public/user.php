<?php
require dirname(__DIR__, 1) . '/vendor/autoload.php';

session_start();

use Classes\Models\Category as Category;
use Classes\Models\User;
use Classes\Others\Utility as Utility;

$categoryList = Category::getAll();


if (!isset($_SESSION['logined'])) {
    header('location: /login.php');
}

User::updateUserForUser();

$userId  = $_SESSION['logined']->id;

$userName  = $_SESSION['logined']->name;
$email  = $_SESSION['logined']->email;
$phoneNumber  = $_SESSION['logined']->phoneNumber;
$address  = $_SESSION['logined']->address;
$avatar  = $_SESSION['logined']->avatar;

Utility::renderView('user', ["categoryList" => $categoryList, 'userId' => $userId, 'userName' => $userName, "email" => $email, 'phoneNumber' => $phoneNumber, 'address' => $address, 'avatar' => $avatar]);
