<?php
require_once dirname(__DIR__, 1) . '\services\connect_db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>

<nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top shadow-lg">
    <div class="container-fluid px-5">
        <a class="navbar-brand" href="/index.php"><img src="../assets/images/logo.png" alt="logo" class="logo"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/index.php">Trang chủ</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Sản phẩm
                    </a>
                    <ul class="dropdown-menu">
                        <?php
                        $sql = "SELECT name FROM categories";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            // output data of each row
                            while ($row = $result->fetch_assoc()) {
                                $name = $row['name'];
                                echo "<li><a class='dropdown-item' href='#'>$name</a></li>";
                            }
                        }

                        ?>

                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#footer">Liên hệ</a>
                </li>
            </ul>
            <form class="d-flex mb-0" role="search">
                <input class="form-control me-2" type="search" placeholder="Sản phẩm" aria-label="Search">
                <button class="btn btn-outline-success text-nowrap" type="submit">Tìm kiếm</button>
            </form>
            <div class="py-4 py-lg-0">
                <?php

                if (isset($_SESSION['logined'])) {
                    echo '<a href="/pages/user.php" class="ms-lg-4 text-black fs-4" ><i class="fa-solid fa-circle-user" ></i></a>';
                } else {
                    echo '<a href="/pages/login.php" class="ms-lg-4 text-black fs-6">Login</a>';
                }
                ?>

                <a href="/pages/cart.php" class="ms-4 text-black fs-4"><i class="fa-solid fa-cart-shopping"></i></a>
                <form method="post" class="d-inline ms-4 text-black fs-5">
                    <input type='hidden' name='logOut' value='logOut' />
                    <button type="submit" class="border-0 bg-transparent"><i class="fa-solid fa-arrow-right-from-bracket"></i></button>
                </form>
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logOut"])) {
                    $_SESSION['logined'] = null;
                    header('location: /pages/login.php');
                }
                ?>
            </div>

        </div>
    </div>
</nav>