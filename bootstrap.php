<?php
require 'vendor/autoload.php';

$config = [
    'database' => require(__DIR__ . '/config/database.php')
];

// Database instance
$connection = Flip\Database\Database::getInstance();
$connection->setConnection(new Flip\Database\Adapters\MysqlAdapter(
    $config['database']['host'],
    $config['database']['port'],
    $config['database']['username'],
    $config['database']['password'],
    $config['database']['db_name']
))->connect();