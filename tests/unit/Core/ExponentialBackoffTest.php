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

namespace Google\Cloud\Tests\Unit\Core;

use Google\Cloud\Core\ExponentialBackoff;
use Prophecy\Argument;

/**
 * @group core
 */
class ExponentialBackoffTest extends \PHPUnit_Framework_TestCase
{
    private $delayFunction;

    public function setUp()
    {
        $this->delayFunction = function() {
            return;
        };
    }

    /**
     * @dataProvider retriesProvider
     */
    public function testThrowsExceptionAfterFullAttempts($retries, $exception)
    {
        // Expected attempts is the number of retries plus the initial attempt.
        $expectedAttempts = $retries ? $retries + 1 : 4;
        $actualAttempts = 0;
        $hasTriggeredException = false;
        $backoff = new ExponentialBackoff($retries);
        $backoff->setDelayFunction($this->delayFunction);

        try {
            $backoff->execute(function () use (&$actualAttempts, $expectedAttempts, $exception) {
                $actualAttempts++;
                throw $exception;
            });
        } catch (\Exception $ex) {
            $hasTriggeredException = true;
        }

        $this->assertTrue($hasTriggeredException);
        $this->assertEquals($expectedAttempts, $actualAttempts);
    }

    public function retriesProvider()
    {
        $rateLimitExceededMessage = '{"error": {"errors": [{"reason": "rateLimitExceeded"}]}}';
        $userRateLimitExceededMessage = '{"error": {"errors": [{"reason": "userRateLimitExceeded"}]}}';

        return [
            [null, new \Exception('', 500)],
            [2, new \Exception('', 502)],
            [3, new \Exception('', 503)],
            [4, new \Exception('', 504)],
            [5, new \Exception($rateLimitExceededMessage)],
            [6, new \Exception($userRateLimitExceededMessage)]
        ];
    }

    public function testThrowsExceptionWhenRetryFunctionReturnsFalse()
    {
        $actualAttempts = 0;
        $hasTriggeredException = false;
        $retryFunction = function(\Exception $ex) {
            return false;
        };
        $backoff = new ExponentialBackoff(null, $retryFunction);
        $backoff->setDelayFunction($this->delayFunction);

        try {
            $backoff->execute(function () use (&$actualAttempts) {
                $actualAttempts++;
                throw new \Exception();
            });
        } catch (\Exception $ex) {
            $hasTriggeredException = true;
        }

        $this->assertTrue($hasTriggeredException);
        $this->assertEquals(1, $actualAttempts);
    }

    public function testSuccessWithNoRetries()
    {
        $actualAttempts = 0;
        $backoff = new ExponentialBackoff();
        $backoff->setDelayFunction($this->delayFunction);

        $backoff->execute(function () use (&$actualAttempts) {
            $actualAttempts++;
            return;
        });

        $this->assertEquals(1, $actualAttempts);
    }
}
