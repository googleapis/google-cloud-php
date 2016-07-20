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

namespace Google\GAX;

use InvalidArgumentException;

/**
 * Encapsulates the custom GAPIC header information.
 */
class AgentHeaderDescriptor
{
    const AGENT_HEADER_KEY = 'x-google-apis-agent';

    private $clientName;
    private $clientVersion;
    private $codeGenName;
    private $codeGenVersion;
    private $gaxVersion;
    private $phpVersion;

    /**
     * @param array $headerInfo {
     *     Required.
     *
     *     @type string $clientName the name of the client application.
     *     @type string $clientVersion the version of the client application.
     *     @type string $codeGenName the code generator name of the client library.
     *     @type string $codeGenVersion the code generator version of the client library.
     *     @type string $gaxVersion the GAX version.
     *     @type string $phpVersion the PHP version.
     * }
     */
    public function __construct($headerInfo)
    {
        $this->clientName = $headerInfo['clientName'];
        $this->clientVersion = $headerInfo['clientVersion'];
        $this->codeGenName = $headerInfo['codeGenName'];
        $this->codeGenVersion = $headerInfo['codeGenVersion'];
        $this->gaxVersion = $headerInfo['gaxVersion'];
        $this->phpVersion = $headerInfo['phpVersion'];
    }

    /**
     * Returns an associative array that contains GAPIC header metadata.
     */
    public function getHeader()
    {
        return [self::AGENT_HEADER_KEY => "$this->clientName/$this->clientVersion;".
            "$this->codeGenName/$this->codeGenVersion;gax/$this->gaxVersion;".
            "php/$this->phpVersion"];
    }

    private static function validate($descriptor)
    {
        $requiredFields = ['clientName', 'clientVersion', 'codeGenName',
            'codeGenVersion', 'gaxVersion', 'phpVersion'];
        foreach ($requiredFields as $field) {
            if (empty($descriptor[$field])) {
                throw new InvalidArgumentException(
                    "$field is required for AgentHeaderDescriptor"
                );
            }
        }
    }
}
