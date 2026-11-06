<?php
declare(strict_types=1);

/*
 * Copyright 2026 Google LLC
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

namespace Google\ApiCore;

/**
 * Interface implemented by all GAPIC service clients, defining common lifecycle,
 * scope, and middleware configuration methods.
 */
interface ServiceInterface
{
    /**
     * Add a middleware to the call stack by providing a callable which will be
     * invoked at the start of each call, and will return an instance of
     * {@see \Google\ApiCore\Middleware\MiddlewareInterface} when invoked.
     *
     * The callable must have the following method signature:
     *
     *     callable(MiddlewareInterface): MiddlewareInterface
     *
     * An implementation may look something like this:
     * ```
     * $client->addMiddleware(function (MiddlewareInterface $handler) {
     *     return new class ($handler) implements MiddlewareInterface {
     *         public function __construct(private MiddlewareInterface $handler) {
     *         }
     *
     *         public function __invoke(Call $call, array $options) {
     *             // modify call and options (pre-request)
     *             $response = ($this->handler)($call, $options);
     *             // modify the response (post-request)
     *             return $response;
     *         }
     *     };
     * });
     * ```
     *
     * @param callable $middlewareCallable A callable which returns an instance
     *                 of {@see \Google\ApiCore\Middleware\MiddlewareInterface} when invoked with a
     *                 MiddlewareInterface instance as its first argument.
     * @return void
     */
    public function addMiddleware(callable $middlewareCallable): void;

    /**
     * Prepend a middleware to the call stack by providing a callable which will be
     * invoked at the end of each call, and will return an instance of
     * {@see \Google\ApiCore\Middleware\MiddlewareInterface} when invoked.
     *
     * The callable must have the following method signature:
     *
     *     callable(MiddlewareInterface): MiddlewareInterface
     *
     * An implementation may look something like this:
     * ```
     * $client->prependMiddleware(function (MiddlewareInterface $handler) {
     *     return new class ($handler) implements MiddlewareInterface {
     *         public function __construct(private MiddlewareInterface $handler) {
     *         }
     *
     *         public function __invoke(Call $call, array $options) {
     *             // modify call and options (pre-request)
     *             $response = ($this->handler)($call, $options);
     *             // modify the response (post-request)
     *             return $response;
     *         }
     *     };
     * });
     * ```
     *
     * @param callable $middlewareCallable A callable which returns an instance
     *                 of {@see \Google\ApiCore\Middleware\MiddlewareInterface} when invoked with a
     *                 MiddlewareInterface instance as its first argument.
     * @return void
     */
    public function prependMiddleware(callable $middlewareCallable): void;

    /**
     * Get the default scopes required by the service.
     *
     * @return array
     */
    public static function getServiceScopes(): array;

    /**
     * Initiates an orderly shutdown in which preexisting calls continue but new
     * calls are immediately cancelled.
     *
     * @return void
     */
    public function close(): void;
}
