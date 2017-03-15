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

namespace Google\Cloud\Tests\Unit\Core\Compute;

use Google\Cloud\Core\Compute\Metadata;
use Google\Cloud\Core\Compute\Metadata\Readers\StreamReader;

/**
 * @group core
 * @group compute
 */
class MetadataTest extends \PHPUnit_Framework_TestCase
{
    protected $mock;
    protected $metadata;

    public function setUp()
    {
        $this->metadata = new Metadata();
        $this->mock = $this->getMockBuilder(
            StreamReader::class)
            ->setMethods(array('read'))
            ->getmock();
        $this->metadata->setReader($this->mock);
    }

    public function testProjectMetadata()
    {
        $expected_path = 'project/attributes/mykey';
        $expected_val = 'myval';
        $this->mock->expects($this->once())
            ->method('read')
            ->with($this->equalTo($expected_path))
            ->willReturn($expected_val);
        $val = $this->metadata->getProjectMetadata('mykey');
        $this->assertEquals($expected_val, $val);
    }

    public function testInstanceMetadata()
    {
        $expected_path = 'instance/attributes/mykey';
        $expected_val = 'myval';
        $this->mock->expects($this->once())
            ->method('read')
            ->with($this->equalTo($expected_path))
            ->willReturn($expected_val);
        $val = $this->metadata->getInstanceMetadata('mykey');
        $this->assertEquals($expected_val, $val);
    }

    public function testGetProjectId()
    {
        $expected_path = 'project/project-id';
        $expected_val = 'my-project';
        $this->mock->expects($this->once())
            ->method('read')
            ->with($this->equalTo($expected_path))
            ->willReturn($expected_val);
        $project_id = $this->metadata->getProjectId();
        $this->assertEquals($expected_val, $project_id);
        // Ensure this value is cached thus we `read` only once.
        $this->metadata->getProjectId();
    }
}
