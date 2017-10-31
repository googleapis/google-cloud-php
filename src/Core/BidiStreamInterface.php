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
namespace Google\Cloud\Core;

interface BidiStreamInterface
{
    /**
     * Write request to the server.
     *
     * @param mixed $request The request to write
     * @throws ValidationException
     * @throws ApiException
     */
    public function write($request);

    /**
     * Write all requests in $requests.
     *
     * @param mixed[] $requests An Iterable of request objects to write to the server
     *
     * @throws ValidationException
     * @throws ApiException
     */
    public function writeAll($requests = []);

    /**
     * Inform the server that no more requests will be written. The write() function cannot be
     * called after closeWrite() is called.
     */
    public function closeWrite();

    /**
     * Read the next response from the server. Returns null if the streaming call completed
     * successfully. Throws an ApiException if the streaming call failed.
     *
     * @throws ValidationException
     * @throws ApiException
     * @return mixed
     */
    public function read();

    /**
     * Call closeWrite(), and read all responses from the server, until the streaming call is
     * completed. Throws an ApiException if the streaming call failed.
     *
     * @throws ValidationException
     * @throws ApiException
     * @return \Generator|mixed[]
     */
    public function closeWriteAndReadAll();
}
