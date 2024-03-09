<?php
session_start();
require dirname(__DIR__, 1) . '/services/connect_db.php';
require_once dirname(__DIR__, 1) . '/services/utils.php';

$shoesId = $_GET['id'];

$sql = $conn->prepare("SELECT shoes.name as name, price,instock, imageurl,description,  category FROM shoes
where shoes.id=?
;");
$sql->bind_param('i', $shoesId);
$sql->execute();
$result = $sql->get_result();

$hasData = false;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $shoeName = $row['name'];
    $imageurl = $row['imageurl'];
    $price = moneyFormat($row['price']);
    $category = $row['category'];
    $description = $row['description'];
    $instock = $row['instock'];
    $hasData = true;
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
    include dirname(__DIR__) . '/components/navbar.php';
    ?>
    <div class="container mt-new-page">
        <div class="row gx-lg-5 gy-5">
            <div class="col-lg-7 col-12 d-flex d-lg-block justify-content-center align-items-center"><img src=<?= $imageurl ?> alt=<?= $shoeName ?> class="w-75 rounded-5"> </div>
            <div class="col-lg-5 col-12 border-start px-4">
                <?php

                if (isset($_SESSION['add_to_cart'])) {
                    if ($_SESSION['add_to_cart'] == true) {
                        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
             Đã thêm sản phẩm vào giỏ hàng
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
                    } else {
                        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            Có lỗi xảy ra, vui lòng thử lại sau!
           <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
         </div>";
                    }
                    $_SESSION['add_to_cart'] = null;
                }


                ?>
                <p class="text-secondary fs-5 fw-semi-bold mb-0"><?= $category ?></p>
                <p class="fs-2 fw-semibold mb-2"><?= $shoeName ?></p>
                <p class="fs-5 text-danger fw-semibold "><?= $price ?> <span class="text-decoration-underline">đ</span></p>
                <p class="fs-6 fw-semibold ">Sản phẩm này không nằm trong các chương trình giảm giá và ưu đãi khuyến mãi.</p>
                <p class="fs-5 fw-semibold mb-3">Sẵn có: <?= $instock ?> </p>
                <div class="accordion mb-5 " id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Chi tiết sản phẩm
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p> <span class="text-uppercase fw-bold fs-5"><?php
                                                                                $sentence = explode('.', $description);
                                                                                echo $sentence[0];
                                                                                ?>.</span>
                                    <?php
                                    $length = count($sentence);
                                    for ($i = 1; $i < $length; $i += 1) {
                                        if ($i < $length - 1) echo $sentence[$i] . ". ";
                                        else echo $sentence[$i];
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="/services/cartItems/create.php" method="post">
                    <input type='hidden' name='id' value='<?= $shoesId ?>' />

                    <button class="btn btn-dark py-3 px-4">Thêm vào giỏ hàng</button>
                </form>

            </div>
        </div>
    </div>
    <?php
    include dirname(__DIR__) . "/components/footer.php";
    $conn->close();

    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>