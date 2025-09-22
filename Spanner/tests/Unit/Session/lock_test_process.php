<?php

use Google\Cloud\Spanner\Session\SessionCache;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * Runs a process which is designed to wait while a session is acquired.
 */
if (count($argv) !== 2) {
    die('Usage: lock_test_process.php DATABASE_NAME' . PHP_EOL);
}

require __DIR__ . '/../../../vendor/autoload.php';
DG\BypassFinals::enable();

class AcquireSession
{
    use ProphecyTrait;

    public function __construct(private string $databaseName)
    {
    }

    public function run(): string
    {
        $sessionCache = new SessionCache(
            $this->prophesize(SpannerClient::class)->reveal(),
            $this->databaseName,
        );

        return $sessionCache->name();
    }

    public function registerFailureType()
    {
    }
}

echo (new AcquireSession($argv[1]))->run();
