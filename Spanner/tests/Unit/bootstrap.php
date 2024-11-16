<?php

use DG\BypassFinals;

// Make sure that while testing we bypass the `final` keyword for the GAPIC client.
BypassFinals::setWhitelist([
    '*/src/Admin/Database/V1/Client/*',
    '*/src/Admin/Instance/V1/Client/*',
    '*/src/V1/Client/*',
]);

BypassFinals::enable();
