<?php
/*
 * Copyright 2025 Google LLC
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

namespace Google\Cloud\Spanner\Middleware;

use Google\ApiCore\Call;
use Google\ApiCore\Middleware\MiddlewareInterface;

/**
 * Middleware that adds the RequestId header to each rpc call made by spanner
 *
 * @internal
 */
class RequestIdHeaderMiddleware implements MiddlewareInterface
{
    private const REQUEST_ID_HEADER_NAME = 'x-goog-spanner-request-id';
    private const VERSION = 1;
    private static string $process;
    private static int $currentClient = 1;
    private int $client;
    private int $channel;
    private int $request = 0;

    /** @var callable */
    private $nextHandler;

    public function __construct(callable $nextHandler, int $channelId)
    {
        $this->nextHandler = $nextHandler;
        $this->channel = $channelId;
        $this->client = self::$currentClient++;
    }

    public function __invoke(Call $call, array $options)
    {
        $options['headers'][self::REQUEST_ID_HEADER_NAME] = [$this->getNewHeaderValue($options)];
        $next = $this->nextHandler;
        return $next(
            $call,
            $options
        );
    }

    /**
     * Returns a new Header value
     *
     * @param array $options The options passed to the middlewre from GAX.
     * @return string
     */
    private function getNewHeaderValue(array $options): string
    {
        $template = '%s.%s.%s.%s.%s.%s';

        $process = $this->getProcess();
        $client = $this->client;
        $channel = $this->channel;
        $attempt = $this->getAttempt($options);
        $request = $this->getNextRequestValue($attempt);

        return sprintf($template, self::VERSION, $process, $client, $channel, $request, $attempt);
    }

    /**
     * Gets the process id for the RequestId header.
     *
     * @return string
     */
    private function getProcess(): string
    {
        if (empty(self::$process)) {
            $rawProcess = random_bytes(8);
            // We want a hex encoded value
            self::$process = bin2hex($rawProcess);
        }

        return self::$process;
    }

    /**
     * Reads the options array passed form GAX and looks for the `retryAttempt` value.
     * If none is found, returns 1, meaning this is the first attempt
     *
     * @param array $options The options passed in from GAX
     * @return int
     */
    private function getAttempt(array $options): int
    {
        if (empty($options['retryAttempt'])) {
            return 1;
        }

        return $options['retryAttempt'] + 1;
    }

    private function getNextRequestValue(int $attempt): int
    {
        if ($attempt > 1) {
            return $this->request;
        }

        $this->request++;
        $currentValue = $this->request;
        return $currentValue;
    }
}
