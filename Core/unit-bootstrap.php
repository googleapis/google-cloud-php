<?php

use Google\ApiCore\Testing\MessageAwareArrayComparator;
use Google\ApiCore\Testing\ProtobufMessageComparator;
use Google\ApiCore\Testing\ProtobufGPBEmptyComparator;
use DG\BypassFinals;

date_default_timezone_set('UTC');
\SebastianBergmann\Comparator\Factory::getInstance()->register(new MessageAwareArrayComparator());
\SebastianBergmann\Comparator\Factory::getInstance()->register(new ProtobufMessageComparator());
\SebastianBergmann\Comparator\Factory::getInstance()->register(new ProtobufGPBEmptyComparator());

// Make sure that while testing we bypass the `final` keyword for the GAPIC client.
BypassFinals::enable();
