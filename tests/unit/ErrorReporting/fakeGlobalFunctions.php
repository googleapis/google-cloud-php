<?php

namespace Google\Cloud\ErrorReporting {
    class MockValues {
        public static $type;
        public static $message;
        public static $file;
        public static $line;
        public static $errorReporting;
        public static $stderr;
    }
    function error_get_last()
    {
        return [
            'type' => MockValues::$type,
            'message' => MockValues::$message,
            'file' => MockValues::$file,
            'line' => MockValues::$line
        ];
    };

    function error_reporting()
    {
        return MockValues::$errorReporting;
    };

    function fwrite($target, $message)
    {
        if ($target != STDERR) {
            throw new \RuntimeException('Only for STDERR');
        }
        MockValues::$stderr = $message;
    };
}
