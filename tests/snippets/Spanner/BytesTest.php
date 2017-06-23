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

namespace Google\Cloud\Tests\Snippets\Spanner;

use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Spanner\Bytes;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\ValueMapper;
use Google\Cloud\Tests\GrpcTestTrait;
use Psr\Http\Message\StreamInterface;

/**
 * @group spanner
 */
class BytesTest extends SnippetTestCase
{
    use GrpcTestTrait;

    const BYTES = 'foobar';

    private $bytes;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();
        $this->bytes = new Bytes(self::BYTES);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Bytes::class);
        $res = $snippet->invoke('bytes');
        $this->assertInstanceOf(Bytes::class, $res->returnVal());
    }

    public function testClassCast()
    {
        $snippet = $this->snippetFromClass(Bytes::class, 1);
        $snippet->addLocal('bytes', $this->bytes);
        $res = $snippet->invoke();

        $this->assertEquals(base64_encode(self::BYTES), $res->output());
    }

    public function testGet()
    {
        $snippet = $this->snippetFromMethod(Bytes::class, 'get');
        $snippet->addLocal('bytes', $this->bytes);
        $res = $snippet->invoke('stream');

        $this->assertInstanceOf(StreamInterface::class, $res->returnVal());
        $this->assertEquals(self::BYTES, (string)$res->returnVal());
    }

    public function testType()
    {
        $snippet = $this->snippetFromMethod(Bytes::class, 'type');
        $snippet->addLocal('bytes', $this->bytes);
        $res = $snippet->invoke();
        $this->assertEquals(Database::TYPE_BYTES, $res->output());
    }

    public function testFormatAsString()
    {
        $snippet = $this->snippetFromMethod(Bytes::class, 'formatAsString');
        $snippet->addLocal('bytes', $this->bytes);
        $res = $snippet->invoke();

        $this->assertEquals(base64_encode(self::BYTES), $res->output());
    }
}
