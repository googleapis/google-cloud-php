<?php

use Google\Cloud\Core\Testing\TestHelpers;

TestHelpers::requireKeyfile([
    'GOOGLE_CLOUD_PHP_TESTS_KEY_PATH',
    'GOOGLE_CLOUD_PHP_TESTS_WHITELIST_KEY_PATH'
]);
TestHelpers::generatedSystemTestBootstrap();
