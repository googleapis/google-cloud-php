<?php
declare(strict_types=1);

/*
 * Copyright 2023 Google LLC
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

namespace Google\ApiCore\Options;

use ArrayAccess;
use Google\ApiCore\Options\TransportOptions\GrpcFallbackTransportOptions;
use Google\ApiCore\Options\TransportOptions\GrpcTransportOptions;
use Google\ApiCore\Options\TransportOptions\RestTransportOptions;

class TransportOptions implements ArrayAccess, OptionsInterface
{
    use OptionsTrait;

    protected GrpcTransportOptions $grpc;

    protected GrpcFallbackTransportOptions $grpcFallback;

    protected RestTransportOptions $rest;

    /**
     * @param array $options {
     *    Config options used to construct the transport.
     *
     *    @type array $grpc
     *    @type array $grpcFallback
     *    @type array $rest
     * }
     */
    public function __construct(array $options = [])
    {
        $this->fromArray($options);
    }

    /**
     * Sets the array of options as class properties.
     *
     * @param array $arr See the constructor for the list of supported options.
     */
    protected function fromArray(array $arr): void
    {
        $this->setGrpc($arr['grpc'] ?? []);
        $this->setGrpcFallback($arr['grpc-fallback'] ?? $arr['grpcFallback'] ?? []);
        $this->setRest($arr['rest'] ?? []);
    }

    /**
     * @param GrpcTransportOptions|array $grpc
     *
     * @return static
     */
    public function setGrpc(GrpcTransportOptions|array $grpc): static
    {
        if (is_array($grpc)) {
            $grpc = new GrpcTransportOptions($grpc);
        }
        $this->grpc = $grpc;

        return $this;
    }

    /**
     * @param GrpcFallbackTransportOptions|array $grpcFallback
     *
     * @return static
     */
    public function setGrpcFallback(GrpcFallbackTransportOptions|array $grpcFallback): static
    {
        if (is_array($grpcFallback)) {
            $grpcFallback = new GrpcFallbackTransportOptions($grpcFallback);
        }
        $this->grpcFallback = $grpcFallback;

        return $this;
    }

    /**
     * @param RestTransportOptions|array $rest
     *
     * @return static
     */
    public function setRest(RestTransportOptions|array $rest): static
    {
        if (is_array($rest)) {
            $rest = new RestTransportOptions($rest);
        }
        $this->rest = $rest;

        return $this;
    }

    public function offsetExists($offset): bool
    {
        if ($offset === 'grpc-fallback') {
            $offset = 'grpcFallback';
        }
        return isset($this->$offset);
    }

    /**
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        if ($offset === 'grpc-fallback') {
            $offset = 'grpcFallback';
        }
        return $this->$offset ?? null;
    }

    public function toArray(): array
    {
        return [
            'grpc' => $this->grpc->toArray(),
            'grpc-fallback' => $this->grpcFallback->toArray(),
            'rest' => $this->rest->toArray(),
        ];
    }
}
