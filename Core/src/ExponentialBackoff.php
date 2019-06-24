<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Core;

/**
 * Exponential backoff implementation.
 */
class ExponentialBackoff
{
    const MAX_DELAY_MICROSECONDS = 60000000;

    /**
     * @var int
     */
    private $retries;

    /**
     * @var callable|null
     */
    private $retryFunction;

    /**
     * @var callable
     */
    private $delayFunction;

    /**
     * @var callable|null
     */
    private $calcDelayFunction;

    /**
     * @var int
     */
    private $retryAttempt = 0;

    /**
     * @var ExpoentialBackoff|null
     */
    private $backoff;

    /**
     * @param int $retries [optional] Number of retries for a failed request.
     * @param callable $retryFunction [optional] returns bool for whether or not to retry
     */
    public function __construct($retries = null, callable $retryFunction = null)
    {
        $this->retries = $retries !== null ? (int) $retries : 3;
        $this->retryFunction = $retryFunction;
        // @todo revisit this approach
        // @codeCoverageIgnoreStart
        $this->delayFunction = function ($delay) {
            usleep($delay);
        };
        // @codeCoverageIgnoreEnd
    }

    /**
     * Executes the retry process.
     *
     * @param callable $function
     * @param array $arguments [optional]
     * @return mixed
     * @throws \Exception The last exception caught while retrying.
     */
    public function execute(callable $function, array $arguments = [])
    {
        $delayFunction = $this->delayFunction;
        $calcDelayFunction = $this->calcDelayFunction ?: [$this, 'calculateDelay'];
        $exception = null;

        while (true) {
            try {
                return call_user_func_array($function, $arguments);
            } catch (\Exception $exception) {
                if (!$this->shouldRetry($exception)) {
                    throw $exception;
                }

                $delayFunction($calcDelayFunction($this->retryAttempt));
                $this->retryAttempt++;
            }
        }

        throw $exception;
    }

    /**
     * Configure this backoff to call another backoff retry function if this
     * backoff's retry function returns false.
     *
     * @param ExponentialBackoff $backoff
     * @return null
     */
    public function chain(ExponentialBackoff $backoff)
    {
        $this->backoff = $backoff;
    }

    /**
     * Function which returns bool for whether or not to retry.
     *
     * @param Exception $exception
     * @return bool
     */
    protected function shouldRetry(\Exception $exception)
    {
        if ($this->retryAttempt < $this->retries) {
            if (!$this->retryFunction) {
                return true;
            }
            if (call_user_func($this->retryFunction, $exception)) {
                return true;
            }
        }

        if ($this->backoff && $this->backoff->shouldRetry($exception)) {
            return true;
        }

        return false;
    }

    /**
     * If not set, defaults to using `usleep`.
     *
     * @param callable $delayFunction
     * @return void
     */
    public function setDelayFunction(callable $delayFunction)
    {
        $this->delayFunction = $delayFunction;
    }

    /**
     * If not set, defaults to using
     * {@see Google\Cloud\Core\ExponentialBackoff::calculateDelay()}.
     *
     * @param callable $calcDelayFunction
     * @return void
     */
    public function setCalcDelayFunction(callable $calcDelayFunction)
    {
        $this->calcDelayFunction = $calcDelayFunction;
    }

    /**
     * Calculates exponential delay.
     *
     * @param int $attempt The attempt number used to calculate the delay.
     * @return int
     */
    public static function calculateDelay($attempt)
    {
        return min(
            mt_rand(0, 1000000) + (pow(2, $attempt) * 1000000),
            self::MAX_DELAY_MICROSECONDS
        );
    }
}
