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

namespace Google\Cloud\Tests\Unit\Storage;

use Google\Cloud\Storage\Acl;
use Google\Cloud\Storage\Connection\ConnectionInterface;
use Prophecy\Argument;

/**
 * @group storage
 */
class AclTest extends \PHPUnit_Framework_TestCase
{
    public $connection;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testThrowsExceptionWithInvalidType()
    {
        $acl = new Acl($this->connection->reveal(), 'nope', ['bucket' => 'bucket']);
    }

    public function testDelete()
    {
        $acl = new Acl($this->connection->reveal(), 'bucketAccessControls', ['bucket' => 'bucket']);

        $this->assertNull($acl->delete('owner'));
    }

    public function testGetAll()
    {
        $accessControls = [
            ['entity' => 'allAuthenticatedUsers']
        ];
        $this->connection->listAcl(Argument::any())->willReturn(['items' => $accessControls]);
        $acl = new Acl($this->connection->reveal(), 'bucketAccessControls', ['bucket' => 'bucket']);

        $this->assertEquals($accessControls, $acl->get());
    }

    public function testGetWithSpecifiedEntity()
    {
        $accessControl = [
            'entity' => 'allAuthenticatedUsers'
        ];
        $this->connection->getAcl(Argument::any())->willReturn($accessControl);
        $acl = new Acl($this->connection->reveal(), 'bucketAccessControls', ['bucket' => 'bucket']);

        $this->assertEquals($accessControl, $acl->get(['entity' => 'allAuthenticatedUsers']));
    }

    public function testAdd()
    {
        $accessControl = [
            'entity' => 'allAuthenticatedUsers',
            'role' => 'READER'
        ];
        $this->connection->insertAcl(Argument::any())->willReturn($accessControl);
        $acl = new Acl($this->connection->reveal(), 'bucketAccessControls', ['bucket' => 'bucket']);

        $this->assertEquals($accessControl, $acl->add('allAuthenticatedUsers', 'READER'));
    }

    public function testUpdate()
    {
        $accessControl = [
            'entity' => 'allAuthenticatedUsers',
            'role' => 'WRITER'
        ];
        $this->connection->patchAcl(Argument::any())->willReturn($accessControl);
        $acl = new Acl($this->connection->reveal(), 'bucketAccessControls', ['bucket' => 'bucket']);

        $this->assertEquals($accessControl, $acl->update('allAuthenticatedUsers', 'WRITER'));
    }
}
