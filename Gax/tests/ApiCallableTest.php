<?php
use Google\GAX\ApiCallable;

class ApiCallableTest extends PHPUnit_Framework_TestCase {
    // TODO(shinfan): Replace with a real test.
    public function test() {
        $callable = new ApiCallable();
        $this->assertEquals("1", "1");
    }
}