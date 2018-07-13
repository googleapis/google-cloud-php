<?php
/*
 * Copyright 2018, Google LLC All rights reserved.
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
namespace Google\Cloud\Bigtable\Tests\Snippet;

use Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient as InstanceAdminClient;
use Google\Cloud\Bigtable\Connection\ConnectionInterface;
use Google\Cloud\Bigtable\Instance;
use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Prophecy\Argument;

/**
 * @group bigtable
 * @group bigtableadmin
 */
class InstanceTest extends SnippetTestCase
{
    use GrpcTestTrait;

    const CLUSTER_ID = 'my-cluster';
    const PROJECT_ID = 'my-awesome-project';
    const INSTANCE_ID = 'my-instance';
    const INSTANCE_NAME = 'projects/my-awesome-project/instances/my-instance';
    const LOCATION_ID = 'us-east1-b';

    private $connection;
    private $instance;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->instance = TestHelpers::stub(Instance::class, [
            $this->connection->reveal(),
            $this->prophesize(LongRunningConnectionInterface::class)->reveal(),
            [],
            self::PROJECT_ID,
            self::INSTANCE_ID
        ]);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Instance::class);
        $res = $snippet->invoke('instance');

        $this->assertInstanceOf(Instance::class, $res->returnVal());
        $this->assertEquals(self::INSTANCE_NAME, $res->returnVal()->name());
    }

    public function testName()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'name');
        $snippet->addLocal('instance', $this->instance);

        $res = $snippet->invoke('name');
        $this->assertEquals(self::INSTANCE_NAME, $res->returnVal());
    }

    public function testId()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'id');
        $snippet->addLocal('instance', $this->instance);

        $res = $snippet->invoke('id');
        $this->assertEquals(self::INSTANCE_ID, $res->returnVal());
    }

    public function testCreate()
    {

        $snippet = $this->snippetFromMethod(Instance::class, 'create');
        $snippet->addUse(Instance::class);
        $snippet->addLocal('instance', $this->instance);

        $this->connection->createInstance(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['name' => 'operations/foo']);

        $this->instance->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(LongRunningOperation::class, $res->returnVal());
    }

    public function testResumeOperation()
    {
        $snippet = $this->snippetFromMagicMethod(Instance::class, 'resumeOperation');
        $snippet->addLocal('instance', $this->instance);
        $snippet->addLocal('operationName', 'foo');

        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(LongRunningOperation::class, $res->returnVal());
        $this->assertEquals('foo', $res->returnVal()->name());
    }

    public function testbuildClusterMetadata()
    {
        $snippet = $this->snippetFromMethod(Instance::class, 'buildClusterMetadata');
        $snippet->addUse(Instance::class);

        $res = $snippet->invoke('cluster');
        $this->assertEquals(self::CLUSTER_ID, $res->returnVal()['clusterId']);
        $this->assertEquals(self::LOCATION_ID, $res->returnVal()['locationId']);
    }
}
