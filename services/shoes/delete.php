<?php
require_once dirname(__DIR__, 1) . '\connect_db.php';
require dirname(__DIR__, 2) . '/vendor/autoload.php';

use Cloudinary\Configuration\Configuration;

Configuration::instance('cloudinary://698573158872163:pP_wRfiJ4vOcPPuJ2985ULdZXp8@dqqetbr1m?secure=true');

use Cloudinary\Api\Upload\UploadApi;

session_start();

if (!isset($_SESSION["logined"]) || (isset($_SESSION["logined"]) && $_SESSION["logined"]['role'] != "admin")) {

    header("location: /pages/login.php");
    exit('Unauthenticated');
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && !empty($_POST["id"])) {

    $shoeId = $_POST["id"];
    $imageurl = $_POST["imageurl"];
    try {
        $temp  = explode('/', $imageurl);
        $imageId = $temp[count($temp) - 2] . '/' . explode('.', $temp[count($temp) - 1])[0];
        (new UploadApi())->destroy($imageId);
    } catch (\Throwable $th) {
        echo $th;
        exit();
    }
    $sql = "delete from shoes WHERE id=$shoeId ;";
    try {

        if ($conn->query($sql) === TRUE) {
            $_SESSION["delete_shoe"] = true;
        } else {
            $_SESSION["delete_shoe"] = false;
        }
    } catch (\Throwable $th) {
        echo $th;
        exit();
    }
    header("location: /pages/admin.php");
}