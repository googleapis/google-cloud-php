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
namespace Google\Cloud\Core;

use Google\GAX\CallSettings;

/**
 * Creates a function wrapper that provides extra functionalities such as retry and bundling.
 */
trait CallStackTrait
{
    /**
     * @param callable $callable a callable to make API call through.
     * @param \Google\GAX\CallSettings $settings the call settings to use for this call.
     * @param array $options {
     *     Optional.
     *     @type \Google\GAX\PageStreamingDescriptor $pageStreamingDescriptor
     *           the descriptor used for page-streaming.
     *     @type \Google\GAX\AgentHeaderDescriptor $headerDescriptor
     *           the descriptor used for creating GAPIC header.
     * }
     *
     * @return callable
     */
    private static function createCallStack(
        callable $callable,
        CallSettings $settings,
        $options = []
    ) {
        $retrySettings = $settings->getRetrySettings();
        if (!is_null($retrySettings)) {
            if ($retrySettings->retriesEnabled()) {
                $timeFuncMillis = null;
                if (array_key_exists('timeFuncMillis', $options)) {
                    $timeFuncMillis = $options['timeFuncMillis'];
                }
                $callable = new Middleware\RetryMiddleware($callable, $retrySettings, $timeFuncMillis);
            } elseif ($retrySettings->getNoRetriesRpcTimeoutMillis() > 0) {
                $callable = new Middleware\TimeoutMiddleware($callable, $retrySettings->getNoRetriesRpcTimeoutMillis());
            }
        }

        if (array_key_exists('pageStreamingDescriptor', $options)) {
            $callable = new Middleware\PageStreamingMiddleware($callable, $options['pageStreamingDescriptor']);
        }

        if (array_key_exists('longRunningDescriptor', $options)) {
            $callable = new Middleware\LongRunningMiddleware($callable, $options['longRunningDescriptor']);
        }

        if (array_key_exists('headerDescriptor', $options) || !is_null($settings->getUserHeaders())) {
            $callable = new Middleware\CustomHeaderMiddleware(
                $callable,
                $options['headerDescriptor'],
                $settings->getUserHeaders()
            );
        }

        return $callable;
    }
}
