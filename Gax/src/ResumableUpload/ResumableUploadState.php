<?php
/*
 * Copyright 2026 Google LLC
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

namespace Google\ApiCore\ResumableUpload;

use Psr\Http\Message\ResponseInterface;

/**
 * State container for an active resumable upload session.
 *
 * @internal
 */
class ResumableUploadState
{
    public string $previousPhase;
    public int $committedOffset = 0;
    public int $chunkGranularity = 1;
    public int $recoveryAttempts = 0;
    public int $lastRecoveryOffset = -1;
    public ?string $buffer = null;
    public ?string $previousBuffer = null;
    public int $previousOffset = 0;
    public bool $isEof = false;
    public ?ResponseInterface $finalResponse = null;

    /**
     * @param int $chunkSize
     * @param callable|null $progressCallback
     * @param array $headers
     * @param ?string $uploadUrl
     * @param string $phase
     */
    public function __construct(
        public int $chunkSize,
        /** @var callable|null $progressCallback */
        public $progressCallback,
        public array $headers,
        public ?string $uploadUrl,
        public string $phase
    ) {
        $this->previousPhase = $phase;
    }
}
