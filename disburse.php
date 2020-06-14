<?php
require __DIR__ . '/bootstrap.php';

$limit = 10;
$disbursement = new Flip\Disbursement\Disbursement(
    Flip\Database\Database::getInstance(),
    Flip\Http\Request\Request::getInstance(),
    $limit
);

echo 'Start disbursement' . PHP_EOL;
$disbursement->disburseAll();
echo 'Disbursement complete' . PHP_EOL;

sleep(3);

echo 'Start disbursement status' . PHP_EOL;
$disbursement->checkAndUpdatePending();
echo 'Disbursement status checking complete' . PHP_EOL;
