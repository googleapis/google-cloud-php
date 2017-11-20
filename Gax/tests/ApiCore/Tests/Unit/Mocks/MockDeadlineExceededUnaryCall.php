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

namespace Google\ApiCore\Tests\Unit\Mocks;

use Google\ApiCore\Testing\MockStatus;
use Google\ApiCore\ValidationException;
use Google\Rpc\Code;

/**
 * Class MockDeadlineExceededUnaryCall simulates a unary call returning DEADLINE_EXCEEDED.
 *
 * If $timeoutMicros is set, the call to wait() will sleep before returning.
 */
class MockDeadlineExceededUnaryCall
{
    private $timeoutMicros;

    public function __construct($timeoutMicros = null)
    {
        $this->timeoutMicros = $timeoutMicros;
    }

    /**
     * Wait for $timeoutMicros, then return DEADLINE_EXCEEDED
     * @return array The null response object and DEADLINE_EXCEEDED status.
     */
    public function wait()
    {
        if ($this->timeoutMicros) {
            usleep($this->timeoutMicros);
        }
        return [null, new MockStatus(Code::DEADLINE_EXCEEDED, 'Deadline Exceeded')];
    }
}
