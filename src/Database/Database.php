<?php

namespace Flip\Database;

use \PDO;

class Database
{
    private static $instance = null;
    private $connection;

    private function __construct() {}

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self;
        }
 
        return self::$instance;
    }

    public function setConnection(AdapterInterface $connection) : self
    {
        $this->connection = $connection;
        return $this;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function connect() : void
    {
        $this->connection = $this->connection->connect();
    }
    
    public function raw(string $sql, array $valueMappings = [])
    {
        $prepared = $this->connection->prepare($sql);
        $prepared->execute($valueMappings);
    }

    public function rawWithTransaction(string $sql, array $valueMappings)
    {
        $this->connection->beginTransaction();
        $this->rawQuery($sql, $valueMappings);
        $this->connection->commit();
    }
}