<?php
require dirname(__DIR__, 1) . '\connect_db.php';

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
    session_start();
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
            } else {
                $currentUser = $row;
            }
        } catch (\Throwable $th) {
            array_push($errorList, "Hệ thống xảy ra lỗi!");
        }
    }
    // if authentic
    if (count($errorList) == 0) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phoneNumber = $_POST['phoneNumber'];
        $address = $_POST['address'];
        $password =  $_POST['password'];
        $newPassword =  $_POST['newPassword'];

        $sqlCheck = "select * from users where email='$phoneNumber' and id!='$id'";
        try {
            $result = $conn->query($sqlCheck);
            $row = $result->fetch_assoc();
            $phoneExists = (bool)$row;
            if ($phoneExists) {
                array_push($errorList, "Số điện thoại đã được đăng ký với tài khoản khác");
            }
        } catch (\Throwable $th) {
            array_push($errorList, "Hệ thống xảy ra lỗi!");
        }


        if (isset($phoneExists) && !$phoneExists) {
            $sql = "UPDATE users SET name='$name', email='$email', phoneNumber='$phoneNumber', address='$address' WHERE id='$id';";
            if (!empty($newPassword)) $sql = "UPDATE users SET name='$name', email='$email', phoneNumber='$phoneNumber', address='$address', password='$newPassword' WHERE id='$id';";
            try {

                if ($conn->query($sql) == TRUE) {

                    $_SESSION['update_user'] = true;
                    $_SESSION['logined'] = array('id' => $id, 'name' => $name, 'email' => $email, 'address' => $address, 'phoneNumber' => $phoneNumber, 'avatar' => $currentUser['avatar']);
                }
            } catch (\Throwable $th) {
                array_push($errorList, "Hệ thống xảy ra lỗi!");
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
