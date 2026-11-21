<?php

namespace Google\CustomOperation;

use Google\Protobuf\Internal\Message;

class CustomOperationWithErrorAnnotations extends Message
{
    private static string $status;
    private static ?int $errorCode;
    private static ?string $errorMessage;

    public function __construct(
        string $status = 'Yes, it is!',
        ?int $errorCode = null,
        ?string $errorMessage = null
    ) {
        self::$status = $status;
        self::$errorCode = $errorCode;
        self::$errorMessage = $errorMessage;
    }

    public function isThisOperationDoneOrWhat()
    {
        return self::$status;
    }

    public function getTheErrorCode()
    {
        return self::$errorCode;
    }

    public function getTheErrorMessage()
    {
        return self::$errorMessage;
    }
}
