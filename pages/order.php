<?php
require_once dirname(__DIR__, 1) . '\services\connect_db.php';
session_start();
if (!isset($_SESSION['logined'])) {

    header('location: /pages/login.php');
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['shoeList'])) {
    $shoeListId = $_POST['shoeList'];
    $shoeList = [];
    $userId = $_SESSION['logined']['id'];


    $sql = "select shoes.name as name,shoes.id as id, price, imageurl, quantity from shoes, cartItems where shoes.id=shoeId and userId='$userId' and (shoes.id = " . $shoeListId[0];
    for ($i = 1; $i < count($shoeListId); $i++) {
        $sql = $sql . " OR shoes.id = " . $shoeListId[$i];
    }
    $sql = $sql . ");";

    try {
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                array_push($shoeList, $row);
            }
        }
    } catch (\Throwable $th) {
        echo 'Error with server.';
    }

    $_SESSION['shoeList'] = $shoeList;
    exit();
}


if (!isset($_SESSION['shoeList']) && !isset($_SESSION['create_bill'])) {
    header("location: /pages/cart.php");
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
    <div class="container mt-new-page">

        <div class="row gx-lg-5 gy-5 mt-new-section">
            <div class="col-12 col-lg-8">
                <h2>Thông tin đơn hàng</h2>
                <?php
                if (isset($_SESSION['create_bill'])) {
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        Tạo đơn hàng thất bại!
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                     </div>";
                    unset($_SESSION['create_bill']);
                }
                ?>
                <div class="info mt-5 shadow p-4 rounded-3">
                    <?php
                    $userName = $_SESSION['logined']['name'];
                    $phoneNumber = $_SESSION['logined']['phoneNumber'];
                    $address = $_SESSION['logined']['address'];
                    echo "<p class='fs-5 mb-2'>Đơn hàng sẽ được vận chuyển đến:</p>
                    <p class='fs-5 mb-2'>Người nhận: <span class='fw-bold'>$userName</span> </p>
                    <p class='fs-5 mb-2'>Số điện thoại: <span class='fw-bold'>$phoneNumber</span> </p>
                    <p class='fs-5 mb-2'>Địa chỉ giao hàng: <span class='fw-bold'>$address</span> </p>
                    <p class='fs-5 mb-2'>Phương thức thanh toán: <span class='fw-bold'>Thanh toán khi nhận hàng</span> </p>";
                    ?>
                </div>
                <ul class="mt-5 p-0 ">
                    <?php
                    $total = 0;
                    function moneyFormat($x)
                    {
                        return str_replace(',', '.', strval(number_format($x)));
                    }
                    $shoeList = $_SESSION['shoeList'];
                    foreach ($shoeList as &$row) {
                        $shoeName = $row['name'];
                        $id = $row['id'];
                        $imageurl = $row['imageurl'];
                        $price = moneyFormat($row['price']);
                        $quantity = $row['quantity'];
                        $total += $row['price'] * $quantity;
                        echo "<li class='mt-2'>
                            <div class='cart-item bg-white d-flex flex-lg-row flex-column justify-content-between gap-2 shadow p-4 rounded-2'>
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
                    $_SESSION['order_total'] = $total;
                    $total = moneyFormat($total);

                    ?>
                </ul>
            </div>
            <div class="col-12 col-lg-4">
                <h2>Thông tin thanh toán</h2>
                <div class="mt-5 p-5 shadow">
                    <p class=" fs-4 fw-bold  "><span>Tổng cộng: </span> <span class="text-danger"><?= $total ?></span> <span class="text-decoration-underline text-danger">đ</span></p>
                    <button class="btn btn-primary px-4 py-2 fs-5 rounded-3 mt-4 shadow" onclick="createBill()">Đặt hàng</button>
                </div>
            </div>
        </div>
    </div>
    <?php
    include dirname(__DIR__) . "\components\\footer.php";
    $conn->close();
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function createBill() {
            location.href = "/services/bills/create.php"
        }
    </script>
</body>

</html>