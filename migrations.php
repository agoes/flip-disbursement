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
    );',

    // alter `disbursement`, add columns : receipt, time_served
    'ALTER TABLE `disbursements`
        ADD COLUMN `receipt` VARCHAR(100),
        ADD COLUMN `time_served` DATETIME
    ;',

    // alter `disbursement`, add columns : vendor_disbursement_id
    'ALTER TABLE `disbursements`
        ADD COLUMN `vendor_disbursement_id` INT(11),
        MODIFY COLUMN `bank_code` VARCHAR(25) NOT NULL;
        ADD UNIQUE KEY `vendor_disbursement_id` (`vendor_disbursement_id`)
    ;',

    // modify column bank_code and add timestamps
    'ALTER TABLE `disbursements`
        MODIFY COLUMN `bank_code` VARCHAR(25) NOT NULL,
        ADD COLUMN `created_at` DATETIME NOT NULL DEFAULT NOW(),
        ADD COLUMN `modified_at` DATETIME NOT NULL DEFAULT NOW()
    ;',

    // modify column vendor_disbursement_id
    'ALTER TABLE `disbursements`
        MODIFY COLUMN `vendor_disbursement_id` VARCHAR(100) NULL
    ;',
];

function migrate(array $migrations, $startFromVersion)
{
    global $db;

    foreach ($migrations as $version => $migration) {
        echo 'Run query ' . $migration . PHP_EOL;
        $db->raw($migration);
        $db->raw('INSERT INTO `migrations` values (?)', [ $version + $startFromVersion ]);
    }
}

echo 'Run migrations' . PHP_EOL;
echo '...' . PHP_EOL;
if ($db->raw('SHOW TABLES LIKE ?', ['migrations'])->fetchColumn()) {
    $checkVersion = $db->raw('SELECT `version` from `migrations` ORDER BY `version` DESC LIMIT 1');
    $latestVersion = $checkVersion->fetchColumn() ?: 0;
    $startFromVersion = $latestVersion + 1;
    $migrations = array_slice($migrations, $startFromVersion);
} else {
    $startFromVersion = 0;
}

migrate($migrations, $startFromVersion);
echo 'Migration complete' . PHP_EOL;