<?php
session_start();
dirname(__DIR__, 1);
require dirname(__DIR__, 1) . '/connect_db.php';
require dirname(__DIR__, 2) . '/vendor/autoload.php';

use Cloudinary\Configuration\Configuration;

Configuration::instance('cloudinary://698573158872163:pP_wRfiJ4vOcPPuJ2985ULdZXp8@dqqetbr1m?secure=true');

use Cloudinary\Api\Upload\UploadApi;



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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errorList = array();
    $signupFormState = array();

    if (empty($_POST['name'])) {
        array_push($errorList, "Vui lòng nhập họ tên.");
    } else {
        $signupFormState['name'] = $_POST['name'];
    }
    if (empty($_POST['email'])) {
        array_push($errorList, "Vui lòng nhập email.");
    } else {

        $signupFormState['email'] = $_POST['email'];

        if (!validateEmail($_POST['email'])) {
            array_push($errorList, "Vui lòng nhập đúng định dạng email.");
        }
    }
    if (empty($_POST['phoneNumber'])) {
        array_push($errorList, "Vui lòng nhập số điện thoại.");
    } else {

        $signupFormState['phoneNumber'] = $_POST['phoneNumber'];


        if (!validatePhoneNumber($_POST['phoneNumber'])) {
            array_push($errorList, "Vui lòng đúng định dạng số điện thoại.");
        }
    }
    if (empty($_POST['address'])) {
        array_push($errorList, "Vui lòng nhập địa chỉ.");
    } else {
        $signupFormState['address'] = $_POST['address'];
    }
    if (empty($_POST['password'])) {
        array_push($errorList, "Vui lòng nhập mật khẩu.");
    }
    if (empty($_POST['confirmPassword'])) {
        array_push($errorList, "Vui lòng nhập lại mật khẩu.");
    }
    if (isset($_POST['password']) && isset($_POST['confirmPassword']) && $_POST['confirmPassword'] != $_POST['password']) {
        array_push($errorList, "Mật khẩu không trùng khớp.");
    }




    if (count($errorList) == 0) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phoneNumber = $_POST['phoneNumber'];
        $address = $_POST['address'];
        $password =  $_POST['password'];

        $sqlCheck = "select * from users where phoneNumber='$phoneNumber' or email='$email';";
        try {
            $result = $conn->query($sqlCheck);
            $row = $result->fetch_assoc();
            $phoneExists = (bool)$row;
            if ($phoneExists) {
                array_push($errorList, "Số điện thoại đã được đăng ký hoặc email đã được đăng ký.");
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        if (isset($phoneExists) && !$phoneExists) {
            if (isset($_FILES['avatar']) && empty($_FILES['avatar']['error'])) {
                echo $_FILES['imageFile']['error'];
                $file = $_FILES['avatar'];
                $respone = (new UploadApi())->upload($file['tmp_name']);
                $avatar = $respone['secure_url'];
            }


            $sql = $conn->prepare("INSERT INTO users (name,email,phoneNumber,address,password) 
            VALUES (?,?,?,?,?);");
            $sql->bind_param('sssss', $name, $email, $phoneNumber, $address, $password);
            if (isset($avatar) && !empty($avatar)) {
                $sql = $conn->prepare("INSERT INTO users (name,email,phoneNumber,address,password,avatar) 
            VALUES (?,?,?,?,?,?);");
                $sql->bind_param('ssssss', $name, $email, $phoneNumber, $address, $password, $avatar);
            }
            if ($sql->execute() === TRUE) {

                $_SESSION['sign_up'] = true;
            } else {
                $_SESSION['sign_up'] = false;
            }
        }
    }
    if (count($errorList) != 0) {
        $_SESSION['error_list'] = $errorList;
        $_SESSION['sign_up_form_state'] = $signupFormState;
    }

    header("location: /pages/signup.php");
} else {
    echo "Unauthenticated";
}






$conn->close();
