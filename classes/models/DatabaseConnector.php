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
    public function getQueryExecuted($query, $params = [])
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

    public function getQueryNotExecuted($query, $params = [])
    {
        $sql = $this->conn->prepare($query);
        $paramsLength = count($params);
        for ($i = 0; $i < $paramsLength; $i++) {
            $sql->bindParam($i + 1, $params[$i]);
        }
        return $sql;
    }

    public  function getAll(string $table, int|bool $limit = false, int|bool $offset = false, bool|string $orderBy = false, string $isAsc = 'asc')
    {
        $params = [];
        $query = "SELECT * FROM " . $table;

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
        return $this->getQueryExecuted($query, $params);
    }
    public  function getOne(string $table, string $id)
    {
        $query = "SELECT * FROM " . $table . " WHERE id=? ;";
        return $this->getQueryExecuted($query, [$id]);
    }
}
