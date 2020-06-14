<?php

namespace Flip\Database;

abstract class AdapterAbstract implements AdapterInterface
{
    public function __construct(
        string $host,
        int $port,
        string $username,
        string $password,
        string $dbName
    ) {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->dbName = $dbName;
    }
}