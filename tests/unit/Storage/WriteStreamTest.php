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

use Google\Cloud\Storage\WriteStream;
use Google\Cloud\Core\Upload\StreamableUploader;
use Prophecy\Argument;


/**
 * @group storage
 */
class WriteStreamTest extends \PHPUnit_Framework_TestCase
{
    public function testUploadsWhenWriteOverflowsBuffer()
    {
        $uploader = $this->prophesize(StreamableUploader::class);
        $uploader->getResumeUri()->willReturn('https://some-resume-uri/');
        $stream = new WriteStream($uploader->reveal(), ['chunkSize' => 10]);

        // We should see 2 calls to upload with size of 10.
        $upload = $uploader->upload(10)->will(function($args) use ($stream) {
            if (count($args) > 0) {
                $size = $args[0];
                $stream->read(10);
            }
            return array();
        });

        // We should see a single call to finish the upload.
        $uploader->upload()->shouldBeCalledTimes(1);

        $stream->write('1234567');
        $upload->shouldHaveBeenCalledTimes(0);
        $stream->write('8901234');
        $upload->shouldHaveBeenCalledTimes(1);
        $stream->write('5678901');
        $upload->shouldHaveBeenCalledTimes(2);
        $stream->close();
    }
}
