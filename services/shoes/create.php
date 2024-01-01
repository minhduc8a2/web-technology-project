<?php
require dirname(__DIR__, 1) . '\connect_db.php';
require dirname(__DIR__, 2) . '/vendor/autoload.php';

use Cloudinary\Configuration\Configuration;

Configuration::instance('cloudinary://698573158872163:pP_wRfiJ4vOcPPuJ2985ULdZXp8@dqqetbr1m?secure=true');

use Cloudinary\Api\Upload\UploadApi;

session_start();
if (!isset($_SESSION["logined"]) || (isset($_SESSION["logined"]) && $_SESSION["logined"]['role'] != "admin")) {

    header("location: /pages/login.php");
    exit('Unauthenticated');
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {

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

    if (isset($_FILES['imageFile']) && $_FILES['imageFile']['error'] != 0) {

        array_push($errorList, "Vui lòng chọn ảnh sản phẩm");
    }



    if (count($errorList) == 0) {
        $name = trim($_POST['name']);
        $category = trim($_POST['category']);
        $description = trim($_POST['description']);
        $price = $_POST['price'];
        $instock = $_POST['instock'];
        $sold =  $_POST['sold'];


        $uploadOK = true;



        try {

            $file = $_FILES['imageFile'];

            $respone = (new UploadApi())->upload($file['tmp_name']);
            $imageurl = $respone['secure_url'];
            $imageId = $respone['public_id'];
        } catch (\Throwable $th) {
            echo $th;
            exit();
        }



        $sql = "INSERT INTO shoes (name, description,category, price,sold, instock,imageurl)
        VALUES ('$name','$description','$category','$price','$sold','$instock','$imageurl') ;";
        try {
            if ($conn->query($sql) === TRUE) {

                $_SESSION['create_shoe'] = array('id' => $id, 'state' => true);
            } else {
                $_SESSION['create_shoe'] = array('id' => $id, 'state' => false);
            }
        } catch (\Throwable $th) {
            echo $th;
            echo $sql;
            (new UploadApi())->destroy($imageId);
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
