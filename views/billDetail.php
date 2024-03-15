<?php

use Classes\Others\Utility as Utility;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>
    <?php
    include dirname(__DIR__) . '/components/navbar.php';
    ?>
    <div class="container mt-new-page p-4 pt-5 shadow rounded-2">


        <h2 class="text-center">Chi tiết đơn hàng</h2>

        <div class="info mt-new-section   ">

            <?php
            if (isset($_SESSION['cancel_bill'])) {
                if ($_SESSION['cancel_bill'] == true) {
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            Đã hủy hóa đơn
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
                } else {
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        Có lỗi xảy ra, vui lòng thử lại sau!
       <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
     </div>";
                }
                $_SESSION['cancel_bill'] = null;
            }


            $id = $bill->id;
            $userName = $bill->userName;
            $phoneNumber = $bill->phoneNumber;
            $address = $bill->address;
            $createdAt = $bill->createdAt;
            $status = $bill->status;
            echo "
            <div class='d-flex align-items-center gap-2'>
                <p class='fs-6 mb-0  fw-bold text-black '   >Mã đơn hàng: $id</p>";
            if ($status == "pending") {
                echo "<form action='/billDetail.php?id={$id}' method='post' class='m-0'>
                <input type='hidden' name='id' value='$id'>
                <input type='hidden' name='cancelBill' value='true'>
                <button class='border-0 bg-transparent text-decoration-underline text-danger' type='submit' >Hủy đơn hàng</button>
            </form>";
            }

            echo "
            </div>
            <p class=' mb-1' style='font-size:18px'>Đơn hàng được tạo lúc: <span class='fw-bold'>$createdAt</span></p>
                    <p class=' mb-1' style='font-size:18px'>Người nhận: <span class='fw-bold'>$userName</span> </p>
                    <p class=' mb-1' style='font-size:18px'>Số điện thoại: <span class='fw-bold'>$phoneNumber</span> </p>
                    <p class=' mb-1' style='font-size:18px'>Địa chỉ giao hàng: <span class='fw-bold'>$address</span> </p>
                    <p class=' mb-1' style='font-size:18px'>Trạng thái đơn hàng: <span class='fw-bold text-danger'>$status</span> </p>";
            ?>
        </div>
        <hr>
        <ul class="mt-2 p-0 ">
            <?php
            $total = 0;


            $length = count($mixList);
            for ($i = 0; $i < $length; $i++) {
                $row = $mixList[$i];
                $shoeName = $row['shoe']->name;

                $imageurl = $row['shoe']->imageurl;
                $price = $row['shoe']->getFormatPrice();
                $quantity = $row['quantity'];
                $total += $row['shoe']->price * $quantity;
                echo "<li class='mt-2'>
                            <div class='cart-item bg-white d-flex flex-lg-row flex-column justify-content-between gap-2  p-4 '>
                                <div class='d-flex align-items-center gap-3'>
                                    <img src='$imageurl' alt='image' style='max-width: 100px; width: 100%;' class='rounded-4'>
                                    <div class='description'>
                                        <h5>$shoeName</h5>
                                        <h6 class='text-danger'>$price <span class='text-decoration-underline'>đ</span></h6>
                                    </div>
                                </div>
                                <div class='d-flex align-items-center'>
                                   <p class='fs-6 m-0 px-2'>Số lượng: <span class='fw-bold'>$quantity</span></p>
                                </div>
                            </div>
                        </li>";
            }
            $total = Utility::moneyFormat($total);

            ?>
        </ul>
        <hr>


        <div class="mt-4  ">
            <p class=" fs-4 fw-bold  text-end"><span>Tổng cộng: </span> <span class="text-danger"><?= $total ?></span> <span class="text-decoration-underline text-danger">đ</span></p>

        </div>

    </div>

    <?php
    include dirname(__DIR__) . "/components/footer.php";
    $conn->close();
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>

    </script>
</body>

</html>