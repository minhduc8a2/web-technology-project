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
                <a class="nav-link " href="/admin.php">Quản lý sản phẩm</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="/adminUser.php">Quản lý người dùng</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/adminBill.php">Quản lý hóa đơn</a>
            </li>
        </ul>
        <main class="mt-5">
            <?php
            include dirname(__DIR__) . '/components/errorList.php';
            include dirname(__DIR__) . '/components/message.php';
            if (isset($_SESSION['change_status_bill'])) {
                if ($_SESSION['change_status_bill'] == true) {
                    showMessage("Đổi trạng thái đơn hàng thành công!");
                } else {

                    showMessage("Đổi trạng thái đơn hàng thất bại, vui lòng thử lại sau.",'danger');;
                }
                unset($_SESSION['change_status_bill']);
            }
            ?>


            <ul class="mt-5 p-0 ">
                <?php


                foreach ($billList as &$row) {
                    $id = $row->id;
                    $userName = $row->userName;
                    $phoneNumber = $row->phoneNumber;
                    $address = $row->address;
                    $createdAt = $row->createdAt;
                    $status = $row->status;
                    $total = $row->getFormatTotal();
                    echo "
                <li class='p-4 shadow rounded-2 mt-4'>
                    <div class='d-flex gap-2 align-items-center mb-2'>
                        <a class='fs-6  text-decoration-underline fw-bold text-black' href='/billDetail.php?id=$id'  style='white-space: nowrap;'>Mã đơn hàng: $id</a>
                        <form action='/adminBill.php' method='post' class='m-0 d-flex align-items-center '>
                            <input type='hidden' name='id' value='$id'/>
                            <input type='hidden' name='delete' />
                          
                            <button class='border-0 bg-transparent text-danger fs-5' type='submit' id='del-btn'> <i class='fa-solid fa-trash-can'></i></button>
                        </form> 
                        
                    </div>

                    <p class=' mb-2'>Đơn hàng được tạo lúc: <span class='fw-bold'>$createdAt</span></p>
                    <p class=' mb-2'>Người nhận: <span class='fw-bold'>$userName</span> </p>
                    <p class=' mb-2'>Số điện thoại: <span class='fw-bold'>$phoneNumber</span> </p>
                    <p class=' mb-2'>Địa chỉ giao hàng: <span class='fw-bold'>$address</span> </p>
                    <p class=' mb-2'>Trạng thái đơn hàng: </p>
                    
                    <form action='/adminBill.php' method='post' style='width:250px;'>
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
            <div class=" mt-5 d-flex justify-content-center align-items-center">
                <ul class=" pagination ">
                    <li class="page-item<?= $paginator->getPrevPage() ?
                                            '' : ' disabled' ?>">
                        <a role="button" href="/adminBill.php?page=<?= $paginator->getPrevPage() ?>&limit=12" class="page-link">
                            <span>&laquo;</span>
                        </a>
                    </li>
                    <?php foreach ($pages as $page) : ?>
                        <li class="page-item<?= $paginator->currentPage === $page ?
                                                ' active' : '' ?>"><a role="button" href="/adminBill.php?page=<?= $page ?>&limit=12" class="page-link"><?= $page ?></a>
                        </li>
                    <?php endforeach ?>
                    <li class="page-item<?= $paginator->getNextPage() ?
                                            '' : ' disabled' ?>">
                        <a role="button" href="/adminBill.php?page=<?= $paginator->getNextPage() ?>&limit=12" class="page-link">
                            <span>&raquo;</span>
                        </a>
                    </li>
                </ul>
            </div>
        </main>
    </div>

    <?php
    include dirname(__DIR__) . "/components/footer.php";

    ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        const delBtn = $('#del-btn');
        delBtn.on('click', function(e) {
            e.preventDefault();
            if (confirm('Bạn có chắc là muốn xóa hóa đơn này?')) {
                delBtn.parent().submit();
            }
        })
    </script>
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