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

use InvalidArgumentException;

/**
* Middleware that adds custom headers
*/
class CustomHeaderMiddleware
{
    const TRANSPORT_METHOD_PARAM_COUNT = 2;
    const TRANSPORT_METHOD_OPTIONS_INDEX = 1;

    /** @var callable */
    private $nextHandler;

    /** @var array */
    private $headerDescriptor;

    /** @var array */
    private $userHeaders;

    public function __construct(callable $nextHandler, $headerDescriptor, $userHeaders = null)
    {
        $this->nextHandler = $nextHandler;
        $this->headerDescriptor = $headerDescriptor;
        $this->userHeaders = $userHeaders;
    }

    public function __invoke()
    {
        $params = func_get_args();

        if (count($params) != self::TRANSPORT_METHOD_PARAM_COUNT) {
            throw new InvalidArgumentException('Invalid parameter count.');
        }

        if (!is_array($params[self::TRANSPORT_METHOD_OPTIONS_INDEX])) {
            throw new InvalidArgumentException('Options argument is not found.');
        }

        $headers = [];
        // Check user-specified $headers first, and then merge $headerDescriptor headers, to ensure
        // that $headerDescriptor headers such as x-goog-api-client cannot be overwritten
        // by the $userHeaders.
        $options = $params[self::TRANSPORT_METHOD_OPTIONS_INDEX];
        if (array_key_exists('headers', $options)) {
            $headers = $options['headers'];
        }
        if (!is_null($this->userHeaders)) {
            $headers = array_merge($headers, $this->userHeaders);
        }
        if (!is_null($this->headerDescriptor)) {
            $headers = array_merge($headers, $this->headerDescriptor->getHeader());
        }
        $params[self::TRANSPORT_METHOD_OPTIONS_INDEX]['headers'] = $headers;

        return call_user_func_array($this->nextHandler, $params);
    }
}
