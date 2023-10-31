<?php
/*
 * Copyright 2018 Google LLC
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

namespace Google\ApiCore\Tests\Unit\Middleware;

use Google\ApiCore\ApiException;
use Google\ApiCore\ApiStatus;
use Google\ApiCore\Call;
use Google\ApiCore\Middleware\RetryMiddleware;
use Google\ApiCore\RetrySettings;
use Google\Rpc\Code;
use GuzzleHttp\Promise\Promise;
use PHPUnit\Framework\TestCase;
use function usleep;

class RetryMiddlewareTest extends TestCase
{
    public function testRetryNoRetryableCode()
    {
        $call = $this->getMockBuilder(Call::class)
            ->disableOriginalConstructor()
            ->getMock();
        $retrySettings = RetrySettings::constructDefault()
            ->with([
                'retriesEnabled' => false,
                'retryableCodes' => []
            ]);
        $callCount = 0;
        $handler = function(Call $call, $options) use (&$callCount) {
            return new Promise(function () use (&$callCount) {
                throw new ApiException('Call Count: ' . $callCount += 1, 0, '');
            });
        };
        $middleware = new RetryMiddleware($handler, $retrySettings);

        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Call Count: 1');

        $middleware($call, [])->wait();
    }

    public function testRetryBackoff()
    {
        $call = $this->getMockBuilder(Call::class)
            ->disableOriginalConstructor()
            ->getMock();
        $retrySettings = RetrySettings::constructDefault()
            ->with([
                'retriesEnabled' => true,
                'retryableCodes' => [ApiStatus::CANCELLED],
            ]);
        $callCount = 0;
        $handler = function(Call $call, $options) use (&$callCount) {
            $callCount += 1;
            return $promise = new Promise(function () use (&$promise, $callCount) {
                if ($callCount < 3) {
                    throw new ApiException('Cancelled!', Code::CANCELLED, ApiStatus::CANCELLED);
                }
                $promise->resolve('Ok!');
            });
        };
        $middleware = new RetryMiddleware($handler, $retrySettings);
        $response = $middleware(
            $call,
            []
        )->wait();

        $this->assertSame('Ok!', $response);
        $this->assertEquals(3, $callCount);
    }

    public function testRetryTimeoutExceedsMaxTimeout()
    {
        $call = $this->getMockBuilder(Call::class)
            ->disableOriginalConstructor()
            ->getMock();
        $retrySettings = RetrySettings::constructDefault()
            ->with([
                'retriesEnabled' => true,
                'retryableCodes' => [ApiStatus::CANCELLED],
                'totalTimeoutMillis' => 0,
            ]);
        $handler = function(Call $call, $options) {
            return new Promise(function () {
                throw new ApiException('Cancelled!', Code::CANCELLED, ApiStatus::CANCELLED);
            });
        };
        $middleware = new RetryMiddleware($handler, $retrySettings);

        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Retry total timeout exceeded.');

        $middleware($call, [])->wait();
    }

    public function testRetryTimeoutExceedsRealTime()
    {
        $call = $this->getMockBuilder(Call::class)
            ->disableOriginalConstructor()
            ->getMock();
        $retrySettings = RetrySettings::constructDefault()
            ->with([
                'retriesEnabled' => true,
                'retryableCodes' => [ApiStatus::CANCELLED],
                'initialRpcTimeoutMillis' => 500,
                'totalTimeoutMillis' => 1000,
            ]);
        $handler = function(Call $call, $options) {
            return new Promise(function () use ($options) {
                // sleep for the duration of the timeout
                if (isset($options['timeoutMillis'])) {
                    usleep(intval($options['timeoutMillis'] * 1000));
                }
                throw new ApiException('Cancelled!', Code::CANCELLED, ApiStatus::CANCELLED);
            });
        };
        $middleware = new RetryMiddleware($handler, $retrySettings);

        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Retry total timeout exceeded.');

        $middleware($call, [])->wait();
    }

    public function testRetryTimeoutIsInteger()
    {
        $call = $this->getMockBuilder(Call::class)
            ->disableOriginalConstructor()
            ->getMock();
        $retrySettings = RetrySettings::constructDefault()
            ->with([
                'retriesEnabled' => true,
                'retryableCodes' => [ApiStatus::CANCELLED],
                'initialRpcTimeoutMillis' => 10000,
                'totalTimeoutMillis' => 10000,
            ]);
        $callCount = 0;
        $observedTimeouts = [];
        $handler = function(Call $call, $options) use (&$callCount, &$observedTimeouts) {
            $observedTimeouts[] = $options['timeoutMillis'];
            $callCount += 1;
            return $promise = new Promise(function () use (&$promise, $callCount) {
                if ($callCount < 2) {
                    throw new ApiException('Cancelled!', Code::CANCELLED, ApiStatus::CANCELLED);
                }
                $promise->resolve('Ok!');
            });
        };
        $middleware = new RetryMiddleware($handler, $retrySettings);
        $middleware($call, [])->wait();

        $this->assertCount(2, $observedTimeouts, 'Expect 2 attempts');
        $this->assertSame(10000, $observedTimeouts[0], 'First timeout matches config');
        $this->assertIsInt($observedTimeouts[1], 'Second timeout is an int');
    }

    public function testTimeoutMillisCallSettingsOverwrite()
    {
        $handlerCalled = false;
        $timeout = 1234;
        $handler = function (Call $call, array $options) use (&$handlerCalled, $timeout) {
            $handlerCalled = true;
            $this->assertEquals($timeout, $options['timeoutMillis']);
            return $this->getMockBuilder(Promise::class)
                ->disableOriginalConstructor()
                ->getMock();
        };
        $retrySettings = RetrySettings::constructDefault()
            ->with([
                'retriesEnabled' => true,
                'retryableCodes' => [ApiStatus::CANCELLED],
            ]);
        $middleware = new RetryMiddleware($handler, $retrySettings);

        $call = $this->getMockBuilder(Call::class)
            ->disableOriginalConstructor()
            ->getMock();
        $options = ['timeoutMillis' => $timeout];
        $middleware($call, $options);
        $this->assertTrue($handlerCalled);
    }

    public function testRetryLogicalTimeout()
    {
        $timeout = 2000;
        $call = $this->getMockBuilder(Call::class)
            ->disableOriginalConstructor()
            ->getMock();
        $retrySettings = RetrySettings::constructDefault()
            ->with([
                'retriesEnabled' => true,
                'retryableCodes' => [ApiStatus::CANCELLED],
            ])
            ->with(RetrySettings::logicalTimeout($timeout));
        $callCount = 0;
        $observedTimeouts = [];
        $handler = function(Call $call, $options) use (&$callCount, &$observedTimeouts) {
            $callCount += 1;
            $observedTimeouts[] = $options['timeoutMillis'];
            return $promise = new Promise(function () use (&$promise, $callCount) {
                // each call needs to take at least 1 millisecond otherwise the rounded timeout will not decrease
                // with each step of the test.
                usleep(1000);
                if ($callCount < 3) {
                    throw new ApiException('Cancelled!', Code::CANCELLED, ApiStatus::CANCELLED);
                }
                $promise->resolve('Ok!');
            });
        };
        $middleware = new RetryMiddleware($handler, $retrySettings);
        $response = $middleware(
            $call,
            []
        )->wait();

        $this->assertSame('Ok!', $response);
        $this->assertEquals(3, $callCount);
        $this->assertCount(3, $observedTimeouts);
        $this->assertEquals($observedTimeouts[0], $timeout);
        for ($i = 1; $i < count($observedTimeouts); $i++) {
            $this->assertTrue($observedTimeouts[$i-1] > $observedTimeouts[$i]);
        }
    }

    public function testNoRetryLogicalTimeout()
    {
        $timeout = 2000;
        $call = $this->getMockBuilder(Call::class)
            ->disableOriginalConstructor()
            ->getMock();
        $retrySettings = RetrySettings::constructDefault()
            ->with(RetrySettings::logicalTimeout($timeout));
        $observedTimeout = 0;
        $handler = function(Call $call, $options) use (&$observedTimeout) {
            $observedTimeout = $options['timeoutMillis'];
            return $promise = new Promise(function () use (&$promise) {
                $promise->resolve('Ok!');
            });
        };
        $middleware = new RetryMiddleware($handler, $retrySettings);
        $response = $middleware(
            $call,
            []
        )->wait();

        $this->assertSame('Ok!', $response);
        $this->assertEquals($observedTimeout, $timeout);
    }

    public function testCustomRetry()
    {
        $call = $this->getMockBuilder(Call::class)
            ->disableOriginalConstructor()
            ->getMock();

        $maxAttempts = 3;
        $currentAttempt = 0;
        $retrySettings = RetrySettings::constructDefault()
            ->with([
                'retriesEnabled' => true,
                'retryFunction' => function ($ex, $options) use ($maxAttempts, &$currentAttempt) {
                    $currentAttempt++;
                    if($currentAttempt < $maxAttempts) {
                        return true;
                    }

                    return false;
                }
            ]);
        $callCount = 0;
        $handler = function(Call $call, $options) use (&$callCount) {
            return new Promise(function () use (&$callCount) {
                ++$callCount;
                throw new ApiException('Call Count: ' . $callCount, 0, '');
            });
        };
        $middleware = new RetryMiddleware($handler, $retrySettings);

        $this->expectException(ApiException::class);
        // test if the custom retry func threw an exception after $maxAttempts
        $this->expectExceptionMessage('Call Count: ' . ($maxAttempts));

        $middleware($call, [])->wait();
    }

    public function testCustomRetryRespectsRetriesEnabled()
    {
        $call = $this->getMockBuilder(Call::class)
            ->disableOriginalConstructor()
            ->getMock();

        $retrySettings = RetrySettings::constructDefault()
            ->with([
                'retriesEnabled' => false,
                'retryFunction' => function ($ex, $options) {
                    // This should not run as retriesEnabled is false
                    $this->fail('Custom retry function shouldn\'t have run.');
                    return true;
                }
            ]);

        $handler = function (Call $call, $options) {
            return new Promise(function () {
                throw new ApiException('Exception msg', 0, '');
            });
        };
        $middleware = new RetryMiddleware($handler, $retrySettings);

        $this->expectException(ApiException::class);
        $middleware($call, [])->wait();
    }

    public function testCustomRetryRespectsTimeout()
    {
        $call = $this->getMockBuilder(Call::class)
            ->disableOriginalConstructor()
            ->getMock();

        $retrySettings = RetrySettings::constructDefault()
            ->with([
                'retriesEnabled' => true,
                'totalTimeoutMillis' => 1,
                'retryFunction' => function ($ex, $options) {
                    usleep(900);
                    return true;
                }
            ]);

        $callCount = 0;
        $handler = function (Call $call, $options) use (&$callCount) {
            return new Promise(function () use(&$callCount) {
                ++$callCount;
                throw new ApiException('Call count: ' . $callCount, 0, '');
            });
        };
        $middleware = new RetryMiddleware($handler, $retrySettings);
        
        try {
            $middleware($call, [])->wait();
            $this->fail('Expected an exception, but didn\'t receive any');
        } catch(ApiException $e) {
            $this->assertEquals('Retry total timeout exceeded.', $e->getMessage());
            // we used a total timeout of 1 ms and every retry sleeps for .9 ms
            // This means that the call count should be 2(original call and 1 retry)
            $this->assertEquals(2, $callCount);
        }
    }

    public function testMaxRetries()
    {
        $call = $this->getMockBuilder(Call::class)
            ->disableOriginalConstructor()
            ->getMock();

        $maxRetries = 2;
        $retrySettings = RetrySettings::constructDefault()
            ->with([
                'retriesEnabled' => true,
                'retryableCodes' => [ApiStatus::CANCELLED],
                'maxRetries' => $maxRetries
            ]);
        $callCount = 0;
        $handler = function(Call $call, $options) use (&$callCount) {
            return new Promise(function () use (&$callCount) {
                ++$callCount;
                throw new ApiException('Call Count: ' . $callCount, 0, ApiStatus::CANCELLED);
            });
        };
        $middleware = new RetryMiddleware($handler, $retrySettings);

        $this->expectException(ApiException::class);
        // test if the custom retry func threw an exception after $maxRetries + 1 calls
        $this->expectExceptionMessage('Call Count: ' . ($maxRetries + 1));

        $middleware($call, [])->wait();
    }

    /**
     * Tests for maxRetries to be evaluated before the retry function.
     */
    public function testMaxRetriesOverridesCustomRetryFunc()
    {
        $call = $this->getMockBuilder(Call::class)
            ->disableOriginalConstructor()
            ->getMock();

        $maxRetries = 2;
        $callCount = 0;
        $retrySettings = RetrySettings::constructDefault()
            ->with([
                'retriesEnabled' => true,
                'retryableCodes' => [ApiStatus::CANCELLED],
                'maxRetries' => $maxRetries,
                'retryFunction' => function ($ex, $options) use (&$callCount) {
                    // The retryFunction will signal a retry until the total call count reaches 5.
                    return $callCount < 5 ? true : false;
                }
            ]);
        $handler = function(Call $call, $options) use (&$callCount) {
            return new Promise(function () use (&$callCount) {
                ++$callCount;
                throw new ApiException('Call Count: ' . $callCount, 0, ApiStatus::CANCELLED);
            });
        };
        $middleware = new RetryMiddleware($handler, $retrySettings);

        $this->expectException(ApiException::class);
        // Even though our custom retry function wants 4 retries
        // the exception should be thrown after $maxRetries + 1 calls
        $this->expectExceptionMessage('Call Count: ' . ($maxRetries + 1));

        $middleware($call, [])->wait();
    }

    /**
     * Tests for custom retry function returning false, before we reach maxRetries.
     */
    public function testCustomRetryThrowsExceptionBeforeMaxRetries()
    {
        $call = $this->getMockBuilder(Call::class)
            ->disableOriginalConstructor()
            ->getMock();

        $maxRetries = 10;
        $customRetryMaxCalls = 4;
        $callCount = 0;
        $retrySettings = RetrySettings::constructDefault()
            ->with([
                'retriesEnabled' => true,
                'retryableCodes' => [ApiStatus::CANCELLED],
                'maxRetries' => $maxRetries,
                'retryFunction' => function ($ex, $options) use (&$callCount, $customRetryMaxCalls) {
                    // The retryFunction will signal a retry until the total call count reaches $customRetryMaxCalls.
                    return $callCount < $customRetryMaxCalls ? true : false;
                }
            ]);
        $handler = function(Call $call, $options) use (&$callCount) {
            return new Promise(function () use (&$callCount) {
                ++$callCount;
                throw new ApiException('Call Count: ' . $callCount, 0, ApiStatus::CANCELLED);
            });
        };
        $middleware = new RetryMiddleware($handler, $retrySettings);

        $this->expectException(ApiException::class);
        // Even though our maxRetries hasn't reached
        // the exception should be thrown after $customRetryMaxCalls
        // because the custom retry function would return false.
        $this->expectExceptionMessage('Call Count: ' . ($customRetryMaxCalls));

        $middleware($call, [])->wait();
    }

    public function testUnlimitedMaxRetries()
    {
        $call = $this->getMockBuilder(Call::class)
            ->disableOriginalConstructor()
            ->getMock();

        $customRetryMaxCalls = 4;
        $callCount = 0;
        $retrySettings = RetrySettings::constructDefault()
            ->with([
                'retriesEnabled' => true,
                'retryableCodes' => [ApiStatus::CANCELLED],
                'maxRetries' => 0,
                'retryFunction' => function ($ex, $options) use (&$callCount, $customRetryMaxCalls) {
                    // The retryFunction will signal a retry until the total call count reaches $customRetryMaxCalls.
                    return $callCount < $customRetryMaxCalls ? true : false;
                }
            ]);
        $handler = function(Call $call, $options) use (&$callCount) {
            return new Promise(function () use (&$callCount) {
                ++$callCount;
                throw new ApiException('Call Count: ' . $callCount, 0, ApiStatus::CANCELLED);
            });
        };
        $middleware = new RetryMiddleware($handler, $retrySettings);

        $this->expectException(ApiException::class);
        // Since the maxRetries is set to 0(unlimited),
        // the exception should be thrown after $customRetryMaxCalls
        // because then the custom retry function would return false.
        $this->expectExceptionMessage('Call Count: ' . ($customRetryMaxCalls));

        $middleware($call, [])->wait();
    }
}
