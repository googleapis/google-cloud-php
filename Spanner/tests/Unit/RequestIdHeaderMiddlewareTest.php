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

use Google\ApiCore\ApiException;
use Google\Cloud\Spanner\Middleware\RequestIdHeaderMiddleware;
use Google\ApiCore\Call;
use Google\ApiCore\Transport\TransportInterface;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\Fixtures;
use Google\Cloud\Spanner\Admin\Instance\V1\ListInstancesResponse;
use Google\Cloud\Spanner\SpannerClient;
use Google\Rpc\Code;
use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Promise\RejectedPromise;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * A middleware in charge of adding Spanner's Request Id header to all the rpc calls.
 *
 * @internal
 */
class RequestIdHeaderMiddlewareTest extends TestCase
{
    use ProphecyTrait;
    use GrpcTestTrait;

    const PROJECT = 'my-awesome-project';

    public function testAddsRequestIdHeader()
    {
        $channelId = 1;
        $headerName = 'x-goog-spanner-request-id';
        $expectedHeaderParts = 6; // version.process.client.channel.request.attempt

        $nextHandler = function (Call $call, array $options) use ($headerName, $expectedHeaderParts, $channelId) {
            $this->assertArrayHasKey($headerName, $options['headers']);

            $headerValue = $options['headers'][$headerName][0];
            [$version, $process, $client, $channel, $request, $attempt] = $parts = explode(
                '.',
                $headerValue
            );

            $this->assertCount($expectedHeaderParts, $parts, 'Header should have 6 parts separated by dots.');
            $this->assertEquals(1, (int)$version, 'The version part of the header is incorrect.');
            $this->assertMatchesRegularExpression(
                '/^[0-9a-fA-F]{16}$/',
                $process,
                'The process ID part should be a 16-character hex string.'
            );
            $this->assertEquals(1, (int)$client, 'The client ID part of the header is incorrect.');
            $this->assertEquals($channelId, (int)$channel, 'The channel ID part of the header is incorrect.');
            $this->assertEquals(1, (int)$request, 'The request ID part of the header is incorrect.');
            $this->assertEquals(1, (int)$attempt, 'The attempt ID part of the header is incorrect.');

            return 'foo';
        };

        $middleware = new RequestIdHeaderMiddleware($nextHandler, $channelId);
        $call = $this->prophesize(Call::class)->reveal();
        $middleware($call, []);
    }

    public function testMaintainsProcessIdAcrossCalls()
    {
        $channelId = 123;
        $headerName = 'x-goog-spanner-request-id';
        $capturedProcesses = [];

        $nextHandler = function (Call $call, array $options) use ($headerName, &$capturedProcesses) {
            $headerValue = $options['headers'][$headerName][0];
            $parts = explode('.', $headerValue);
            $capturedProcesses[] = $parts[1]; // Capture the process ID

            return 'ok';
        };

        $middleware = new RequestIdHeaderMiddleware($nextHandler, $channelId);
        $call = $this->prophesize(Call::class)->reveal();

        $middleware($call, []);
        $middleware($call, []);

        $this->assertCount(2, $capturedProcesses);

        $this->assertEquals(
            $capturedProcesses[0],
            $capturedProcesses[1],
            'Process ID should be the same across multiple calls.'
        );

        $this->assertMatchesRegularExpression('/^[0-9a-fA-F]{16}$/', $capturedProcesses[0]);

        $middleware2 = new RequestIdHeaderMiddleware($nextHandler, $channelId);
        $middleware2($call, []);

        $this->assertEquals(
            $capturedProcesses[0],
            $capturedProcesses[2],
            'Process ID should be the same across multiple middlewares in the same process.'
        );
    }

    public function testRequestPartIncrementsWithEachCall()
    {
        $channelId = 456;
        $headerName = 'x-goog-spanner-request-id';
        $capturedRequests = [];

        $nextHandler = function (Call $call, array $options) use ($headerName, &$capturedRequests) {
            $headerValue = $options['headers'][$headerName][0];
            $parts = explode('.', $headerValue);
            $capturedRequests[] = (int) $parts[4]; // Capture the request ID part

            return 'ok';
        };

        $middleware = new RequestIdHeaderMiddleware($nextHandler, $channelId);
        $call = $this->prophesize(Call::class)->reveal();

        $middleware($call, []);
        $middleware($call, []);
        $middleware($call, []);

        $this->assertCount(3, $capturedRequests);

        $this->assertEquals(1, $capturedRequests[0], 'First request ID should be 1.');
        $this->assertEquals(2, $capturedRequests[1], 'Second request ID should be 2.');
        $this->assertEquals(3, $capturedRequests[2], 'Third request ID should be 3.');
    }

    public function testAttemptPartReflectsRetryAttempt()
    {
        $channelId = 789;
        $headerName = 'x-goog-spanner-request-id';
        $retryAttempt = 5;

        $nextHandler = function (Call $call, array $options) use ($headerName, $retryAttempt) {
            $this->assertArrayHasKey($headerName, $options['headers']);
            $headerValue = $options['headers'][$headerName][0];
            $parts = explode('.', $headerValue);

            $this->assertCount(6, $parts, 'Header should have 6 parts.');
            $this->assertEquals($retryAttempt + 1, (int)$parts[5], 'The attempt ID should be retryAttempt + 1.');

            return 'ok';
        };

        $middleware = new RequestIdHeaderMiddleware($nextHandler, $channelId);
        $call = $this->prophesize(Call::class)->reveal();

        $middleware($call, ['retryAttempt' => $retryAttempt]);
    }

    public function testMiddlewareGetsTheRetryField()
    {
        $this->checkAndSkipGrpcTests();
        $headerName = 'x-goog-spanner-request-id';
        $callCount = 0;
        // the will method from prophecy overrides $this on the scope.
        $test = $this;

        $transport = $this->prophesize(TransportInterface::class);
        $client =  new SpannerClient([
            'projectId' => self::PROJECT,
            'credentials' => Fixtures::KEYFILE_STUB_FIXTURE(),
            'transport' => $transport->reveal()
        ]);

        $transport->startUnaryCall(Argument::cetera())
            ->shouldBeCalledTimes(2)
            ->will(function ($args) use (&$callCount, $headerName, $test) {
                $callCount++;
                $options = $args[1];

                $test->assertArrayHasKey('headers', $options);
                $test->assertArrayHasKey($headerName, $options['headers']);
                $headerValue = $options['headers'][$headerName][0];
                $parts = explode('.', $headerValue);
                $attempt = (int) $parts[5];
                $request = (int) $parts[4];

                if ($callCount === 1) {
                    $test->assertEquals(1, $attempt);
                    return new RejectedPromise(
                        new ApiException('Transient error', Code::UNAVAILABLE, 'UNAVAILABLE')
                    );
                }

                $test->assertEquals(1, $request);
                $test->assertEquals(2, $attempt);

                $response = new ListInstancesResponse();
                return new FulfilledPromise($response);
            });

        iterator_to_array($client->instances([
            'retrySettings' => [
                'maxRetries' => 2
            ]
        ]));
    }
}
