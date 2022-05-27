<?php
/**
 * Copyright 2015 Google Inc.
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

namespace Google\Cloud\Core\Tests\Unit\Compute;

use Google\Cloud\Core\Compute\Metadata;
use Google\Cloud\Core\Compute\Metadata\Readers\ReaderInterface;
use Google\Cloud\Core\Compute\Metadata\Readers\StreamReader;
use Google\Cloud\Core\Testing\TestHelpers;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group core
 * @group core-compute
 */
class MetadataTest extends TestCase
{
    private $metadata;
    private $reader;

    public function set_up()
    {
        $this->metadata = TestHelpers::stub(Metadata::class, [], ['reader']);
        $this->reader = $this->prophesize(ReaderInterface::class);
    }

    public function testSetReader()
    {
        $beforeReader = $this->metadata->___getProperty('reader');

        $this->metadata->setReader(new StreamReader);

        $this->assertNotEquals(
            get_class($beforeReader),
            get_class($this->metadata->___getProperty('reader'))
        );
    }

    /**
     * @dataProvider metadataTypes
     */
    public function testGetMetadata($type, $method)
    {
        $path = $type . '/attributes/mykey';
        $expectedVal = 'myval';

        $this->reader->read($path)
            ->shouldBeCalled()
            ->willReturn($expectedVal);

        $this->metadata->___setProperty('reader', $this->reader->reveal());
        $this->assertEquals($expectedVal, $this->metadata->$method('mykey'));
    }

    public function metadataTypes()
    {
        return [
            ['project', 'getProjectMetadata'],
            ['instance', 'getInstanceMetadata']
        ];
    }

    /**
     * @dataProvider projectIdTypes
     */
    public function testGetProjectId($type, $method)
    {
        $path = 'project/' . $type;
        $expectedVal = 'my-project';

        $this->reader->read($path)
            ->shouldBeCalledOnce()
            ->willReturn($expectedVal);

        $this->metadata->___setProperty('reader', $this->reader->reveal());
        $this->assertEquals($expectedVal, $this->metadata->$method());

        // Ensure this value is cached thus we `read` only once.
        $this->metadata->$method();
    }

    public function projectIdTypes()
    {
        return [
            ['project-id', 'getProjectId'],
            ['numeric-project-id', 'getNumericProjectId']
        ];
    }
}
