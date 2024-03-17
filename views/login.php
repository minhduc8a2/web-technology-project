<?php
if (isset($_SESSION['logined'])) {
    // echo $_SESSION['logined'];
    header('location: /');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>
    <?php
    include dirname(__DIR__) . '/components/navbar.php';
    ?>
    <div class="container mt-new-page">
        <h1 class="my-5 text-center">Đăng nhập</h1>
        <div class="row justify-content-center">
            <div class="col-lg-6 col-12">
                <?php



                if (isset($_SESSION['error_list'])) {
                    foreach ($_SESSION['error_list'] as &$value) {
                        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                $value
                     <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                    }
                    $_SESSION['error_list'] = null;
                }

                $email = "";

                if (isset($_SESSION['sign_in_form_state'])) {

                    $email = $_SESSION['sign_in_form_state']['email'];

                    $_SESSION['sign_in_form_state'] = null;
                }

                ?>
                <form action="/login.php" method="post" class="p-lg-5 p-2 shadow rounded-4">


                    <div class=" mb-3">
                        <label for="inputEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="inputEmail" name="email" value='<?= $email ?>'>

                    </div>

                    <div class="mb-3">
                        <label for="inputPassword" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" id="inputPassword" name="password">

                    </div>

                    <button type="submit" class="btn btn-primary">Đăng nhập</button>
                    <p class="mt-4">Chưa có tài khoản? <a href="signup.php" class="text-decoration-underline fw-bold text-black">Đăng ký</a></p>
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