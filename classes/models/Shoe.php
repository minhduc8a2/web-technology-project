<?php

namespace Classes\Models;

require dirname(__DIR__, 2) . '/vendor/autoload.php';


use Classes\Models\DatabaseConnector as DatabaseConnector;
use Classes\Others\Utility as Utility;
use \PDO;

class Shoe
{
    public $id;
    public $name;
    public $category;
    public $description;
    public $imageurl;
    public $price;
    public $instock;
    public $sold;
    function __construct($row)
    {
        $this->id = intval($row['id']);
        $this->name = htmlspecialchars($row['name']);
        $this->category = htmlspecialchars($row['category']);
        $this->description = htmlspecialchars($row['description']);
        $this->imageurl = htmlspecialchars($row['imageurl']);
        $this->price = intval(htmlspecialchars($row['price']));
        $this->instock = htmlspecialchars($row['instock']);
        $this->sold = htmlspecialchars($row['sold']);
    }
    public static function getAll()
    {
        $database = new DatabaseConnector();
        $sql = $database->getQuery('select* from shoes');
        $tempList = [];
        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            array_push($tempList, new Shoe($row));
        }
        return $tempList;
    }

    public static function getOne(int $id): Shoe|NULL
    {
        $database = new DatabaseConnector();
        $sql = $database->getOne('shoes', $id);

        if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            return new Shoe($row);
        }
        return NULL;
    }
    public static function search(string $searchTerm, int $limit = 12, int $offset = 0)
    {

        $database = new DatabaseConnector();
        $sql = $database->search('select * from shoes', ['name', 'category'], $searchTerm, $limit, $offset);
        $tempList = [];
        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            array_push($tempList, new Shoe($row));
        }
        return $tempList;
    }
    public static function getShoesByCategory(int $categoryId, int $limit = 12, int $offset = 0)
    {


        $database = new DatabaseConnector();
        $sql = $database->getQuery('SELECT shoes.id as id, shoes.name as name, price, imageurl, category, description, instock,   sold FROM shoes, categories ', 'WHERE categories.id = ? AND shoes.category = categories.name', [$categoryId], $limit, $offset);
        $tempList = [];
        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            array_push($tempList, new Shoe($row));
        }
        return $tempList;
    }
    public static function getShoesAndQuantityInCart(int $userId, int|bool $limit = false, int|bool $offset = false)
    {


        $database = new DatabaseConnector();
        $sql = $database->getQuery('SELECT shoes.name as name,shoes.id as id, price, imageurl, instock,quantity, description, category, sold  FROM shoes, cartItems', 'where shoes.id=shoeId and userId=?', [$userId], $limit, $offset);
        $tempList = [];
        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            array_push($tempList, ['shoe' => new Shoe($row), 'quantity' => $row['quantity']]);
        }
        return $tempList;
    }
    public static function getShoesCount(string|false $where = false, array $whereParams = [])
    {
        $database = new DatabaseConnector();
        $sql = $database->getQuery('SELECT COUNT(*) as count from shoes', $where, $whereParams);
        if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            return $row['count'];
        } else return 0;
    }
    public  function getArrayForExtraction()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category,
            'description' => $this->description,
            'imageurl' => $this->imageurl,
            'price' => $this->price,
            'instock' => $this->instock,
            'sold' => $this->sold,
        ];
    }


    function getFormatPrice()
    {
        return Utility::moneyFormat($this->price);
    }
}
