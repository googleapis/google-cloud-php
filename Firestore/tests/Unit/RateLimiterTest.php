<?php
/**
 * Copyright 2022 Google Inc.
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

namespace Google\Cloud\Firestore\Tests\Unit;

use Google\Cloud\Firestore\RateLimiter;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @group firestore
 * @group firestore-writebatch
 */
class RateLimiterTest extends TestCase
{

    private $rateLimiter;

    public function setUp(): void
    {
        $this->rateLimiter = new RateLimiter(
            500, // initialCapacity
            1.5, // multiplier
            5 * 60 * 1000, // multiplierMillis
            1000000, // maximumRate
            0// startTimeMillis
        );
    }

    public function testTryMakeRequests()
    {
        $this->assertTrue($this->rateLimiter->tryMakeRequest(250, 0));
        $this->assertTrue($this->rateLimiter->tryMakeRequest(250, 0));

        // Once tokens have been used, further requests should fail.
        $this->assertFalse($this->rateLimiter->tryMakeRequest(1, 0));
        $this->assertFalse($this->rateLimiter->tryMakeRequest(1, 0));

        // Tokens will only refill up to max capacity.
        $this->assertFalse($this->rateLimiter->tryMakeRequest(501, 1 * 1000));
        $this->assertTrue($this->rateLimiter->tryMakeRequest(500, 1 * 1000));

        // Tokens will refill incrementally based on number of ms elapsed.
        $this->assertFalse($this->rateLimiter->tryMakeRequest(250, 1 * 1000 + 499));
        $this->assertTrue($this->rateLimiter->tryMakeRequest(249, 1 * 1000 + 500));

        // Scales with multiplier.
        $this->assertFalse($this->rateLimiter->tryMakeRequest(751, (5 * 60 - 1) * 1000));
        $this->assertFalse($this->rateLimiter->tryMakeRequest(751, 5 * 60 * 1000));
        $this->assertTrue($this->rateLimiter->tryMakeRequest(750, 5 * 60 * 1000));

        // Tokens will never exceed capacity.
        $this->assertFalse($this->rateLimiter->tryMakeRequest(751, (5 * 60 + 3) * 1000));

        // Rejects requests made before lastRefillTime.
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Request time should not be before the last token refill time');
        $this->rateLimiter->tryMakeRequest(751, (5 * 60 + 2) * 1000);
    }

    public function testGetNextRequestDelayMs()
    {
        // Should return 0 if there are enough tokens for the request to be made.
        $timestamp = 0;
        $this->assertEquals(0, $this->rateLimiter->getNextRequestDelayMs(500, $timestamp));

        // Should factor in remaining tokens when calculating the time.
        $this->assertTrue($this->rateLimiter->tryMakeRequest(250, $timestamp));
        $this->assertEquals(500, $this->rateLimiter->getNextRequestDelayMs(500, $timestamp));

        // Once tokens have been used, should calculate time before next request.
        $timestamp = 1 * 1000;
        $this->assertTrue($this->rateLimiter->tryMakeRequest(500, $timestamp));
        $this->assertEquals(200, $this->rateLimiter->getNextRequestDelayMs(100, $timestamp));
        $this->assertEquals(500, $this->rateLimiter->getNextRequestDelayMs(250, $timestamp));
        $this->assertEquals(1000, $this->rateLimiter->getNextRequestDelayMs(500, $timestamp));
        $this->assertEquals(-1, $this->rateLimiter->getNextRequestDelayMs(501, $timestamp));

        // Scales with multiplier.
        $timestamp = 5 * 60 * 1000;
        $this->assertTrue($this->rateLimiter->tryMakeRequest(750, $timestamp));
        $this->assertEquals(334, $this->rateLimiter->getNextRequestDelayMs(250, $timestamp));
        $this->assertEquals(667, $this->rateLimiter->getNextRequestDelayMs(500, $timestamp));
        $this->assertEquals(1000, $this->rateLimiter->getNextRequestDelayMs(750, $timestamp));
        $this->assertEquals(-1, $this->rateLimiter->getNextRequestDelayMs(751, $timestamp));
    }

    public function testCalculateCapacity()
    {
        $this->assertEquals(500, $this->rateLimiter->calculateCapacity(0));
        $this->assertEquals(750, $this->rateLimiter->calculateCapacity(5 * 60 * 1000));
        $this->assertEquals(1125, $this->rateLimiter->calculateCapacity(10 * 60 * 1000));
        $this->assertEquals(1687, $this->rateLimiter->calculateCapacity(15 * 60 * 1000));
        $this->assertEquals(738945, $this->rateLimiter->calculateCapacity(90 * 60 * 1000));

        // Check that maximum rate limit is enforced.
        $this->assertEquals(1000000, $this->rateLimiter->calculateCapacity(1000 * 60 * 1000));
    }
}
