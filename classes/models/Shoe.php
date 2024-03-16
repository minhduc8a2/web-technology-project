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
        $this->id = isset($row['id']) ?  intval(Utility::standardizeString($row['id'])) : '';
        $this->name = isset($row['name']) ? htmlspecialchars(trim($row['name'])) : '';
        $this->category = isset($row['category']) ? htmlspecialchars(trim($row['category'])) : '';
        $this->description = isset($row['description']) ? htmlspecialchars(trim($row['description'])) : '';
        $this->imageurl = isset($row['imageurl']) ? htmlspecialchars(Utility::standardizeString($row['imageurl'])) : '';
        $this->price = isset($row['price']) ? intval(htmlspecialchars(Utility::standardizeString($row['price']))) : 0;
        $this->instock = isset($row['instock']) ? htmlspecialchars(Utility::standardizeString($row['instock'])) : 0;
        $this->sold = isset($row['sold']) ? htmlspecialchars(Utility::standardizeString($row['sold'])) : 0;
    }
    public static function getAll(int|bool $limit = false, int|bool $offset = false)
    {
        $database = new DatabaseConnector();
        $sql = $database->getQuery('select* from shoes', false, [], $limit, $offset);
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
    public static function deleteOne(int $id)
    {
        $database = new DatabaseConnector();
        return $database->deleteOne('shoes', $id);
    }
    public static function create($newShoe)
    {
        $database = new DatabaseConnector();
        $sql = $database->queryNotExecuted("INSERT INTO shoes (name, description,category, price,sold, instock,imageurl)
        VALUES (?,?,?,?,?,?,?) ;", [$newShoe->name, $newShoe->description, $newShoe->category, $newShoe->price, $newShoe->sold, $newShoe->instock, $newShoe->imageurl]);
        try {
            if ($sql->execute()) {
                return true;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

        return false;
    }
    public static function update($shoe)
    {
        $database = new DatabaseConnector();
        $sql = $database->queryNotExecuted("UPDATE shoes SET name=?, description=?,  price=?, category=?, instock = ?, sold = ?, imageurl = ? WHERE id=?;", [$shoe->name, $shoe->description, $shoe->price, $shoe->category, $shoe->instock, $shoe->sold, $shoe->imageurl, $shoe->id]);
        try {
            if ($sql->execute()) {
                return true;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

        return false;
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
    public static function getShoesAndQuantityInOrder(int $userId)
    {
        $database = new DatabaseConnector();
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['shoeList'])) {

            $shoeListId = $_POST['shoeList'];

            $query = "select shoes.name as name,shoes.id as id, price, imageurl, quantity from shoes, cartItems where shoes.id=shoeId and userId=? and (shoes.id = ? ";

            for ($i = 1; $i < count($shoeListId); $i++) {
                $query = $query . " OR shoes.id = ? ";
            }
            $query = $query . ");";
            $sql = $database->queryExecuted($query, [$userId, ...$shoeListId]);
            $tempList = [];
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                array_push($tempList, ['shoe' => new Shoe($row), 'quantity' => $row['quantity']]);
            }
            $_SESSION['mixList'] =   $tempList;
        }
    }
    public static function getShoesByBill(int $billId)
    {
        $database = new DatabaseConnector();

        $sql = $database->queryExecuted("select shoes.id as id, shoes.name as name, billItems.price as price, imageurl, quantity from shoes, billItems where billId = ? and billItems.shoeId = shoes.id ;", [$billId]);
        $tempList = [];
        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            array_push($tempList, ['shoe' => new Shoe($row), 'quantity' => $row['quantity']]);
        }
        return $tempList;
    }
    public static function getCount(string|false $where = false, array $whereParams = [])
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
