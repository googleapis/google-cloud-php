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

namespace Google\ApiCore\Tests\Unit\ResumableUpload;

use Google\ApiCore\ApiException;
use Google\ApiCore\ApiStatus;
use Google\ApiCore\ResumableUpload\ResumableUploadClient;
use Google\ApiCore\ResumableUpload\ResumableUploadState;
use Google\ApiCore\ValidationException;
use GuzzleHttp\Psr7\Utils;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;

class ResumableUploadStateTest extends TestCase
{
    public function testPrepareBufferReadsStreamAndSetsIsEof()
    {
        $state = new ResumableUploadState(
            10,
            null,
            [],
            null,
            'starting'
        );

        $stream = Utils::streamFor('hello world');
        $state->prepareBuffer($stream);

        $this->assertSame('hello worl', $state->buffer);
        $this->assertFalse($state->isEof);
    }

    public function testPrepareBufferNoopWhenBufferIsNotNull()
    {
        $state = new ResumableUploadState(
            10,
            null,
            [],
            null,
            'starting'
        );
        $state->buffer = 'existing data';

        $stream = Utils::streamFor('new data');
        $state->prepareBuffer($stream);

        $this->assertSame('existing data', $state->buffer);
    }

    public function testPrepareBufferRoundsToChunkGranularity()
    {
        $state = new ResumableUploadState(
            300000,
            null,
            [],
            null,
            'starting'
        );
        $state->chunkGranularity = 262144; // 256KB granularity

        $stream = Utils::streamFor(str_repeat('a', 400000));
        $state->prepareBuffer($stream);

        $this->assertSame(262144, strlen($state->buffer));
    }

    public function testPrepareBufferSeeksStreamWhenPositionDiffersFromCommittedOffset()
    {
        $state = new ResumableUploadState(
            5,
            null,
            [],
            null,
            'starting'
        );
        $state->committedOffset = 3;

        $stream = Utils::streamFor('abcdefghij');
        $state->prepareBuffer($stream);

        $this->assertSame('defgh', $state->buffer);
    }

    public function testPrepareBufferThrowsValidationExceptionWhenStreamNotSeekableAndPositionDiffers()
    {
        $state = new ResumableUploadState(
            5,
            null,
            [],
            null,
            'starting'
        );
        $state->committedOffset = 3;

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('tell')->willReturn(0);
        $stream->method('isSeekable')->willReturn(false);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Cannot read from stream at offset 3');
        $state->prepareBuffer($stream);
    }

    public function testCommitBufferUpdatesOffsetsAndClearsBuffer()
    {
        $state = new ResumableUploadState(
            10,
            null,
            [],
            null,
            'transmitting'
        );
        $state->committedOffset = 5;
        $state->buffer = '12345';

        $state->commitBuffer();

        $this->assertSame('12345', $state->previousBuffer);
        $this->assertSame(5, $state->previousOffset);
        $this->assertSame(10, $state->committedOffset);
        $this->assertNull($state->buffer);
    }

    public function testReconcileRecoveryOffsetSlicesCurrentBuffer()
    {
        $state = new ResumableUploadState(
            10,
            null,
            [],
            'https://upload.url',
            'recovery'
        );
        $state->committedOffset = 10;
        $state->buffer = 'abcdefghij'; // bytes 10-19

        $stream = Utils::streamFor(str_repeat('x', 30));
        $state->reconcileRecoveryOffset(14, $stream, 3);

        $this->assertSame('efghij', $state->buffer);
        $this->assertSame(14, $state->committedOffset);
        $this->assertSame(0, $state->recoveryAttempts);
        $this->assertSame(14, $state->lastRecoveryOffset);
    }

    public function testReconcileRecoveryOffsetSlicesPreviousAndCurrentBuffer()
    {
        $state = new ResumableUploadState(
            10,
            null,
            [],
            'https://upload.url',
            'recovery'
        );
        $state->previousOffset = 10;
        $state->previousBuffer = 'abcde'; // bytes 10-14
        $state->committedOffset = 15;
        $state->buffer = 'fghij'; // bytes 15-19

        $stream = Utils::streamFor(str_repeat('x', 30));
        $state->reconcileRecoveryOffset(12, $stream, 3);

        $this->assertSame('cdefghij', $state->buffer);
        $this->assertSame(12, $state->committedOffset);
    }

    public function testReconcileRecoveryOffsetSeeksStreamWhenOutsideBuffers()
    {
        $state = new ResumableUploadState(
            10,
            null,
            [],
            'https://upload.url',
            'recovery'
        );
        $state->committedOffset = 20;
        $state->buffer = 'abcde'; // bytes 20-24

        $stream = Utils::streamFor(str_repeat('x', 100));
        $state->reconcileRecoveryOffset(50, $stream, 3);

        $this->assertNull($state->buffer);
        $this->assertSame(50, $state->committedOffset);
        $this->assertSame(50, $stream->tell());
    }

    public function testReconcileRecoveryOffsetThrowsValidationExceptionWhenStreamNotSeekableAndOutsideBuffers()
    {
        $state = new ResumableUploadState(
            10,
            null,
            [],
            'https://upload.url',
            'recovery'
        );
        $state->committedOffset = 20;
        $state->buffer = 'abcde';

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('isSeekable')->willReturn(false);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Cannot recover resumable upload: the server confirmed offset 50');
        $state->reconcileRecoveryOffset(50, $stream, 3);
    }

    public function testReconcileRecoveryOffsetExhaustsAttemptsWhenOffsetUnchanged()
    {
        $state = new ResumableUploadState(
            10,
            null,
            [],
            'https://upload.url',
            'recovery'
        );
        $state->committedOffset = 10;
        $state->buffer = 'abcde';
        $state->lastRecoveryOffset = 10;
        $state->recoveryAttempts = 2;

        $stream = Utils::streamFor(str_repeat('x', 30));

        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Exhausted recovery attempts with unchanged offset');
        $state->reconcileRecoveryOffset(10, $stream, 3);
    }
}
