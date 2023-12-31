<?php
require_once dirname(__DIR__, 1) . '\services\connect_db.php';
session_start();
if (!isset($_SESSION['logined'])) {

    header('location: /pages/login.php');
}

$userId = $_SESSION['logined']['id'];
//get billlist
$sql = "select* from bills where userId=$userId;";
$billList = [];
try {
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            array_push($billList, $row);
        }
    }
} catch (\Throwable $th) {
    echo 'Error with server.';
    exit();
}
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
    include dirname(__DIR__) . '\components\navbar.php';
    ?>
    <div class="container mt-new-page p-4 pt-5 shadow rounded-2">


        <h2 class="text-center">Danh sách đơn hàng</h2>

        <ul class="mt-5 p-0 ">
            <?php

            function moneyFormat($x)
            {
                return str_replace(',', '.', strval(number_format($x)));
            }

            foreach ($billList as &$row) {
                $id = $row['id'];
                $userName = $row['userName'];
                $phoneNumber = $row['phoneNumber'];
                $address = $row['address'];
                $createdAt = $row['createdAt'];
                $status = $row['status'];
                $total = moneyFormat($row['total']);
                echo "
                <li class='p-4 shadow rounded-2 mt-4'>
                    <a class='fs-6 mb-2 text-decoration-underline fw-bold text-black' href='/pages/billDetail.php?id=$id'  style='white-space: nowrap;'>Mã đơn hàng: $id</a>

                    <p class=' mb-2'>Đơn hàng được tạo lúc: <span class='fw-bold'>$createdAt</span></p>
                    <p class=' mb-2'>Người nhận: <span class='fw-bold'>$userName</span> </p>
                    <p class=' mb-2'>Số điện thoại: <span class='fw-bold'>$phoneNumber</span> </p>
                    <p class=' mb-2'>Địa chỉ giao hàng: <span class='fw-bold'>$address</span> </p>
                    <p class=' mb-2'>Trạng thái đơn hàng: <span class='fw-bold text-danger'>$status</span> </p>
                    <hr>
                    <p class='fs-4 mt-4 mb-2 text-end'>Tổng tiền: <span class='fw-bold text-danger'>$total</span> </p>

                    
                </li>
                ";
            }



            ?>
        </ul>


    </div>

    <?php
    include dirname(__DIR__) . "\components\\footer.php";
    $conn->close();
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>