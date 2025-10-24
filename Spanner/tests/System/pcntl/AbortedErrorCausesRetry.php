<?php

include __DIR__ . '/../../../vendor/autoload.php';
include __DIR__ . '/forked-process-test.php';

use Google\Cloud\Core\Exception\AbortedException;
use Google\Cloud\Spanner\Tests\System\SystemTestCaseTrait;

list($dbName, $tableName, $id) = getInputArgs();
$delay = 5000;

$abortedErrorRetry = new class($dbName, $tableName, $id, $delay) {
    use SystemTestCaseTrait;

    public function __construct(
        string $dbName,
        private string $tableName,
        private int $id,
        private int $delay,
    ) {
        self::$dbName = $dbName;
    }

    public function run(): int
    {
        if ($childPID1 = pcntl_fork()) {
            usleep($this->delay);
            $iteration = 0;
            $db1 = self::getDatabaseInstance(self::$dbName);
            $db1->runTransaction(function ($t) use (&$iteration) {
                $iteration++;
                usleep(2 * $this->delay);
                $row = $t->execute('SELECT id, number FROM ' . $this->tableName . ' WHERE ID = @id', [
                    'parameters' => ['id' => $this->id]
                ])->rows()->current();

                if ($iteration === 1) {
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
                $t->update($this->tableName, $row);
                $t->commit();
            });

            echo $iteration;
            pcntl_waitpid($childPID1, $status1);
        } else {
            $db2 = self::getDatabaseInstance(self::$dbName);
            $db2->runTransaction(function ($t) {
                $row = $t->execute('SELECT id, number FROM ' . $this->tableName . ' WHERE ID = @id', [
                    'parameters' => ['id' => $this->id]
                ])->rows()->current();

                $row['number'] += 1;
                $t->update($this->tableName, $row);
                $t->commit();
            });
        }

        return 0;
    }
};

exit($abortedErrorRetry->run());
