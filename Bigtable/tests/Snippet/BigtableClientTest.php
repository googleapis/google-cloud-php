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

namespace Google\Cloud\Bigtable\Tests\Bigtable;

use Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient as InstanceAdminClient;
use Google\Cloud\Bigtable\BigtableClient;
use Google\Cloud\Bigtable\Connection\ConnectionInterface;
use Google\Cloud\Bigtable\Instance;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Prophecy\Argument;

/**
 * @group bigtable
 * @group bigtableadmin
 */
class BigtableClientTest extends SnippetTestCase
{
    use GrpcTestTrait;

    const PROJECT = 'my-awesome-project';
    const INSTANCE = 'my-instance';
    const LOCATION = 'us-east1-b';

    private $client;
    private $connection;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->client = TestHelpers::stub(BigtableClient::class);
        $this->client->___setProperty('connection', $this->connection->reveal());
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(BigtableClient::class);
        $res = $snippet->invoke('bigtable');
        $this->assertInstanceOf(BigtableClient::class, $res->returnVal());
    }

    public function testInstance()
    {
        $snippet = $this->snippetFromMethod(BigtableClient::class, 'instance');
        $snippet->addLocal('bigtable', $this->client);

        $res = $snippet->invoke('instance');
        $this->assertInstanceOf(Instance::class, $res->returnVal());
        $this->assertEquals(
            InstanceAdminClient::instanceName(self::PROJECT, self::INSTANCE),
            $res->returnVal()->name()
        );
    }

    public function testClusterMetadata()
    {
        $snippet = $this->snippetFromMethod(BigtableClient::class, 'clusterMetadata');
        $snippet->addLocal('bigtable', $this->client);
        $snippet->addLocal('clusterid', 'my-cluster');
        $snippet->addLocal('clusterMetadata', InstanceAdminClient::locationName(self::PROJECT, self::LOCATION));

        $res = $snippet->invoke('clusterMetadata');
        $this->assertEquals(
            InstanceAdminClient::locationName(self::PROJECT, self::LOCATION),
            $res->returnVal()
        );
    }
}
