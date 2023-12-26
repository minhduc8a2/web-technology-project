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
  <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top shadow-lg">
    <div class="container-fluid px-5">
      <a class="navbar-brand" href="#"><img src="./assets/images/logo.png" alt="logo" class="logo"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Trang chủ</a>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Sản phẩm
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Liên hệ</a>
          </li>
        </ul>
        <form class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Sản phẩm" aria-label="Search">
          <button class="btn btn-outline-success text-nowrap" type="submit">Tìm kiếm</button>
        </form>
      </div>
    </div>
  </nav>
  <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item  active" data-bs-interval="2000">
        <img src="./assets/images/banner/banner1.avif" class="d-lg-block d-none w-100 " alt="banner1">
        <img src="./assets/images/banner/banner1_vertical.avif" class="d-lg-none d-block   " alt="banner1" style="height: 700px;">
        <div class="carousel-caption  d-none d-lg-block  text-start " style="padding-bottom: 10rem;">
          <h5 class="fs-1 fw-bold">HOLIDAY SALE</h5>
          <p class="mt-4" style="max-width: 500px; ">Ưu đãi lên đến 50%. Giá hiển thị trên trang web là giá bán cuối cùng. Một số sản phẩm ngoại lệ. Điều khoản và Điều kiện đi kèm.</p>
          <button class="styled-btn fw-bold mt-4">MUA NGAY <i class="fa-solid fa-arrow-right "></i></button>
        </div>
        <div class="carousel-caption  d-lg-none   ">
          <h5 class="fs-1">HOLIDAY SALE</h5>
          <p class="" style="max-width: 500px;">Ưu đãi lên đến 50%. Giá hiển thị trên trang web là giá bán cuối cùng. Một số sản phẩm ngoại lệ. Điều khoản và Điều kiện đi kèm.</p>
          <button class="styled-btn fw-bold mt-2 mb-4 ">MUA NGAY <i class="fa-solid fa-arrow-right "></i></button>
        </div>

      </div>
      <div class="carousel-item" data-bs-interval="4000">
        <img src="./assets/images/banner/banner2.avif" class="d-lg-block d-none w-100" alt="banner2">
        <img src="./assets/images/banner/banner2_vertical.avif" class="d-lg-none d-block " alt="banner2" style="height: 700px;">
        <div class="carousel-caption  d-none d-lg-block  text-start " style="padding-bottom: 10rem;">
          <h5 class="fs-1">TỎA SÁNG CÙNG SAMBA</h5>
          <p class="" style="max-width: 500px;">Châu Bùi, 24K.RIGHT, Lil Thu, Nick Q Tran tỏa sáng cùng Samba. Bạn thì sao?</p>
        </div>
        <div class="carousel-caption  d-lg-none   ">
          <h5 class="fs-1">TỎA SÁNG CÙNG SAMBA</h5>
          <p class="" style="max-width: 500px;">Châu Bùi, 24K.RIGHT, Lil Thu, Nick Q Tran tỏa sáng cùng Samba. Bạn thì sao?</p>
        </div>
      </div>
      <div class="carousel-item" data-bs-interval="4000">
        <img src="./assets/images/banner/banner3.jpg" class="d-lg-block d-none w-100" alt="banner3">
        <img src="./assets/images/banner/banner3_vertical.jpg" class="d-lg-none d-block  " alt="banner3" style="height: 700px;">
        <div class="carousel-caption  d-none d-lg-block  text-start " style="padding-bottom: 10rem;">
          <h5 class="fs-1">ARSENAL X IAN WRIGHT</h5>
          <p class="" style="max-width: 500px;">Tôn vinh ký ức, khoảnh khắc và con người của Huyền thoại Arsenal trong suốt sự nghiệp của anh.</p>
        </div>
        <div class="carousel-caption  d-lg-none   ">
          <h5 class="fs-1">ARSENAL X IAN WRIGHT</h5>
          <p class="" style="max-width: 500px;">Tôn vinh ký ức, khoảnh khắc và con người của Huyền thoại Arsenal trong suốt sự nghiệp của anh.</p>
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
        <div class="col-lg-3 col-md-6">
          <div class="card w-100 border-0 shadow-lg rounded-4 ">
            <div class="image-wrapper overflow-hidden rounded-4">
              <img src="./assets/images/products_test/adizero/Giay_Adizero_Prime_X_2.0_STRUNG_trang_HP9709_HM1.avif" class="card-img-top  shadow-sm card-image " alt="giay adidas">
            </div>

            <div class="card-body">
              <h5 class="card-title">Giày Adizero Prime X 2.0</h5>
              <p class="card-text">3.500.000đ</p>

            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="card w-100 border-0 shadow-lg rounded-4 ">
            <div class="image-wrapper overflow-hidden rounded-4">
              <img src="./assets/images/products_test/adizero/Giay_Adizero_Prime_X_2.0_STRUNG_trang_HP9709_HM1.avif" class="card-img-top  shadow-sm card-image " alt="giay adidas">
            </div>

            <div class="card-body">
              <h5 class="card-title">Giày Adizero Prime X 2.0</h5>
              <p class="card-text">3.500.000đ</p>

            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="card w-100 border-0 shadow-lg rounded-4 ">
            <div class="image-wrapper overflow-hidden rounded-4">
              <img src="./assets/images/products_test/adizero/Giay_Adizero_Prime_X_2.0_STRUNG_trang_HP9709_HM1.avif" class="card-img-top  shadow-sm card-image " alt="giay adidas">
            </div>

            <div class="card-body">
              <h5 class="card-title">Giày Adizero Prime X 2.0</h5>
              <p class="card-text">3.500.000đ</p>

            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="card w-100 border-0 shadow-lg rounded-4 ">
            <div class="image-wrapper overflow-hidden rounded-4">
              <img src="./assets/images/products_test/adizero/Giay_Adizero_Prime_X_2.0_STRUNG_trang_HP9709_HM1.avif" class="card-img-top  shadow-sm card-image " alt="giay adidas">
            </div>

            <div class="card-body">
              <h5 class="card-title">Giày Adizero Prime X 2.0</h5>
              <p class="card-text">3.500.000đ</p>

            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <?php
  $servername = "localhost";
  $username = "root";
  $password = "heroandroidluc@12ky";
  $database = "testdb";
  // Create connection
  $conn = new mysqli($servername, $username, $password, $database);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  echo "Connected successfully";

  $sql = "INSERT INTO users (name)
VALUES ('John')";

  // if ($conn->query($sql) === TRUE) {
  //   echo "New record created successfully";
  // } else {
  //   echo "Error: " . $sql . "<br>" . $conn->error;
  // }

  $sql = "SELECT name FROM users";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
      echo " - Name: " . $row["name"] . "<br>";
    }
  } else {
    echo "0 results";
  }
  $conn->close();
  ?>
  <?php
  include "./components/footer.php";

  ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>