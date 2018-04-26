<?php

namespace Google\Cloud\Bigtable\V2\Exception;

class InvalidChunkException extends \RuntimeException
{
    public static function assert($predicate, $message = "")
    {
        if (!$predicate) {
            throw new InvalidChunkException($message);
        };
    }
}
