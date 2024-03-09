<?php
session_start();

require dirname(__DIR__, 1) . '/connect_db.php';
require dirname(__DIR__, 2) . '/vendor/autoload.php';

use Cloudinary\Configuration\Configuration;

Configuration::instance('cloudinary://698573158872163:pP_wRfiJ4vOcPPuJ2985ULdZXp8@dqqetbr1m?secure=true');

use Cloudinary\Api\Upload\UploadApi;

if (!isset($_SESSION["logined"])) {

    header("location: /pages/login.php");
    exit();
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


        if (!validatePhoneNumber(trim($_POST['phoneNumber']))) {
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
    if (empty($_POST['newPassword']) && !empty($_POST['confirmPassword'])) {
        array_push($errorList, "Vui lòng nhập mật khẩu mới.");
    }
    if (empty($_POST['confirmPassword']) && !empty($_POST['newPassword'])) {
        array_push($errorList, "Vui lòng nhập lại mật khẩu mới.");
    }
    if (!empty($_POST['newPassword']) && !empty($_POST['confirmPassword']) && $_POST['confirmPassword'] != $_POST['newPassword']) {
        array_push($errorList, "Mật khẩu mới không trùng khớp.");
    }

    //check authentication
    if (count($errorList) == 0) {
        $email = $_POST['email'];
        $password =  $_POST['password'];
        $sqlCheck = "select * from users where email='$email' and password='$password'";
        try {
            $result = $conn->query($sqlCheck);
            $row = $result->fetch_assoc();
            $userExist = (bool)$row;
            if (!$userExist) {

                array_push($errorList, "Mật khẩu hiện tại không đúng!");
            }
        } catch (\Throwable $th) {
            array_push($errorList, "Hệ thống xảy ra lỗi!");
            echo $th;
        }
    }
    // if authentic
    if (count($errorList) == 0) {
        $id = $_POST['id'];
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phoneNumber = trim($_POST['phoneNumber']);
        $address = trim($_POST['address']);
        $avatar = $_POST['avatar'];
        $password =  trim($_POST['password']);
        $newPassword =  trim($_POST['newPassword']);

        $sqlCheck = "select * from users where ( phoneNumber='$phoneNumber' and id!='$id' ) or ( email='$email' and id!='$id' );";

        $phoneExists = false;
        try {
            $result = $conn->query($sqlCheck);
            $row = $result->fetch_assoc();
            $phoneExists = (bool)$row;
            if ($phoneExists) {
                array_push($errorList, "Số điện thoại hoặc email đã được đăng ký với tài khoản khác");
            }
        } catch (\Throwable $th) {
            array_push($errorList, "Hệ thống xảy ra lỗi!");
            echo $th;
        }
        $hasFile = false;

        if (isset($_FILES['imageFile']) && empty($_FILES['imageFile']['error']) &&  !$phoneExists) {

            $hasFile = true;
            if ($avatar != 'null') {
                $temp  = explode('/', $avatar);
                $imageId = $temp[count($temp) - 2] . '/' . explode('.', $temp[count($temp) - 1])[0];
            }
            try {
                if ($avatar != 'null') {
                    (new UploadApi())->destroy($imageId);
                }
                $file = $_FILES['imageFile'];

                $respone = (new UploadApi())->upload($file['tmp_name']);
                $avatar = $respone['secure_url'];
                $avatarId = $respone['public_id'];
                $uploadSuccess = true;
            } catch (\Throwable $th) {
                echo $th;
                $uploadSuccess = false;
            }
        }

        if (!$phoneExists && (!$hasFile || ($hasFile && $uploadSuccess))) {

            $sql = $conn->prepare("UPDATE users SET name=?, avatar=?, email=?, phoneNumber=?, address=? WHERE id=?;");
            $sql->bind_param('sssssi', $name,  $avatar, $email, $phone, $address, $id);
            if (!empty($newPassword)) {
                $sql = $conn->prepare("UPDATE users SET name=?, avatar=?, email=?, phoneNumber=?,password=?, address=? WHERE id=?;");
                $sql->bind_param('ssssssi', $name,  $avatar, $email, $phone, $newPassword, $address, $id);
            }

            try {

                if ($sql->execute() == TRUE) {

                    $_SESSION['update_user'] = true;

                    $_SESSION['logined'] = array('id' => $id, 'name' => $name, 'email' => $email, 'address' => $address, 'phoneNumber' => $phoneNumber, 'avatar' => $avatar, 'role' => $_SESSION['logined']['role']);
                }
            } catch (\Throwable $th) {
                if ($avatarId) {
                    (new UploadApi())->destroy($avatarId);
                }
                array_push($errorList, "Hệ thống xảy ra lỗi!");
                echo $th;
            }
        }
    }
    if (count($errorList) != 0) {
        $_SESSION['error_list'] = $errorList;
    }

    header("location: /pages/user.php");
} else {
    echo "Unauthenticated";
}
$conn->close();
