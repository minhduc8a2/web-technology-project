<?php
require_once dirname(__DIR__, 1) . '/connect_db.php';
try {
    $sql = "
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
    
    ";

    if ($conn->query($sql) === TRUE) {

        echo "<br>trigger auto decrease quantity on instock created successfully";
    }
} catch (\Throwable $th) {
    echo $th;
}

try {
    $sql = "
    CREATE TRIGGER auto_create_category 
    AFTER INSERT ON shoes
    FOR EACH ROW 
    BEGIN
        IF NOT EXISTS ( SELECT * FROM categories where name = NEW.category) then
            INSERT INTO categories (name) values (NEW.category);
        end if;
    END;
    ";

    if ($conn->query($sql) === TRUE) {

        echo "<br>trigger auto create category  created successfully";
    }
} catch (\Throwable $th) {
    echo $th;
}
try {
    $sql = "
    CREATE TRIGGER auto_create_category_on_update
    AFTER UPDATE ON shoes
    FOR EACH ROW 
    BEGIN
        IF NOT EXISTS ( SELECT * FROM categories where name = NEW.category) then
            INSERT INTO categories (name) values (NEW.category);
        end if;
    END;
    
    ";

    if ($conn->query($sql) === TRUE) {

        echo "<br>trigger auto create category on update  created successfully";
    }
} catch (\Throwable $th) {
    echo $th;
}
try {
    $sql = "
    CREATE TRIGGER auto_delete_category_on_delete
    AFTER DELETE ON shoes
    FOR EACH ROW 
    BEGIN
        IF NOT EXISTS ( SELECT * FROM shoes where OLD.category = shoes.category) then
            delete from categories where categories.name = OLD.category;
        end if;
    END;
    
    ";

    if ($conn->query($sql) === TRUE) {

        echo "<br>trigger auto delete category  created successfully";
    }
} catch (\Throwable $th) {
    echo $th;
}

try {
    $sql = "
    CREATE TRIGGER auto_delete_category_on_update
    AFTER UPDATE ON shoes
    FOR EACH ROW 
    BEGIN
        IF NOT EXISTS ( SELECT * FROM shoes where OLD.category = shoes.category) then
            delete from categories where categories.name = OLD.category;
        end if;
    END;
    
    ";

    if ($conn->query($sql) === TRUE) {

        echo "<br>trigger auto delete category on update shoes created successfully";
    }
} catch (\Throwable $th) {
    echo $th;
}

try {
    $sql = "
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
    
    ";

    if ($conn->query($sql) === TRUE) {

        echo "<br>auto_update_quantity_shoes_on_update_bill_status  created successfully";
    }
} catch (\Throwable $th) {
    echo $th;
}
