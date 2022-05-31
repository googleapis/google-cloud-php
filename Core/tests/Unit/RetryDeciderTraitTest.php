<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Core\Tests\Unit;

use Google\Cloud\Core\RetryDeciderTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group core
 */
class RetryDeciderTraitTest extends TestCase
{
    private $impl;

    public function set_up()
    {
        $this->impl = TestHelpers::impl(RetryDeciderTrait::class);
    }

    /**
     * @dataProvider retryProvider
     */
    public function testDisableRetry($exception)
    {
        $this->impl->call('setHttpRetryCodes', [[]]);
        $this->impl->call('setHttpRetryMessages', [[]]);
        $retryFunction = $this->impl->call('getRetryFunction');

        $this->assertFalse($retryFunction($exception));
    }

    /**
     * @dataProvider retryProvider
     */
    public function testShouldRetry($exception, $shouldRetryMessage, $expected)
    {
        $retryFunction = $this->impl->call('getRetryFunction', [$shouldRetryMessage]);

        $this->assertEquals($expected, $retryFunction($exception));
    }

    public function retryProvider()
    {
        $rateLimitExceededMessage = '{"error": {"errors": [{"reason": "rateLimitExceeded"}]}}';
        $userRateLimitExceededMessage = '{"error": {"errors": [{"reason": "userRateLimitExceeded"}]}}';
        $notAGoodMessage = '{"error": {"errors": [{"reason": "notAGoodReason"}]}}';
        $rateLimitExceededResponse = new Response(400, [], $rateLimitExceededMessage);
        $notAGoodMessageResponse = new Response(400, [], $notAGoodMessage);
        $request = new Request('GET', 'https://www.example.com');

        return [
            [
                RequestException::create($request, $rateLimitExceededResponse),
                true,
                true
            ],
            [
                RequestException::create($request, $notAGoodMessageResponse),
                true,
                false
            ],
            [new \Exception('', 400), true, false],
            [new \Exception('', 500), true, true],
            [new \Exception('', 502), true, true],
            [new \Exception('', 503), true, true],
            [new \Exception($rateLimitExceededMessage), true, true],
            [new \Exception($userRateLimitExceededMessage), true, true],
            [new \Exception($userRateLimitExceededMessage), false, false],
            [new \Exception($notAGoodMessage), true, false],
        ];
    }
}
