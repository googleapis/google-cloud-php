<?php

require __DIR__ . '/../../vendor/autoload.php';

use Google\Cloud\Tests\System\PubSub\PubSubTestCase;
use Google\Cloud\Tests\System\Datastore\DatastoreTestCase;
use Google\Cloud\Tests\System\Storage\StorageTestCase;
use Google\Cloud\Tests\System\Logging\LoggingTestCase;
use Google\Cloud\Tests\System\BigQuery\BigQueryTestCase;

if (!getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH')) {
    throw new \Exception(
        'Please set the \'GOOGLE_CLOUD_PHP_TESTS_KEY_PATH\' env var to run the system tests'
    );
}

register_shutdown_function(function () {
    PubSubTestCase::tearDownFixtures();
    DatastoreTestCase::tearDownFixtures();
    StorageTestCase::tearDownFixtures();
    LoggingTestCase::tearDownFixtures();
    BigQueryTestCase::tearDownFixtures();
});
