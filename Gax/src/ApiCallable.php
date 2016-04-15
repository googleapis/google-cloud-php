<?php
namespace Google\GAX;

/**
 * Creates a function wrapper that provides extra functionalities such as retry and bundling.
 */
class ApiCallable {
    public static function createBasicApiCall($callable) {
        $inner = function() use ($callable) {
            call_user_func_array($callable, func_get_args());
        };
        return $inner;
    }
}