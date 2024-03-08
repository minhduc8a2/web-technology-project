<?php
require_once dirname(__DIR__, 1) . '/connect_db.php';

//shoes table
try {
    $sql = "CREATE TABLE shoes (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(200) NOT NULL,
        category VARCHAR(100) NOT NULL,
        description VARCHAR(1000) NOT NULL,
        updatedat TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        price INT UNSIGNED NOT NULL,
        instock INT UNSIGNED NOT NULL,
        sold INT UNSIGNED NOT NULL,
        imageurl  VARCHAR(500) NOT NULL
        
        );";

    if ($conn->query($sql) === TRUE) {

        echo "<br>shoes created successfully";
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

        echo "<br>categories created successfully";
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

        echo "<br>cartItem tables created successfully";
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
        avatar VARCHAR(200) DEFAULT 'https://res.cloudinary.com/dqqetbr1m/image/upload/v1704084419/adidas_php/gwvuxp7hqmdz3jnjkpgz.png',
        role VARCHAR(15) DEFAULT 'normal',
        updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        UNIQUE (phoneNumber)
        );";

    if ($conn->query($sql) === TRUE) {

        echo "<br>users tables created successfully";
    }
} catch (\Throwable $th) {
    echo $th;
}

try {
    $sql = "CREATE TABLE bills (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        userId INT(6) UNSIGNED NOT NULl,
        userName  VARCHAR(100) NOT NULL,
        phoneNumber VARCHAR(100) NOT NULL,
        address VARCHAR(100) NOT NULL,
        discount INT NOT NULL default 0,
        status VARCHAR(50) NOT NULL default 'pending',
        total INT NOT NULL default 0,
        createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
       
        );";

    if ($conn->query($sql) === TRUE) {

        echo "<br>bills tables created successfully";
    }
} catch (\Throwable $th) {
    echo $th;
}

try {
    $sql = "CREATE TABLE billItems (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        billId INT(6) unsigned not null,
        shoeId INT(6) NOT NULL,
        price INT NOT NULL,
        quantity INT NOT NULL,
        updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (billId)
        REFERENCES bills (id)
        ON DELETE CASCADE
        );";

    if ($conn->query($sql) === TRUE) {

        echo "<br>billitems tables created successfully";
    }
} catch (\Throwable $th) {
    echo $th;
}


try {
    $sql = "INSERT INTO `users` (`id`, `name`, `email`, `phoneNumber`, `address`, `password`, `avatar`, `role`) VALUES (NULL, 'admin', 'admin@gmail.com', '0000000000', 'Database', '12345678', NULL, 'admin')";

    if ($conn->query($sql) === TRUE) {

        echo "<br>Admin account created!";
    }
} catch (\Throwable $th) {
    echo $th;
}
