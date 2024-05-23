<?php

use Google\Cloud\Core\Testing\TestHelpers;
use DG\BypassFinals;

TestHelpers::snippetBootstrap();

date_default_timezone_set('UTC');

// Make sure that while testing we bypass the `final` keyword for the GAPIC client.
BypassFinals::enable();
