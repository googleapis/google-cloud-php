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

namespace Google\Cloud\Tests\Unit\Core\Upload;

use Google\Cloud\Core\RequestWrapper;
use Google\Cloud\Core\Upload\MultipartUploader;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;

/**
 * @group core
 * @group upload
 */
class MultipartUploaderTest extends \PHPUnit_Framework_TestCase
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
}
