<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
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
                <a class="nav-link active" aria-current="page" href="/admin.php">Quản lý sản phẩm</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/adminUser.php">Quản lý người dùng</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/adminBill.php">Quản lý hóa đơn</a>
            </li>
        </ul>
        <main class="mt-5">
            <?php
            include dirname(__DIR__) . '/components/errorList.php';
            include dirname(__DIR__) . '/components/message.php';

            if (isset($_SESSION['update_shoe'])) {
                if ($_SESSION['update_shoe']['state'] == true) {
                    showMessage('Cập nhật thành công!');
                } else {

                    showMessage('Cập nhật thất bại, vui lòng kiểm tra lại thông tin sản phẩm hoặc thử lại sau.', 'danger');;
                }
                unset($_SESSION['update_shoe']);
            }
            if (isset($_SESSION['create_shoe'])) {
                if ($_SESSION['create_shoe'] == true) {
                    showMessage('Tạo sản phẩm thành công!');
                } else {

                    showMessage('Tạo sản phẩm thất bại, vui lòng kiểm tra lại thông tin sản phẩm hoặc thử lại sau.', 'danger');
                }
                unset($_SESSION['create_shoe']);
            }

            if (isset($_SESSION['delete_shoe'])) {
                if ($_SESSION['delete_shoe'] == true) {
                    showMessage('Xóa sản phẩm thành công!');
                } else {

                    showMessage('Xóa sản phẩm thất bại, vui lòng thử lại sau.', 'danger');
                }
                unset($_SESSION['delete_shoe']);
            }
            ?>
            <div class="accordion" id="accordionExample">
                <div class='accordion-item'>
                    <h2 class='accordion-header'>
                        <button class='accordion-button collapsed text-uppercase' type='button' data-bs-toggle='collapse' data-bs-target='#collapseCreate' aria-expanded='false' aria-controls='collapseCreate'>
                            Tạo sản phẩm mới
                        </button>
                    </h2>
                    <div id='collapseCreate' class='accordion-collapse collapse' data-bs-parent='#accordionExample'>
                        <div class='accordion-body'>
                            <form action='/admin.php' method='post' class='p-lg-5 p-2 shadow rounded-4' enctype='multipart/form-data'>
                                <div class='mb-3'>
                                    <label class='form-label'>Tên giày</label>
                                    <input type='text' class='form-control' name='name' value='Example'>

                                </div>

                                <div class=' mb-3'>
                                    <label class='form-label'>Loại giày</label>
                                    <input type='text' class='form-control' name='category' value='Example'>

                                </div>
                                <div class=' mb-3'>
                                    <label class='form-label'>Mô tả</label>
                                    <input type='text' class='form-control' name='description' value='Example'>

                                </div>
                                <div class='mb-3'>
                                    <label class='form-label'>Giá bán</label>
                                    <input type='number' class='form-control' name='price' min=1000 value=1000000>

                                </div>
                                <div class='mb-3'>
                                    <label class='form-label'>Tồn kho</label>
                                    <input type='text' class='form-control' name='instock' min=1 value=100>

                                </div>
                                <div class='mb-3'>
                                    <label class='form-label'>Đã bán</label>
                                    <input type='number' class='form-control' name='sold' value=0>

                                </div>


                                <div class='mb-3'>
                                    <label class='form-label'>Ảnh sản phẩm</label>
                                    <div class='input-group mb-4'>
                                        <input type='file' class='form-control' aria-describedby='inputGroupFileAddon04' aria-label='Upload' name='imageFile' accept='image/*'>
                                    </div>
                                </div>
                                <input type="hidden" name="create">
                                <button class='btn btn-danger' type='submit'><span class='spinner-border spinner-border-sm  me-2' hidden></span>Tạo sản phẩm mới</button>
                            </form>
                        </div>
                    </div>
                </div>

                <?php
                foreach ($shoeList as &$shoe) {

                    $shoeName = $shoe->name;
                    $id = $shoe->id;
                    $category = $shoe->category;
                    $description = $shoe->description;
                    $price = $shoe->price;
                    $instock = $shoe->instock;
                    $sold = $shoe->sold;
                    $imageurl = $shoe->imageurl;
                    echo "
                <div class='accordion-item'>
                    <h2 class='accordion-header'>
                        <button class='accordion-button collapsed text-uppercase' type='button' data-bs-toggle='collapse' data-bs-target='#collapse$id' aria-expanded='false' aria-controls='collapse$id'>
                            $shoeName
                        </button>
                    </h2>
                    <div id='collapse$id' class='accordion-collapse collapse' data-bs-parent='#accordionExample'>
                        <div class='accordion-body'>
                            <form action='/admin.php' method='post' class='m-0 d-flex align-items-center shadow-sm p-4 rounded-4'>
                                <input type='hidden' name='id' value='$id'/>
                                <input type='hidden' name='imageurl' value='$imageurl'/>
                                <input type='hidden' name='delete' />
                                <button class='border-0 bg-transparent text-danger fs-5' type='submit' id='del-btn'>Xóa sản phẩm <i class='fa-solid fa-trash-can'></i></button>
                            </form> 
                            <form action='/admin.php' method='post' class='p-lg-5 p-2 shadow rounded-4 mt-4' enctype='multipart/form-data'>
                                <div class='mb-3'>
                                    <label class='form-label'>Tên giày</label>
                                    <input type='text' class='form-control' name='name' value=' $shoeName '>

                                </div>

                                <div class=' mb-3'>
                                    <label class='form-label'>Loại giày</label>
                                    <input type='text' class='form-control' name='category' value=' $category '>

                                </div>
                                <div class=' mb-3'>
                                    <label class='form-label'>Mô tả</label>
                                    <input type='text' class='form-control' name='description' value='$description'>

                                </div>
                                <div class='mb-3'>
                                    <label class='form-label'>Giá bán</label>
                                    <input type='number' class='form-control' name='price' min=0 value= $price >

                                </div>
                                <div class='mb-3'>
                                    <label class='form-label'>Tồn kho</label>
                                    <input type='text' class='form-control' name='instock' value= $instock >

                                </div>
                                <div class='mb-3'>
                                    <label class='form-label'>Đã bán</label>
                                    <input type='number' class='form-control' name='sold' value= $sold >

                                </div>  
                                <input type='hidden' name='imageurl' value='$imageurl'/>
                                <input type='hidden' name='id' value='$id'/>
                                <input type='hidden' name='update' />

                                <div class='d-flex gap-4 align-items-center my-4'>
                                    <div class='border-end pe-4'>
                                        <p>Ảnh hiện tại</p>
                                        <img src='$imageurl' class='rounded-2' alt='preview' style='width:200px;'>
                                    </div>
                                    
                                    <div class='mb-3'>
                                        <label class='form-label'>Chọn ảnh mới</label>
                                        <div class='input-group mb-4'>
                                            <input type='file' class='form-control' aria-describedby='inputGroupFileAddon04' aria-label='Upload' name='imageFile' accept='image/*'>
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
            <div class=" mt-5 d-flex justify-content-center align-items-center">
                <ul class=" pagination ">
                    <li class="page-item<?= $paginator->getPrevPage() ?
                                            '' : ' disabled' ?>">
                        <a role="button" href="/admin.php?page=<?= $paginator->getPrevPage() ?>&limit=12" class="page-link">
                            <span>&laquo;</span>
                        </a>
                    </li>
                    <?php foreach ($pages as $page) : ?>
                        <li class="page-item<?= $paginator->currentPage === $page ?
                                                ' active' : '' ?>"><a role="button" href="/admin.php?page=<?= $page ?>&limit=12" class="page-link"><?= $page ?></a>
                        </li>
                    <?php endforeach ?>
                    <li class="page-item<?= $paginator->getNextPage() ?
                                            '' : ' disabled' ?>">
                        <a role="button" href="/admin.php?page=<?= $paginator->getNextPage() ?>&limit=12" class="page-link">
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
            if (confirm('Bạn có chắc là muốn xóa sản phẩm này?')) {
                delBtn.parent().submit();

            }
        })
    </script>
</body>

</html>