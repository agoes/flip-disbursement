<?php
require __DIR__ . '/bootstrap.php';

$db = Flip\Database\Database::getInstance();

$migrations = [
    // create `migrations` table
    'CREATE TABLE IF NOT EXISTS `migrations` (
        `version` CHAR(14) NOT NULL,
        UNIQUE KEY `version` (`version`)
    );',

    // create `disbursement` table
    'CREATE TABLE IF NOT EXISTS `disbursements` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `bank_code` VARCHAR(5) NOT NULL,
        `bank_account_number` VARCHAR(25) NOT NULL,
        `amount` DECIMAL(15) NOT NULL,
        `status` VARCHAR(15) NOT NULL,
        PRIMARY KEY (`id`)
    );'
];

/**
 * TODO
 * 
 * - Check migrations table existance
 * - Get latest version of migrations and slice migrations array to the latest / new migrations
 */

foreach ($migrations as $version => $migration) {
    $db->raw($migration);
    $db->raw('INSERT INTO `migrations` values (?)', [ $version ]);
}