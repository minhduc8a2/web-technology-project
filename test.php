<?php
require __DIR__ . '/vendor/autoload.php';

use Cloudinary\Configuration\Configuration;

Configuration::instance('cloudinary://698573158872163:pP_wRfiJ4vOcPPuJ2985ULdZXp8@dqqetbr1m?secure=true');

use Cloudinary\Api\Upload\UploadApi;

$respone = (new UploadApi())->upload('logo.png');
echo $respone['public_id'];
