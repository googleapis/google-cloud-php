<?php
/**
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
namespace Google\Cloud\Bigtable\Tests\Unit;

use Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient as InstanceAdminClient;
use Google\Cloud\Bigtable\BigtableClient;
use Google\Cloud\Bigtable\Connection\ConnectionInterface;
use Google\Cloud\Bigtable\Instance;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @group bigtable
 * @group bigtableadmin
 */
class InstanceTest extends TestCase
{
    use GrpcTestTrait;

    const PROJECT_ID = 'my-awesome-project';
    const INSTANCE_ID = 'my-instance';
    const INSTANCE_NAME = 'projects/my-awesome-project/instances/my-instance';
    const CLUSTER_ID = 'my-cluster';
    const LOCATION_ID = 'us-east1-b';

    private $connection;
    private $instance;
    private $bigtableClient;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $this->bigtableClient = new BigtableClient();
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->instance = TestHelpers::stub(Instance::class, [
            $this->connection->reveal(),
            $this->prophesize(LongRunningConnectionInterface::class)->reveal(),
            [],
            self::PROJECT_ID,
            self::INSTANCE_ID
        ], [
            'info',
            'connection'
        ]);
    }

    public function testName()
    {
        $this->assertEquals(self::INSTANCE_NAME, $this->instance->name());
    }

    public function testId()
    {
        $this->assertEquals(self::INSTANCE_ID, $this->instance->id());
    }

    public function testInstanceWhenBadIdFormatPassed()
    {
        $badInstanceId = 'badformat/my-instance';
        try {
            $instance = TestHelpers::stub(Instance::class, [
                $this->connection->reveal(),
                $this->prophesize(LongRunningConnectionInterface::class)->reveal(),
                [],
                self::PROJECT_ID,
                $badInstanceId
            ], [
                'info',
                'connection'
            ]);
        } catch(\Exception $e) {
            $error = "Please pass just instanceId as 'instance-id'";
            $this->assertEquals($error, $e->getMessage());
        }
    }

    public function testInstanceId()
    {
        $instanceId = InstanceAdminClient::parseName($this->instance->name())['instance'];
        $this->assertEquals($this->instance->id(), $instanceId);
    }

    public function testCreateWithoutClusterMetadata()
    {
        try {
            $this->instance->create(
                []
            );
        }  catch(\Exception $e) {
            $error = 'At least one clusterMetadata must be passed';
            $this->assertEquals($error, $e->getMessage());
        }
    }

    public function testCreateWithoutClusterId()
    {
        try {
            $clusterMetadataList = $this->bigtableClient->clusterMetadata(null, null);
            $this->instance->create(
                [$clusterMetadataList]
            );
        }  catch(\Exception $e) {
            $error = 'Cluster id must be set';
            $this->assertEquals($error, $e->getMessage());
        }
    }

    public function testCreateWithClusterIdBadFormat()
    {
        try {
            $badClusterId = 'badformat/my-cluster';
            $clusterMetadataList = $this->bigtableClient->clusterMetadata($badClusterId, 'location-id');
            $this->instance->create(
                [$clusterMetadataList]
            );
        }  catch(\Exception $e) {
            $error = "Please pass just clusterId as 'cluster-id'";
            $this->assertEquals($error, $e->getMessage());
        }
    }

    public function testCreateWithoutLocationId()
    {
        try {
            $clusterMetadataList = $this->bigtableClient->clusterMetadata(self::CLUSTER_ID, null);
            $this->instance->create(
                [$clusterMetadataList]
            );
        }  catch(\Exception $e) {
            $error = 'Location id must be set';
            $this->assertEquals($error, $e->getMessage());
        }
    }

    public function testCreateWithLocationIdBadFormat()
    {
        $badLocationId = 'badformat/my-locations';
        $clusterMetadataList = $this->bigtableClient->clusterMetadata(
            self::CLUSTER_ID,
            $badLocationId
        );
        try {
            $this->instance->create(
                [$clusterMetadataList]
            );
        }  catch(\Exception $e) {
            $error = "Please pass just locationId as 'location-id'";
            $this->assertEquals($error, $e->getMessage());
        }
    }

    public function testCreateWithServeNodeIsZero()
    {
        $clusterMetadataList = $this->bigtableClient->clusterMetadata(
            self::CLUSTER_ID,
            self::LOCATION_ID,
            null,
            0
        );
        try {
            $this->instance->create(
                [$clusterMetadataList]
            );
        }  catch(\Exception $e) {
            $error = "When creating Production instance, serveNodes must be > 0";
            $this->assertEquals($error, $e->getMessage());
        }
    }

    public function testCreate()
    {
        $this->connection->createInstance(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['name' => self::INSTANCE_NAME]);
        $this->instance->___setProperty('connection', $this->connection->reveal());

        $clusterMetadataList = $this->bigtableClient->clusterMetadata(
            self::CLUSTER_ID,
            self::LOCATION_ID,
            Instance::STORAGE_TYPE_HDD,
            2
        );
        $instance = $this->instance->create(
            [$clusterMetadataList],
            [
                'displayName' => 'My Insatnce',
                'labels' => ['foo' => 'bar'],
                'type' => Instance::INSTANCE_TYPE_DEVELOPMENT
            ]
        );
        $this->assertInstanceOf(LongRunningOperation::class, $instance);
        $this->assertEquals(self::INSTANCE_NAME, $instance->name());
    }
}
