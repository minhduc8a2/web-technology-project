<?php
session_start();

require_once dirname(__DIR__, 1) . '/services/connect_db.php';
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>
    <?php
    include dirname(__DIR__) . '/components/navbar.php';
    ?>
    <main class="standout-product mt-new-section">
        <h1 class="fs-1 text-center">Kết quả tìm kiếm</h1>
        <div class="container mt-5">
            <div class="row gy-4">

                <?php

                if (isset($searchTerm)) {
                    $sql = "SELECT id,name, price, imageurl FROM shoes where  name LIKE '%$searchTerm%'";
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
                } else echo "<h3>Không có kết quả nào phù hợp.</h3>";

                $conn->close();

                ?>
            </div>
        </div>
    </main>
    <?php
    include dirname(__DIR__) . "/components/footer.php";

    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>