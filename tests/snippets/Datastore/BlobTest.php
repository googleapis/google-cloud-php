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

namespace Google\Cloud\Tests\Snippets\Datastore;

use Google\Cloud\Datastore\Blob;
use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Psr\Http\Message\StreamInterface;

/**
 * @group datastore
 */
class BlobTest extends SnippetTestCase
{
    private $value;
    private $blob;

    public function setUp()
    {
        $this->value = 'foo';
        $this->blob = new Blob($this->value);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Blob::class);
        $snippet->replace(
            "file_get_contents(__DIR__ .'/family-photo.jpg')",
            "''"
        );

        $res = $snippet->invoke('blob');

        $this->assertInstanceOf(Blob::class, $res->returnVal());
    }

    public function testToString()
    {
        $snippet = $this->snippetFromClass(Blob::class, 1);
        $snippet->addLocal('blob', $this->blob);

        $res = $snippet->invoke();
        $this->assertEquals($this->value, $res->output());
    }

    public function testValue()
    {
        $snippet = $this->snippetFromMethod(Blob::class, 'get');
        $snippet->addLocal('blob', $this->blob);

        $res = $snippet->invoke('value');
        $this->assertInstanceOf(StreamInterface::class, $res->returnVal());
        $this->assertEquals($this->value, (string)$res->returnVal());
    }
}
