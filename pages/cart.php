<?php
require_once dirname(__DIR__, 1) . '\services\connect_db.php';
session_start();
if (!isset($_SESSION['logined'])) {

    header('location: /pages/login.php');
}

if (isset($_SESSION["update_quantity"])) {
    if ($_SESSION["update_quantity"] == true) {
        echo "<script>alert('Cập nhật số lượng thành công')</script>";
    } else  echo "<script>alert('Cập nhật số lượng thất bại, vui lòng thử lại sau!')</script>";
    $_SESSION["update_quantity"] = null;
}
if (isset($_SESSION["delete_shoe"])) {
    if ($_SESSION["delete_shoe"] == true) {
        echo "<script>alert('Xóa sản phẩm thành công!')</script>";
    } else  echo "<script>alert('Xóa sản phẩm thất bại, vui lòng thử lại sau!')</script>";
    $_SESSION["delete_shoe"] = null;
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
        <h1 class="text-center">Giỏ hàng</h1>
        <div class="row gx-lg-5 gy-5 mt-new-section">
            <div class="col-12 col-lg-8">
                <h2>Danh sách sản phẩm</h2>
                <ul class="mt-5 p-0 ">
                    <?php
                    $total = 0;
                    $userId = 1;

                    $sql = "SELECT shoes.name as name,shoes.id as id, price, imageurl, instock,quantity  FROM shoes, cartItems
                    where shoes.id=shoeId and userId='$userId'
                    ;";
                    $result = $conn->query($sql);
                    function moneyFormat($x)
                    {
                        return str_replace(',', '.', strval(number_format($x)));
                    }

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $shoeName = $row['name'];
                            $id = $row['id'];
                            $imageurl = $row['imageurl'];
                            $price = moneyFormat($row['price']);
                            $instock = $row['instock'];
                            $quantity = $row['quantity'];
                            $total += $row['price'] * $quantity;
                            echo "<li class='mt-2'>
                            <div class='cart-item bg-white d-flex flex-lg-row flex-column justify-content-between gap-2 shadow p-4 rounded-2'>
                                <div class='d-flex align-items-center gap-3'>
                                    <img src='https://res.cloudinary.com/dqqetbr1m/image/upload/v1696121189/ducstore/vhcswlkqauz5jxqeah1p.png' alt='image' style='max-width: 100px; width: 100%;' class='rounded-4'>
                                    <div class='description'>
                                        <h5>$shoeName</h5>
                                        <h6 class='text-danger'>$price <span class='text-decoration-underline'>đ</span></h6>
                                    </div>
                                </div>
                                <div class='d-flex align-items-center'>
                                    <div class='update-quantity d-flex gap-2' style='height: fit-content;'>
                                    <form action='/services/cartItems/updateQuantity.php' method='post' class='d-flex gap-2 align-items-center m-0'>
                                        
                                        <input type='number' name='quantity' max=$instock min=1 value=$quantity class='p-2'>
                                        <input type='hidden' name='id' value='$id'/>
                                        <button class='btn btn-danger' type='submit'>Cập nhật</button>
                                    </form>
                                     <form action='/services/cartItems/delete.php' method='post' class='m-0 d-flex align-items-center'>
                                        <input type='hidden' name='id' value='$id'/>
                                        <button class='border-0 bg-transparent text-danger fs-5' type='submit'><i class='fa-solid fa-trash-can'></i></button>
                                     </form>   
                                        
                                    </div>
                                </div>
                            </div>
                        </li>";
                        }
                        $total = moneyFormat($total);
                    }

                    ?>
                </ul>
            </div>
            <div class="col-12 col-lg-4">
                <h2>Thông tin thanh toán</h2>
                <div class="mt-5 p-5 shadow">
                    <p class=" fs-4 fw-bold  "><span>Tổng cộng: </span> <span class="text-danger"><?= $total ?></span> <span class="text-decoration-underline text-danger">đ</span></p>
                    <button class="btn btn-primary px-4 py-2 fs-5 rounded-3 mt-4 shadow">Mua hàng</button>
                </div>

            </div>
        </div>
    </div>
    <?php
    include dirname(__DIR__) . "\components\\footer.php";
    $conn->close();
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>