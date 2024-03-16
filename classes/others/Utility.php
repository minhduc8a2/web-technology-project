<?php

namespace Classes\Others;

require dirname(__DIR__, 2) . '/vendor/autoload.php';

use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

class Utility
{
    public static function moneyFormat($x)
    {
        return str_replace(',', '.', strval(number_format($x)));
    }
    public static function renderView(string $view, array $data = [])
    {
        $path = dirname(__DIR__, 2) . '/views/' . "{$view}.php";
        extract($data);
        require($path);
    }
    public static function validatePhoneNumber($phone)
    {
        if (preg_match('/^[0-9]*$/', $phone)) {
            return  true;
        } else {
            return  false;
        }
    }

    public static function validateEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }
    public static function createErrorMessageForCreateUser(array &$errorList)
    {
        if (empty($_POST['name'])) {
            array_push($errorList, "Vui lòng nhập họ tên.");
        }
        if (empty($_POST['email'])) {
            array_push($errorList, "Vui lòng nhập email.");
        } else {

            if (!Utility::validateEmail($_POST['email'])) {
                array_push($errorList, "Vui lòng nhập đúng định dạng email.");
            }
        }
        if (empty($_POST['phoneNumber'])) {
            array_push($errorList, "Vui lòng nhập số điện thoại.");
        } else {
            if (!Utility::validatePhoneNumber(trim($_POST['phoneNumber']))) {
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
    }

    public static function createErrorMessageForCreateShoe(array &$errorList, $haveImage = true)
    {
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

        if (isset($_FILES['imageFile']) && $_FILES['imageFile']['error'] != 0 && $haveImage) {

            array_push($errorList, "Vui lòng chọn ảnh sản phẩm");
        }
    }

    public static function uploadImage($file,)
    {
        Configuration::instance('cloudinary://698573158872163:pP_wRfiJ4vOcPPuJ2985ULdZXp8@dqqetbr1m?secure=true');
        try {

            $respone = (new UploadApi())->upload($file['tmp_name']);
            $imageurl = $respone['secure_url'];
            $imageId = $respone['public_id'];
            return ['imageurl' => $imageurl, 'imageId' => $imageId];
        } catch (\Throwable $th) {
            return false;
        }
    }
    public static function deleteImageOnCloudinary($id)
    {
        try {
            (new UploadApi())->destroy($id);
        } catch (\Throwable $th) {
            return false;
        }
        return true;
    }
    public static function deleteImageOnCloudinaryByURL($imageurl)
    {
        if (isset($imageurl) && !empty($imageurl)) {
            try {
                $temp  = explode('/', $imageurl);
                $imageId = $temp[count($temp) - 2] . '/' . explode('.', $temp[count($temp) - 1])[0];
                Utility::deleteImageOnCloudinary($imageId);
            } catch (\Throwable $th) {
                return false;
            }
            return true;
        }
        return false;
    }
}
