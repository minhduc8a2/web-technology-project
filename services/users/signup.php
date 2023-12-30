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

        $sqlCheck = "select * from users where phoneNumber='$phoneNumber'";
        try {
            $result = $conn->query($sqlCheck);
            $row = $result->fetch_assoc();
            $phoneExists = (bool)$row;
            if ($phoneExists) {
                array_push($errorList, "Số điện thoại đã được đăng ký");
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        if (isset($phoneExists) && !$phoneExists) {
            $sql = "INSERT INTO users (name,email,phoneNumber,address,password) 
            VALUES ('$name','$email','$phoneNumber', '$address','$password');";

            if ($conn->query($sql) === TRUE) {

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
