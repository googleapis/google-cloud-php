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

namespace Google\GAX\Testing;

class MockStub
{
    // invariant: count($responseSequence) >= 1
    private $responseSequence;

    public $actualCalls;

    private function __construct()
    {
        $this->actualCalls = [];
    }

    public static function create($responseObject)
    {
        $stub = new MockStub();
        $status = new MockStatus(\Grpc\STATUS_OK, '');
        $stub->responseSequence = [[$responseObject, $status]];
        return $stub;
    }

    /**
     * Creates a sequence such that the responses are returned in order,
     * and once there is only one left, it is repeated indefinitely.
     */
    public static function createWithResponseSequence($sequence)
    {
        if (count($sequence) == 0) {
            throw new \InvalidArgumentException("createResponseSequence: need at least 1 response");
        }
        $stub = new MockStub();
        $stub->responseSequence = $sequence;
        return $stub;
    }

    public function takeAction($request, $metadata = array(), $options = array())
    {
        $actualCall = [
            'request' => $request,
            'metadata' => $metadata,
            'options' => $options];
        array_push($this->actualCalls, $actualCall);
        if (count($this->responseSequence) == 1) {
            return new MockGrpcCall($this->responseSequence[0]);
        } else {
            $response = array_shift($this->responseSequence);
            return new MockGrpcCall($response);
        }
    }
}

class MockGrpcCall
{
    // this will be an array of [responseObject, status]
    private $response;
    public function __construct($response)
    {
        $this->response = $response;
    }

    public function wait()
    {
        return $this->response;
    }
}
