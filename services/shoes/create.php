<?php
require dirname(__DIR__, 1) . '\connect_db.php';
$name = "GIÀY ADIZERO ADIOS PRO 3M";
$category = "Giày chạy bộ";
$description = "ĐÔI GIÀY CHẠY BỘ ĐƯỜNG DÀI SIÊU NHẸ CÓ SỬ DỤNG CHẤT LIỆU TÁI CHẾ. Giày Adizero Adios Pro 3 là đỉnh cao của các sản phẩm Adizero Racing. Giày được thiết kế với sự tham gia của vận động viên và dành cho vận động viên nhằm làm nên kỳ tích. Đôi giày chạy bộ adidas này có khả năng tối ưu hóa hiệu quả chạy bộ. Các thanh carbon ENERGYROD tạo độ cứng siêu nhẹ cho sải bước gọn ghẽ, hiệu quả. Lớp đệm LIGHTSTRIKE PRO siêu nhẹ nâng niu từng bước chạy nhờ kết cấu hai lớp mút foam đàn hồi nhất của adidas giúp bạn giữ sức đường dài. Bên dưới là một lớp mỏng đế ngoài bằng cao su dệt cho độ bám vượt trội trong điều kiện khô ráo cũng như ẩm ướt.";
$price = 3500000;
$instock = 100;
$sold = 0;
$imageurl = "https://res.cloudinary.com/dqqetbr1m/image/upload/v1696121189/ducstore/vhcswlkqauz5jxqeah1p.png";
$imageid = "ducstore/vqcekybubd4qbcrx07yi";


$sql = "INSERT INTO shoes (name,description, category, price,sold, instock,imageurl,imageid)
VALUES ('$name','$description', '$category', '$price','$sold', '$instock', '$imageurl','$imageid');";

if ($conn->query($sql) === TRUE) {
    echo "<script>console.log('New record created successfully')</script>";
} else {
    echo "<script>console.log('Failed to create')</script>";
}

$conn->close();
