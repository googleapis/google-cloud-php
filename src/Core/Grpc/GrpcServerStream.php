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
namespace Google\Cloud\Core\Grpc;

use Google\Cloud\Core\ServerStreamInterface;
use Google\GAX\ApiException;
use Google\GAX\CallHelperTrait;
use Google\Rpc\Code;

class GrpcServerStream implements ServerStreamInterface
{
    private $call;
    private $resourcesGetMethod;

    /**
     * ServerStream constructor.
     *
     * @param \Grpc\ServerStreamingCall $serverStreamingCall The gRPC server streaming call object
     * @param array $grpcStreamingDescriptor
     */
    public function __construct(\Grpc\ServerStreamingCall $serverStreamingCall, $grpcStreamingDescriptor = [])
    {
        $this->call = $serverStreamingCall;
        if (array_key_exists('resourcesGetMethod', $grpcStreamingDescriptor)) {
            $this->resourcesGetMethod = $grpcStreamingDescriptor['resourcesGetMethod'];
        }
    }

    /**
     * A generator which yields results from the server until the streaming call
     * completes. Throws an ApiException if the streaming call failed.
     *
     * @throws ApiException
     * @return \Generator|mixed
     */
    public function readAll()
    {
        $resourcesGetMethod = $this->resourcesGetMethod;
        if (!is_null($resourcesGetMethod)) {
            foreach ($this->call->responses() as $response) {
                foreach ($response->$resourcesGetMethod() as $resource) {
                    yield $resource;
                }
            }
        } else {
            foreach ($this->call->responses() as $response) {
                yield $response;
            }
        }
        $status = $this->call->getStatus();
        if (!($status->code == Code::OK)) {
            throw ApiException::createFromStdClass($status);
        }
    }

    /**
     * Return the underlying gRPC call object
     *
     * @return \Grpc\ServerStreamingCall
     */
    public function getServerStreamingCall()
    {
        return $this->call;
    }
}
