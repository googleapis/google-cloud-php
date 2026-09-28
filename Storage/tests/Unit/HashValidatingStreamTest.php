<?php
/**
 * Copyright 2026 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Storage\Tests\Unit;

use Google\Cloud\Storage\HashValidatingStream;
use GuzzleHttp\Psr7\Utils;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

/**
 * @group storage
 */
class HashValidatingStreamTest extends TestCase
{
    private $testData = 'this is a test download payload';
    private $correctCrc32c;
    private $correctMd5;

    public function setUp(): void
    {
        $this->correctCrc32c = base64_encode(hash('crc32c', $this->testData, true));
        $this->correctMd5 = base64_encode(hash('md5', $this->testData, true));
    }

    public function testValidCrc32cReadSequentiallySucceeds()
    {
        $rawStream = Utils::streamFor($this->testData);
        $stream = new HashValidatingStream($rawStream, [
            'expectedCrc32c' => $this->correctCrc32c
        ]);

        $content = '';
        while (!$stream->eof()) {
            $content .= $stream->read(4);
        }

        $this->assertEquals($this->testData, $content);
    }

    public function testValidCrc32cGetContentsSucceeds()
    {
        $rawStream = Utils::streamFor($this->testData);
        $stream = new HashValidatingStream($rawStream, [
            'expectedCrc32c' => $this->correctCrc32c
        ]);

        $content = $stream->getContents();
        $this->assertEquals($this->testData, $content);
    }

    public function testValidMd5GetContentsSucceeds()
    {
        $rawStream = Utils::streamFor($this->testData);
        $stream = new HashValidatingStream($rawStream, [
            'expectedMd5' => $this->correctMd5
        ]);

        $content = $stream->getContents();
        $this->assertEquals($this->testData, $content);
    }

    public function testValidBothCrc32cAndMd5Succeeds()
    {
        $rawStream = Utils::streamFor($this->testData);
        $stream = new HashValidatingStream($rawStream, [
            'expectedCrc32c' => $this->correctCrc32c,
            'expectedMd5' => $this->correctMd5
        ]);

        $content = $stream->getContents();
        $this->assertEquals($this->testData, $content);
    }

    public function testInvalidCrc32cThrowsException()
    {
        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('CRC32C checksum mismatch');

        $rawStream = Utils::streamFor($this->testData);
        $stream = new HashValidatingStream($rawStream, [
            'expectedCrc32c' => 'invalidcrc32c='
        ]);

        $stream->getContents();
    }

    public function testInvalidMd5ThrowsException()
    {
        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('MD5 checksum mismatch');

        $rawStream = Utils::streamFor($this->testData);
        $stream = new HashValidatingStream($rawStream, [
            'expectedMd5' => 'invalidmd5hash=='
        ]);

        $stream->getContents();
    }

    public function testNoHashesRequestedNoValidation()
    {
        $rawStream = Utils::streamFor($this->testData);
        $stream = new HashValidatingStream($rawStream, []);

        $content = $stream->getContents();
        $this->assertEquals($this->testData, $content);
    }

    public function testStreamIsNonSeekable()
    {
        $rawStream = Utils::streamFor($this->testData);
        $stream = new HashValidatingStream($rawStream, []);

        $this->assertFalse($stream->isSeekable());
    }

    public function testSeekThrowsException()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Seeking is not supported on a validating stream.');

        $rawStream = Utils::streamFor($this->testData);
        $stream = new HashValidatingStream($rawStream, []);

        $stream->seek(0);
    }
}
