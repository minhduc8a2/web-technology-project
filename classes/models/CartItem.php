<?php

namespace Classes\Models;

require dirname(__DIR__, 2) . '/vendor/autoload.php';


use Classes\Models\DatabaseConnector as DatabaseConnector;
use Classes\Others\Utility as Utility;

class CartItem
{
    public static function create($shoeId, $userId)
    {

        $database = new DatabaseConnector();

        $sql = $database->queryNotExecuted("call create_cartitem( ? , ? )", [$userId, $shoeId]);
        try {
            return $sql->execute();
        } catch (\Throwable $th) {
            //throw $th;
        }
        return false;
    }

    public static function delete($shoeId, $userId)
    {
        $database = new DatabaseConnector();

        $sql = $database->queryNotExecuted("delete from cartItems WHERE shoeId=? and userId=?", [$shoeId, $userId]);
        try {
            return $sql->execute();
        } catch (\Throwable $th) {
            //throw $th;
        }
        return false;
    }
    public static function updateQuantity($input_quantity, $shoeId, $userId)
    {
        $database = new DatabaseConnector();
        $sql = $database->queryNotExecuted("UPDATE cartItems SET quantity=? WHERE shoeId=? and userId=?", [$input_quantity, $shoeId, $userId]);
        try {
            return $sql->execute();
        } catch (\Throwable $th) {
            //throw $th;
        }
        return false;
    }
}
