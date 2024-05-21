<?php

use DG\BypassFinals;

// Make sure that while testing we bypass the `final` keyword for the GAPIC client.
BypassFinals::setWhitelist([
    '*/src/V2/Client/*',
]);

BypassFinals::enable();

include_once(__DIR__ . '/../../vendor/google/cloud-core/snippet-bootstrap.php');