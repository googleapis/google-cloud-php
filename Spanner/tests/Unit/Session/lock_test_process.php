<?php

namespace Google\Cloud\Spanner\Tests\Unit\Session;

use DG\BypassFinals;
use Google\Cloud\Spanner\Session\SessionCache;
use Google\Cloud\Spanner\V1\Client\SpannerClient;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

/**
 * Runs a process which is designed to wait while a session is acquired.
 */
if (count($argv) !== 2) {
    die('Usage: lock_test_process.php DATABASE_NAME' . PHP_EOL);
}

if (file_exists(__DIR__ . '/../../../vendor/autoload.php')) {
    // google/cloud-spanner autoload
    require __DIR__ . '/../../../vendor/autoload.php';
} elseif (file_exists(__DIR__ . '/../../../../vendor/autoload.php')) {
    // google/cloud autoload
    require __DIR__ . '/../../../../vendor/autoload.php';
}

BypassFinals::enable();

$acquireSession = new class($argv[1]) {
    use ProphecyTrait;

    public function __construct(private string $databaseName)
    {
    }

    public function run(): string
    {
        $spannerClient = $this->prophesize(SpannerClient::class);
        $spannerClient->createSession(Argument::cetera())
            ->will(function () {
                throw new \Exception('createSession called in child process - this shouldn\'t happen');
            });

        $parts = explode('/', $this->databaseName);
        $sessionCache = new SessionCache(
            $spannerClient->reveal(),
            $this->databaseName,
            ['cacheItemPool' => new FilesystemAdapter(array_pop($parts))]
        );

        return $sessionCache->name();
    }

    public function registerFailureType()
    {
    }
};

echo $acquireSession->run();
