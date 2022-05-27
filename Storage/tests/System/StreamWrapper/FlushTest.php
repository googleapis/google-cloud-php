<?php
/**
 * Copyright 2020 Google LLC
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

namespace Google\Cloud\Storage\Tests\System\StreamWrapper;

use Google\Cloud\Storage\StreamWrapper;

/**
 * @group storage
 * @group storage-stream-wrapper
 * @group storage-stream-wrapper-flush
 */
class FlushTest extends StreamWrapperTestCase
{
    private static $fileName = 'flush.txt';
    private static $binFileName = 'flush';
    private $fileUrl;
    private $tailFileUrl;
    private $binFileUrl;
    private $tailBinFileUrl;

    public function set_up()
    {
        $this->fileUrl = self::generateUrl(self::$fileName);
        $this->tailFileUrl = $this->fileUrl . StreamWrapper::TAIL_NAME_SUFFIX;
        $this->binFileUrl = self::generateUrl(self::$binFileName);
        $this->tailBinFileUrl = $this->binFileUrl . StreamWrapper::TAIL_NAME_SUFFIX;
        unlink($this->fileUrl);
    }

    public function tear_down()
    {
        unlink($this->fileUrl);
        unlink($this->tailFileUrl);
        unlink($this->binFileUrl);
        unlink($this->tailBinFileUrl);
    }

    public function testFlushOff()
    {
        $f = fopen($this->fileUrl, 'w');
        fwrite($f, 'hello');
        $this->assertFalse(fflush($f));
        fwrite($f, ' world');
        fclose($f);

        $info = static::$bucket->object(self::$fileName)->info();
        $this->assertArrayNotHasKey('componentCount', $info);
        $this->assertEquals('hello world', file_get_contents($this->fileUrl));
    }

    public function testFlushOnAndCalled()
    {
        $ctx = stream_context_create(['gs' => ['flush' => true]]);
        $f = fopen($this->fileUrl, 'w', false, $ctx);
        fwrite($f, 'hello');
        $this->assertTrue(fflush($f));
        fwrite($f, ' world');
        $this->assertTrue(fflush($f));
        fwrite($f, '!');
        fclose($f);

        $info = static::$bucket->object(self::$fileName)->info();
        $this->assertArrayHasKey('componentCount', $info);
        $this->assertEquals(3, $info['componentCount']);
        $this->assertEquals('hello world!', file_get_contents($this->fileUrl));
        $this->assertFalse(file_exists($this->tailFileUrl));
    }

    public function testFlushOnAndNotCalled()
    {
        $ctx = stream_context_create(['gs' => ['flush' => true]]);
        $f = fopen($this->fileUrl, 'w', false, $ctx);
        fwrite($f, 'hello');
        fwrite($f, ' world');
        fwrite($f, '!');
        fclose($f);

        $info = static::$bucket->object(self::$fileName)->info();
        $this->assertArrayNotHasKey('componentCount', $info);
        $this->assertEquals('hello world!', file_get_contents($this->fileUrl));
        $this->assertFalse(file_exists($this->tailFileUrl));
    }

    public function testFlushEmptyBuffer()
    {
        $ctx = stream_context_create(['gs' => ['flush' => true]]);
        $f = fopen($this->fileUrl, 'w', false, $ctx);
        $this->assertTrue(fflush($f));
        fwrite($f, 'hello');
        fflush($f);
        fflush($f);
        fwrite($f, ' world');
        fclose($f);

        $info = static::$bucket->object(self::$fileName)->info();
        $this->assertArrayHasKey('componentCount', $info);
        $this->assertEquals(2, $info['componentCount']);
        $this->assertFalse(file_exists($this->tailFileUrl));
    }

    public function testFlushNoContentType()
    {
        $ctx = stream_context_create(['gs' => ['flush' => true]]);
        $f = fopen($this->binFileUrl, 'w', false, $ctx);
        fwrite($f, '0');
        fflush($f);
        fwrite($f, '1');
        fclose($f);

        $info = static::$bucket->object(self::$binFileName)->info();
        $this->assertArrayHasKey('componentCount', $info);
        $this->assertEquals(2, $info['componentCount']);
        $this->assertEquals('application/octet-stream', $info['contentType']);
        $this->assertFalse(file_exists($this->tailBinFileUrl));
    }
}
