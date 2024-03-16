<?php

namespace Classes\Models;

require dirname(__DIR__, 2) . '/vendor/autoload.php';


use Classes\Models\DatabaseConnector as DatabaseConnector;
use Classes\Others\Utility as Utility;
use \PDO;

class Bill
{
    public $id;
    public $userId;
    public $userName;
    public $phoneNumber;
    public $address;
    public $discount;
    public $status;
    public $total;
    public $createdAt;
    public $updatedAt;
    function __construct($row)
    {
        $this->id = isset($row['id']) ? intval(Utility::standardizeString($row['id'])) : '';
        $this->userId = isset($row['userId']) ? htmlspecialchars(Utility::standardizeString($row['userId'])) : '';
        $this->userName = isset($row['userName']) ? htmlspecialchars(Utility::standardizeString($row['userName'], 'name')) : '';
        $this->phoneNumber = isset($row['phoneNumber']) ? htmlspecialchars(Utility::standardizeString($row['phoneNumber'])) : '';
        $this->address = isset($row['address']) ? htmlspecialchars(trim($row['address'])) : '';
        $this->discount = isset($row['discount']) ? intval(htmlspecialchars(Utility::standardizeString($row['discount']))) : 0;
        $this->status = isset($row['status']) ? htmlspecialchars(Utility::standardizeString($row['status'])) : 0;
        $this->total = isset($row['total']) ? htmlspecialchars(Utility::standardizeString($row['total'])) : 0;
        $this->createdAt = isset($row['createdAt']) ? htmlspecialchars(Utility::standardizeString($row['createdAt'])) : 0;
        $this->updatedAt = isset($row['updatedAt']) ? htmlspecialchars(Utility::standardizeString($row['updatedAt'])) : 0;
    }
    public static function getAll()
    {
        $database = new DatabaseConnector();
        $sql = $database->getQuery('select* from bills');
        $tempList = [];
        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            array_push($tempList, new Bill($row));
        }
        return $tempList;
    }
    public static function getAllForUser(int $userId)
    {
        $database = new DatabaseConnector();
        $sql = $database->getQuery('select* from bills', 'where userId = ?', [$userId]);
        $tempList = [];
        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            array_push($tempList, new Bill($row));
        }
        return $tempList;
    }

    public static function getOne(int $id): Bill|NULL
    {
        $database = new DatabaseConnector();
        $sql = $database->getOne('bills', $id);

        if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            return new Bill($row);
        }
        return NULL;
    }
    public static function deleteOne(int $id)
    {
        $database = new DatabaseConnector();
        return $database->deleteOne('bills', $id);
    }
    public static function getOneForUser(int $id, int $userId): Bill|NULL
    {
        $database = new DatabaseConnector();
        $sql = $database->queryExecuted('select* from bills where id=? and userId=?;', [$id, $userId]);

        if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            return new Bill($row);
        }
        return NULL;
    }
    public static function changeStatus(int $id, string $status)
    {
        $database = new DatabaseConnector();
        $sql = $database->queryNotExecuted('UPDATE bills SET status = ? WHERE id = ?', [$status, $id]);
        try {
            return $sql->execute();
        } catch (\Throwable $th) {
            //throw $th;
        }
        return false;
    }
    public static function cancel($id)
    {

        Bill::changeStatus($id, 'cancelled');
    }
    public static function getCount(string|false $where = false, array $whereParams = [])
    {
        $database = new DatabaseConnector();
        $sql = $database->getQuery('SELECT COUNT(*) as count from bills', $where, $whereParams);
        if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            return $row['count'];
        } else return 0;
    }
    public static function delete($id)
    {
        $database = new DatabaseConnector();

        $sql = $database->queryNotExecuted("delete from bills where id = ?", [$id]);
        try {
            return $sql->execute();
        } catch (\Throwable $th) {
            //throw $th;
        }
        return false;
    }
    public static function create($userId, $userName, $phoneNumber, $address, $total, $mixList)
    {
        $database = new DatabaseConnector();

        $sql = $database->queryNotExecuted("INSERT INTO bills (userId,userName,phoneNumber, address, total) VALUES (?,?,?,?,?);", [$userId, $userName, $phoneNumber, $address, $total]);
        try {
            if ($sql->execute() === TRUE) {
                $bill_id = $database->conn->lastInsertId();

                $length = count($mixList);
                for ($i = 0; $i < $length; $i++) {
                    $shoeId = $mixList[$i]['shoe']->id;
                    $price = $mixList[$i]['shoe']->price;
                    $quantity = $mixList[$i]['quantity'];
                    $sql = $database->queryNotExecuted("INSERT INTO billItems (billId,shoeId,price, quantity) VALUES (?,?,?,?);", [$bill_id, $shoeId, $price, $quantity]);
                    if ($sql->execute() !== TRUE) {
                        Bill::delete($bill_id);
                        return  FALSE; // creating bill is not successful

                    }
                }
                return [TRUE, 'billId' => $bill_id];
            }
        } catch (\Throwable $th) {
        }
        return  FALSE;
    }
    function getFormatTotal()
    {
        return Utility::moneyFormat($this->total);
    }
}
