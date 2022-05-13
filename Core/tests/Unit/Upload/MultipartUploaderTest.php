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
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Promise;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Utils;
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
        $stream = Utils::streamFor('abcd');
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

    public function testUploadsAsyncData()
    {
        $requestWrapper = $this->prophesize(RequestWrapper::class);
        $stream = Utils::streamFor('abcd');
        $successBody = '{"canI":"kickIt"}';
        $response = new Response(200, [], $successBody);
        $promise = Promise\promise_for($response);

        $requestWrapper->sendAsync(
            Argument::type(RequestInterface::class),
            Argument::type('array')
        )->willReturn($promise);

        $uploader = new MultipartUploader(
            $requestWrapper->reveal(),
            $stream,
            'http://www.example.com'
        );

        $actualPromise = $uploader->uploadAsync();
        $actualPromise->wait();
        $this->assertInstanceOf(PromiseInterface::class, $actualPromise);
        $this->assertEquals(
            json_decode($successBody, true),
            $actualPromise->wait()
        );
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
                    $this->assertEquals($request->hasHeader('Content-Length'), $shouldContentLengthExist);
                    return true;
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
        $stream = $this->prophesize(Psr7\Stream::class);
        $stream->getSize()
            ->willReturn($size);
        $stream->isReadable()
            ->willReturn(true);
        $stream->isSeekable()
            ->willReturn(true);

        return $stream->reveal();
    }
}
