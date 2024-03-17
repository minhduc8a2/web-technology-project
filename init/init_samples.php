<?php
try {
    $sql = $database->queryNotExecuted("INSERT INTO `users` ( `name`, `email`, `phoneNumber`, `address`, `password`, `role`) VALUES ( 'admin', 'admin@gmail.com', '0939999999', 'Cần Thơ', '12345678', 'admin') ;");

    if ($sql->execute() === TRUE) {

        echo "<br>Admin account created!";
    } else echo "<br>failed to insert admin";
} catch (\Throwable $th) {
    echo $th;
}
try {
    $sql = $database->queryNotExecuted("INSERT INTO `shoes` (`id`, `name`, `category`, `description`, `updatedAt`, `price`, `instock`, `sold`, `imageurl`) VALUES (NULL, 'GIÀY TRAE UNLIMITED', 'Bóng rổ', 'ĐÔI GIÀY TRAINER BÓNG RỔ TRAE YOUNG CHO ĐỘ BÁM MƯỢT MÀ. Trae Young có lối chơi của riêng mình. Đôi giày bóng rổ adidas signature của anh có thiết kế cổ thấp và đế giữa Bounce linh hoạt theo mọi chuyển động của bạn. 3 Sọc classic nay khoác lên mình thiết kế răng cưa sần, chạy từ mũi giày đến phần giữa bàn chân. Đế ngoài bằng cao su với các vùng bám hai bên tạo độ ma sát khi bạn đổi hướng hoặc bứt tốc về phía rổ.', '2024-03-17 08:33:55', '2300000', '998', '2', 'https://res.cloudinary.com/dqqetbr1m/image/upload/v1710598438/adidas_php/u7ngfy7hf0g4oazorz52.avif'), (NULL, 'GIÀY ADIZERO ADIOS PRO 3M', 'Giày chạy bộ', 'ĐÔI GIÀY CHẠY BỘ ĐƯỜNG DÀI SIÊU NHẸ CÓ SỬ DỤNG CHẤT LIỆU TÁI CHẾ. Giày Adizero Adios Pro 3 là đỉnh cao của các sản phẩm Adizero Racing. Giày được thiết kế với sự tham gia của vận động viên và dành cho vận động viên nhằm làm nên kỳ tích. Đôi giày chạy bộ adidas này có khả năng tối ưu hóa hiệu quả chạy bộ. Các thanh carbon ENERGYROD tạo độ cứng siêu nhẹ cho sải bước gọn ghẽ, hiệu quả. Lớp đệm LIGHTSTRIKE PRO siêu nhẹ nâng niu từng bước chạy nhờ kết cấu hai lớp mút foam đàn hồi nhất của adidas giúp bạn giữ sức đường dài. Bên dưới là một lớp mỏng đế ngoài bằng cao su dệt cho độ bám vượt trội trong điều kiện khô ráo cũng như ẩm ướt.', '2024-03-17 08:30:05', '6500000', '999', '1', 'https://res.cloudinary.com/dqqetbr1m/image/upload/v1710598535/adidas_php/o3v1drfhigpzay1hdmmf.avif'), (NULL, 'GIÀY FORUM LOW CL THE GRINCH', 'Nữ • Originals', 'ĐÔI GIÀY SNEAKER ĐẬM CHẤT CINDY LOU WHO VỚI PHONG CÁCH LỄ HỘI. Lấy cảm hứng từ The Grinch, đôi giày adidas Forum này sẽ chiếm trọn spotlight ở bất kỳ nơi đâu. Chất liệu da lộn xù cao cấp và những gam màu đậm chất Cindy Lou gợi nhớ câu chuyện Giáng sinh quen thuộc của Dr. Seuss, và các chi tiết trang trí dây giày cho phép bạn biến hóa phong cách. Các chi tiết trang trí này khi tháo ra sẽ hé lộ dây giày bản rộng classic cho phong cách tối giản. Bất kể bạn chọn kiểu nào, các chi tiết đặc trưng của giày Forum và đế cupsole bằng cao su sẽ mang đến cảm giác thoải mái và nâng đỡ khi bạn khám phá Whoville hay thư giãn tại nhà.', '2024-03-16 21:17:00', '3300000', '1000', '0', 'https://res.cloudinary.com/dqqetbr1m/image/upload/v1710598635/adidas_php/vfktln4ku0qopyzdylkt.avif');");

    if ($sql->execute() === TRUE) {

        echo "<br>shoe samples created!";
    } else echo "<br>failed to insert shoe samples";
} catch (\Throwable $th) {
    echo $th;
}
