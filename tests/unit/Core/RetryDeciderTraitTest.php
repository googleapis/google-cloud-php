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

namespace Google\Cloud\Tests\Unit\Core;

use Google\Cloud\Core\RetryDeciderTrait;

/**
 * @group core
 */
class RetryDeciderTraitTest extends \PHPUnit_Framework_TestCase
{
    private $implementation;

    public function setUp()
    {
        $this->implementation = new RetryDeciderTraitStub();
    }

    /**
     * @dataProvider retryProvider
     */
    public function testShouldRetry($exception, $shouldRetryMessage, $expected)
    {
        $retryFunction = $this->implementation->call('getRetryFunction', [$shouldRetryMessage]);

        $this->assertEquals($expected, $retryFunction($exception));
    }

    public function retryProvider()
    {
        $rateLimitExceededMessage = '{"error": {"errors": [{"reason": "rateLimitExceeded"}]}}';
        $userRateLimitExceededMessage = '{"error": {"errors": [{"reason": "userRateLimitExceeded"}]}}';
        $notAGoodMessage = '{"error": {"errors": [{"reason": "notAGoodReason"}]}}';

        return [
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

class RetryDeciderTraitStub
{
    use RetryDeciderTrait;

    public function call($fn, array $args = [])
    {
        return call_user_func_array([$this, $fn], $args);
    }
}
