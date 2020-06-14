<?php
require __DIR__ . '/bootstrap.php';

$db = Flip\Database\Database::getInstance();

$bankCode = ['bni', 'bca', 'mandiri'];

$db->raw("INSERT INTO `disbursements`
    (`bank_code`, `bank_account_number`, `amount`, `status`)
    VALUES
        ('" . $bankCode[array_rand($bankCode)] . "', '" . rand() . "', '" . rand() . "', 'NEW'),
        ('" . $bankCode[array_rand($bankCode)] . "', '" . rand() . "', '" . rand() . "', 'NEW'),
        ('" . $bankCode[array_rand($bankCode)] . "', '" . rand() . "', '" . rand() . "', 'NEW'),
        ('" . $bankCode[array_rand($bankCode)] . "', '" . rand() . "', '" . rand() . "', 'NEW'),
        ('" . $bankCode[array_rand($bankCode)] . "', '" . rand() . "', '" . rand() . "', 'NEW'),
        ('" . $bankCode[array_rand($bankCode)] . "', '" . rand() . "', '" . rand() . "', 'NEW'),
        ('" . $bankCode[array_rand($bankCode)] . "', '" . rand() . "', '" . rand() . "', 'NEW'),
        ('" . $bankCode[array_rand($bankCode)] . "', '" . rand() . "', '" . rand() . "', 'NEW'),
        ('" . $bankCode[array_rand($bankCode)] . "', '" . rand() . "', '" . rand() . "', 'NEW'),
        ('" . $bankCode[array_rand($bankCode)] . "', '" . rand() . "', '" . rand() . "', 'NEW'),
        ('" . $bankCode[array_rand($bankCode)] . "', '" . rand() . "', '" . rand() . "', 'NEW')
    ;");