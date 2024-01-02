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

$userList = [];
$sql = "select* from users ;";
try {
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            array_push($userList, $row);
        }
    }
} catch (\Throwable $th) {
    echo 'Error with server.';
    exit();
}
if (isset($_SESSION['update_user'])) {
    if ($_SESSION['update_user']['state'] == true) {
        echo '<script>alert("Cập nhật thành công!")</script>';
    } else {

        echo '<script>alert("Cập nhật thất bại, vui lòng kiểm tra lại thông tin người dùng hoặc thử lại sau.")</script>';;
    }
    unset($_SESSION['update_user']);
}
if (isset($_SESSION['create_user'])) {
    if ($_SESSION['create_user'] == true) {
        echo '<script>alert("Tạo người dùng thành công!")</script>';
    } else {

        echo '<script>alert("Tạo người dùng thất bại, vui lòng kiểm tra lại thông tin người dùng hoặc thử lại sau.")</script>';
    }
    unset($_SESSION['create_user']);
}

if (isset($_SESSION['delete_user'])) {
    if ($_SESSION['delete_user'] == true) {
        echo '<script>alert("Xóa người dùng thành công!")</script>';
    } else {

        echo '<script>alert("Xóa người dùng thất bại, vui lòng thử lại sau.")</script>';
    }
    unset($_SESSION['delete_user']);
}

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
                <a class="nav-link active" aria-current="page" href="/pages/adminUser.php">Quản lý người dùng</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/pages/adminBill.php">Quản lý hóa đơn</a>
            </li>
        </ul>
        <main class="mt-5">
            <?php
            if (isset($_SESSION['error_list'])) {
                foreach ($_SESSION['error_list'] as &$value) {
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        $value
                       <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                     </div>";
                }
                unset($_SESSION['error_list']);
            }

            ?>
            <div class="accordion" id="accordionExample">
                <div class='accordion-item'>
                    <h2 class='accordion-header'>
                        <button class='accordion-button collapsed text-uppercase' type='button' data-bs-toggle='collapse' data-bs-target='#collapseCreate' aria-expanded='false' aria-controls='collapseCreate'>
                            Tạo tài khoản người dùng
                        </button>
                    </h2>
                    <div id='collapseCreate' class='accordion-collapse collapse' data-bs-parent='#accordionExample'>
                        <div class='accordion-body'>
                            <form action='/services/users/create.php' method='post' class='p-lg-5 p-2 shadow rounded-4 mt-4' enctype='multipart/form-data'>
                                <div class='mb-3'>
                                    <label class='form-label'>Họ tên</label>
                                    <input type='text' class='form-control' name='name' value='Example'>

                                </div>

                                <div class=' mb-3'>
                                    <label class='form-label'>Email</label>
                                    <input type='email' class='form-control' name='email' value='email@gmail.com'>

                                </div>
                                <div class='mb-3'>
                                    <label class='form-label'>Số điện thoại</label>
                                    <input type='text' class='form-control' name='phoneNumber' value='099999999'>

                                </div>
                                <div class='mb-3'>
                                    <label class='form-label'>Địa chỉ</label>
                                    <input type='text' class='form-control' name='address' value='Cần Thơ'>

                                </div>
                                <div class='mb-3'>
                                    <label class='form-label'>Vai trò: 'admin' hoặc 'normal'</label>
                                    <input type='text' class='form-control' name='role' value='normal'>

                                </div>
                                <div class='mb-3'>
                                    <label class='form-label'>Mật khẩu</label>
                                    <input type='password' class='form-control' name='password' value=''>

                                </div>
                                <input type='hidden' name='create' />

                                <div class='d-flex gap-4 align-items-center my-4'>
                                    <div class='mb-3'>
                                        <label class='form-label'>Chọn ảnh đại diện</label>
                                        <div class='input-group mb-4'>
                                            <input type='file' class='form-control' aria-describedby='inputGroupFileAddon04' aria-label='Upload' name='imageFile'>
                                        </div>
                                    </div>
                                </div>
                                <button class='btn btn-danger' type='submit'><span class='spinner-border spinner-border-sm  me-2' hidden></span>Tạo tài khoản</button>
                            </form>

                        </div>
                    </div>
                </div>

                <?php
                foreach ($userList as &$user) {
                    $id = $user['id'];
                    $userName  = $user['name'];
                    $email  = $user['email'];
                    $phoneNumber  = $user['phoneNumber'];
                    $address  = $user['address'];
                    $role  = $user['role'];
                    $avatar  = $user['avatar'];
                    echo "
                <div class='accordion-item'>
                    <h2 class='accordion-header'>
                        <button class='accordion-button collapsed text-uppercase' type='button' data-bs-toggle='collapse' data-bs-target='#collapse$id' aria-expanded='false' aria-controls='collapse$id'>
                            $email
                        </button>
                    </h2>
                    <div id='collapse$id' class='accordion-collapse collapse' data-bs-parent='#accordionExample'>
                        <div class='accordion-body'>
                            <form action='/services/users/delete.php' method='post' class='m-0 d-flex align-items-center shadow-sm p-4 rounded-4'>
                                <input type='hidden' name='id' value='$id'/>
                                <input type='hidden' name='avatar' value='$avatar'/>
                                <button class='border-0 bg-transparent text-danger fs-5' type='submit'>Xóa người dùng <i class='fa-solid fa-trash-can'></i></button>
                            </form> 
                        <form action='/services/users/updateForAdmin.php' method='post' class='p-lg-5 p-2 shadow rounded-4 mt-4' enctype='multipart/form-data'>
                        <div class='mb-3'>
                            <label  class='form-label'>Họ tên</label>
                            <input type='text' class='form-control'  name='name' value=' $userName'>
    
                        </div>
    
                        <div class=' mb-3'>
                            <label  class='form-label'>Email</label>
                            <input type='email' class='form-control'  name='email' value=' $email'>
    
                        </div>
                        <div class='mb-3'>
                            <label  class='form-label'>Số điện thoại</label>
                            <input type='text' class='form-control'  name='phoneNumber' value=' $phoneNumber'>
    
                        </div>
                        <div class='mb-3'>
                            <label  class='form-label'>Địa chỉ</label>
                            <input type='text' class='form-control'  name='address' value=' $address'>
    
                        </div>
                        <div class='mb-3'>
                            <label  class='form-label'>Vai trò: 'admin' hoặc 'normal'</label>
                            <input type='text' class='form-control'  name='role' value=' $role'>
    
                        </div>
                        <div class='mb-3'>
                            <label  class='form-label'>Mật khẩu</label>
                            <input type='password' class='form-control'  name='password' value='$password'>
    
                        </div>
                                <input type='hidden' name='avatar' value='$avatar'/>
                                <input type='hidden' name='id' value='$id'/>
                                <div class='d-flex gap-4 align-items-center my-4'>
                                    <div class='border-end pe-4'>
                                        <p>Ảnh hiện tại</p>
                                        ";
                    if ($avatar == 'null') {
                        echo "
                                        <img src='../assets/images/user.png' class='rounded-2' alt='preview' style='width:200px;'>";
                    } else {
                        echo "
                                            <img src='$avatar' class='rounded-2' alt='preview' style='width:200px;'>";
                    }

                    echo "</div>
                                    
                                    <div class='mb-3'>
                                        <label class='form-label'>Chọn ảnh mới</label>
                                        <div class='input-group mb-4'>
                                            <input type='file' class='form-control' aria-describedby='inputGroupFileAddon04' aria-label='Upload' name='imageFile'>
                                        </div>
                                    </div>
                                </div>
                               
                                <button class='btn btn-danger' type='submit'><span class='spinner-border spinner-border-sm  me-2' hidden></span>Cập nhật</button>
                            </form>
                            
                        </div>
                    </div>
                </div>
                        ";
                }
                ?>

            </div>

        </main>
    </div>

    <?php
    include dirname(__DIR__) . "/components/footer.php";

    ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>