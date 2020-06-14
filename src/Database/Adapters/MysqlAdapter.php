<?php

namespace Flip\Database\Adapters;

use \PDO;
use Flip\Database\AdapterAbstract;

class MysqlAdapter extends AdapterAbstract
{
    public function buildDsn() : string
    {
        $format = 'mysql:host=%s:%d;dbname=%s';
        return sprintf(
            $format,
            $this->host,
            $this->port,
            $this->dbName
        );
    }

    public function connect()
    {
        $dsn = $this->buildDsn();
        $connection = new PDO($dsn, $this->username, $this->password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connection;
    }
}