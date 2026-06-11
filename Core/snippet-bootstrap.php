<?php

use DG\BypassFinals;
use Google\Cloud\Core\Testing\TestHelpers;

TestHelpers::snippetBootstrap();

date_default_timezone_set('UTC');

// Make sure that while testing we bypass the `final` keyword for the GAPIC client.
// Only run this if the individual component has the helper package installed
if (class_exists(BypassFinals::class)) {
    BypassFinals::enable();
}

// Prevent gRPC extension from segfaulting at process shutdown on CI
if (extension_loaded('grpc') && getenv('CI')) {
    register_shutdown_function(function () {
        // Frees up standard buffers and exits immediately, bypassing the extension unload race
        posix_kill(posix_getpid(), SIGKILL);
    });
}

