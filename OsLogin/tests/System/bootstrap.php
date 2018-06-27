<?php

if (file_exists(__DIR__ . '/../../vendor/autoload.php')) {
    require_once __DIR__ . '/../../vendor/autoload.php';
}

use Google\Cloud\Core\Testing\TestHelpers;

TestHelpers::requireKeyfile('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH');
TestHelpers::generatedSystemTestBootstrap();
