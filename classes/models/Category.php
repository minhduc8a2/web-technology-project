<?php

namespace Classes\Models;

require dirname(__DIR__, 2) . '/vendor/autoload.php';


use Classes\Models\DatabaseConnector as DatabaseConnector;
use \PDO;

class Category
{
    public $id;
    public $name;

    function __construct($row)
    {
        $this->id = intval($row['id']);
        $this->name = htmlspecialchars($row['name']);
    }
    public static function getAll()
    {
        $database = new DatabaseConnector();
        $sql = $database->getQuery('select* from categories');
        $tempList = [];
        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            array_push($tempList, new Category($row));
        }
        return $tempList;
    }

    public static function getOne(int $id): Category|NULL
    {
        $database = new DatabaseConnector();
        $sql = $database->getOne('categories', $id);

        if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            return new Category($row);
        }
        return NULL;
    }
}
