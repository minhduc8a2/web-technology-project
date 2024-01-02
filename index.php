<?php
session_start();
include dirname(__FILE__) . '/services/connect_db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="./assets/css/styles.css">
</head>

<body>
  <?php
  include dirname(__FILE__) . '/components/navbar.php';
  ?>
  <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item  active" data-bs-interval="2000">
        <img src="./assets/images/banner/banner1.avif" class="d-md-block d-none w-100 " alt="banner1">
        <img src="./assets/images/banner/banner1_vertical.avif" class="d-md-none d-block   " alt="banner1" style="height: 700px;">
        <div class="carousel-caption  d-none d-lg-block  text-start " style="padding-bottom: 10rem;">
          <h5 class="fs-1 fw-bold">HOLIDAY SALE</h5>
          <p class="mt-4" style="max-width: 500px; ">Ưu đãi lên đến 50%. Giá hiển thị trên trang web là giá bán cuối cùng. Một số sản phẩm ngoại lệ. Điều khoản và Điều kiện đi kèm.</p>
          <a href="/pages/search.php?search=giày"><button class="styled-btn fw-bold mt-4">MUA NGAY <i class="fa-solid fa-arrow-right "></i></button></a>


        </div>
        <div class="carousel-caption  d-lg-none   ">
          <h5 class="fs-1">HOLIDAY SALE</h5>
          <p class="" style="max-width: 500px;">Ưu đãi lên đến 50%. Giá hiển thị trên trang web là giá bán cuối cùng. Một số sản phẩm ngoại lệ. Điều khoản và Điều kiện đi kèm.</p>
          <a href="/pages/search.php?search=giày" class=""><button class="styled-btn fw-bold mt-4 mb-4">MUA NGAY <i class="fa-solid fa-arrow-right "></i></button></a>
        </div>

      </div>
      <div class="carousel-item" data-bs-interval="4000">
        <img src="./assets/images/banner/banner2.avif" class="d-md-block d-none w-100" alt="banner2">
        <img src="./assets/images/banner/banner2_vertical.avif" class="d-md-none d-block " alt="banner2" style="height: 700px;">
        <div class="carousel-caption  d-none d-lg-block  text-start " style="padding-bottom: 10rem;">
          <h5 class="fs-1">TỎA SÁNG CÙNG SAMBA</h5>
          <p class="" style="max-width: 500px;">Châu Bùi, 24K.RIGHT, Lil Thu, Nick Q Tran tỏa sáng cùng Samba. Bạn thì sao?</p>
          <a href="/pages/search.php?search=samba"><button class="styled-btn fw-bold mt-4">MUA NGAY <i class="fa-solid fa-arrow-right "></i></button></a>
        </div>
        <div class="carousel-caption  d-lg-none   ">
          <h5 class="fs-1">TỎA SÁNG CÙNG SAMBA</h5>
          <p class="" style="max-width: 500px;">Châu Bùi, 24K.RIGHT, Lil Thu, Nick Q Tran tỏa sáng cùng Samba. Bạn thì sao?</p>
          <a href="/pages/search.php?search=samba" class=""><button class="styled-btn fw-bold mt-4 mb-4">MUA NGAY <i class="fa-solid fa-arrow-right "></i></button></a>
        </div>
      </div>
      <div class="carousel-item" data-bs-interval="4000">
        <img src="./assets/images/banner/banner3.jpg" class="d-md-block d-none w-100" alt="banner3">
        <img src="./assets/images/banner/banner3_vertical.jpg" class="d-md-none d-block  " alt="banner3" style="height: 700px;">
        <div class="carousel-caption  d-none d-lg-block  text-start " style="padding-bottom: 10rem;">
          <h5 class="fs-1">ARSENAL X IAN WRIGHT</h5>
          <p class="" style="max-width: 500px;">Tôn vinh ký ức, khoảnh khắc và con người của Huyền thoại Arsenal trong suốt sự nghiệp của anh.</p>
          <a href="/pages/search.php?search=ian+wright"><button class="styled-btn fw-bold mt-4">MUA NGAY <i class="fa-solid fa-arrow-right "></i></button></a>
        </div>
        <div class="carousel-caption  d-lg-none   ">
          <h5 class="fs-1">ARSENAL X IAN WRIGHT</h5>
          <p class="" style="max-width: 500px;">Tôn vinh ký ức, khoảnh khắc và con người của Huyền thoại Arsenal trong suốt sự nghiệp của anh.</p>
          <a href="/pages/search.php?search=ian+wright" class=""><button class="styled-btn fw-bold mt-4 mb-4">MUA NGAY <i class="fa-solid fa-arrow-right "></i></button></a>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
      <span class="carousel-control-prev-icon opacity-0 " aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
      <span class="carousel-control-next-icon opacity-0 " aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
  <main class="standout-product mt-new-section">
    <h1 class="fs-1 text-center">Sản phẩm nổi bật</h1>
    <div class="container mt-5">
      <div class="row gy-4">

        <?php



        $sql = "SELECT id,name, price, imageurl FROM shoes limit 10";
        $result = $conn->query($sql);
        function moneyFormat($x)
        {

          return str_replace(',', '.', strval(number_format($x)));
        }
        if ($result->num_rows > 0) {
          // output data of each row
          while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $name = $row['name'];
            $imageurl = $row['imageurl'];
            $price = moneyFormat($row['price']);
            echo "
            <div class='col-lg-3  col-6'>
            <a class='card w-100 border-0 shadow rounded-4 ' href='/pages/product.php?id=$id'>
              <div class='image-wrapper overflow-hidden rounded-4'>
                <img src=' $imageurl ' class='card-img-top  shadow-sm card-image ' alt='giay adidas'>
              </div>
  
              <div class='card-body'>
                <h5 class='card-title '>$name </h5>
                <p class='card-text'> $price đ</p>
  
              </div>
            </a>
          </div>
            ";
          }
        } else {
          echo "0 results";
        }
        $conn->close();

        ?>
      </div>
    </div>
  </main>

  <?php
  include __DIR__ . "/components/footer.php";

  ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>