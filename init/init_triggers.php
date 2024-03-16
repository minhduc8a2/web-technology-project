<?php
try {
    $sql = $database->queryNotExecuted("
    CREATE TRIGGER auto_update_on_shoes_when_create_bill 
    AFTER INSERT ON billItems
    FOR EACH ROW 
    BEGIN
        DECLARE currentQuantity INT;
          
        SELECT instock INTO currentQuantity
        FROM shoes
        WHERE shoes.id = NEW.shoeId;
        IF NEW.quantity < currentQuantity THEN
            UPDATE shoes
            SET shoes.instock = shoes.instock - NEW.quantity
            WHERE shoes.id = NEW.shoeId;
        END IF;
        UPDATE shoes
	    SET shoes.sold = shoes.sold + NEW.quantity
	    WHERE shoes.id = NEW.shoeId;
    END;
    
    ");

    if ($sql->execute() === TRUE) {

        echo "<br>trigger auto decrease quantity on instock created successfully";
    }
} catch (\Throwable $th) {
    echo $th . '<br/>';
}

try {
    $sql = $database->queryNotExecuted("
    CREATE TRIGGER auto_create_category 
    AFTER INSERT ON shoes
    FOR EACH ROW 
    BEGIN
        IF NOT EXISTS ( SELECT * FROM categories where name = NEW.category) then
            INSERT INTO categories (name) values (NEW.category);
        end if;
    END;
    ");

    if ($sql->execute() === TRUE) {

        echo "<br>trigger auto create category  created successfully";
    }
} catch (\Throwable $th) {
    echo $th . '<br/';
}
try {
    $sql = $database->queryNotExecuted("
    DROP TRIGGER IF EXISTS prevent_delete_admin;
    CREATE TRIGGER prevent_delete_admin 
    BEFORE DELETE ON users
    FOR EACH ROW 
    BEGIN
        DECLARE COUNT INT;
        SELECT COUNT(*) INTO COUNT FROM users WHERE role = 'admin';
        IF (COUNT=1 AND OLD.role='admin') then
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Admin must exist';
        end if;
    END;
    ");

    if ($sql->execute() === TRUE) {

        echo "<br>trigger auto create category  created successfully";
    }
} catch (\Throwable $th) {
    echo "<br>trigger auto create category failed";
}
try {
    $sql = $database->queryNotExecuted("
    CREATE PROCEDURE create_cartitem (IN userId INT, IN shoeId INT )
    BEGIN
        IF NOT EXISTS ( SELECT * FROM cartItems where cartItems.userId = userId AND cartItems.shoeId = shoeId) then
            INSERT INTO cartItems (userId, shoeId) values (userId, shoeId);
        end if;
    END;
    ");

    if ($sql->execute() === TRUE) {

        echo "<br>procedure create_cartitem  created successfully";
    }
} catch (\Throwable $th) {
    echo $th . '<br/';
}
try {
    $sql = $database->queryNotExecuted("
    CREATE TRIGGER auto_create_category_on_update
    AFTER UPDATE ON shoes
    FOR EACH ROW 
    BEGIN
        IF NOT EXISTS ( SELECT * FROM categories where name = NEW.category) then
            INSERT INTO categories (name) values (NEW.category);
        end if;
    END;
    
    ");

    if ($sql->execute() === TRUE) {

        echo "<br>trigger auto create category on update  created successfully";
    }
} catch (\Throwable $th) {
    echo $th . '<br/';
}
try {
    $sql = $database->queryNotExecuted("
    CREATE TRIGGER auto_delete_category_on_delete
    AFTER DELETE ON shoes
    FOR EACH ROW 
    BEGIN
        IF NOT EXISTS ( SELECT * FROM shoes where OLD.category = shoes.category) then
            delete from categories where categories.name = OLD.category;
        end if;
    END;
    
    ");

    if ($sql->execute() === TRUE) {

        echo "<br>trigger auto delete category  created successfully";
    }
} catch (\Throwable $th) {
    echo $th . '<br/';
}

try {
    $sql = $database->queryNotExecuted("
    CREATE TRIGGER auto_delete_category_on_update
    AFTER UPDATE ON shoes
    FOR EACH ROW 
    BEGIN
        IF NOT EXISTS ( SELECT * FROM shoes where OLD.category = shoes.category) then
            delete from categories where categories.name = OLD.category;
        end if;
    END;
    
    ");

    if ($sql->execute() === TRUE) {

        echo "<br>trigger auto delete category on update shoes created successfully";
    }
} catch (\Throwable $th) {
    echo $th . '<br/';
}

try {
    $sql = $database->queryNotExecuted("
    CREATE TRIGGER auto_update_quantity_shoes_on_update_bill_status
    BEFORE UPDATE ON bills
    FOR EACH ROW 
    BEGIN
        IF OLD.status != 'cancel' AND NEW.status = 'cancel' THEN
            UPDATE shoes 
            INNER JOIN billItems ON shoes.id = billItems.shoeId
            SET shoes.instock = shoes.instock + billItems.quantity,  shoes.sold = shoes.sold - billItems.quantity
            WHERE billItems.billId = OLD.id;
        ELSEIF OLD.status = 'cancel' AND NEW.status != 'cancel' THEN
            UPDATE shoes 
            INNER JOIN billItems ON shoes.id = billItems.shoeId
            SET shoes.instock = shoes.instock - billItems.quantity, shoes.sold = shoes.sold + billItems.quantity
            WHERE billItems.billId = OLD.id;
        END IF;
    END;
    
    ");

    if ($sql->execute() === TRUE) {

        echo "<br>auto_update_quantity_shoes_on_update_bill_status  created successfully";
    }
} catch (\Throwable $th) {
    echo $th . '<br/';
}
