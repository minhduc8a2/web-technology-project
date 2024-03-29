<?php
require dirname(__DIR__, 1) . '/vendor/autoload.php';
include dirname(__DIR__) . '/components/message.php';

use Classes\Others\Utility as Utility;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>
    <?php
    include dirname(__DIR__) . '/components/navbar.php';
    ?>
    <div class="container mt-new-page">
        <h1 class="text-center">Giỏ hàng</h1>
        <div class="row gx-lg-5 gy-5 mt-new-section">
            <div class="col-12 col-lg-8">
                <h2>Danh sách sản phẩm</h2>
                <?php
                if (isset($_SESSION["update_quantity"])) {
                    if ($_SESSION["update_quantity"] == true) {
                        showMessage('Cập nhật số lượng thành công');
                    } else  showMessage('Cập nhật số lượng thất bại, vui lòng thử lại sau!', 'danger');
                    $_SESSION["update_quantity"] = null;
                }
                if (isset($_SESSION["delete_shoe"])) {
                    if ($_SESSION["delete_shoe"] == true) {
                        showMessage('Xóa sản phẩm thành công!');
                    } else  showMessage('Xóa sản phẩm thất bại, vui lòng thử lại sau!', 'danger');
                    $_SESSION["delete_shoe"] = null;
                }

                ?>
                <ul class="mt-5 p-0 ">
                    <?php
                    $total = 0;
                    $mixListLength = count($mixList);
                    if ($mixList > 0) {
                        // output data of each row

                        for ($i = 0; $i < $mixListLength; $i++) {
                            $id = $mixList[$i]['shoe']->id;
                            $imageurl = $mixList[$i]['shoe']->imageurl;
                            $name = $mixList[$i]['shoe']->name;
                            $price = $mixList[$i]['shoe']->getFormatPrice();
                            $rawPrice = $mixList[$i]['shoe']->price;
                            $sold = $mixList[$i]['shoe']->sold;
                            $instock = $mixList[$i]['shoe']->instock;
                            $quantity = $mixList[$i]['quantity'];
                            $total += $rawPrice * $quantity;
                            echo "<li class='mt-2'>
                            <div class='cart-item bg-white d-flex flex-lg-row flex-column justify-content-between gap-2 shadow p-4 rounded-2'>
                                <div class='d-flex align-items-center gap-3'>
                                <div class='form-check'>
                                    <input class='form-check-input select-shoe-checkbox' type='checkbox' data-price=$rawPrice data-quantity=$quantity value='$id'  checked>
                                
                                </div>
                                    <img src='$imageurl' alt='image' style='max-width: 100px; width: 100%;' class='rounded-4'>
                                    <div class='description'>
                                        <h5>$name</h5>
                                        <h6 class='text-danger'>$price <span class='text-decoration-underline'>đ</span></h6>
                                    </div>
                                </div>
                                <div class='d-flex align-items-center'>
                                    <div class='update-quantity d-flex gap-2' style='height: fit-content;'>
                                    <form action='/cart.php' method='post' class='d-flex gap-2 align-items-center m-0'>
                                        
                                        <input type='number' name='quantity' max=$instock min=1 value=$quantity class='p-2'>
                                        <input type='hidden' name='id' value='$id'/>
                                        <input type='hidden' name='changeQuantity' value='true'/>

                                        <button class='btn btn-danger' type='submit'>Cập nhật</button>
                                    </form>
                                     <form action='/cart.php' method='post' class='m-0 d-flex align-items-center'>
                                        <input type='hidden' name='id' value='$id'/>
                                        <input type='hidden' name='delete' value='true'/>
                                        <button class='border-0 bg-transparent text-danger fs-5' type='submit' id='del-btn'><i class='fa-solid fa-trash-can'></i></button>
                                     </form>   
                                        
                                    </div>
                                </div>
                            </div>
                        </li>";
                        }
                        $total = Utility::moneyFormat($total);
                    }

                    ?>
                </ul>
            </div>
            <div class="col-12 col-lg-4">
                <h2>Thông tin thanh toán</h2>
                <div class="mt-5 p-5 shadow">
                    <p class=" fs-4 fw-bold  "><span>Tổng cộng: </span> <span class="text-danger" id="total-price"><?= $total ?></span> <span class="text-decoration-underline text-danger">đ</span></p>
                    <button class="btn btn-primary px-4 py-2 fs-5 rounded-3 mt-4 shadow" onclick="goToOrder()">Mua hàng</button>
                </div>

            </div>
        </div>
    </div>
    <?php
    include dirname(__DIR__) . "/components/footer.php";
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        let total = 0;
        let checkboxList = document.getElementsByClassName('select-shoe-checkbox');
        for (let index = 0; index < checkboxList.length; index++) {
            const element = checkboxList[index];
            total += element.dataset['price'] * element.dataset['quantity'];
        }
        for (let index = 0; index < checkboxList.length; index++) {
            const element = checkboxList[index];
            element.onchange = () => {
                if (element.checked) total += element.dataset['price'] * element.dataset['quantity'];
                else total -= element.dataset['price'] * element.dataset['quantity'];
                document.getElementById('total-price').innerText = total.toLocaleString('vi-VN');
            }
        }


        function goToOrder() {
            let shoeList = []
            let checkboxList = document.getElementsByClassName('select-shoe-checkbox');
            for (let index = 0; index < checkboxList.length; index++) {
                const element = checkboxList[index];

                if (element.checked) shoeList.push(element.value);

            }

            if (shoeList.length > 0) {
                $.ajax({
                    type: "POST",
                    url: "order.php",
                    data: {
                        shoeList: shoeList
                    }
                }, ).done(function(msg) {
                    location.href = "order.php"
                });
            }





        }
        const delBtn = $('#del-btn');
        delBtn.on('click', function(e) {
            e.preventDefault();
            if (confirm('Bạn có chắc là muốn xóa hóa đơn này?')) {
                delBtn.parent().submit();
            }
        })
    </script>
</body>

</html>