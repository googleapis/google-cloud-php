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

namespace Google\Cloud\Tests;

use Google\Cloud\Tests\Mocks\MockRequest;

trait MockTrait
{
    public function createMockRequest($token = null, $pageSize = null)
    {
        return new MockRequest($token, $pageSize);
    }

    public function createMockResponse($pageToken = null, $resourcesList = [])
    {
        $mockResponse = $this->getMockBuilder(MockResponse::class)
            ->setMethods(['getResourcesList', 'getNextPageToken'])
            ->getMock();
        $mockResponse->method('getNextPageToken')
            ->willReturn($pageToken);
        $mockResponse->method('getResourcesList')
            ->willReturn($resourcesList);

        return $mockResponse;
    }

    public function createCallWithResponseSequence($sequence)
    {
        foreach ($sequence as $key => $value) {
            if (!is_array($value)) {
                $sequence[$key] = [$value, null];
            }
        }
        $mockCall = $this->getMockBuilder(MockCall::class)
            ->setMethods(['takeAction'])
            ->getMock();
        $mockCall->method('takeAction')
            ->will(call_user_func_array([$this, 'onConsecutiveCalls'], $sequence));

        return $mockCall;
    }
}
