<?php
/*
 * Copyright 2016 Google LLC
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

use Google\Auth\Logging\LoggingTrait;
use Google\Auth\Logging\RpcLogEvent;
use Google\Protobuf\Internal\Message;
use Google\Rpc\Code;
use Psr\Log\LoggerInterface;

/**
 * ServerStream is the response object from a server streaming API call.
 */
class ServerStream
{
    use LoggingTrait;

    private $call;
    private $resourcesGetMethod;
    private null|LoggerInterface $logger;

    /**
     * ServerStream constructor.
     *
     * @param ServerStreamingCallInterface $serverStreamingCall The server streaming call object
     * @param array $streamingDescriptor
     * @param null|LoggerInterface $logger A PSR-3 compliant logger.
     */
    public function __construct(
        $serverStreamingCall,
        array $streamingDescriptor = [],
        null|LoggerInterface $logger = null
    ) {
        $this->call = $serverStreamingCall;
        if (array_key_exists('resourcesGetMethod', $streamingDescriptor)) {
            $this->resourcesGetMethod = $streamingDescriptor['resourcesGetMethod'];
        }
        $this->logger = $logger;
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
        foreach ($this->call->responses() as $response) {
            if ($this->logger && $response instanceof Message) {
                $responseEvent = new RpcLogEvent();
                $responseEvent->payload = $response->serializeToJsonString();
                $responseEvent->processId = (int) getmypid();
                $responseEvent->requestId = crc32((string) spl_object_id($this) . getmypid());

                $this->logResponse($responseEvent);
            }

            if (!is_null($resourcesGetMethod)) {
                foreach ($response->$resourcesGetMethod() as $resource) {
                    yield $resource;
                }
            } else {
                yield $response;
            }
        }

        // Errors in the REST transport will be thrown from there and not reach
        // this handling. Successful REST server-streams will have an OK status.
        $status = $this->call->getStatus();

        if ($this->logger) {
            $statusEvent = new RpcLogEvent();
            $statusEvent->status = $status->code;
            $statusEvent->processId = (int) getmypid();
            $statusEvent->requestId = crc32((string) spl_object_id($this) . getmypid());

            $this->logResponse($statusEvent);
        }

        if ($status->code !== Code::OK) {
            throw ApiException::createFromStdClass($status);
        }
    }

    /**
     * Return the underlying call object.
     *
     * @return ServerStreamingCallInterface
     */
    public function getServerStreamingCall()
    {
        return $this->call;
    }
}
