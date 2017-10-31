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
use Google\Cloud\Core\Grpc\GrpcBidiStream;
use Google\Cloud\Core\Grpc\GrpcClientStream;
use Google\Cloud\Core\Grpc\GrpcServerStream;
use Google\GAX\CallSettings;

class MockStreamingTransport implements ApiTransportInterface
{
    use CallStackTrait;
    use MockStubTrait;

    private $descriptor;

    public function setStreamingDescriptor($descriptor)
    {
        $this->descriptor = $descriptor;
    }

    /**
     * Creates an API request
     * @return callable
     */
    public function createApiCall($method, CallSettings $settings, $options = [])
    {
        $handler = [$this, $method];
        $callable = function () use ($handler) {
            return call_user_func_array($handler, func_get_args());
        };
        return $this->createCallStack($callable, $settings, $options);
    }

    public function __call($name, $arguments)
    {
        $metadata = [];
        list($request, $optionalArgs) = $arguments;

        if (array_key_exists('headers', $optionalArgs)) {
            $metadata = $optionalArgs['headers'];
        }

        switch ($this->descriptor['grpcStreamingType']) {
            case 'BidiStreaming':
                $newArgs = [$name, $this->deserialize, $metadata, $optionalArgs];
                $response = call_user_func_array(array($this, '_bidiRequest'), $newArgs);
                return new GrpcBidiStream($response, $this->descriptor);

            case 'ClientStreaming':
                $newArgs = [$name, $this->deserialize, $metadata, $optionalArgs];
                $response = call_user_func_array(array($this, '_clientStreamRequest'), $newArgs);
                return new GrpcClientStream($response, $this->descriptor);

            case 'ServerStreaming':
                $newArgs = [$name, $request, $this->deserialize, $metadata, $optionalArgs];
                $response = call_user_func_array(array($this, '_serverStreamRequest'), $newArgs);
                return new GrpcServerStream($response, $this->descriptor);

            default:
                throw new \Exception('Invalid streaming type');
        }
    }
}
