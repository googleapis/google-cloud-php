<?php

include __DIR__ . '/../../../../vendor/autoload.php';
include __DIR__ . '/forked-process-test.php';

use Google\Cloud\Spanner\Database;
use Google\Cloud\Tests\System\Spanner\SpannerTestCase;

list ($dbName, $tableName, $id) = getInputArgs();

$db1 = SpannerTestCase::getDatabaseInstance($dbName);
$db2 = SpannerTestCase::getDatabaseInstance($dbName);

$delay = 50000;

if ($childPID1 = pcntl_fork()) {
    usleep(1 * $delay);

    $iteration = 0;
    $db1->runTransaction(function ($t) use ($id, $tableName, $delay, &$iteration) {
        $iteration++;
        $row = $t->execute('SELECT id, number FROM '. $tableName .' WHERE ID = @id', [
            'parameters' => ['id' => (int) $id]
        ])->rows()->current();

        if ($iteration === 0) {
            usleep(3 * $delay);
        }

        $row['number'] = $row['number'] + 1;
        $t->update($tableName, $row);
        $t->commit();
    });

    echo $iteration;
    pcntl_waitpid($childPID1, $status1);
} else {
    usleep(1 * $delay);

    $db2->runTransaction(function ($t) use ($id, $tableName) {
        $row = $t->execute('SELECT id, number FROM '. $tableName .' WHERE ID = @id', [
            'parameters' => ['id' => (int) $id]
        ])->rows()->current();

        $row['number'] = $row['number'] + 1;
        $t->update($tableName, $row);
        $t->commit();
    });

    exit(0);
}

exit(0);
