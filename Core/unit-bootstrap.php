<?php

use DG\BypassFinals;
use Google\ApiCore\Testing\MessageAwareArrayComparator;
use Google\ApiCore\Testing\ProtobufGPBEmptyComparator;
use Google\ApiCore\Testing\ProtobufMessageComparator;

date_default_timezone_set('UTC');
\SebastianBergmann\Comparator\Factory::getInstance()->register(new MessageAwareArrayComparator());
\SebastianBergmann\Comparator\Factory::getInstance()->register(new ProtobufMessageComparator());
\SebastianBergmann\Comparator\Factory::getInstance()->register(new ProtobufGPBEmptyComparator());

// Make sure that while testing we bypass the `final` keyword for the GAPIC client.
// Only run this if the individual component has the helper package installed
if (class_exists(BypassFinals::class)) {
    BypassFinals::enable();
}
