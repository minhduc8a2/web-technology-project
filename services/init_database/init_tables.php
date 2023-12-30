<?php
require dirname(__DIR__, 1) . '\connect_db.php';

//shoes table
try {
    $sql = "CREATE TABLE shoes (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        category VARCHAR(100) NOT NULL,
        description VARCHAR(1000) NOT NULL,
        updatedat TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        price INT UNSIGNED NOT NULL,
        instock INT UNSIGNED NOT NULL,
        sold INT UNSIGNED NOT NULL,
        imageurl  VARCHAR(500) NOT NULL,
        imageid  VARCHAR(100) NOT NULL
        );";

    if ($conn->query($sql) === TRUE) {

        echo "<script>console.log('shoes created successfully')</script>";
    }
} catch (\Throwable $th) {
    echo $th;
}
// categories table
try {
    $sql = "CREATE TABLE categories (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        updatedat TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );";

    if ($conn->query($sql) === TRUE) {

        echo "<script>console.log('categories created successfully')</script>";
    }
} catch (\Throwable $th) {
    echo $th;
}

// cartitem table
try {
    $sql = "CREATE TABLE cartItems (
       
        userId INT(6) UNSIGNED,
        shoeId INT(6) UNSIGNED,
        PRIMARY KEY (userid, shoeId),
        quantity INT UNSIGNED DEFAULT 1,
        updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );";

    if ($conn->query($sql) === TRUE) {

        echo "<script>console.log('cartItem tables created successfully')</script>";
    }
} catch (\Throwable $th) {
    echo $th;
}

// users table
try {
    $sql = "CREATE TABLE users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        phoneNumber VARCHAR(100) NOT NULL,
        address VARCHAR(100) NOT NULL,
        password VARCHAR(200) NOT NULL,
        avatar VARCHAR(100) DEFAULT 'user_avatar',
        role VARCHAR(15) DEFAULT 'normal',
        updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        UNIQUE (phoneNumber)
        );";

    if ($conn->query($sql) === TRUE) {

        echo "<script>console.log('users tables created successfully')</script>";
    }
} catch (\Throwable $th) {
    echo $th;
}
