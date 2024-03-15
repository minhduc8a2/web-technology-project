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
        $this->id =  intval($row['id']);
        $this->userId = isset($row['userId']) ? htmlspecialchars($row['userId']) : '';
        $this->userName = isset($row['userName']) ? htmlspecialchars($row['userName']) : '';
        $this->phoneNumber = isset($row['phoneNumber']) ? htmlspecialchars($row['phoneNumber']) : '';
        $this->address = isset($row['address']) ? htmlspecialchars($row['address']) : '';
        $this->discount = isset($row['discount']) ? intval(htmlspecialchars($row['discount'])) : 0;
        $this->status = isset($row['status']) ? htmlspecialchars($row['status']) : 0;
        $this->total = isset($row['total']) ? htmlspecialchars($row['total']) : 0;
        $this->createdAt = isset($row['createdAt']) ? htmlspecialchars($row['createdAt']) : 0;
        $this->updatedAt = isset($row['updatedAt']) ? htmlspecialchars($row['updatedAt']) : 0;
    }
    public static function getAll()
    {
        $database = new DatabaseConnector();
        $sql = $database->getQuery('select* from bills');
        $tempList = [];
        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            array_push($tempList, new Shoe($row));
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
        return $sql->execute();
    }
    public static function cancel($id)
    {

        Bill::changeStatus($id, 'cancelled');
    }

    public static function delete($id)
    {
        $database = new DatabaseConnector();

        $sql = $database->queryNotExecuted("delete from bills where id = ?", [$id]);
        return $sql->execute();
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
