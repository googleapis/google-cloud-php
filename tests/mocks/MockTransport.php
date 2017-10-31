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

namespace Google\Cloud\Tests\Mocks;

use Google\Cloud\Core\ApiTransportInterface;
use Google\Cloud\Core\CallStackTrait;
use Google\GAX\ApiException;
use Google\GAX\CallSettings;
use Google\GAX\Testing\ReceivedRequest;

class MockTransport implements ApiTransportInterface
{
    use CallStackTrait;
    use MockStubTrait;

    /**
     * Creates an API request
     * @return callable
     */
    public function createApiCall($method, CallSettings $settings, $options = [])
    {
        $handler = [$this, $method];
        $callable = function () use ($handler) {
            list($response, $status) = call_user_func_array($handler, func_get_args())->wait();
            if ($status->code == \Google\Rpc\Code::OK) {
                return $response;
            } else {
                throw ApiException::createFromStdClass($status);
            }
        };
        return $this->createCallStack($callable, $settings, $options);
    }

    public function __call($name, $arguments)
    {
        $metadata = [];
        $options = [];
        list($request, $optionalArgs) = $arguments;

        if (array_key_exists('headers', $optionalArgs)) {
            $metadata = $optionalArgs['headers'];
        }

        $newArgs = [$name, $request, $this->deserialize, $metadata, $optionalArgs];
        return call_user_func_array(array($this, '_simpleRequest'), $newArgs);
    }

    public function methodThatSleeps($argument, $options)
    {
        $metadata = [];
        $this->receivedFuncCalls[] = new ReceivedRequest(
            'methodThatSleeps',
            $argument,
            $this->deserialize,
            $metadata,
            $options
        );
        $timeoutMillis = isset($options['timeoutMillis']) ? $options['timeoutMillis'] : null;
        $call = new MockDeadlineExceededUnaryCall($timeoutMillis * 1000);
        $this->callObjects[] = $call;
        return $call;
    }
}
