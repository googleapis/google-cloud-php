<?php
/*
 * Copyright 2016, Google Inc.
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
namespace Google\GAX;

use Grpc;

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Creates a function wrapper that provides extra functionalities such as retry and bundling.
 */
class ApiCallable
{
    const GRPC_CALLABLE_PARAM_COUNT = 3;
    const GRPC_CALLABLE_OPTION_INDEX = 2;
    const GRPC_RESPONSE_STATUS_INDEX = 1;

    private static function setTimeout($apiCall, $timeout)
    {
        $inner = function() use ($apiCall, $timeout) {
            $params = func_get_args();
            if (count($params) != self::GRPC_CALLABLE_PARAM_COUNT ||
                gettype($params[self::GRPC_CALLABLE_OPTION_INDEX]) != 'array') {
                // TODO(shinfan): Throw ApiException here.
                echo 'Something went wrong.';
            } else {
                $params[self::GRPC_CALLABLE_OPTION_INDEX]['timeout'] = $timeout;
            }
            return call_user_func_array($apiCall, $params);
        };
        return $inner;
    }

    private static function setRetry($apiCall, $retrySettings)
    {
        $inner = function() use ($apiCall, $retrySettings) {
            $backoffSettings = $retrySettings->getBackoffSettings();

            // Initialize retry parameters
            $delayMult = $backoffSettings->getRetryDelayMultiplier();
            $maxDelayMillis = $backoffSettings->getMaxRetryDelayMillis();
            $timeoutMult = $backoffSettings->getRpcTimeoutMultiplier();
            $maxTimeoutMillis = $backoffSettings->getMaxRpcTimeoutMillis();
            $totalTimeoutMillis = $backoffSettings->getTotalTimeoutMillis();

            $delayMillis = $backoffSettings->getInitialRetryDelayMillis();
            $timeoutMillis = $backoffSettings->getInitialRpcTimeoutMillis();
            $currentTimeMillis = time() * 1000;
            $deadlineMillis = $currentTimeMillis + $totalTimeoutMillis;

            while ($currentTimeMillis < $deadlineMillis) {
                $nextApiCall = self::setTimeout($apiCall, $timeoutMillis);
                list($response, $status) =
                    call_user_func_array($nextApiCall, func_get_args());
                if ($status->code == Grpc\STATUS_OK) {
                    return array($response, $status);
                }
                if (!in_array($status->code, $retrySettings->getRetryableCodes())) {
                    // TODO(shinfan): Implement API exception for PHP.
                    throw new \Exception("API exception");
                }
                sleep($delayMillis / 1000);
                $currentTimeMillis = time() * 1000;
                $delayMillis = min($delayMillis * $delayMult, $maxDelayMillis);
                $timeoutMillis = min($timeoutMillis * $timeoutMult,
                                     $maxTimeoutMillis,
                                     $deadlineMillis - $currentTimeMillis);
            }
            throw new \Exception("Retry total timeout exceeded.");
        };
        return $inner;
    }

    public static function createApiCall($callable, $timeout)
    {
        $apiCall = function() use ($callable) {
            return call_user_func_array($callable, func_get_args())->wait();
        };
        return self::setTimeout($apiCall, $timeout);
    }

    public static function createRetryableApiCall($callable, $retrySettings)
    {
        $apiCall = function() use ($callable) {
            return call_user_func_array($callable, func_get_args())->wait();
        };
        return self::setRetry($apiCall, $retrySettings);
    }
}
