<?php

include __DIR__ . '/../../../vendor/autoload.php';
include __DIR__ . '/forked-process-test.php';

use Google\Cloud\Spanner\Tests\System\SpannerTestCase;

list ($dbName, $tableName, $id) = getInputArgs();

$tmpFile = sys_get_temp_dir() . '/ConcurrentTransactionsIncremementValueWithExecute.txt';
setupIterationTracker($tmpFile);

$callable = function ($dbName, $tableName, $id) use ($tmpFile) {
    $iterations = 0;
    $db = SpannerTestCase::getDatabaseInstance($dbName);
    $db->runTransaction(function ($transaction) use ($id, $tableName, &$iterations) {
        $iterations++;

        $row = $transaction->execute('SELECT * FROM ' . $tableName . ' WHERE id = @id', [
            'parameters' => [
                'id' => (int) $id
            ]
        ])->rows()->current();

        $row['number'] +=1;

        $transaction->update($tableName, $row);
        $transaction->commit();
    });

    updateIterationTracker($tmpFile, $iterations);
};

$delay = 2000;
$retryLimit = 3;
if ($childPID1 = pcntl_fork()) {
    usleep($delay);

    $callable($dbName, $tableName, $id);

    while (pcntl_waitpid($childPID1, $status1, WNOHANG) == 0 && $retryLimit) {
        usleep(2 * $delay);
        $retryLimit--;
    }
} else {
    usleep(2 * $delay);

    $callable($dbName, $tableName, $id);

    exit(0);
}

echo file_get_contents($tmpFile);

exit(0);
