<?php

namespace Google\Cloud\Spanner\Tests\Unit\Session;

use DG\BypassFinals;
use Exception;
use Google\Auth\Cache\FileSystemCacheItemPool;
use Google\Cloud\Spanner\Session\SessionCache;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * Runs a process which is designed to wait while a session is acquired.
 */
if (count($argv) !== 2) {
    die('Usage: lock_test_process.php DATABASE_NAME' . PHP_EOL);
}

$spannerAutoload = __DIR__ . '/../../../vendor/autoload.php';
$googleCloudAutoload = __DIR__ . '/../../../../vendor/autoload.php';

if (file_exists($spannerAutoload) && file_exists($googleCloudAutoload)) {
    throw new Exception('Both autoloaders exist, please remove one');
}

if (file_exists($spannerAutoload)) {
    // google/cloud-spanner autoload
    require $spannerAutoload;
} elseif (file_exists($googleCloudAutoload)) {
    // google/cloud autoload
    require $googleCloudAutoload;
} else {
    throw new Exception('no autoloader found');
}

BypassFinals::enable();

[$_cmd, $databaseName] = $argv;

$acquireSession = new class($databaseName) {
    use ProphecyTrait;

    public function __construct(
        private string $databaseName,
    ) {
    }

    public function run(): string
    {
        $spannerClient = $this->prophesize(SpannerClient::class);
        $spannerClient->createSession(Argument::cetera())
            ->will(function () {
                throw new \Exception('createSession called in child process - this shouldn\'t happen');
            });

        $sessionCache = new SessionCache(
            $spannerClient->reveal(),
            $this->databaseName
        );

        return $sessionCache->name();
    }

    public function registerFailureType()
    {
    }
};

echo $acquireSession->run();
