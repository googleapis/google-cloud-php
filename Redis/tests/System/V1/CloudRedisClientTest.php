<?php
/**
 * Copyright 2018 Google Inc.
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

namespace Google\Cloud\Redis\Tests\System\V1;

use Google\Auth\CredentialsLoader;
use Google\Cloud\Redis\V1\Client\CloudRedisClient;
use Google\Cloud\Redis\V1\CreateInstanceRequest;
use Google\Cloud\Redis\V1\DeleteInstanceRequest;
use Google\Cloud\Redis\V1\ListInstancesRequest;
use Google\Cloud\Redis\V1\Instance;
use Google\Cloud\Redis\V1\Instance\Tier;
use Google\Cloud\Redis\V1\OperationMetadata;
use Google\Protobuf\GPBEmpty;
use PHPUnit\Framework\TestCase;

/**
 * @group redis
 * @group grpc
 */
class CloudRedisClientTest extends TestCase
{
    const LOCATION_ID = 'us-central1';
    const TIER = Tier::BASIC;
    const MEMORY_SIZE_GB = 1;

    private static CloudRedisClient $client;
    private static string $parent;
    private static string $instanceId;
    private static string $instanceName;

    /**
     * @beforeClass
     */
    public static function setUpTestFixtures()
    {
        if (!$keyFilePath = getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH')) {
            self::markTestSkipped('Set the GOOGLE_CLOUD_PHP_TESTS_KEY_PATH environment variable');
        }
        $keyFileData = json_decode(file_get_contents($keyFilePath), true);
        $projectId = $keyFileData['project_id'] ?? '';

        self::$client = new CloudRedisClient([
            'credentials' => $keyFilePath,
            'transport' => 'grpc'
        ]);

        self::$parent = self::$client::locationName($projectId, self::LOCATION_ID);
        self::$instanceId = uniqid('redis-test-instance-');
        self::$instanceName = self::$client::instanceName($projectId, self::LOCATION_ID, self::$instanceId);
    }

    public function testCreateOperations()
    {
        // Create the listance
        $instance = (new Instance())
            ->setTier(self::TIER)
            ->setMemorySizeGb(self::MEMORY_SIZE_GB);
        $createOp = self::$client->createInstance(
            CreateInstanceRequest::build(self::$parent, self::$instanceId, $instance)
        );
        $createOp->pollUntilComplete();

        $this->assertTrue($createOp->operationSucceeded());
        $instance = $createOp->getResult();
        $this->assertInstanceOf(Instance::class, $instance);
        $this->assertSame(self::$instanceName, $instance->getName());
    }

    /**
     * @depends testCreateOperations
     */
    public function testListOperation()
    {
        // List the instance
        $instances = self::$client->listInstances(ListInstancesRequest::build(self::$parent));
        $this->assertSame(1, count(array_map(
            fn ($instance) => $instance->getName() === self::$instanceName,
            iterator_to_array($instances->iterateAllElements())
        )));
    }

    /**
     * @depends testCreateOperations
     */
    public function testDeleteOperation()
    {
        // Delete Operation
        $deleteOp = self::$client->deleteInstance(
            DeleteInstanceRequest::build(self::$instanceName)
        );
        $deleteOp->pollUntilComplete();
        $this->assertTrue($deleteOp->operationSucceeded());

        // Ensure delete op succeeded
        $instances = self::$client->listInstances(ListInstancesRequest::build(self::$parent));
        $this->assertSame(0, count(array_map(
            fn ($instance) => $instance->getName() === self::$instanceName,
            iterator_to_array($instances->iterateAllElements())
        )));
    }
}
