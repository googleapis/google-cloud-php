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

namespace Google\Cloud\Firestore;

/**
 * A helper that uses the Token Bucket algorithm to rate limit the number of
 * operations that can be made in a second.
 *
 * Before a given request containing a number of operations can proceed,
 * RateLimiter determines doing so stays under the provided rate limits. It can
 * also determine how much time is required before a request can be made.
 *
 * RateLimiter can also implement a gradually increasing rate limit. This is
 * used to enforce the 500/50/5 rule
 * (https://cloud.google.com/firestore/docs/best-practices#ramping_up_traffic).
 *
 * @internal Please note RateLimiter is internal but contains public methods
 * for testing purposes.
 */
class RateLimiter
{
    /**
     * @var int Number of tokens available. Each operation consumes one token.
     * Decrements with every permitted request and refills over time.
     */
    private $availableTokens;

    /**
     * @var int When the token bucket was first filled.
     */
    private $startTimeMillis;

    /**
     * @var int When the token bucket was last refilled.
     */
    private $lastRefillTimeMillis;

    /**
     * @var int Initial maximum number of operations per second.
     */
    private $initialCapacity;

    /**
     * @var float
     */
    private $multiplier;

    /**
     * @var int
     */
    private $multiplierMillis;

    /**
     * @var int
     */
    private $maximumRate;

    /**
     * Constructor.
     *
     * @param int $initialCapacity Initial maximum number of operations per second.
     * @param float $multiplier Rate by which to increase the capacity.
     * @param int $multiplierMillis How often the capacity should increase in
     *        milliseconds.
     * @param int $maximumRate Maximum number of allowed operations per second.
     *        The number of tokens added per second will never exceed this number.
     * @param int $startTimeMillis [optional] The starting time in epoch milliseconds
     *        that the rate limit is based on.
     */
    public function __construct(
        $initialCapacity,
        $multiplier,
        $multiplierMillis,
        $maximumRate,
        $startTimeMillis = null
    ) {
        if (is_null($startTimeMillis)) {
            $startTimeMillis = floor(microtime(true) * 1000);
        }
        $this->availableTokens = $initialCapacity;
        $this->lastRefillTimeMillis = $startTimeMillis;
        $this->startTimeMillis = $startTimeMillis;
        $this->initialCapacity = $initialCapacity;
        $this->multiplier = $multiplier;
        $this->multiplierMillis = $multiplierMillis;
        $this->maximumRate = $maximumRate;
    }

    /**
     * Tries to make the number of operations. Returns true if the request
     * succeeded and false otherwise.
     *
     * @param int $numOperations The number of operations to request.
     * @param int $requestTimeMillis The time used to calculate the number of
     *        available tokens.
     * @return bool Used for testing the limiter.
     */
    public function tryMakeRequest($numOperations, $requestTimeMillis = null)
    {
        if (is_null($requestTimeMillis)) {
            $requestTimeMillis = floor(microtime(true) * 1000);
        }
        $this->refillTokens($requestTimeMillis);
        if ($numOperations <= $this->availableTokens) {
            $this->availableTokens -= $numOperations;
            return true;
        }
        return false;
    }

    /**
     * Returns the number of ms needed to make a request with the provided number
     * of operations.
     * Returns 0 if the request can be made with the existing capacity.
     * Returns -1 if the request is not possible with the current capacity.
     *
     * @param int $numOperations The number of operations to request.
     * @param int $requestTimeMillis The time used to calculate the number of
     *        available tokens.
     * @return int
     */
    public function getNextRequestDelayMs($numOperations, $requestTimeMillis = null)
    {
        if (is_null($requestTimeMillis)) {
            $requestTimeMillis = floor(microtime(true) * 1000);
        }
        if ($numOperations < $this->availableTokens) {
            return 0;
        }

        $capacity = $this->calculateCapacity($requestTimeMillis);
        if ($capacity < $numOperations) {
            return -1;
        }

        $requiredTokens = $numOperations - $this->availableTokens;
        return ceil(($requiredTokens * 1000) / $capacity);
    }

    /**
     * Calculates the maximum capacity based on the provided date.
     *
     * This method is marked public only for testing.
     *
     * @param int $requestTimeMillis The time used to calculate the number of
     *        available tokens.
     * @return int
     */
    public function calculateCapacity($requestTimeMillis)
    {
        if ($requestTimeMillis < $this->startTimeMillis) {
            // startTime cannot be before requestTime
            return 0;
        }
        $millisElapsed = $requestTimeMillis - $this->startTimeMillis;
        $operationsPerSecond = min(
            floor(
                pow(
                    $this->multiplier,
                    round($millisElapsed / $this->multiplierMillis)
                ) * $this->initialCapacity
            ),
            $this->maximumRate
        );
        return $operationsPerSecond;
    }

    /**
     * Refills the number of available tokens based on how much time has elapsed
     * since the last time the tokens were refilled.
     *
     * @param int $requestTimeMillis The time used to calculate the number of
     *        available tokens.
     * @return void
     * @throws InvalidArgumentException If request time is before last token refill time.
     */
    private function refillTokens($requestTimeMillis)
    {
        if ($requestTimeMillis < $this->lastRefillTimeMillis) {
            throw new \InvalidArgumentException(
                'Request time should not be before the last token refill time.'
            );
        }
        $elapsedTime = $requestTimeMillis - $this->lastRefillTimeMillis;
        $capacity = $this->calculateCapacity($requestTimeMillis);
        $tokensToAdd = floor(($elapsedTime * $capacity) / 1000);
        if ($tokensToAdd > 0) {
            $this->availableTokens = min(
                $capacity,
                $this->availableTokens + $tokensToAdd
            );
            $this->lastRefillTimeMillis = $requestTimeMillis;
        }
    }
}
