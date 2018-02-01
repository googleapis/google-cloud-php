<?php

require __DIR__ . '/../../vendor/autoload.php';

use Google\Cloud\Core\Testing\System\SystemTestCase;

if (!getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH')) {
    throw new \Exception(
        'Please set the \'GOOGLE_CLOUD_PHP_TESTS_KEY_PATH\' env var to run the system tests'
    );
}

SystemTestCase::setupQueue();

$pid = getmypid();
register_shutdown_function(function () use ($pid) {
    // Skip flushing deletion queue if exiting a forked process.
    if ($pid !== getmypid()) {
        return;
    }

    // This should always be last.
    SystemTestCase::processQueue();
});
