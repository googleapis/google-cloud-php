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

namespace Google\Cloud\Storage\Tests\System\StreamWrapper;

/**
 * @group storage
 * @group storage-stream-wrapper
 * @group storage-stream-wrapper-write
 */
class WriteTest extends StreamWrapperTestCase
{
    private $fileUrl;

    public function setUp(): void
    {
        $this->fileUrl = self::generateUrl('output.txt');
        unlink($this->fileUrl);
    }

    public function tearDown(): void
    {
        unlink($this->fileUrl);
    }

    public function testFilePutContents()
    {
        $this->assertFileDoesNotExist($this->fileUrl);

        $output = 'This is a test';
        $this->assertEquals(strlen($output), file_put_contents($this->fileUrl, $output));

        $this->assertFileExists($this->fileUrl);
    }

    public function testFwrite()
    {
        $this->assertFileDoesNotExist($this->fileUrl);

        $output = 'This is a test';
        $fd = fopen($this->fileUrl, 'w');
        $this->assertEquals(strlen($output), fwrite($fd, $output));
        $this->assertTrue(fclose($fd));

        $this->assertFileExists($this->fileUrl);
    }

    public function testTouch()
    {
        $this->assertFileDoesNotExist($this->fileUrl);

        $this->assertTrue(touch($this->fileUrl));

        $this->assertFileExists($this->fileUrl);
    }

    public function testStreamingWrite()
    {
        $this->assertFileDoesNotExist($this->fileUrl);

        $fp = fopen($this->fileUrl, 'w');
        for ($i = 0; $i < 20000; $i++) {
            fwrite($fp, "Line Number: $i\n");
        }
        fclose($fp);

        $this->assertFileExists($this->fileUrl);
    }
}
