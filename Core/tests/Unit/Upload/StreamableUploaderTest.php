<?php
/**
 * Copyright 2017 Google Inc.
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

use Google\Cloud\Core\Exception\GoogleException;
use Google\Cloud\Core\RequestWrapper;
use Google\Cloud\Core\Upload\StreamableUploader;
use GuzzleHttp\Psr7\BufferStream;
use GuzzleHttp\Psr7\Response;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group core
 * @group upload
 */
class StreamableUploaderTest extends TestCase
{
    use ExpectException;

    private $requestWrapper;
    private $stream;
    private $successBody;

    public function set_up()
    {
        $this->requestWrapper = $this->prophesize(RequestWrapper::class);
        $this->stream = new BufferStream(16);
        $this->successBody = '{"canI":"kickIt"}';
    }

    public function testStreamingWrites()
    {
        $resumeResponse = new Response(200, ['Location' => 'http://some-resume-uri.example.com'], $this->successBody);
        $this->requestWrapper->send(
            Argument::that(function ($request) {
                return (string) $request->getUri() == 'http://www.example.com';
            }),
            Argument::type('array')
        )->willReturn($resumeResponse);

        $uploadResponse = new Response(200, [], $this->successBody);
        $upload = $this->requestWrapper->send(
            Argument::that(function ($request) {
                return (string) $request->getUri() == 'http://some-resume-uri.example.com';
            }),
            Argument::type('array')
        )->willReturn($uploadResponse);

        $uploader = new StreamableUploader(
            $this->requestWrapper->reveal(),
            $this->stream,
            'http://www.example.com',
            ['chunkSize' => 16]
        );

        // write some data smaller than the chunk size
        $this->stream->write("0123456789");

        // write some more data that will put us over the chunk size.
        $this->stream->write("more text");

        $uploader->upload(16);
        $upload->shouldHaveBeenCalledTimes(1);

        // finish the upload
        $this->assertEquals(json_decode($this->successBody, true), $uploader->upload());
        $upload->shouldHaveBeenCalledTimes(2);
    }

    public function testUploadsData()
    {
        $response = new Response(200, ['Location' => 'theResumeUri'], $this->successBody);

        $this->requestWrapper->send(
            Argument::type(RequestInterface::class),
            Argument::type('array')
        )->willReturn($response)->shouldBeCalled();

        $uploader = new StreamableUploader(
            $this->requestWrapper->reveal(),
            $this->stream,
            'http://www.example.com'
        );

        $this->assertEquals(json_decode($this->successBody, true), $uploader->upload());
    }

    public function testGetResumeUri()
    {
        $resumeUri = 'theResumeUri';
        $response = new Response(200, ['Location' => $resumeUri]);

        $this->requestWrapper->send(
            Argument::type(RequestInterface::class),
            Argument::type('array')
        )->willReturn($response)->shouldBeCalled();

        $uploader = new StreamableUploader(
            $this->requestWrapper->reveal(),
            $this->stream,
            'http://www.example.com'
        );

        $this->assertEquals($resumeUri, $uploader->getResumeUri());
    }

    public function testThrowsExceptionWithFailedUpload()
    {
        $this->expectException('Google\Cloud\Core\Exception\GoogleException');

        $resumeUriResponse = new Response(200, ['Location' => 'theResumeUri']);

        $this->requestWrapper->send(
            Argument::which('getMethod', 'POST'),
            Argument::type('array')
        )->willReturn($resumeUriResponse)->shouldBeCalled();

        $this->requestWrapper->send(
            Argument::which('getMethod', 'PUT'),
            Argument::type('array')
        )->willThrow(GoogleException::class)->shouldBeCalled();

        $uploader = new StreamableUploader(
            $this->requestWrapper->reveal(),
            $this->stream,
            'http://www.example.com'
        );

        $uploader->upload();
    }

    public function testLastChunkSendsCorrectHeaders()
    {
        $resumeUriResponse = new Response(200, ['Location' => 'theResumeUri']);
        $response = new Response(200, ['Location' => 'theResumeUri'], $this->successBody);

        $this->requestWrapper->send(
            Argument::which('getMethod', 'POST'),
            Argument::type('array')
        )->willReturn($resumeUriResponse)->shouldBeCalled();

        $this->requestWrapper->send(
            Argument::that(function ($request) {
                return $request->getHeaderLine('Content-Length') == '10';
            }),
            Argument::type('array')
        )->willReturn($response)->shouldBeCalled();

        $uploader = new StreamableUploader(
            $this->requestWrapper->reveal(),
            $this->stream,
            'http://www.example.com'
        );
        $this->stream->write('0123456789');
        $uploader->upload();
    }

    public function testThrowsExceptionWhenAttemptsAsyncUpload()
    {
        $this->expectException('Google\Cloud\Core\Exception\GoogleException');

        $stream = $this->prophesize(StreamInterface::class);
        $uploader = new StreamableUploader(
            $this->requestWrapper->reveal(),
            $stream->reveal(),
            'http://www.example.com'
        );

        $uploader->uploadAsync();
    }
}
