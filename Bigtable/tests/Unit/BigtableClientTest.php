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
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @group bigtable
 */
class BigtableClientTest extends TestCase
{
    use GrpcTestTrait;

    const PROJECT_ID = 'my-awesome-project';
    const INSTANCE_ID = 'inst';
    const CLUSTER_ID = 'my-cluster';
    const LOCATION_ID = 'us-east1-b';
    const LOCATION_NAME = 'projects/my-awesome-project/locations/us-east1-b';

    private $client;
    private $connection;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->client = TestHelpers::stub(BigtableClient::class, [
            ['projectId' => self::PROJECT_ID]
        ]);
    }

    public function testInstance()
    {
        $instance = $this->client->instance(self::INSTANCE_ID);
        $this->assertInstanceOf(Instance::class, $instance);
        $this->assertEquals(
            InstanceAdminClient::instanceName(self::PROJECT_ID, self::INSTANCE_ID),
            $instance->name()
        );
    }

    public function testbuildClusterMetadataWithoutStorageType()
    {
        $cluster = $this->client->buildClusterMetadata(self::CLUSTER_ID, self::LOCATION_ID);
        $this->assertEquals($cluster['clusterId'], self::CLUSTER_ID);
        $this->assertEquals($cluster['locationId'], self::LOCATION_ID);
        $this->assertEquals($cluster['defaultStorageType'], Instance::STORAGE_TYPE_UNSPECIFIED);
        $this->assertFalse(array_key_exists('serveNodes', $cluster));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid storage type provided.
     */
    public function testbuildClusterMetadataInvalidStorageType()
    {
        $this->client->buildClusterMetadata(self::CLUSTER_ID, self::LOCATION_ID, 3);
    }

    public function testbuildClusterMetadataWithStorageType()
    {
        $cluster = $this->client->buildClusterMetadata(
            self::CLUSTER_ID,
            self::LOCATION_ID,
            Instance::STORAGE_TYPE_HDD
        );
        $this->assertEquals($cluster['clusterId'], self::CLUSTER_ID);
        $this->assertEquals($cluster['locationId'], self::LOCATION_ID);
        $this->assertEquals($cluster['defaultStorageType'], Instance::STORAGE_TYPE_HDD);
        $this->assertFalse(array_key_exists('serveNodes', $cluster));
    }

    public function testbuildClusterMetadataWithServeNodes()
    {
        $cluster = $this->client->buildClusterMetadata(
            self::CLUSTER_ID,
            self::LOCATION_ID,
            Instance::STORAGE_TYPE_HDD,
            3
        );
        $this->assertEquals($cluster['clusterId'], self::CLUSTER_ID);
        $this->assertEquals($cluster['locationId'], self::LOCATION_ID);
        $this->assertEquals($cluster['defaultStorageType'], Instance::STORAGE_TYPE_HDD);
        $this->assertEquals($cluster['serveNodes'], 3);
    }
}
