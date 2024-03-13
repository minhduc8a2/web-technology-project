<?php

namespace Classes\Models;

use PDO;

class DatabaseConnector
{
    public $conn = NULL;
    function __construct(
        private $servername = "localhost",
        private $username = "root",
        private $password = "root",
        private $dbname = "webtechdb"
    ) {
        try {
            $conn = new \PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->conn = $conn;
        } catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            exit();
        }
    }
    public function queryExecuted($query, $params = [])
    {
        $sql = $this->conn->prepare($query);
        $paramsLength = count($params);
        for ($i = 0; $i < $paramsLength; $i++) {
            if (gettype($params[$i]) == 'integer') {
                $sql->bindParam($i + 1, $params[$i], PDO::PARAM_INT);
            } else  if (gettype($params[$i]) == 'string') {
                $sql->bindParam($i + 1, $params[$i], PDO::PARAM_STR);
            } else  if (gettype($params[$i]) == 'boolean') {
                $sql->bindParam($i + 1, $params[$i], PDO::PARAM_BOOL);
            }
        }
        $sql->execute();
        return $sql;
    }

    public function queryNotExecuted($query, $params = [])
    {
        $sql = $this->conn->prepare($query);
        $paramsLength = count($params);
        for ($i = 0; $i < $paramsLength; $i++) {
            $sql->bindParam($i + 1, $params[$i]);
        }
        return $sql;
    }

    public  function getQuery(string $select,  string|bool $where = false, array $whereParams = [], int|bool $limit = false, int|bool $offset = false, bool|string $orderBy = false, string $isAsc = 'asc')
    {
        $params = [];
        $query = $select;
        if ($where) {

            $query = $query . ' ' . $where;
            $params = array_merge($params, $whereParams);
        }
        if ($orderBy) {
            array_push($params, $orderBy, $isAsc);
            $query = $query . " order by ? ? ";
        }

        if ($limit) {
            array_push($params, $limit);
            $query = $query . " LIMIT ?";
        }
        if ($offset) {
            array_push($params, $offset);
            $query = $query . " OFFSET ?";
        }
        $query = $query . ";";

        return $this->queryExecuted($query, $params);
    }
    public  function getOne(string $table, string $id)
    {
        $query = "SELECT * FROM " . $table . " WHERE id=? ;";
        return $this->queryExecuted($query, [$id]);
    }

    public  function search(string $select, array $fields, string $searchTerm, int $limit = 12, int $offset = 0)
    {
        $params = [];
        $where = " WHERE " . $fields[0] . " LIKE ? ";
        array_push($params, '%' . $searchTerm . '?');
        $fieldLength = count($fields);
        for ($i = 1; $i < $fieldLength; $i++) {
            $where = $where . " OR " . $fields[$i] . " LIKE ?";
            // $tempParam  = "%" . $searchTerm . "%";
            array_push($params, '%' . $searchTerm . '%');
        }
        return $this->getQuery($select, $where, $params, $limit, $offset);
    }
}
