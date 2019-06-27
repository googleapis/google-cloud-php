<?php
/**
 * Copyright 2016 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Core\Tests\Unit\Upload;

use Google\Cloud\Core\RequestWrapper;
use Google\Cloud\Core\Upload\MultipartUploader;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;
use PHPUnit\Framework\TestCase;

/**
 * @group core
 * @group upload
 */
class MultipartUploaderTest extends TestCase
{
    public function testUploadsData()
    {
        $requestWrapper = $this->prophesize(RequestWrapper::class);
        $stream = Psr7\stream_for('abcd');
        $successBody = '{"canI":"kickIt"}';
        $response = new Response(200, [], $successBody);

        $requestWrapper->send(
            Argument::type(RequestInterface::class),
            Argument::type('array')
        )->willReturn($response);

        $uploader = new MultipartUploader(
            $requestWrapper->reveal(),
            $stream,
            'http://www.example.com'
        );

        $this->assertEquals(json_decode($successBody, true), $uploader->upload());
    }

    /**
     * @dataProvider streamSizes
     */
    public function testStreamWithoutSizeDoesNotReceiveContentLengthHeader($stream, $shouldContentLengthExist)
    {
        $requestWrapper = $this->prophesize(RequestWrapper::class);
        $requestWrapper->send(
            Argument::that(
                function (RequestInterface $request) use ($shouldContentLengthExist) {
                    return $request->hasHeader('Content-Length') === $shouldContentLengthExist;
                }
            ),
            Argument::type('array')
        )->willReturn(new Response(200, [], '{}'));

        $uploader = new MultipartUploader(
            $requestWrapper->reveal(),
            $stream,
            'http://www.example.com'
        );

        $uploader->upload();
    }

    public function streamSizes()
    {
        return [
            'stream has an unknown size' => [$this->createStreamWithSizeOf(null), false],
            'stream has an known size' => [$this->createStreamWithSizeOf(5), true],
        ];
    }

    private function createStreamWithSizeOf($size)
    {
        $stream = $this->getMockBuilder(Psr7\Stream::class)
                       ->setConstructorArgs([fopen('php://temp', 'r+')])
                       ->setMethods(['getSize'])
                       ->getMock();
        $stream->method('getSize')->willReturn($size);

        return $stream;
    }
}
