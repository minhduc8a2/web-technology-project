<?php
require dirname(__DIR__, 1) . '/vendor/autoload.php';

session_start();

use Classes\Models\Category as Category;
use Classes\Models\Shoe as Shoe;
use Classes\Others\Utility as Utility;
use Classes\Others\Paginator as Paginator;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;



if (!isset($_SESSION['logined']) || (isset($_SESSION['logined']) && $_SESSION['logined']->role != 'admin')) {
    unset($_SESSION['logined']);
    header('location: /pages/login.php');
    exit();
}

//check if admin want to create shoe

Configuration::instance('cloudinary://698573158872163:pP_wRfiJ4vOcPPuJ2985ULdZXp8@dqqetbr1m?secure=true');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {

    $errorList = array();
    Utility::createErrorMessageForCreateShoe($errorList);
    if (count($errorList) == 0) {
        $uploadOK = true;
        ['imageurl' => $imageurl, 'imageId' => $imageId] = Utility::uploadImage($_FILES['imageFile']) ?? ['', ''];
        $_POST['imageurl'] = $imageurl;
        $newShoe = new Shoe($_POST);
        $check = Shoe::create($newShoe);
        if ($check) {
            $_SESSION['create_shoe'] =  true;
        } else {
            $_SESSION['create_shoe'] = false;
            if ($imageId) Utility::deleteImageOnCloudinary($imageId);
        }
    }
    if (count($errorList) != 0) {
        $_SESSION['error_list'] = array('errorList' => $errorList);
    }
}

//end of check if admin want to create shoe

//check if admin want to delete shoe

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"]) && isset($_POST["id"]) && !empty($_POST["id"])) {

    $shoeId = $_POST["id"];
    $imageurl = $_POST["imageurl"];
    Utility::deleteImageOnCloudinaryByURL($imageurl);
    $check = Shoe::deleteOne($shoeId);
    if ($check) {
        $_SESSION["delete_shoe"] = true;
    } else {
        $_SESSION["delete_shoe"] = false;
    }
}
//end of check if admin want to delete shoe


$categoryList = Category::getAll();

$limit = $_GET['limit'] ?? 12;
$page = $_GET['page'] ?? 1;
$offset = $page ? ($page - 1) * $limit : 0;
$totalShoes = Shoe::getShoesCount();
$paginator = new Paginator($limit, $totalShoes, $page);
$pages = $paginator->getPages(length: 3);

$shoeList = Shoe::getAll($limit, $offset);
Utility::renderView('admin', ["shoeList" => $shoeList, "categoryList" => $categoryList, 'pages' => $pages, 'paginator' => $paginator]);
