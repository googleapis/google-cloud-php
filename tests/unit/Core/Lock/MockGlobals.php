<?php

namespace Google\Cloud\Core\Lock {
    class MockValues
    {
        public static $flockReturnValue;
        public static $fopenReturnValue;
        public static $sem_acquireReturnValue;
        public static $sem_releaseReturnValue;
        public static $sem_getReturnValue;

        public static function initialize()
        {
            self::$flockReturnValue = true;
            self::$fopenReturnValue = function($file, $mode) {
                return \fopen($file, $mode);
            };
            self::$sem_acquireReturnValue = true;
            self::$sem_releaseReturnValue = true;
            self::$sem_getReturnValue = function($key) {
                return \sem_get($key);
            };
        }
    }

    function flock($handle, $type)
    {
        return MockValues::$flockReturnValue;
    }

    function fopen($file, $mode)
    {
        $val = MockValues::$fopenReturnValue;

        if (is_callable($val)) {
            return $val($file, $mode);
        }

        return $val;
    }

    function sem_acquire($id)
    {
        return MockValues::$sem_acquireReturnValue;
    }

    function sem_release($id)
    {
        return MockValues::$sem_releaseReturnValue;
    }

    function sem_get($key)
    {
        $val = MockValues::$sem_getReturnValue;

        if (is_callable($val)) {
            return $val($key);
        }

        return $val;
    }
}
