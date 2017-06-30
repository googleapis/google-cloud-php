<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Tests\Storage;

use Google\Cloud\Storage\ReadStream;
use Google\Cloud\Upload\StreamableUploader;
use Prophecy\Argument;
use Psr\Http\Message\StreamInterface;

/**
 * @group storage
 */
class ReadStreamTest extends \PHPUnit_Framework_TestCase
{
    public function testReadsFromHeadersWhenGetSizeIsNull()
    {
        $httpStream = $this->prophesize(StreamInterface::class);
        $httpStream->getSize()->willReturn(null);
        $httpStream->getMetadata('wrapper_data')->willReturn([
            "Foo: bar",
            "User-Agent: php",
            "Content-Length: 1234",
            "Asdf: qwer",
        ]);

        $stream = new ReadStream($httpStream->reveal());

        $this->assertEquals(1234, $stream->getSize());
    }

    public function testReadsFromHeadersWhenGetSizeIsZero()
    {
        $httpStream = $this->prophesize(StreamInterface::class);
        $httpStream->getSize()->willReturn(0);
        $httpStream->getMetadata('wrapper_data')->willReturn([
            "Foo: bar",
            "User-Agent: php",
            "Content-Length: 1234",
            "Asdf: qwer",
        ]);

        $stream = new ReadStream($httpStream->reveal());

        $this->assertEquals(1234, $stream->getSize());
    }

    public function testNoContentLengthHeader()
    {
        $httpStream = $this->prophesize(StreamInterface::class);
        $httpStream->getSize()->willReturn(null);
        $httpStream->getMetadata('wrapper_data')->willReturn(array());

        $stream = new ReadStream($httpStream->reveal());

        $this->assertEquals(0, $stream->getSize());
    }
}
