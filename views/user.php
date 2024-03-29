<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $userName ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>
    <?php
    include dirname(__DIR__) . '/components/navbar.php';
    ?>
    <div class="container mt-new-page">
        <div class="row gy-5 ">
            <div class="col-12 col-lg-6 ">
                <h1 class="mb-5">Chức năng người dùng</h1>
                <div class="d-flex flex-lg-row flex-column p-4 justify-content-start gap-4 align-items-center">
                    <?php
                    if (!$avatar) {
                        echo '<img src="../assets/images/user.png" alt="" class="img-fluid  d-lg-block d-none " style="max-width: 200px;">';
                        echo "<img src='../assets/images/user.png'  class='img-fluid rounded-circle d-lg-none w-75' >";
                    } else {
                        echo "<img src='$avatar'  class='img-fluid rounded-circle d-lg-block d-none' style='max-width: 200px;'>";
                        echo "<img src='$avatar'  class='img-fluid rounded-circle d-lg-none w-75' >";
                    }
                    ?>
                    <div class="d-flex flex-column gap-2 align-items-start">
                        <a class="btn btn-dark" style="width: fit-content;" href="/billList.php">Xem đơn hàng</a>
                        <?php
                        if ($_SESSION['logined']->role == 'admin') {
                            echo '<a class="btn btn-danger" style="width: fit-content;" href="/admin.php">Quản lý website</a>';
                        }
                        ?>
                    </div>

                </div>


            </div>
            <div class="col-12 col-lg-6">
                <h1 class="mb-5">Thông tin tài khoản</h1>
                <form action="/user.php" method="post" class="p-lg-5 p-4 shadow rounded-4" enctype='multipart/form-data'>
                    <?php
                    if (isset($_SESSION['update_user']) && $_SESSION['update_user'] == true) {
                        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        Cập nhật thành công.
                       <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                     </div>";
                        $_SESSION['update_user'] = null;
                    }
                    if (isset($_SESSION['error_list'])) {
                        foreach ($_SESSION['error_list'] as &$value) {
                            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                     $value
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                  </div>";
                        }
                        $_SESSION['error_list'] = null;
                    }
                    ?>
                    <div class="mb-3">
                        <label for="inputName" class="form-label">Họ tên</label>
                        <input type="text" class="form-control" id="inputName" name="name" value='<?= $userName ?>'>

                    </div>

                    <div class=" mb-3">
                        <label for="inputEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="inputEmail" name="email" value='<?= $email ?>'>

                    </div>
                    <div class="mb-3">
                        <label for="inputPhoneNumber" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="inputPhoneNumber" name="phoneNumber" value='<?= $phoneNumber ?>'>

                    </div>
                    <div class="mb-3">
                        <label for="inputAddress" class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" id="inputAddress" name="address" value='<?= $address ?>'>

                    </div>
                    <div class="mb-3">
                        <label for="inputPassword" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" id="inputPassword" name="password">

                    </div>
                    <div class="mb-3">
                        <label for="inputNewPassword" class="form-label">Mật khẩu Mới</label>
                        <input type="password" class="form-control" id="inputNewPassword" name="newPassword">

                    </div>
                    <div class="mb-3">
                        <label for="inputConfirmPassword" class="form-label">Nhập lại Mật khẩu</label>
                        <input type="password" class="form-control" id="inputConfirmPassword" name="confirmPassword">

                    </div>
                    <div class="mb-3">
                        <label for="inputAvatar" class="form-label">Avatar</label>
                        <div class="input-group mb-4">
                            <input type='file' class='form-control' aria-describedby='inputGroupFileAddon04' aria-label='Upload' name='imageFile'>

                        </div>
                    </div>
                    <input type='hidden' name='id' value=<?= $userId ?> />
                    <input type='hidden' name='avatar' value='<?= $avatar ?>' />

                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>


        </div>
    </div>



    <?php
    include dirname(__DIR__) . "/components/footer.php";

    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>