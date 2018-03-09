<?php

use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Datastore\Tests\System\DatastoreTestCase;

TestHelpers::requireKeyfile('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH');
TestHelpers::systemTestShutdown(function () {
    DatastoreTestCase::tearDownFixtures();
});
