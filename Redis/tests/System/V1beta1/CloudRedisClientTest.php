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

namespace Google\Cloud\Redis\Tests\System\V1beta1;

use Google\Auth\CredentialsLoader;
use Google\Cloud\Redis\V1beta1\CloudRedisClient;
use Google\Cloud\Redis\V1beta1\Instance;
use Google\Cloud\Redis\V1beta1\Instance\Tier;
use Google\Protobuf\Any;
use Google\Protobuf\GPBEmpty;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group redis
 * @group grpc
 */
class CloudRedisClientTest extends TestCase
{
    protected static $grpcClient;
    protected static $projectId;
    private static $hasSetUp = false;

    public function clientProvider()
    {
        self::set_up_before_class();

        return [
            [self::$grpcClient]
        ];
    }

    public static function set_up_before_class()
    {
        # This system test fails now with the following error:
        # Exception: Expect utf-8 encoding.
        # Interestingly, the V1 system test is passing.
        # TODO(tmatsuo): Remove V1beta1 if feasible, or fix this system test.
        self::markTestSkipped('Temporary skipping the system test for V1beta1 Redis client');
        if (self::$hasSetUp) {
            return;
        }

        $keyFilePath = getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH');
        $keyFileData = json_decode(file_get_contents($keyFilePath), true);

        self::$grpcClient = new CloudRedisClient([
            'credentials' => $keyFilePath,
            'transport' => 'grpc'
        ]);

        self::$projectId = $keyFileData['project_id'];

        self::$hasSetUp = true;
    }

    private function deleteInstance(CloudRedisClient $client, $instanceToDelete)
    {
        $operationResponse = $client->deleteInstance($instanceToDelete);
        while (!$operationResponse->isDone()) {
            // get the $any object to ensure this does not fail
            $any = $operationResponse->getMetadata();
            $this->assertInstanceOf(Any::class, $any);
            sleep(5);
            $operationResponse->reload();
        }

        $this->assertTrue($operationResponse->operationSucceeded());
        // get the $result object to ensure this does not fail
        $result = $operationResponse->getResult();
        $this->assertInstanceOf(GPBEmpty::class, $result);
    }

    /**
     * @param CloudRedisClient $client
     * @param string $parent
     * @param string $instanceId
     * @return string Name
     */
    private function createRedisInstance(CloudRedisClient $client, $parent, $instanceId)
    {
        $tier = Tier::BASIC;
        $memorySizeGb = 1;
        $instance = new Instance();
        $instance->setTier($tier);
        $instance->setMemorySizeGb($memorySizeGb);
        $operationResponse = $client->createInstance($parent, $instanceId, $instance);

        while (!$operationResponse->isDone()) {
            // get the $any object to ensure this does not fail
            $any = $operationResponse->getMetadata();
            $this->assertInstanceOf(Any::class, $any);
            sleep(5);
            $operationResponse->reload();
        }

        $this->assertTrue($operationResponse->operationSucceeded());
        $result = $operationResponse->getResult();
        $this->assertInstanceOf(Instance::class, $result);
        return $result->getName();
    }

    /**
     * @dataProvider clientProvider
     */
    public function testCreateListDeleteOperations(CloudRedisClient $client)
    {
        $locationId = 'us-central1';
        $instanceId = 'my-redis-test-instance';
        $parent = $client::locationName(self::$projectId, $locationId);
        $instanceName = $client::instanceName(self::$projectId, $locationId, $instanceId);

        $instances = $client->listInstances($parent);
        foreach ($instances->iterateAllElements() as $instance) {
            if ($instance->getName() === $instanceName) {
                // Instance exists - lets delete it
                $this->deleteInstance($client, $instance->getName());
            }
        }

        $createdInstanceName = $this->createRedisInstance($client, $parent, $instanceId);
        $this->assertSame($instanceName, $createdInstanceName);

        $instances = iterator_to_array($client->listInstances($parent)->iterateAllElements());
        $this->assertSame(1, count($instances));

        $this->deleteInstance($client, $createdInstanceName);

        $instances = iterator_to_array($client->listInstances($parent)->iterateAllElements());
        $this->assertSame(0, count($instances));
    }
}
