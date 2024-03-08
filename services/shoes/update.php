<?php
session_start();

require dirname(__DIR__, 1) . '/connect_db.php';
require dirname(__DIR__, 2) . '/vendor/autoload.php';

use Cloudinary\Configuration\Configuration;

Configuration::instance('cloudinary://698573158872163:pP_wRfiJ4vOcPPuJ2985ULdZXp8@dqqetbr1m?secure=true');

use Cloudinary\Api\Upload\UploadApi;

if (!isset($_SESSION["logined"]) || (isset($_SESSION["logined"]) && $_SESSION["logined"]['role'] != "admin")) {

    header("location: /pages/login.php");
    exit('Unauthenticated');
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {

    $errorList = array();

    if (empty($_POST['name'])) {
        array_push($errorList, "Vui lòng nhập tên sản phẩm");
    } else {
    }
    if (empty($_POST['category'])) {
        array_push($errorList, "Vui lòng nhập loại sản phẩm.");
    }
    if (empty($_POST['description'])) {
        array_push($errorList, "Vui lòng nhập mô tả sản phẩm.");
    }
    if (empty($_POST['price'])) {
        array_push($errorList, "Vui lòng nhập giá sản phẩm.");
    }
    if (empty($_POST['instock'])) {
        array_push($errorList, "Vui lòng nhập số lượng tồn kho.");
    }
    try {
        if (empty($_POST['sold']) && $_POST['sold'] != 0) {
            array_push($errorList, "Vui lòng nhập số lượng đã bán.");
        }
    } catch (\Throwable $e) {
        if (empty($_POST['sold'])) {
            array_push($errorList, "Vui lòng nhập số lượng đã bán.");
        }
    }





    if (count($errorList) == 0) {
        $name = trim($_POST['name']);
        $category = trim($_POST['category']);
        $description = trim($_POST['description']);
        $price = $_POST['price'];
        $instock = $_POST['instock'];
        $sold =  $_POST['sold'];
        $id = $_POST['id'];
        $imageurl = trim($_POST['imageurl']);
        $uploadOK = true;
        if (isset($_FILES['imageFile']) && empty($_FILES['imageFile']['error'])) {

            $temp  = explode('/', $imageurl);
            $imageId = $temp[count($temp) - 2] . '/' . explode('.', $temp[count($temp) - 1])[0];
            try {
                (new UploadApi())->destroy($imageId);
                $file = $_FILES['imageFile'];

                $respone = (new UploadApi())->upload($file['tmp_name']);
                $imageurl = $respone['secure_url'];
            } catch (\Throwable $th) {
                $uploadOK = false;
            }
        }


        $sql = $conn->prepare("UPDATE shoes SET name=?, description=?,  price=?, category=?, instock = ?, sold = ?, imageurl = ? WHERE id=?;");
        $sql->bind_param('ssisiisi', $name, $description, $price, $category, $instock, $sold, $imageurl, $id);
        try {
            if ($sql->execute() === TRUE && $uploadOK) {

                $_SESSION['update_shoe'] = array('id' => $id, 'state' => true);
            } else {
                $_SESSION['update_shoe'] = array('id' => $id, 'state' => false);
            }
        } catch (\Throwable $th) {
            echo $th;
            exit();
        }
    }
    if (count($errorList) != 0) {
        $_SESSION['error_list'] = array('id' => $_POST['id'], 'errorList' => $errorList);
    }

    header("location: /pages/admin.php");
} else {
    echo "Unauthenticated";
}






$conn->close();
