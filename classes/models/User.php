<?php

namespace Classes\Models;

require dirname(__DIR__, 2) . '/vendor/autoload.php';

use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

use Classes\Models\DatabaseConnector as DatabaseConnector;
use Classes\Others\Utility as Utility;
use \PDO;

class User
{
    public  $id;
    public $name;
    public $email;
    public $phoneNumber;
    public $address;
    public $avatar;
    public $role;
    public $password;

    function __construct($row)
    {
        $this->id = isset($row['id']) ? intval($row['id']) : '';
        $this->name = isset($row['name']) ? htmlspecialchars(trim($row['name'])) : '';
        $this->email = isset($row['email']) ? htmlspecialchars(trim($row['email'])) : '';
        $this->phoneNumber = isset($row['phoneNumber']) ? htmlspecialchars(trim($row['phoneNumber'])) : '';
        $this->address = isset($row['address']) ? htmlspecialchars(trim($row['address'])) : '';
        $this->avatar = isset($row['avatar']) ? htmlspecialchars(trim($row['avatar'])) : '';
        $this->role = isset($row['role']) ? htmlspecialchars(trim($row['role'])) : '';
        $this->password = isset($row['password']) ? htmlspecialchars(trim($row['password'])) : '';
    }

    public static function getAll(int|bool $limit = false, int|bool $offset = false)
    {
        $database = new DatabaseConnector();
        $sql = $database->getQuery('select* from users', false, [], $limit, $offset);
        $tempList = [];
        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            array_push($tempList, new User($row));
        }
        return $tempList;
    }
    public static function getCount(string|false $where = false, array $whereParams = [])
    {
        $database = new DatabaseConnector();
        $sql = $database->getQuery('SELECT COUNT(*) as count from users', $where, $whereParams);
        if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            return $row['count'];
        } else return 0;
    }
    public static function deleteOne(int $id)
    {
        $database = new DatabaseConnector();
        return $database->deleteOne('users', $id);
    }
    public static function checkExist(string|false $where = false, array $whereParams = [])
    {
        return User::getCount($where, $whereParams) != 0;
    }

    public static function create(User $user, bool $haveAvatar)
    {
        $database = new DatabaseConnector();
        if (!$haveAvatar) {
            $sql = $database->queryNotExecuted('INSERT INTO users (name,email,phoneNumber,address,password,role) 
            VALUES (?,?,?,?,?,?);', [$user->name, $user->email, $user->phoneNumber, $user->address, $user->password, $user->role]);
        } else {
            $sql = $database->queryNotExecuted('INSERT INTO users (name,email,phoneNumber,address,password,role,avatar) 
            VALUES (?,?,?,?,?,?,?);', [$user->name, $user->email, $user->phoneNumber, $user->address, $user->password, $user->role, $user->avatar]);
        }

        return $sql->execute();
    }
    public static function update(User $user)
    {
        $database = new DatabaseConnector();

        $sql = $database->queryNotExecuted("UPDATE users SET name=?,role=?, email=?, phoneNumber=?, avatar=?,  address=?, password=? WHERE id=? ;", [$user->name, $user->role, $user->email, $user->phoneNumber, $user->avatar, $user->address, $user->password, $user->id]);
        return $sql->execute();
    }
    public static function signUp()
    {

        Configuration::instance('cloudinary://698573158872163:pP_wRfiJ4vOcPPuJ2985ULdZXp8@dqqetbr1m?secure=true');
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

                if (!Utility::validateEmail($_POST['email'])) {
                    array_push($errorList, "Vui lòng nhập đúng định dạng email.");
                }
            }
            if (empty($_POST['phoneNumber'])) {
                array_push($errorList, "Vui lòng nhập số điện thoại.");
            } else {

                $signupFormState['phoneNumber'] = $_POST['phoneNumber'];


                if (!Utility::validatePhoneNumber($_POST['phoneNumber'])) {
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
                $database = new DatabaseConnector();

                $name = $_POST['name'];
                $email = $_POST['email'];
                $phoneNumber = $_POST['phoneNumber'];
                $address = $_POST['address'];
                $password =  $_POST['password'];

                try {
                    $sql = $database->queryExecuted("select * from users where phoneNumber= ? or email= ? ;", [$phoneNumber, $email]);
                    $row = $sql->fetch(PDO::FETCH_ASSOC);
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


                    $sql = $database->queryExecuted("INSERT INTO users (name,email,phoneNumber,address,password) 
                    VALUES (?,?,?,?,?);", [$name, $email, $phoneNumber, $address, $password]);
                    if (isset($avatar) && !empty($avatar)) {
                        $sql = $database->queryExecuted("INSERT INTO users (name,email,phoneNumber,address,password,avatar) 
                        VALUES (?,?,?,?,?,?);", [$name, $email, $phoneNumber, $address, $password, $avatar]);
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
        }
    }
    public static function login()
    {
        $database = new DatabaseConnector();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $errorList = array();
            $signinFormState = array();

            if (empty($_POST['email'])) {
                array_push($errorList, "Vui lòng nhập email.");
            } else {

                $signinFormState['email'] = $_POST['email'];

                if (!Utility::validateEmail($_POST['email'])) {
                    array_push($errorList, "Vui lòng nhập đúng định dạng email.");
                }
            }


            if (empty($_POST['password'])) {
                array_push($errorList, "Vui lòng nhập mật khẩu.");
            }



            if (count($errorList) == 0) {

                $email = $_POST['email'];
                $password =  $_POST['password'];


                try {
                    $sql = $database->queryExecuted("select * from users where email= ? and password= ? ", [$email, $password]);
                    $row = $sql->fetch(PDO::FETCH_ASSOC);
                    $userExists = (bool)$row;
                    if (!$userExists) {
                        array_push($errorList, "Thông tin đăng nhập không chính xác.");
                    } else {
                        $_SESSION['logined'] = new User($row);
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
            }
        }
    }
    public static function updateUserForUser()
    {
        $database = new DatabaseConnector();
        Configuration::instance('cloudinary://698573158872163:pP_wRfiJ4vOcPPuJ2985ULdZXp8@dqqetbr1m?secure=true');
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

                if (!Utility::validateEmail($_POST['email'])) {
                    array_push($errorList, "Vui lòng nhập đúng định dạng email.");
                }
            }
            if (empty($_POST['phoneNumber'])) {
                array_push($errorList, "Vui lòng nhập số điện thoại.");
            } else {

                $signupFormState['phoneNumber'] = $_POST['phoneNumber'];


                if (!Utility::validatePhoneNumber(trim($_POST['phoneNumber']))) {
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
                $sql = $database->queryExecuted("select * from users where email= ? and password= ?", [$email, $password]);
                try {
                    $row = $sql->fetch(pDO::FETCH_ASSOC);
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

                $sqlCheck = $database->queryExecuted("select * from users where ( phoneNumber= ? and id!= ? ) or ( email= ? and id!= ? );", [$phoneNumber, $id, $email, $id]);

                $phoneExists = false;
                try {
                    $row = $sql->fetch(pDO::FETCH_ASSOC);
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

                    $sql = $database->queryNotExecuted("UPDATE users SET name=?, avatar=?, email=?, phoneNumber=?, address=? WHERE id=?;", [$name,  $avatar, $email, $phoneNumber, $address, $id]);
                    if (!empty($newPassword)) {
                        $sql =  $database->queryNotExecuted("UPDATE users SET name=?, avatar=?, email=?, phoneNumber=?,password=?, address=? WHERE id=?;", [$name,  $avatar, $email, $phoneNumber, $newPassword, $address, $id]);
                    }

                    try {

                        if ($sql->execute() == TRUE) {

                            $_SESSION['update_user'] = true;

                            $_SESSION['logined'] = new User(array('id' => $id, 'name' => $name, 'email' => $email, 'address' => $address, 'phoneNumber' => $phoneNumber, 'avatar' => $avatar, 'role' => $_SESSION['logined']->role));
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
        }
    }
    public static function logout()
    {

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logOut"])) {
            $_SESSION['logined'] = null;
        }
    }
}
