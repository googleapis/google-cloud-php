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

use Google\ApiCore\ApiException;
use Google\ApiCore\ArrayTrait;
use Google\ApiCore\BidiStream;
use Google\ApiCore\Call;
use Google\ApiCore\ClientStream;
use Google\ApiCore\Middleware\MiddlewareInterface;
use Google\ApiCore\ServerStream;
use Google\Cloud\Core\RequestProcessorTrait;
use Google\Cloud\Spanner\Serializer;
use GuzzleHttp\Promise\PromiseInterface;
use Throwable;

/**
 * Middleware for Spanner that adds the following functionality:
 *
 *  - Wraps any Api Exception to a `Google\Cloud\Core\Exception` exception
 *    class. This is primarily to maintain backwards compatibility with previous
 *    Spanner versions.
 *  -
 *
 * @internal
 */
class SpannerMiddleware implements MiddlewareInterface
{
    use ArrayTrait;
    use RequestProcessorTrait;

    private const ROUTE_TO_LEADER_HEADER = 'x-goog-spanner-route-to-leader';
    private const RESOURCE_PREFIX_HEADER = 'google-cloud-resource-prefix';

    /** @var callable */
    private $nextHandler;
    private Serializer $serializer;

    public function __construct(callable $nextHandler)
    {
        $this->nextHandler = $nextHandler;
        $this->serializer = new Serializer();
    }

    /**
     * @param Call $call
     * @param array $options
     *
     * @return PromiseInterface|ClientStream|ServerStream|BidiStream
     * @throws Throwable
     */
    public function __invoke(
        Call $call,
        array $options
    ): PromiseInterface|ClientStream|ServerStream|BidiStream {
        if ($resourcePrefix = $this->pluck('resource-prefix', $options, false)) {
            $options['headers'][self::RESOURCE_PREFIX_HEADER] = [$resourcePrefix];
        }

        if (true === $this->pluck('route-to-leader', $options, false)) {
            $options['headers'][self::ROUTE_TO_LEADER_HEADER] = ['true'];
        }

        $response = ($this->nextHandler)($call, $options);
        if ($response instanceof PromiseInterface) {
            return $response->then(null, function ($value) {
                if ($value instanceof ApiException) {
                    throw $this->convertToGoogleException($value);
                }
                if ($value instanceof Throwable) {
                    throw $value;
                }
            });
        }

        // this can also be a Stream
        return $response;
    }
}
