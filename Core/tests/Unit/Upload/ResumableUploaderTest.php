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

use Google\Cloud\Core\Exception\GoogleException;
use Google\Cloud\Core\RequestWrapper;
use Google\Cloud\Core\Upload\ResumableUploader;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;
use InvalidArgumentException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Argument;

/**
 * @group core
 * @group upload
 */
class ResumableUploaderTest extends TestCase
{
    use ProphecyTrait;

    private $requestWrapper;
    private $stream;
    private $successBody;

    public function setUp(): void
    {
        $this->requestWrapper = $this->prophesize(RequestWrapper::class);
        $this->stream = Utils::streamFor('abcd');
        $this->successBody = '{"canI":"kickIt"}';
    }

    public function testUploadsData()
    {
        $response = new Response(200, ['Location' => 'theResumeUri'], $this->successBody);

        $this->requestWrapper->send(
            Argument::type(RequestInterface::class),
            Argument::type('array')
        )->willReturn($response);

        $uploader = new ResumableUploader(
            $this->requestWrapper->reveal(),
            $this->stream,
            'http://www.example.com'
        );

        $this->assertEquals(json_decode($this->successBody, true), $uploader->upload());
    }

    public function testUploadsDataWithCallback()
    {
        $response = new Response(200, ['Location' => 'theResumeUri'], $this->successBody);

        $called = false;
        $callback = function () use (&$called) {
            $called = true;
        };

        $this->requestWrapper->send(
            Argument::type(RequestInterface::class),
            Argument::type('array')
        )->willReturn($response);

        $uploader = new ResumableUploader(
            $this->requestWrapper->reveal(),
            $this->stream,
            'http://www.example.com',
            ['uploadProgressCallback' => $callback]
        );

        $this->assertEquals(json_decode($this->successBody, true), $uploader->upload());
        $this->assertTrue($called);
    }

    public function testUploadsDataWithInvalidCallback()
    {
        $this->expectException(InvalidArgumentException::class);

        $callback = 'foo';

        $uploader = new ResumableUploader(
            $this->requestWrapper->reveal(),
            $this->stream,
            'http://www.example.com',
            ['uploadProgressCallback' => $callback]
        );
    }

    public function testGetResumeUri()
    {
        $resumeUri = 'theResumeUri';
        $response = new Response(200, ['Location' => $resumeUri]);

        $this->requestWrapper->send(
            Argument::type(RequestInterface::class),
            Argument::type('array')
        )->willReturn($response);

        $uploader = new ResumableUploader(
            $this->requestWrapper->reveal(),
            $this->stream,
            'http://www.example.com'
        );

        $this->assertEquals($resumeUri, $uploader->getResumeUri());
    }

    public function testResumesUpload()
    {
        $response = new Response(200, [], $this->successBody);
        $statusResponse = new Response(200, ['Range' => 'bytes 0-2']);

        $this->requestWrapper->send(
            Argument::type(RequestInterface::class),
            Argument::type('array')
        )->willReturn($response);

        $this->requestWrapper->send(
            Argument::that(function ($request) {
                return $request->getHeaderLine('Content-Range') === 'bytes */*';
            }),
            Argument::type('array')
        )->willReturn($statusResponse);

        $uploader = new ResumableUploader(
            $this->requestWrapper->reveal(),
            $this->stream,
            'http://www.example.com'
        );

        $this->assertEquals(
            json_decode($this->successBody, true),
            $uploader->resume('http://some-resume-uri.example.com')
        );
    }

    public function testResumeFinishedUpload()
    {
        $statusResponse = new Response(200, [], $this->successBody);

        $this->requestWrapper->send(
            Argument::type(RequestInterface::class),
            Argument::type('array')
        )->willReturn($statusResponse);

        $uploader = new ResumableUploader(
            $this->requestWrapper->reveal(),
            $this->stream,
            'http://www.example.com'
        );

        $this->assertEquals(
            json_decode($this->successBody, true),
            $uploader->resume('http://some-resume-uri.example.com')
        );
    }

    /**
     * This tests whether retry related options are properly set in the
     * abstract uploader class. Since we already had these tests for
     * ResumableUploader class which extends the AbstractUploader class,
     * thus testing it here would be sufficient.
     */
    public function testRetryOptionsPassing()
    {
        $attempt = 0;
        $retryFunctionCalled = false;
        $retryListenerCalled = false;
        $requestWrapper = new RequestWrapper([
            'httpHandler' => function () use (&$attempt) {
                if ($attempt++ < 1) {
                    throw new \Exception('retry!');
                }
                return new Response(200, [], $this->successBody);
            },
            'authHttpHandler' => function () {
                return new Response(200, [], '{"access_token": "abc"}');
            },
        ]);
        $options = [
            'restRetryFunction' => function () use (&$retryFunctionCalled) {
                $retryFunctionCalled = true;
                return true;
            },
            'restRetryListener' => function () use (&$retryListenerCalled) {
                $retryListenerCalled = true;
            },
        ];
        $uploader = new ResumableUploader(
            $requestWrapper,
            $this->stream,
            'http://www.example.com',
            $options
        );
        $uploader->upload();

        $this->assertTrue($retryFunctionCalled);
        $this->assertTrue($retryListenerCalled);
    }

    public function testThrowsExceptionWhenAttemptsAsyncUpload()
    {
        $this->expectException(GoogleException::class);

        $stream = $this->prophesize(StreamInterface::class);
        $uploader = new ResumableUploader(
            $this->requestWrapper->reveal(),
            $stream->reveal(),
            'http://www.example.com'
        );

        $uploader->uploadAsync();
    }

    public function testThrowsExceptionWhenResumingNonSeekableStream()
    {
        $this->expectException(GoogleException::class);

        $stream = $this->prophesize(StreamInterface::class);
        $stream->isSeekable()->willReturn(false);
        $stream->getMetadata('uri')->willReturn('blah');

        $uploader = new ResumableUploader(
            $this->requestWrapper->reveal(),
            $stream->reveal(),
            'http://www.example.com'
        );

        $uploader->resume('http://some-resume-uri.example.com');
    }

    public function testThrowsExceptionWithFailedUpload()
    {
        $this->expectException(GoogleException::class);

        $resumeUriResponse = new Response(200, ['Location' => 'theResumeUri']);

        $this->requestWrapper->send(
            Argument::which('getMethod', 'POST'),
            Argument::type('array')
        )->willReturn($resumeUriResponse);

        $this->requestWrapper->send(
            Argument::which('getMethod', 'PUT'),
            Argument::type('array')
        )->willThrow(GoogleException::class);

        $uploader = new ResumableUploader(
            $this->requestWrapper->reveal(),
            $this->stream,
            'http://www.example.com'
        );

        $uploader->upload();
    }
}
