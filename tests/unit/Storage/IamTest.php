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

namespace Google\Cloud\Tests\Unit\Storage;

use Google\Cloud\Core\Iam\IamConnectionInterface;
use Google\Cloud\Dev\SetStubConnectionTrait;
use Google\Cloud\Storage\Iam;
use Prophecy\Argument;

/**
 * @group storage
 */
class IamTest extends \PHPUnit_Framework_TestCase
{
    const RESOURCE = 'foo';
    const BUCKET = 'my-bucket';
    const OBJECT = 'my-object';

    private $resourceArgs;
    private $connection;

    private $return = ['foo' => 'bar'];

    public function setUp()
    {
        $this->resourceArgs = ['bucket' => self::BUCKET, 'object' => self::OBJECT];
        $this->connection = $this->prophesize(IamConnectionInterface::class);
    }

    public function testSetPolicy()
    {
        $this->connection->setPolicy([
            'kind' => 'storage#policy',
            'bindings' => [],
            'resourceId' => sprintf('buckets/%s/objects/%s', self::BUCKET, self::OBJECT),
            'bucket' => self::BUCKET,
            'object' => self::OBJECT,
        ])->shouldBeCalled()->willReturn($this->return);

        $iam = $this->createStub($this->connection->reveal(), $this->resourceArgs);
        $res = $iam->setPolicy(['bindings' => []]);

        $this->assertEquals($this->return, $res);
    }

    public function testSetObjectPolicy()
    {
        $this->connection->setPolicy([
            'kind' => 'storage#policy',
            'bindings' => [],
            'resourceId' => sprintf('buckets/%s', self::BUCKET),
            'bucket' => self::BUCKET,
        ])->shouldBeCalled()->willReturn($this->return);

        $args = $this->resourceArgs;
        unset($args['object']);
        $iam = $this->createStub($this->connection->reveal(), $args);
        $res = $iam->setPolicy(['bindings' => []]);

        $this->assertEquals($this->return, $res);
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testSetPolicyMissingBindings()
    {
        $iam = $this->createStub($this->connection->reveal(), $this->resourceArgs);
        $iam->setPolicy([]);
    }

    public function testGetPolicy()
    {
        $this->connection->getPolicy([
            'bucket' => self::BUCKET,
            'object' => self::OBJECT
        ])->shouldBeCalled()->willReturn($this->return);

        $iam = $this->createStub($this->connection->reveal(), $this->resourceArgs);
        $res = $iam->policy();

        $this->assertEquals($this->return, $res);
    }

    public function testTestPermissions()
    {
        $permissions = ['foo', 'bar'];
        $this->connection->testPermissions([
            'permissions' => $permissions,
            'bucket' => self::BUCKET,
            'object' => self::OBJECT
        ])->shouldBeCalled()->willReturn(['permissions' => $this->return]);

        $iam = $this->createStub($this->connection->reveal(), $this->resourceArgs);
        $res = $iam->testPermissions($permissions);

        $this->assertEquals($this->return, $res);
    }

    private function createStub($connection, array $resourceArgs)
    {
        return new Iam(
            $this->connection->reveal(),
            self::RESOURCE,
            $resourceArgs
        );
    }
}
