<?php
/*
 * Copyright 2017, Google Inc.
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
namespace Google\Cloud\Core\Middleware;

use Google\GAX\RetrySettings;
use Google\GAX\ApiException;
use Google\GAX\ApiStatus;
use Exception;

/**
* Middleware that adds retry functionality
*/
class RetryMiddleware
{
    /** @var callable */
    private $nextHandler;

    /** @var RetrySettings */
    private $retrySettings;

    /** @var callable */
    private $timeFuncMillis;

    public function __construct(
        callable $nextHandler,
        RetrySettings $retrySettings,
        $timeFuncMillis = null
    ) {
        $this->nextHandler = $nextHandler;
        $this->retrySettings = $retrySettings;
        if (!isset($timeFuncMillis)) {
            $timeFuncMillis = function () {
                return microtime(true) * 1000.0;
            };
        }
        $this->timeFuncMillis = $timeFuncMillis;
    }

    public function __invoke()
    {
        // Initialize retry parameters
        $delayMult = $this->retrySettings->getRetryDelayMultiplier();
        $maxDelayMillis = $this->retrySettings->getMaxRetryDelayMillis();
        $timeoutMult = $this->retrySettings->getRpcTimeoutMultiplier();
        $maxTimeoutMillis = $this->retrySettings->getMaxRpcTimeoutMillis();
        $totalTimeoutMillis = $this->retrySettings->getTotalTimeoutMillis();

        $delayMillis = $this->retrySettings->getInitialRetryDelayMillis();
        $timeoutMillis = $this->retrySettings->getInitialRpcTimeoutMillis();
        $currentTimeMillis = call_user_func($this->timeFuncMillis);
        $deadlineMillis = $currentTimeMillis + $totalTimeoutMillis;

        while ($currentTimeMillis < $deadlineMillis) {
            $nextHandler = new TimeoutMiddleware($this->nextHandler, $timeoutMillis);
            try {
                return call_user_func_array($nextHandler, func_get_args());
            } catch (ApiException $e) {
                if (!in_array($e->getStatus(), $this->retrySettings->getRetryableCodes())) {
                    throw $e;
                }
            } catch (Exception $e) {
                throw $e;
            }
            // Don't sleep if the failure was a timeout
            if ($e->getStatus() != ApiStatus::DEADLINE_EXCEEDED) {
                usleep($delayMillis * 1000);
            }
            $currentTimeMillis = call_user_func($this->timeFuncMillis);
            $delayMillis = min($delayMillis * $delayMult, $maxDelayMillis);
            $timeoutMillis = min(
                $timeoutMillis * $timeoutMult,
                $maxTimeoutMillis,
                $deadlineMillis - $currentTimeMillis
            );
        }
        throw new ApiException(
            "Retry total timeout exceeded.",
            \Google\Rpc\Code::DEADLINE_EXCEEDED,
            ApiStatus::DEADLINE_EXCEEDED
        );
    }
}
