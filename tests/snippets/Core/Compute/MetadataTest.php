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

namespace Google\Cloud\Tests\Snippets\Core\Compute;

use Google\Cloud\Core\Compute\Metadata;
use Google\Cloud\Core\Compute\Metadata\Readers\ReaderInterface;
use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Prophecy\Argument;

/**
 * @group compute
 */
class MetadataTest extends SnippetTestCase
{
    const PROJECT = 'my-project';

    private $metadata;
    private $reader;

    public function setUp()
    {
        $this->reader = $this->prophesize(ReaderInterface::class);
        $this->metadata = new Metadata;
        $this->metadata->setReader($this->reader->reveal());
    }

    public function testClass()
    {
        $this->reader->read('project/project-id')
            ->shouldBeCalled()
            ->willReturn(self::PROJECT);

        $snippet = $this->snippetFromClass(Metadata::class);
        $snippet->insertAfterLine(2, '$metadata->setReader($reader);');
        $snippet->addLocal('reader', $this->reader->reveal());
        $res = $snippet->invoke('projectId');

        $this->assertEquals($res->returnVal(), self::PROJECT);
    }

    public function testClassMetadata()
    {
        $key = 'foo';
        $val = 'bar';

        $this->reader->read('project/attributes/'. $key)
            ->shouldBeCalled()
            ->willReturn($val);

        $this->metadata->setReader($this->reader->reveal());

        $snippet = $this->snippetFromClass(Metadata::class, 1);
        $snippet->addLocal('metadata', $this->metadata);
        $snippet->addLocal('key', $key);

        $res = $snippet->invoke('val');
        $this->assertEquals($res->returnVal(), $val);
    }

    public function testGet()
    {
        $this->reader->read('project/project-id')
            ->shouldBeCalled()
            ->willReturn(self::PROJECT);

        $this->metadata->setReader($this->reader->reveal());

        $snippet = $this->snippetFromMethod(Metadata::class, 'get');
        $snippet->addLocal('metadata', $this->metadata);
        $res = $snippet->invoke('projectId');

        $this->assertEquals(self::PROJECT, $res->returnVal());
    }

    public function testGetProjectId()
    {
        $this->reader->read('project/project-id')
            ->shouldBeCalled()
            ->willReturn(self::PROJECT);

        $this->metadata->setReader($this->reader->reveal());

        $snippet = $this->snippetFromMethod(Metadata::class, 'getProjectId');
        $snippet->addLocal('metadata', $this->metadata);
        $res = $snippet->invoke('projectId');

        $this->assertEquals(self::PROJECT, $res->returnVal());
    }

    public function testGetProjectMetadata()
    {
        $val = 'hello world';

        $this->reader->read('project/attributes/foo')
            ->shouldBeCalled()
            ->willReturn($val);

        $this->metadata->setReader($this->reader->reveal());

        $snippet = $this->snippetFromMethod(Metadata::class, 'getProjectMetadata');
        $snippet->addLocal('metadata', $this->metadata);
        $res = $snippet->invoke('foo');

        $this->assertEquals($val, $res->returnVal());
    }

    public function testGetInstanceMetadata()
    {
        $val = 'hello world';

        $this->reader->read('instance/attributes/foo')
            ->shouldBeCalled()
            ->willReturn($val);

        $this->metadata->setReader($this->reader->reveal());

        $snippet = $this->snippetFromMethod(Metadata::class, 'getInstanceMetadata');
        $snippet->addLocal('metadata', $this->metadata);
        $res = $snippet->invoke('foo');

        $this->assertEquals($val, $res->returnVal());
    }
}
