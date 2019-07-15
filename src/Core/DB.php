<?php
namespace Web\FrontController\Core;


class DB
{
    private $server = 'localhost';
    private $dbName = 'vueexample';
    private $username = 'root';
    private $pwd = '';

    private static $db; // в данном свойстве будем хранить объект DB класса
    private $connection;

    private function __construct()
    {
        $this->connection = new \PDO(
            "mysql:host=$this->server;dbname=$this->dbName;charset=UTF8",
            $this->username, $this->pwd,
            [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
    }

    public static function getDB(){
        if (self::$db == null) self::$db = new DB();
        return self::$db;
    }

    public function getAll($sql){
        $statement = $this->connection->query($sql);
        if (!$statement) return false;
//        $statement->setFetchMode(\PDO::FETCH_CLASS, $class);
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function nonSelectQuery($sql, $params){
        $statement = $this->connection->prepare($sql);
        if (!$statement) return false;
        return $statement->execute($params);
    }

    //получение id добавленной записи при вставке в табличку
    public function insertInfoTable($sql, $params){
        $statement = $this->connection->prepare($sql);
        if (!$statement) return false;
        $statement->execute($params);
        return $this->connection->lastInsertId();
    }

    public function paramsGetAll($sql, $params) {
        $statement = $this->connection->prepare($sql);
        if (!$statement) return false;
        $statement->execute($params);
//        $statement->setFetchMode(\PDO::FETCH_CLASS, $class);
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function paramsGetOne($sql, $params){
        $statement = $this->connection->prepare($sql);
        if (!$statement) return false;
        $statement->execute($params);
//        $statement->setFetchMode(\PDO::FETCH_CLASS, $class);
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }
}