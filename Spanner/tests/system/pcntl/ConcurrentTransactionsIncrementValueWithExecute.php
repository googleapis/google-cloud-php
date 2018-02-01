<?php

include __DIR__ . '/../../../../vendor/autoload.php';
include __DIR__ . '/forked-process-test.php';

use Google\Cloud\Spanner\Database;
use Google\Cloud\Tests\System\Spanner\SpannerTestCase;

list ($dbName, $tableName, $id) = getInputArgs();

$tmpFile = sys_get_temp_dir() . '/ConcurrentTransactionsIncremementValueWithExecute.txt';
setupIterationTracker($tmpFile);

$db1 = SpannerTestCase::getDatabaseInstance($dbName);
$db2 = SpannerTestCase::getDatabaseInstance($dbName);

$callable = function(Database $db, $tableName, $id) use ($tmpFile) {
    $iterations = 0;
    $db->runTransaction(function ($transaction) use ($id, $tableName, &$iterations) {
        $iterations++;

        $row = $transaction->execute('SELECT * FROM '. $tableName .' WHERE id = @id', [
            'parameters' => [
                'id' => (int) $id
            ]
        ])->rows()->current();

        $row['number'] = $row['number']+1;

        $transaction->update($tableName, $row);
        $transaction->commit();
    });

    updateIterationTracker($tmpFile, $iterations);
};

$delay = 50000;
if ($childPID1 = pcntl_fork()) {
    usleep(2 * $delay);

    $callable($db1, $tableName, $id);

    pcntl_waitpid($childPID1, $status1);
} else {
    usleep(2 * $delay);

    $callable($db2, $tableName, $id);

    exit(0);
}

echo file_get_contents($tmpFile);

exit(0);
