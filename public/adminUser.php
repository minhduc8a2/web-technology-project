<?php
require dirname(__DIR__, 1) . '/vendor/autoload.php';

session_start();

use Classes\Models\Category as Category;
use Classes\Models\User as User;
use Classes\Others\Utility as Utility;
use Classes\Others\Paginator as Paginator;
use Cloudinary\Configuration\Configuration;



Configuration::instance('cloudinary://698573158872163:pP_wRfiJ4vOcPPuJ2985ULdZXp8@dqqetbr1m?secure=true');

if (!isset($_SESSION['logined']) || (isset($_SESSION['logined']) && $_SESSION['logined']->role != 'admin')) {
    unset($_SESSION['logined']);
    header('location: /login.php');
    exit();
}

//check if admin want to create user


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {

    $errorList = array();
    Utility::createErrorMessageForCreateUser($errorList);
    if (count($errorList) == 0) {
        unset($_POST['id']);
        $newUser = new User($_POST);
        //check user exists
        $checkExist = User::checkExist('where  phoneNumber = ?  or  email= ?', [$newUser->phoneNumber, $newUser->email]);
        if ($checkExist) {
            array_push($errorList, "Số điện thoại hoặc email đã được đăng ký với tài khoản khác.");
        }
        //
        //upload avatar
        if (isset($_FILES['imageFile']) && empty($_FILES['imageFile']['error'])) {
            ['imageurl' => $avatar, 'imageId' => $avatarId] = Utility::uploadImage($_FILES['imageFile']) ?? ['', ''];
        }
        //
        $haveAvatar = false;
        if (isset($avatar) && !empty($avatar)) {
            $haveAvatar = true;
            $newUser->avatar = $avatar;
        }
        $check = User::create($newUser, $haveAvatar);
        if ($check) {

            $_SESSION['create_user'] = true;
        } else {
            if (isset($avatarId)) Utility::deleteImageOnCloudinary($avatarId);
        }
    }
    if (count($errorList) != 0) {
        $_SESSION['error_list'] = array('errorList' => $errorList);
    }
}

//end of check if admin want to create user

//check if admin want to delete user

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"]) && isset($_POST["id"]) && !empty($_POST["id"])) {

    $userId = $_POST["id"];
    $imageurl = $_POST["imageurl"] ?? '';
    Utility::deleteImageOnCloudinaryByURL($imageurl);
    $check = User::deleteOne($userId);
    if ($check) {
        $_SESSION["delete_user"] = true;
    } else {
        $_SESSION["delete_user"] = false;
    }
}
//end of check if admin want to delete user
// check if admin want to update user

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && isset($_POST["update"])) {

    $errorList = array();
    Utility::createErrorMessageForCreateUser($errorList);
    if (count($errorList) == 0) {
        $newUser = new User($_POST);
        //check user exists
        $checkExist = User::checkExist('where ( phoneNumber=? and id!=? ) or ( email=? and id!=? );', [$newUser->phoneNumber, $newUser->id, $newUser->email, $newUser->id]);
        if ($checkExist) {
            array_push($errorList, "Số điện thoại hoặc email đã được đăng ký với tài khoản khác.");
        }
        //
        //upload avatar
        if (isset($_FILES['imageFile']) && empty($_FILES['imageFile']['error'])) {
            Utility::deleteImageOnCloudinaryByURL($newUser->avatar);
            ['imageurl' => $avatar, 'imageId' => $avatarId] = Utility::uploadImage($_FILES['imageFile']) ?? ['', ''];
            $newUser->avatar = $avatar;
        }
        //
        if (isset($checkExist) && !$checkExist) {
            $check = User::update($newUser);
            if ($check) {
                $_SESSION['update_user'] = array('id' => $newUser->id, 'state' => true);
            } else {
                Utility::deleteImageOnCloudinary($avatarId);
            }
        }
    }
    if (count($errorList) != 0) {
        $_SESSION['error_list'] = array('errorList' => $errorList);
    }
}
// end of check if admin want to update user

$categoryList = Category::getAll();
$limit = $_GET['limit'] ?? 12;
$page = $_GET['page'] ?? 1;
$offset = $page ? ($page - 1) * $limit : 0;
$totalUsers = User::getCount();
$paginator = new Paginator($limit, $totalUsers, $page);
$pages = $paginator->getPages(length: 3);

$userList = User::getAll($limit, $offset);
Utility::renderView('adminUser', ["userList" => $userList, "categoryList" => $categoryList, 'pages' => $pages, 'paginator' => $paginator]);
