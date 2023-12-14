<?php

include __DIR__ . '/../../../../vendor/autoload.php';
include __DIR__ . '/forked-process-test.php';

use Google\Cloud\Core\Exception\AbortedException;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Spanner\Tests\System\SpannerTestCase;

list ($dbName, $tableName, $id) = getInputArgs();
$delay = 2000;

if ($childPID1 = pcntl_fork()) {
    usleep($delay);
    $iteration = 0;
    TestHelpers::SystemBootstrap();
    SpannerTestCase::setUpBeforeClass();
    $db1 = SpannerTestCase::getDatabaseInstance($dbName);
    $db1->runTransaction(function ($t) use ($id, $tableName, $delay, &$iteration) {
        $iteration++;
        $row = $t->execute('SELECT id, number FROM ' . $tableName . ' WHERE ID = @id', [
            'parameters' => ['id' => (int) $id]
        ])->rows()->current();

        if ($iteration < 2) {
            throw new AbortedException('foo', 409, null, [
                [
                    'retryDelay' => [
                        'seconds' => 1,
                        'nanos' => 0
                    ]
                ]
            ]);
        }

        $row['number'] += 1;
        $t->update($tableName, $row);
        $t->commit();
    });

    echo $iteration;
    pcntl_waitpid($childPID1, $status1);
} else {
    usleep($delay);
    TestHelpers::SystemBootstrap();
    SpannerTestCase::setUpBeforeClass();
    $db2 = SpannerTestCase::getDatabaseInstance($dbName);
    $db2->runTransaction(function ($t) use ($id, $tableName) {
        $row = $t->execute('SELECT id, number FROM ' . $tableName . ' WHERE ID = @id', [
            'parameters' => ['id' => (int) $id]
        ])->rows()->current();

        $row['number'] += 1;
        $t->update($tableName, $row);
        $t->commit();
    });

    exit(0);
}

exit(0);
