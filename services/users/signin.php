<?php
require dirname(__DIR__, 1) . '\connect_db.php';





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
    $signinFormState = array();

    if (empty($_POST['email'])) {
        array_push($errorList, "Vui lòng nhập email.");
    } else {

        $signinFormState['email'] = $_POST['email'];

        if (!validateEmail($_POST['email'])) {
            array_push($errorList, "Vui lòng nhập đúng định dạng email.");
        }
    }


    if (empty($_POST['password'])) {
        array_push($errorList, "Vui lòng nhập mật khẩu.");
    }



    if (count($errorList) == 0) {

        $email = $_POST['email'];
        $password =  $_POST['password'];

        $sqlCheck = "select * from users where email='$email' and password='$password'";
        try {
            $result = $conn->query($sqlCheck);
            $row = $result->fetch_assoc();
            $userExists = (bool)$row;
            if (!$userExists) {
                array_push($errorList, "Thông tin đăng nhập không chính xác.");
            } else {
                $_SESSION['logined'] = array('id' => $row['id'], 'name' => $row['name'], 'email' => $row['email'], 'address' => $row['address'], 'phoneNumber' => $row['phoneNumber'], 'avatar' => $row['avatar']);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    if (count($errorList) != 0) {
        $_SESSION['error_list'] = $errorList;
        $_SESSION['sign_in_form_state'] = $signinFormState;
    }
    if (isset($_SESSION['logined'])) {
        header("location: /");
    } else header('location: /pages/login.php');
} else {
    echo "Unauthenticated";
}


$conn->close();
