<?php

//shoes table
try {
    $sql = $database->queryNotExecuted("CREATE TABLE shoes (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(200) NOT NULL,
        category VARCHAR(100) NOT NULL,
        description VARCHAR(1000) NOT NULL,
        updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        price INT UNSIGNED NOT NULL,
        instock INT UNSIGNED NOT NULL,
        sold INT UNSIGNED NOT NULL,
        imageurl  VARCHAR(500) NOT NULL
        
        );");

    if ($sql->execute() === TRUE) {

        echo "<br>shoes created successfully";
    }
} catch (\Throwable $th) {
    echo $th;
}
// categories table
try {
    $sql = $database->queryNotExecuted("CREATE TABLE categories (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(200) NOT NULL,
        updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );");

    if ($sql->execute() === TRUE) {

        echo "<br>categories created successfully";
    } else echo "<br>failed to create categories";
} catch (\Throwable $th) {
    echo $th;
}

// users table
try {
    $sql = $database->queryNotExecuted("CREATE TABLE users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL ,
        phoneNumber VARCHAR(20) NOT NULL,
        address VARCHAR(200) NOT NULL,
        password VARCHAR(100) NOT NULL,
        avatar VARCHAR(200) ,
        role VARCHAR(10) DEFAULT 'normal' NOT NULL,
        updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        UNIQUE (phoneNumber, email)
        );");

    if ($sql->execute() === TRUE) {

        echo "<br>users tables created successfully";
    } else echo "<br>failed to create users";
} catch (\Throwable $th) {
    echo $th;
}

// cartitem table
try {
    $sql = $database->queryNotExecuted("CREATE TABLE cartItems (
       
        userId INT(6) UNSIGNED,
        shoeId INT(6) UNSIGNED,
        PRIMARY KEY (userid, shoeId),
        quantity INT UNSIGNED DEFAULT 1,
        CONSTRAINT FK_cartItems_users foreign key (userId) references users(id) on delete cascade,
        CONSTRAINT FK_cartItems_shoes foreign key (shoeId) references shoes(id) on delete cascade,
        updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );");

    if ($sql->execute() === TRUE) {

        echo "<br>cartItem tables created successfully";
    } else echo "<br>failed to create cartItem";
} catch (\Throwable $th) {
    echo $th;
}


try {
    $sql = $database->queryNotExecuted("CREATE TABLE bills (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        userId INT(6) UNSIGNED NOT NULl,
        userName  VARCHAR(100) NOT NULL,
        phoneNumber VARCHAR(100) NOT NULL,
        address VARCHAR(100) NOT NULL,
        discount INT NOT NULL default 0,
        status VARCHAR(50) NOT NULL default 'pending',
        total INT NOT NULL default 0,
        CONSTRAINT FK_bills_users foreign key (userId) references users(id) on delete cascade,

        createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        
        );");

    if ($sql->execute() === TRUE) {

        echo "<br>bills tables created successfully";
    } else echo "<br>failed to create bills";
} catch (\Throwable $th) {
    echo $th;
}

try {
    $sql = $database->queryNotExecuted("CREATE TABLE billItems (
        billId INT(6) unsigned not null,
        shoeId INT(6) unsigned NOT NULL,
        PRIMARY KEY (billId, shoeId),
        price INT NOT NULL,
        quantity INT NOT NULL,
        updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        CONSTRAINT FK_billItems_bills foreign key (billId) references bills(id) on delete cascade,
        CONSTRAINT FK_billItems_shoes foreign key (shoeId) references shoes(id) 
        );");

    if ($sql->execute() === TRUE) {

        echo "<br>billitems tables created successfully";
    } else echo "<br>failed to create billItems";
} catch (\Throwable $th) {
    echo $th;
}


try {
    $sql = $database->queryNotExecuted("INSERT INTO `users` (`id`, `name`, `email`, `phoneNumber`, `address`, `password`, `avatar`, `role`) VALUES (NULL, 'admin', 'admin@gmail.com', '0000000000', 'Database', '12345678', NULL, 'admin') ;");

    if ($sql->execute() === TRUE) {

        echo "<br>Admin account created!";
    } else echo "<br>failed to insert admin";
} catch (\Throwable $th) {
    echo $th;
}
