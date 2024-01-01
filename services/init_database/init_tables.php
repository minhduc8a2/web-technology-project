<?php
require dirname(__DIR__, 1) . '\connect_db.php';

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
        avatar VARCHAR(200) DEFAULT 'https://res.cloudinary.com/dqqetbr1m/image/upload/v1704084419/adidas_php/gwvuxp7hqmdz3jnjkpgz.png',
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

        echo "<script>console.log('bills tables created successfully')</script>";
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
        updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        FOREIGN KEY (billId)
        REFERENCES bills (id)
        ON DELETE CASCADE
        );";

    if ($conn->query($sql) === TRUE) {

        echo "<script>console.log('billitems tables created successfully')</script>";
    }
} catch (\Throwable $th) {
    echo $th;
}
try {
    $sql = "DELIMITER $$

    CREATE TRIGGER auto_update_on_shoes_when_create_bill 
    AFTER INSERT ON billItems
    FOR EACH ROW 
    BEGIN
        DECLARE currentQuantity INT;
          -- Fetch the current quantity from shoes
        SELECT instock INTO currentQuantity
        FROM shoes
        WHERE shoes.id = NEW.shoeId;
    
        -- Check if the amount is less than the current quantity
        IF NEW.quantity < currentQuantity THEN
            UPDATE shoes
            SET shoes.instock = shoes.instock - NEW.quantity
            WHERE shoes.id = NEW.shoeId;
        END IF;
        UPDATE shoes
	    SET shoes.sold = shoes.sold + NEW.quantity
	    WHERE shoes.id = NEW.shoeId;
    END$$
    
    DELIMITER ;";

    if ($conn->query($sql) === TRUE) {

        echo "<script>console.log('trigger auto decrease quantity on instock created successfully')</script>";
    }
} catch (\Throwable $th) {
    echo $th;
}

try {
    $sql = "DELIMITER $$

    CREATE TRIGGER auto_create_category 
    AFTER INSERT ON shoes
    FOR EACH ROW 
    BEGIN
        IF NOT EXISTS ( SELECT * FROM categories where name = NEW.category) then
            INSERT INTO categories (name) values (NEW.category);
        end if;
    END$$
    
    DELIMITER ;
    
    DELIMITER $$
    
    CREATE TRIGGER auto_create_category_on_update
    AFTER UPDATE ON shoes
    FOR EACH ROW 
    BEGIN
        IF NOT EXISTS ( SELECT * FROM categories where name = NEW.category) then
            INSERT INTO categories (name) values (NEW.category);
        end if;
    END$$
    
    DELIMITER ;";

    if ($conn->query($sql) === TRUE) {

        echo "<script>console.log('trigger auto create category  created successfully')</script>";
    }
} catch (\Throwable $th) {
    echo $th;
}

try {
    $sql = "DELIMITER $$

    CREATE TRIGGER auto_delete_category_on_delete
    AFTER DELETE ON shoes
    FOR EACH ROW 
    BEGIN
        IF NOT EXISTS ( SELECT * FROM shoes where OLD.category = shoes.category) then
            delete from categories where categories.name = OLD.category;
        end if;
    END$$
    
    DELIMITER ;";

    if ($conn->query($sql) === TRUE) {

        echo "<script>console.log('trigger auto delete category  created successfully')</script>";
    }
} catch (\Throwable $th) {
    echo $th;
}
