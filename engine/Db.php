<?php

namespace app\engine;



class Db {

    private $config;
    private $connection = null; //PDO объект

    public function __construct($driver, $host,$port, $login, $password, $database, $charset = "utf8") {
        $this->config = [
            'driver' => $driver,
            'host' => $host,
            'port' => $port,
            'login' => $login,
            'password' => $password,
            'database' => $database,
            'charset' => $charset
        ];
    }

    private function getConnection() {
        if (is_null($this->connection)) {
            $this->connection = new \PDO(
                $this->prepareDsnString(),
                $this->config['login'],
                $this->config['password']);
            $this->connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        }
        return $this->connection;
    }

    private function prepareDsnString() {
        $dsn = sprintf("%s:host=%s;port=%s;dbname=%s",
            $this->config['driver'],
            $this->config['host'],
            $this->config['port'],
            $this->config['database']);
        if ($this->config['driver'] == "mysql"){
            $dsn = $dsn . ";charset={$this->config['charset']}";
        }
        return $dsn;
    }

    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }

    private function query($sql, $params) {
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function queryLimit($sql, $limit) {
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function queryOneObject($sql, $params, $class) {
        $stmt = $this->query($sql, $params);
        $stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $class);
        return $stmt->fetch();
    }

    public function queryOne($sql, $params = []) {
        return $this->query($sql, $params)->fetch();
    }

    public function queryAll($sql, $params = []) {
        return $this->query($sql, $params)->fetchAll();
    }

    public function execute($sql, $params = []) {
        return $this->query($sql, $params)->rowCount();
    }

}