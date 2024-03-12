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
function validatePhoneNumber($phone)
{
    if (preg_match('/^[0-9]*$/', $phone)) {
        return  true;
    } else {
        return  false;
    }
}

function validateEmail($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    return true;
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create"])) {

    $errorList = array();
    if (empty($_POST['name'])) {
        array_push($errorList, "Vui lòng nhập họ tên.");
    }
    if (empty($_POST['email'])) {
        array_push($errorList, "Vui lòng nhập email.");
    } else {

        if (!validateEmail($_POST['email'])) {
            array_push($errorList, "Vui lòng nhập đúng định dạng email.");
        }
    }
    if (empty($_POST['phoneNumber'])) {
        array_push($errorList, "Vui lòng nhập số điện thoại.");
    } else {
        if (!validatePhoneNumber(trim($_POST['phoneNumber']))) {
            array_push($errorList, "Vui lòng đúng định dạng số điện thoại.");
        }
    }
    if (empty($_POST['address'])) {
        array_push($errorList, "Vui lòng nhập địa chỉ.");
    }
    if (empty($_POST['role'])) {
        array_push($errorList, "Vui lòng nhập vai trò.");
    } else if (trim($_POST['role']) != 'admin' && trim($_POST['role']) != 'normal') {
        array_push($errorList, "Vui lòng nhập 1 trong hai giá trị 'admin' hoặc 'normal' trong mục vai trò.");
    }
    if (empty($_POST['password'])) {
        array_push($errorList, "Vui lòng nhập mật khẩu.");
    }



    // if authentic
    if (count($errorList) == 0) {

        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phoneNumber = trim($_POST['phoneNumber']);
        $address = trim($_POST['address']);
        $password =  trim($_POST['password']);
        $role = trim($_POST['role']);


        $sqlCheck = "select * from users where  phoneNumber='$phoneNumber'  or  email='$email';";
        try {
            $result = $conn->query($sqlCheck);
            $row = $result->fetch_assoc();
            $phoneExists = (bool)$row;
            if ($phoneExists) {
                array_push($errorList, "Số điện thoại hoặc email đã được đăng ký với tài khoản khác.");
            }
        } catch (\Throwable $th) {
            echo $th;
            exit();
        }
        if (isset($_FILES['imageFile']) && empty($_FILES['imageFile']['error'])) {
            try {
                $file = $_FILES['imageFile'];

                $respone = (new UploadApi())->upload($file['tmp_name']);
                $avatar = $respone['secure_url'];
                $avatarId = $respone['public_id'];
            } catch (\Throwable $th) {
                echo $th;
                exit();
            }
        }


        $sql = $conn->prepare("INSERT INTO users (name,email,phoneNumber,address,password,role) 
        VALUES (?,?,?,?,?,?);");
        $sql->bind_param('ssssss', $name, $email, $phoneNumber, $address, $password, $role);
        if (isset($avatar) && !empty($avatar)) {
            $sql = $conn->prepare("INSERT INTO users (name,email,phoneNumber,address,password,avatar,role) 
        VALUES (?,?,?,?,?,?,?);");
            $sql->bind_param('ssssss', $name, $email, $phoneNumber, $address, $password, $avatar, $role);
        }
        try {


            if ($sql->execute() == TRUE) {

                $_SESSION['create_user'] = true;
            }
        } catch (\Throwable $th) {
            echo $th;
            if (isset($avatarId)) (new UploadApi())->destroy($avatarId);
            exit();
        }

        if (count($errorList) != 0) {
            $_SESSION['error_list'] = $errorList;
        }
    }
    header("location: /pages/adminUser.php");
} else {
    echo "Unauthenticated";
}






$conn->close();
