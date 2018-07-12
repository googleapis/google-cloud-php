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
    const PROJECT_NAME = 'projects/my-awesome-project';
    const INSTANCE_ID = 'my-instance';
    const INSTANCE_NAME = 'projects/my-awesome-project/instances/my-instance';
    const CLUSTER_ID = 'my-cluster';
    const LOCATION_ID = 'us-east1-b';
    const LOCATION_NAME = 'projects/my-awesome-project/locations/us-east1-b';

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

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Please pass just instanceId as 'instance-id'
     */
    public function testInstanceWhenBadIdFormatPassed()
    {
        $badInstanceId = 'badformat/my-instance';
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
    }

    public function testInstanceId()
    {
        $instanceId = InstanceAdminClient::parseName($this->instance->name())['instance'];
        $this->assertEquals($this->instance->id(), $instanceId);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage At least one clusterMetadata must be passed
     */
    public function testCreateWithoutbuildClusterMetadata()
    {
        $this->instance->create([]);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Cluster id must be set.
     */
    public function testCreateWithoutClusterId()
    {
        $this->instance->create([
            ['clusterId' => null, 'locationId' => self::LOCATION_ID]
        ]);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Please pass just clusterId as 'cluster-id'
     */
    public function testCreateWithClusterIdBadFormat()
    {
        $badClusterId = 'badformat/my-cluster';
        $clusterMetadataList = $this->bigtableClient->buildClusterMetadata($badClusterId, self::LOCATION_ID);
        $this->instance->create([
            $clusterMetadataList
        ]);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Location id must be set.
     */
    public function testCreateWithoutLocationId()
    {
        $this->instance->create([
            ['clusterId' => self::CLUSTER_ID, 'locationId' => null]
        ]);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Please pass just locationId as 'location-id'
     */
    public function testCreateWithLocationIdBadFormat()
    {
        $badLocationId = 'badformat/my-locations';
        $clusterMetadataList = $this->bigtableClient->buildClusterMetadata(
            self::CLUSTER_ID,
            $badLocationId
        );
        $this->instance->create([
            $clusterMetadataList
        ]);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage When creating Production instance, serveNodes must be > 0
     */
    public function testCreateWithServeNodeIsZero()
    {
        $clusterMetadataList = $this->bigtableClient->buildClusterMetadata(
            self::CLUSTER_ID,
            self::LOCATION_ID,
            null,
            0
        );
        $this->instance->create([
            $clusterMetadataList
        ]);
    }

    public function testCreateWithoutOptions()
    {
        $args = [
            'parent' => self::PROJECT_NAME,
            'instanceId' => self::INSTANCE_ID,
            'instance' => [
                'displayName' => self::INSTANCE_ID,
                'type' => Instance::INSTANCE_TYPE_UNSPECIFIED,
                'labels' => []
            ],
            'clusters' => [
                'my-cluster' => [
                    'clusterId' => self::CLUSTER_ID,
                    'locationId' => self::LOCATION_ID,
                    'defaultStorageType' => 0,
                    'serveNodes' => 2,
                    'location' => self::LOCATION_NAME
                ]
            ]
        ];
        $this->connection->createInstance($args)
            ->shouldBeCalled()
            ->willReturn([
                'name' => self::INSTANCE_NAME,
                'displayName' => self::INSTANCE_ID,
                'labels' => [],
                'type' => 0
            ]);
        $this->instance->___setProperty('connection', $this->connection->reveal());

        $clusterMetadataList = $this->bigtableClient->buildClusterMetadata(
            self::CLUSTER_ID,
            self::LOCATION_ID,
            Instance::STORAGE_TYPE_HDD,
            2
        );
        $instance = $this->instance->create(
            [$clusterMetadataList]
        );
        $this->assertInstanceOf(LongRunningOperation::class, $instance);
        $this->assertEquals(self::INSTANCE_NAME, $instance->name());
        $this->assertEquals(self::INSTANCE_ID, $instance->info()['displayName']);
    }

    public function testCreateWithDisplayNameOptions()
    {
        $args = [
            'parent' => self::PROJECT_NAME,
            'instanceId' => self::INSTANCE_ID,
            'instance' => [
                'displayName' => 'My Test Instance',
                'type' => Instance::INSTANCE_TYPE_UNSPECIFIED,
                'labels' => []
            ],
            'clusters' => [
                'my-cluster' => [
                    'clusterId' => self::CLUSTER_ID,
                    'locationId' => self::LOCATION_ID,
                    'defaultStorageType' => 0,
                    'serveNodes' => 2,
                    'location' => self::LOCATION_NAME
                ]
            ]
        ];
        $this->connection->createInstance($args)
            ->shouldBeCalled()
            ->willReturn([
                'name' => self::INSTANCE_NAME,
                'displayName' => 'My Test Instance'
            ]);
        $this->instance->___setProperty('connection', $this->connection->reveal());

        $clusterMetadataList = $this->bigtableClient->buildClusterMetadata(
            self::CLUSTER_ID,
            self::LOCATION_ID,
            Instance::STORAGE_TYPE_HDD,
            2
        );
        $instance = $this->instance->create(
            [$clusterMetadataList],
            ['displayName' => 'My Test Instance']
        );
        $this->assertInstanceOf(LongRunningOperation::class, $instance);
        $this->assertEquals('My Test Instance', $instance->info()['displayName']);
    }

    public function testCreateWithLabelsOptions()
    {
        $args = [
            'parent' => self::PROJECT_NAME,
            'instanceId' => self::INSTANCE_ID,
            'instance' => [
                'displayName' => 'My Instance',
                'type' => Instance::INSTANCE_TYPE_UNSPECIFIED,
                'labels' => ['foo' => 'bar']
            ],
            'clusters' => [
                'my-cluster' => [
                    'clusterId' => self::CLUSTER_ID,
                    'locationId' => self::LOCATION_ID,
                    'defaultStorageType' => 0,
                    'serveNodes' => 2,
                    'location' => self::LOCATION_NAME
                ]
            ]
        ];
        $this->connection->createInstance($args)
            ->shouldBeCalled()
            ->willReturn([
                'name' => self::INSTANCE_NAME,
                'displayName' => 'My Instance',
                'labels' => ['foo' => 'bar']
            ]);
        $this->instance->___setProperty('connection', $this->connection->reveal());

        $clusterMetadataList = $this->bigtableClient->buildClusterMetadata(
            self::CLUSTER_ID,
            self::LOCATION_ID,
            Instance::STORAGE_TYPE_HDD,
            2
        );
        $instance = $this->instance->create(
            [$clusterMetadataList],
            ['displayName' => 'My Instance', 'labels' => ['foo' => 'bar']]
        );
        $this->assertInstanceOf(LongRunningOperation::class, $instance);
        $this->assertEquals(['foo' => 'bar'], $instance->info()['labels']);
    }

    public function testCreateWithInstanceTypeDevelopmentWithServeNodeOptions()
    {
        $args = [
            'parent' => self::PROJECT_NAME,
            'instanceId' => self::INSTANCE_ID,
            'instance' => [
                'displayName' => 'My Instance',
                'type' => Instance::INSTANCE_TYPE_DEVELOPMENT,
                'labels' => ['foo' => 'bar']
            ],
            'clusters' => [
                'my-cluster' => [
                    'clusterId' => self::CLUSTER_ID,
                    'locationId' => self::LOCATION_ID,
                    'defaultStorageType' => 0,
                    'location' => self::LOCATION_NAME
                ]
            ]
        ];
        $this->connection->createInstance($args)
            ->shouldBeCalled()
            ->willReturn([
                'name' => self::INSTANCE_NAME,
                'displayName' => 'My Instance',
                'labels' => ['foo' => 'bar'],
                'type' => Instance::INSTANCE_TYPE_DEVELOPMENT
            ]);
        $this->instance->___setProperty('connection', $this->connection->reveal());

        $clusterMetadataList = $this->bigtableClient->buildClusterMetadata(
            self::CLUSTER_ID,
            self::LOCATION_ID,
            Instance::STORAGE_TYPE_HDD,
            2
        );
        $instance = $this->instance->create(
            [$clusterMetadataList],
            [
                'displayName' => 'My Instance',
                'labels' => ['foo' => 'bar'],
                'type' => Instance::INSTANCE_TYPE_DEVELOPMENT
            ]
        );
        $this->assertInstanceOf(LongRunningOperation::class, $instance);
        $this->assertEquals(Instance::INSTANCE_TYPE_DEVELOPMENT, $instance->info()['type']);
    }
}
