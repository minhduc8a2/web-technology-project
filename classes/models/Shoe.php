<?php

namespace Classes\Models;

require dirname(__DIR__, 2) . '/vendor/autoload.php';


use Classes\Models\DatabaseConnector as DatabaseConnector;
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
        $this->price = htmlspecialchars($row['price']);
        $this->instock = htmlspecialchars($row['instock']);
        $this->sold = htmlspecialchars($row['sold']);
    }
    public static function getAll()
    {
        $database = new DatabaseConnector();
        $sql = $database->getAll('shoes');
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
}
