<?php

require __DIR__ . '/../../vendor/autoload.php';

if (!getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH')) {
    throw new \Exception(
        'Please set the \'GOOGLE_CLOUD_PHP_TESTS_KEY_PATH\' env var to run the perf tests'
    );
}
