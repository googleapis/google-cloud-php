<?php

include __DIR__ . '/../../../../vendor/autoload.php';
include __DIR__ . '/forked-process-test.php';

use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Tests\System\Spanner\SpannerTestCase;

list ($dbName, $tableName, $id) = getInputArgs();

$tmpFile = sys_get_temp_dir() . '/ConcurrentTransactionsIncremementValueWithRead.txt';
setupIterationTracker($tmpFile);

$db1 = SpannerTestCase::getDatabaseInstance($dbName);
$db2 = SpannerTestCase::getDatabaseInstance($dbName);

$keyset = new KeySet(['keys' => [$id]]);
$columns = ['id','number'];

$callable = function(Database $db, KeySet $keyset, array $columns, $tableName) use ($tmpFile) {
    $iterations = 0;
    $db->runTransaction(function ($transaction) use ($keyset, $columns, $tableName, &$iterations) {
        $iterations++;
        $row = $transaction->read($tableName, $keyset, $columns)->rows()->current();

        $row['number'] = $row['number']+1;

        $transaction->update($tableName, $row);
        $transaction->commit();
    });

    updateIterationTracker($tmpFile, $iterations);
};

$delay = 50000;
if ($childPID1 = pcntl_fork()) {
    usleep(2 * $delay);

    $callable($db1, $keyset, $columns, $tableName);

    pcntl_waitpid($childPID1, $status1);
} else {
    usleep(2 * $delay);

    $callable($db2, $keyset, $columns, $tableName);

    exit(0);
}

echo file_get_contents($tmpFile);

exit(0);
