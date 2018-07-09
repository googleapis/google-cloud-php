<?php

use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Firestore\Tests\System\FirestoreTestCase;

TestHelpers::requireKeyfile('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH');
TestHelpers::generatedSystemTestBootstrap();
TestHelpers::systemTestShutdown(function () {
    FirestoreTestCase::tearDownFixtures();
});
