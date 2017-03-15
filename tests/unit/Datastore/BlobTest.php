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

namespace Google\Cloud\Tests\Unit\Datastore;

use Google\Cloud\Datastore\Blob;
use GuzzleHttp\Psr7;

/**
 * @group datastore
 */
class BlobTest extends \PHPUnit_Framework_TestCase
{
    public function testBlobString()
    {
        $blob = new Blob('hello world');
        $this->assertEquals('hello world', (string) $blob);
    }

    public function testBlobResource()
    {
        $string = 'hello world';
        $stream = fopen('php://memory','r+');
        fwrite($stream, $string);
        rewind($stream);

        $blob = new Blob($stream);
        $this->assertEquals('hello world', (string) $blob);
    }

    public function testBlobStreamInterface()
    {
        $blob = new Blob(Psr7\stream_for('hello world'));
        $this->assertEquals('hello world', (string) $blob);
    }

    public function testToString()
    {
        $blob = new Blob('hello world');
        $this->assertEquals((string)$blob->get(), (string) $blob);
    }
}
