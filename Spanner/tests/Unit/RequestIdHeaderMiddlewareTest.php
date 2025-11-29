<?php
/**
 * Copyright 2016 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Spanner\Tests\Unit;

use Google\Cloud\Spanner\Middleware\RequestIdHeaderMiddleware;
use Google\ApiCore\Call;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class RequestIdHeaderMiddlewareTest extends TestCase
{
    use ProphecyTrait;

    public function testAddsRequestIdHeader()
    {
        $channelId = 1;
        $headerName = 'x-goog-spanner-request-id';
        $expectedHeaderParts = 6; // version.process.client.channel.request.attempt

        // 1. This is our mock "next handler". It's where the assertions happen.
        $nextHandler = function (Call $call, array $options) use ($headerName, $expectedHeaderParts, $channelId) {
            // Assert the header exists
            $this->assertArrayHasKey($headerName, $options['headers']);

            $headerValue = $options['headers'][$headerName];
            [$version, $process, $client, $channel, $request, $attempt] = $parts = explode(
                '.',
                $headerValue
            );

            // Assert the header format is correct
            $this->assertCount($expectedHeaderParts, $parts, 'Header should have 6 parts separated by dots.');

            // Assert the version is correct (hardcoded to 1 in middleware)
            $this->assertEquals(1, (int)$version, 'The version part of the header is incorrect.');

            // Assert the process ID is a 16-character hex string
            $this->assertMatchesRegularExpression('/^[0-9a-fA-F]{16}$/', $process, 'The process ID part should be a 16-character hex string.');

            // Assert the client ID is correct (first client instance in this process, so 1)
            $this->assertEquals(1, (int)$client, 'The client ID part of the header is incorrect.');

            // Assert the channel ID is correctly placed
            $this->assertEquals($channelId, (int)$channel, 'The channel ID part of the header is incorrect.');

            // Assert the request ID is correct (first request for this middleware, so 1)
            $this->assertEquals(1, (int)$request, 'The request ID part of the header is incorrect.');

            // Assert the attempt ID is correct (first attempt, so 1)
            $this->assertEquals(1, (int)$attempt, 'The attempt ID part of the header is incorrect.');

            // Return a dummy value, as the handler is expected to return something.
            return 'foo';
        };

        // 2. Instantiate the middleware
        $middleware = new RequestIdHeaderMiddleware($nextHandler, $channelId);

        $call = $this->prophesize(Call::class)->reveal();

        // 3. Invoke the middleware. This will trigger the assertions in $nextHandler.
        $middleware($call, []);
    }

    public function testMaintainsProcessIdAcrossCalls()
    {
        $channelId = 123;
        $headerName = 'x-goog-spanner-request-id';
        $capturedProcesses = [];

        // This handler will capture the process ID from each call.
        $nextHandler = function (Call $call, array $options) use ($headerName, &$capturedProcesses) {
            $headerValue = $options['headers'][$headerName];
            $parts = explode('.', $headerValue);
            $capturedProcesses[] = $parts[1]; // Capture the process ID part

            return 'ok';
        };

        $middleware = new RequestIdHeaderMiddleware($nextHandler, $channelId);
        $call = $this->prophesize(Call::class)->reveal();

        // Invoke the same middleware instance twice
        $middleware($call, []);
        $middleware($call, []);

        // Assert that the handler was called twice
        $this->assertCount(2, $capturedProcesses);

        // Assert that the process ID was the same for both calls
        $this->assertEquals(
            $capturedProcesses[0],
            $capturedProcesses[1],
            'Process ID should be the same across multiple calls.'
        );

        // Also assert that the process ID is a valid hex value
        $this->assertMatchesRegularExpression('/^[0-9a-fA-F]{16}$/', $capturedProcesses[0]);
    }

    public function testRequestPartIncrementsWithEachCall()
    {
        $channelId = 456;
        $headerName = 'x-goog-spanner-request-id';
        $capturedRequests = [];

        // This handler will capture the request ID from each call.
        $nextHandler = function (Call $call, array $options) use ($headerName, &$capturedRequests) {
            $headerValue = $options['headers'][$headerName];
            $parts = explode('.', $headerValue);
            $capturedRequests[] = (int) $parts[4]; // Capture the request ID part

            return 'ok';
        };

        $middleware = new RequestIdHeaderMiddleware($nextHandler, $channelId);
        $call = $this->prophesize(Call::class)->reveal();

        // Invoke the same middleware instance multiple times
        $middleware($call, []); // Request 1
        $middleware($call, []); // Request 2
        $middleware($call, []); // Request 3

        // Assert that the handler was called three times
        $this->assertCount(3, $capturedRequests);

        // Assert that the request IDs increment correctly
        $this->assertEquals(1, $capturedRequests[0], 'First request ID should be 1.');
        $this->assertEquals(2, $capturedRequests[1], 'Second request ID should be 2.');
        $this->assertEquals(3, $capturedRequests[2], 'Third request ID should be 3.');
    }

    public function testAttemptPartReflectsRetryAttempt()
    {
        $channelId = 789;
        $headerName = 'x-goog-spanner-request-id';
        $retryAttempt = 5; // Simulate the 5th retry, so the attempt counter should be 6

        // This handler will capture the attempt ID from the call.
        $nextHandler = function (Call $call, array $options) use ($headerName, $retryAttempt) {
            $this->assertArrayHasKey($headerName, $options['headers']);
            $headerValue = $options['headers'][$headerName];
            $parts = explode('.', $headerValue);

            $this->assertCount(6, $parts, 'Header should have 6 parts.');
            $this->assertEquals($retryAttempt + 1, (int)$parts[5], 'The attempt ID should be retryAttempt + 1.');

            return 'ok';
        };

        $middleware = new RequestIdHeaderMiddleware($nextHandler, $channelId);
        $call = $this->prophesize(Call::class)->reveal();

        // Invoke the middleware with retryAttempt in options
        $middleware($call, ['retryAttempt' => $retryAttempt]);
    }
}