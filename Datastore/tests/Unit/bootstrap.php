<?php

use DG\BypassFinals;

BypassFinals::allowPaths([
    '*/src/V1/Client/*',
]);

BypassFinals::enable(true);
