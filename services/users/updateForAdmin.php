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
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {

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
    if (empty($_POST['password'])) {
        array_push($errorList, "Vui lòng nhập mật khẩu.");
    }



    // if authentic
    if (count($errorList) == 0) {
        $id = $_POST['id'];
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phoneNumber = trim($_POST['phoneNumber']);
        $address = trim($_POST['address']);
        $password =  trim($_POST['password']);
        $avatar = trim($_POST['avatar']);

        $sqlCheck = "select * from users where ( phoneNumber='$phoneNumber' and id!='$id' ) or ( email='$email' and id!='$id' );";
        try {
            $result = $conn->query($sqlCheck);
            $row = $result->fetch_assoc();
            $phoneExists = (bool)$row;
            if ($phoneExists) {
                array_push($errorList, "Số điện thoại hoặc email đã được đăng ký với tài khoản khác");
            }
        } catch (\Throwable $th) {
            echo $th;
            exit();
        }
        if (isset($_FILES['imageFile']) && empty($_FILES['imageFile']['error'])) {
            if ($avatar != 'null') {
                $temp  = explode('/', $avatar);
                $imageId = $temp[count($temp) - 2] . '/' . explode('.', $temp[count($temp) - 1])[0];
            }
            try {
                if ($avatar != 'null') {
                    echo 'hehe';
                    (new UploadApi())->destroy($imageId);
                }
                $file = $_FILES['imageFile'];

                $respone = (new UploadApi())->upload($file['tmp_name']);
                $avatar = $respone['secure_url'];
                $avatarId = $respone['public_id'];
            } catch (\Throwable $th) {
                echo $th;
                exit();
            }
        }

        if (isset($phoneExists) && !$phoneExists) {
            $sql = "UPDATE users SET name='$name', email='$email', phoneNumber='$phoneNumber', avatar='$avatar',  address='$address', password='$password' WHERE id='$id' ;";

            try {

                if ($conn->query($sql) == TRUE) {

                    $_SESSION['update_user'] = array('id' => $id, 'state' => true);
                }
            } catch (\Throwable $th) {
                echo $th;
                (new UploadApi())->destroy($avatarId);
                exit();
            }
        }
    }
    if (count($errorList) != 0) {
        $_SESSION['error_list'] = $errorList;
    }

    header("location: /pages/adminUser.php");
} else {
    echo "Unauthenticated";
}






$conn->close();