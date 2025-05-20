<?php

use Google\Protobuf\RepeatedField;
use Google\Protobuf\Internal;

require __DIR__ . '/../vendor/autoload.php';

// Fix issue where PHPStan does not respect aliases
if (!class_exists(Internal\RepeatedField::class)) {
    class_alias(RepeatedField::class, Internal\RepeatedField::class);
}
