<?php

namespace Google\CustomOperation;

use Google\Protobuf\Internal\Message;

class CustomOperation extends Message
{
    private static string $status;
    private static mixed $error;

    public function __construct(
        string $status = 'Yes, it is!',
        mixed $error = null
    ) {
        self::$status = $status;
        self::$error = $error;
    }

    public function isThisOperationDoneOrWhat()
    {
        return self::$status;
    }

    public function getError()
    {
        return self::$error;
    }
}
