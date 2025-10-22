<?php

include __DIR__ . '/../../../vendor/autoload.php';
include __DIR__ . '/forked-process-test.php';

use Google\Cloud\Spanner\Tests\System\SystemTestCaseTrait;

list($dbName, $tableName, $id) = getInputArgs();

$tmpFile = sys_get_temp_dir() . '/ConcurrentTransactionsIncremementValueWithExecute.txt';
setupIterationTracker($tmpFile);

$concurrentExecute = new class($dbName, $tableName, $id, $tmpFile) {
    use SystemTestCaseTrait;

    public function __construct(
        string $dbName,
        private string $tableName,
        private int $id,
        private string $tmpFile,
    ) {
        self::$dbName = $dbName;
    }

    public function run(): int
    {
        $iterations = 0;
        $db = self::getDatabaseInstance(self::$dbName);
        if (self::isEmulatorUsed()) {
            // the emulator requires us to manually request a new session
            // presumably because multiplexed sessions aren't properly supported
            $db->session()->refresh();
        }
        $db->runTransaction(function ($transaction) use (&$iterations) {
            $iterations++;

            $row = $transaction->execute('SELECT * FROM ' . $this->tableName . ' WHERE id = @id', [
                'parameters' => [
                    'id' => $this->id,
                ]
            ])->rows()->current();

            $row['number'] += 1;

            $transaction->update($this->tableName, $row);
            $transaction->commit();
        });

        updateIterationTracker($this->tmpFile, $iterations);

        return 0;
    }
};

$delay = 2000;
$retryLimit = 100;
if ($childPID1 = pcntl_fork()) {
    usleep($delay);

    $status = $concurrentExecute->run();

    while (pcntl_waitpid($childPID1, $status1, WNOHANG) == 0 && $retryLimit) {
        usleep(2 * $delay);
        $retryLimit--;
    }

    echo file_get_contents($tmpFile);
    exit($status);
} else {
    usleep(2 * $delay);

    exit($concurrentExecute->run());
}
