<?php
require_once dirname(__DIR__, 1) . '/services/connect_db.php';
session_start();
if (!isset($_SESSION['logined'])) {

    header('location: /pages/login.php');
    exit();
}

if (isset($_SESSION['logined']) && $_SESSION['logined']['role'] != 'admin') {
    unset($_SESSION['logined']);
    header('location: /pages/login.php');
    exit();
}

$sql = "select* from bills ;";
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
if (isset($_SESSION['change_status_bill'])) {
    if ($_SESSION['change_status_bill'] == true) {
        echo '<script>alert("Đổi trạng thái đơn hàng thành công!")</script>';
    } else {

        echo '<script>alert("Đổi trạng thái đơn hàng thất bại, vui lòng thử lại sau.")</script>';;
    }
    unset($_SESSION['change_status_bill']);
}
// if (isset($_SESSION['create_bill'])) {
//     if ($_SESSION['create_bill']['state'] == true) {
//         echo '<script>alert("Tạo sản phẩm thành công!")</script>';
//     } else {

//         echo '<script>alert("Tạo sản phẩm thất bại, vui lòng kiểm tra lại thông tin sản phẩm hoặc thử lại sau.")</script>';
//     }
//     unset($_SESSION['create_bill']);
// }

// if (isset($_SESSION['delete_bill'])) {
//     if ($_SESSION['delete_bill'] == true) {
//         echo '<script>alert("Xóa sản phẩm thành công!")</script>';
//     } else {

//         echo '<script>alert("Xóa sản phẩm thất bại, vui lòng thử lại sau.")</script>';
//     }
//     unset($_SESSION['delete_bill']);
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>
    <?php
    include dirname(__DIR__) . '/components/navbar.php';
    ?>
    <div class="container mt-new-page " style="min-height: 50vh;">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link " href="/pages/admin.php">Quản lý sản phẩm</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="/pages/adminUser.php">Quản lý người dùng</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/pages/adminBill.php">Quản lý hóa đơn</a>
            </li>
        </ul>
        <main class="mt-5">
            <?php
            if (isset($_SESSION['error_list'])) {
                foreach ($_SESSION['error_list']['errorList'] as &$value) {
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        $value
                       <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                     </div>";
                }
                unset($_SESSION['error_list']);
            }

            ?>

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
                    <div class='d-flex gap-2 align-items-center mb-2'>
                        <a class='fs-6  text-decoration-underline fw-bold text-black' href='/pages/billDetail.php?id=$id'  style='white-space: nowrap;'>Mã đơn hàng: $id</a>
                        <form action='/services/bills/delete.php' method='post' class='m-0 d-flex align-items-center '>
                            <input type='hidden' name='id' value='$id'/>
                          
                            <button class='border-0 bg-transparent text-danger fs-5' type='submit'> <i class='fa-solid fa-trash-can'></i></button>
                        </form> 
                        
                    </div>

                    <p class=' mb-2'>Đơn hàng được tạo lúc: <span class='fw-bold'>$createdAt</span></p>
                    <p class=' mb-2'>Người nhận: <span class='fw-bold'>$userName</span> </p>
                    <p class=' mb-2'>Số điện thoại: <span class='fw-bold'>$phoneNumber</span> </p>
                    <p class=' mb-2'>Địa chỉ giao hàng: <span class='fw-bold'>$address</span> </p>
                    <p class=' mb-2'>Trạng thái đơn hàng: </p>
                    
                    <form action='/services/bills/updateStatus.php' method='post' style='width:250px;'>
                        <select class='form-select fw-bold text-danger mb-2' name='status' onchange='enableSubmitStatus($id)'>
                            <option value='cancel'
                             ";
                    if ($status == 'cancel') echo 'selected';
                    echo "   
                            >Đã hủy</option>
                            <option value='pending'
                             ";
                    if ($status == 'pending') echo 'selected';
                    echo "   
                            >Chờ xử lý</option>
                            <option value='processing'
                             ";
                    if ($status == 'processing') echo 'selected';
                    echo "   
                            >Đang xử lý</option>
                            <option value='delivering'
                             ";
                    if ($status == 'delivering') echo 'selected';
                    echo "   
                            >Đang vận chuyển</option>
                            <option value='delivered'
                             ";
                    if ($status == 'delivered') echo 'selected';
                    echo "   
                            >Đã giao thành công</option>
                        </select>
                        <input type='hidden' name='id' value='$id'>
                        <button disabled class='btn btn-danger' type='submit' id = 'change-btn-$id'>Xác nhận</button>
                    </form>
                    <hr>
                    <p class='fs-4 mt-4 mb-2 text-end'>Tổng tiền: <span class='fw-bold text-danger'>$total</span> </p>

                    
                </li>
                ";
                }



                ?>
            </ul>

        </main>
    </div>

    <?php
    include dirname(__DIR__) . "/components/footer.php";

    ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        function enableSubmitStatus(id) {

            console.log('change-btn-' + id)
            changeButton = document.getElementById('change-btn-' + id);
            console.log(changeButton);
            changeButton.disabled = false;
        }
    </script>

</body>

</html>