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
use Google\Cloud\Core\Upload\SignedUrlUploader;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group core
 * @group upload
 */
class SignedUrlUploaderTest extends TestCase
{
    private $requestWrapper;
    private $stream;
    private $successBody;

    public function set_up()
    {
        $this->requestWrapper = $this->prophesize(RequestWrapper::class);
        $this->stream = Utils::streamFor('abcd');
        $this->successBody = '{"canI":"kickIt"}';
    }

    public function testGetResumeUri()
    {
        $resumeUri = 'theResumeUri';
        $response = new Response(200, ['Location' => $resumeUri]);

        $this->requestWrapper->send(
            Argument::that(function ($arg) {
                if (!($arg instanceof RequestInterface)) {
                    return false;
                }

                if ($arg->getHeaderLine('Content-Type') !== 'application/octet-stream') {
                    return false;
                }

                if ($arg->getHeaderLine('Content-Length') != 0) {
                    return false;
                }

                if ($arg->getHeaderLine('x-goog-resumable') !== 'start') {
                    return false;
                }

                return true;
            }),
            Argument::type('array')
        )->willReturn($response);

        $uploader = new SignedUrlUploader(
            $this->requestWrapper->reveal(),
            $this->stream,
            'http://www.example.com'
        );

        $this->assertEquals($resumeUri, $uploader->getResumeUri());
    }
}
