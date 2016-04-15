<?php
use Google\GAX\ApiCallable;

class ApiCallableTest extends PHPUnit_Framework_TestCase {
    public function testBaseCall() {
        $param1 = "param1";
        $param2 = "param2";
        $callable = function ($actualParam1, $actualParam2) use ($param1, $param2) {
            $this->assertEquals($actualParam1, $param1);
            $this->assertEquals($actualParam2, $param2);
        };
        $apiCall = ApiCallable::createBasicApiCall($callable);
        $apiCall($param1, $param2);
    }
}