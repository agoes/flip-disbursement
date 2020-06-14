<?php
require 'vendor/autoload.php';

$config = [
    'database'  => require(__DIR__ . '/config/database.php'),
    'apis'      => require(__DIR__ . '/config/apis.php')
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

$flipConfig = $config['apis']['flip'];
$httpClient = Flip\Http\Request\Request::getInstance();
$httpClient
    ->setBaseUrl($flipConfig['base_url'])
    ->setAuthentication(
        new Flip\Http\Request\AuthenticationStrategies\BasicAuthenticationStrategy(
            $flipConfig['authentication']['basic']['username'],
            $flipConfig['authentication']['basic']['password']
        )
    );