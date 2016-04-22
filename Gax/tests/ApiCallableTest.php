<?php
/*
 * Copyright 2016, Google Inc.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are
 * met:
 *
 *     * Redistributions of source code must retain the above copyright
 * notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above
 * copyright notice, this list of conditions and the following disclaimer
 * in the documentation and/or other materials provided with the
 * distribution.
 *     * Neither the name of Google Inc. nor the names of its
 * contributors may be used to endorse or promote products derived from
 * this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

use Google\GAX\ApiCallable;
use Google\GAX\RetrySettings;
use Google\GAX\BackoffSettings;

class ApiCallableTest extends PHPUnit_Framework_TestCase
{
    public function testBaseCall()
    {
        $isInvoked = false;
        $request = "request";
        $metadata = array();
        $options = array();
        $callable = function ($actualParam1, $actualParam2, $actualParam3)
            use ($request, $metadata, $options, &$isInvoked) {
            $this->assertEquals($actualParam1, $request);
            $this->assertEquals($actualParam2, $metadata);
            $isInvoked = true;
            return new MockGrpcCall(null);
        };
        $apiCall = ApiCallable::createApiCall($callable, 1000);
        $apiCall($request, $metadata, $options);
        $this->assertTrue($isInvoked);
    }

    public function testBaseCallResponse()
    {
        $isInvoked = false;
        $response = array("response", "status");
        $callable = function ($actualParam1, $actualParam2, $actualParam3)
            use ($response, &$isInvoked){
            $isInvoked = true;
            return new MockGrpcCall($response);
        };
        $apiCall = ApiCallable::createApiCall($callable, 1000);
        $actualResponse = $apiCall("request", array(), array());
        $this->assertEquals($response, $actualResponse);
        $this->assertTrue($isInvoked);
    }

    public function testTimeout()
    {
        $isInvoked = false;
        $timeout = 1500;
        $callable = function ($request, $metadata, $options) use ($timeout, &$isInvoked) {
            $this->assertTrue(array_key_exists('timeout', $options));
            $this->assertEquals($options['timeout'], $timeout);
            $isInvoked = true;
            return new MockGrpcCall(null);
        };
        $apiCall = ApiCallable::createApiCall($callable, $timeout);

        $metadata = array();
        $options = array();
        $apiCall("request", $metadata, $options);
        $this->assertTrue($isInvoked);
    }

    public function testRetryNoRetryableCode()
    {
        $callCount = 0;
        $isExceptionRaised = false;
        $callable = function ($request, $metadata, $options)
            use (&$callCount) {
            $callCount += 1;
            return new MockGrpcCall(array("response",
                new MockStatus(Grpc\STATUS_DEADLINE_EXCEEDED)));
        };
        $backoffSettings = new BackoffSettings(array(
            'initialRetryDelayMillis' => 100,
            'retryDelayMultiplier' => 1.3,
            'maxRetryDelayMillis' => 400,
            'initialRpcTimeoutMillis' => 150,
            'rpcTimeoutMultiplier' => 2,
            'maxRpcTimeoutMillis' => 600,
            'totalTimeoutMillis' => 2000
        ));
        $retrySettings = new RetrySettings(
            array(),
            $backoffSettings);
        try {
            $apiCall = ApiCallable::createRetryableApiCall($callable, $retrySettings);
            list($response, $status) = $apiCall("request", array(), array());
        } catch (\Exception $e) {
            $isExceptionRaised = true;
        }
        $this->assertEquals($callCount, 1);
        $this->assertTrue($isExceptionRaised);
    }

    public function testBackoffSettingsMissingFields()
    {
        $isExceptionRaised = false;
        try {
            $backoffSettings = new BackoffSettings(array(
                'initialRetryDelayMillis' => 100,
                'retryDelayMultiplier' => 1.3,
                'initialRpcTimeoutMillis' => 150,
                'rpcTimeoutMultiplier' => 2,
                'maxRpcTimeoutMillis' => 600,
                'totalTimeoutMillis' => 2000
            ));
        } catch (\Exception $e) {
            $isExceptionRaised = true;
        }
        $this->assertTrue($isExceptionRaised);
    }

    public function testRetryBackoff()
    {
        $callCount = 0;
        $isFirstTryInvoked = false;
        $isSecondTryInvoked = false;
        $responseA = "requestA";
        $responseB = "requestB";
        $responseC = "requestC";
        $callable = function ($request, $metadata, $options)
            use (&$callCount, $responseA, $responseB, $responseC,
                &$isFirstTryInvoked, &$isSecondTryInvoked) {
            $callCount += 1;
            if ($callCount == 1) {
                // First try
                $this->assertTrue(array_key_exists('timeout', $options));
                $this->assertEquals(150, $options['timeout']);
                $isFirstTryInvoked = true;
                return new MockGrpcCall(array($responseA,
                                        new MockStatus(Grpc\STATUS_DEADLINE_EXCEEDED)));
            } else if ($callCount == 2) {
                // Second try
                $this->assertTrue(array_key_exists('timeout', $options));
                $this->assertEquals(300, $options['timeout']);
                $isSecondTryInvoked = true;
                return new MockGrpcCall(array($responseB,
                                        new MockStatus(Grpc\STATUS_DEADLINE_EXCEEDED)));
            } else if ($callCount == 3) {
                // Second try
                $this->assertTrue(array_key_exists('timeout', $options));
                $this->assertEquals(500, $options['timeout']);
                $isSecondTryInvoked = true;
                return new MockGrpcCall(array($responseC,
                                        new MockStatus(Grpc\STATUS_OK)));
            }
        };
        $backoffSettings = new BackoffSettings(array(
            'initialRetryDelayMillis' => 100,
            'retryDelayMultiplier' => 1.3,
            'maxRetryDelayMillis' => 400,
            'initialRpcTimeoutMillis' => 150,
            'rpcTimeoutMultiplier' => 2,
            'maxRpcTimeoutMillis' => 500,
            'totalTimeoutMillis' => 2000
        ));
        $retrySettings = new RetrySettings(
            array(Grpc\STATUS_DEADLINE_EXCEEDED),
            $backoffSettings);
        $apiCall = ApiCallable::createRetryableApiCall($callable, $retrySettings);
        list($response, $status) = $apiCall("request", array(), array());
        $this->assertEquals($responseC, $response);
        $this->assertEquals($callCount, 3);
        $this->assertTrue($isFirstTryInvoked);
        $this->assertTrue($isSecondTryInvoked);
    }

    public function testRetryTimeoutExceeds()
    {
        $callCount = 0;
        $isExceptionRaised = false;
        $isFirstTryInvoked = false;
        $isSecondTryInvoked = false;
        $callable = function ($request, $metadata, $options)
            use (&$callCount) {
            $callCount += 1;
            return new MockGrpcCall(array("response",
                new MockStatus(Grpc\STATUS_DEADLINE_EXCEEDED)));
        };
        $backoffSettings = new BackoffSettings(array(
            'initialRetryDelayMillis' => 1000,
            'retryDelayMultiplier' => 1.3,
            'maxRetryDelayMillis' => 4000,
            'initialRpcTimeoutMillis' => 150,
            'rpcTimeoutMultiplier' => 2,
            'maxRpcTimeoutMillis' => 600,
            'totalTimeoutMillis' => 3000
        ));
        $retrySettings = new RetrySettings(
            array(Grpc\STATUS_DEADLINE_EXCEEDED),
            $backoffSettings);
        try {
            $apiCall = ApiCallable::createRetryableApiCall($callable, $retrySettings);
            list($response, $status) = $apiCall("request", array(), array());
        } catch (\Exception $e) {
            $isExceptionRaised = true;
        }
        $this->assertEquals($callCount, 3);
        $this->assertTrue($isExceptionRaised);
    }
}

class MockGrpcCall
{
    private $response;
    public function __construct($response)
    {
        $this->response = $response;
    }

    public function wait()
    {
        return $this->response;
    }
}

class MockStatus
{
    public $code;
    public function __construct($code)
    {
        $this->code = $code;
    }
}
