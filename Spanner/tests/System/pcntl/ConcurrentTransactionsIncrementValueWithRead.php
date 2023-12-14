<?php

include __DIR__ . '/../../../../vendor/autoload.php';
include __DIR__ . '/forked-process-test.php';

use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Tests\System\SpannerTestCase;

list ($dbName, $tableName, $id) = getInputArgs();

$tmpFile = sys_get_temp_dir() . '/ConcurrentTransactionsIncremementValueWithRead.txt';
setupIterationTracker($tmpFile);

TestHelpers::SystemBootstrap();
SpannerTestCase::setUpBeforeClass();
$db1 = SpannerTestCase::getDatabaseInstance($dbName);
$db2 = SpannerTestCase::getDatabaseInstance($dbName);

$keyset = new KeySet(['keys' => [$id]]);
$columns = ['id','number'];

$callable = function (Database $db, KeySet $keyset, array $columns, $tableName) use ($tmpFile) {
    $iterations = 0;
    $db->runTransaction(function ($transaction) use ($keyset, $columns, $tableName, &$iterations) {
        $iterations++;
        $row = $transaction->read($tableName, $keyset, $columns)->rows()->current();

        $row['number'] +=1;

        $transaction->update($tableName, $row);
        $transaction->commit();
    });

    updateIterationTracker($tmpFile, $iterations);
};

$delay = 5000;
$retryLimit = 3;
if ($childPID1 = pcntl_fork()) {
    usleep($delay);

    $callable($db1, $keyset, $columns, $tableName);

    while (pcntl_waitpid($childPID1, $status1, WNOHANG) == 0 && $retryLimit) {
        usleep(2 * $delay);
        $retryLimit--;
    }
} else {
    usleep($delay);

    $callable($db2, $keyset, $columns, $tableName);

    exit(0);
}

echo file_get_contents($tmpFile);

exit(0);
