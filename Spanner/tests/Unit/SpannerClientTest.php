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

namespace Google\Cloud\Spanner\Tests\Unit;

use Google\ApiCore\OperationResponse;
use Google\Cloud\Core\Int64;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\LongRunning\LongRunningOperationManager;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Spanner\Tests\RequestHandlingTestTrait;
use Google\Cloud\Core\Testing\Snippet\Fixtures;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
use Google\Cloud\Spanner\Batch\BatchClient;
use Google\Cloud\Spanner\Bytes;
use Google\Cloud\Spanner\CommitTimestamp;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Date;
use Google\Cloud\Spanner\Duration;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\InstanceConfiguration;
use Google\Cloud\Spanner\PgJsonb;
use Google\Cloud\Spanner\KeyRange;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Numeric;
use Google\Cloud\Spanner\PgNumeric;
use Google\Cloud\Spanner\SpannerClient;
use Google\Cloud\Spanner\Timestamp;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group spanner
 */
class SpannerClientTest extends TestCase
{
    use GrpcTestTrait;
    use ProphecyTrait;
    use RequestHandlingTestTrait;

    const PROJECT = 'my-awesome-project';
    const INSTANCE = 'inst';
    const DATABASE = 'db';
    const CONFIG = 'conf';

    private $requestHandler;
    private $serializer;
    private $client;
    private $directedReadOptionsIncludeReplicas;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->requestHandler = $this->getRequestHandlerStub();
        $this->serializer = $this->getSerializer();

        $this->directedReadOptionsIncludeReplicas = [
            'includeReplicas' => [
                'replicaSelections' => [
                    'location' => 'us-central1',
                    'type' => 'READ_WRITE',
                    'autoFailoverDisabled' => false
                ]
            ]
        ];
        $this->client = TestHelpers::stub(SpannerClient::class, [
            [
                'projectId' => self::PROJECT,
                'credentials' => Fixtures::KEYFILE_STUB_FIXTURE(),
                'directedReadOptions' => $this->directedReadOptionsIncludeReplicas
            ]
        ], ['requestHandler', 'serializer']);
    }

    public function testBatch()
    {
        $batch = $this->client->batch('foo', 'bar');
        $this->assertInstanceOf(BatchClient::class, $batch);

        $ref = new \ReflectionObject($batch);
        $prop = $ref->getProperty('databaseName');
        $prop->setAccessible(true);

        $this->assertEquals(
            sprintf(
                'projects/%s/instances/%s/databases/%s',
                self::PROJECT,
                'foo',
                'bar'
            ),
            $prop->getValue($batch)
        );
    }

    /**
     * @group spanner-admin
     */
    public function testInstanceConfigurations()
    {
        $this->mockSendRequest(
            InstanceAdminClient::class,
            'listInstanceConfigs',
            function ($args) {
                return $this->serializer->encodeMessage($args)['parent']
                    == InstanceAdminClient::projectName(self::PROJECT);
            },
            [
                'instanceConfigs' => [
                    [
                        'name' => InstanceAdminClient::instanceConfigName(self::PROJECT, self::CONFIG),
                        'displayName' => 'Bar'
                    ], [
                        'name' => InstanceAdminClient::instanceConfigName(self::PROJECT, self::CONFIG),
                        'displayName' => 'Bat'
                    ]
                ]
            ]
        );

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->client->___setProperty('serializer', $this->serializer);

        $configs = $this->client->instanceConfigurations();

        $this->assertInstanceOf(ItemIterator::class, $configs);

        $configs = iterator_to_array($configs);
        $this->assertCount(2, $configs);
        $this->assertInstanceOf(InstanceConfiguration::class, $configs[0]);
        $this->assertInstanceOf(InstanceConfiguration::class, $configs[1]);
    }

    /**
     * @group spanner-admin
     */
    public function testPagedInstanceConfigurations()
    {
        $firstCall = [
            'instanceConfigs' => [
                [
                    'name' => 'projects/foo/instanceConfigs/bar',
                    'displayName' => 'Bar'
                ]
            ],
            'nextPageToken' => 'fooBar'
        ];

        $secondCall = [
            'instanceConfigs' => [
                [
                    'name' => 'projects/foo/instanceConfigs/bat',
                    'displayName' => 'Bat'
                ]
            ]
        ];

        $iteration = 0;
        $this->mockSendRequest(
            InstanceAdminClient::class,
            'listInstanceConfigs',
            function ($args) use (&$iteration) {
                $iteration++;
                return $this->serializer->encodeMessage($args)['parent']
                    == InstanceAdminClient::projectName(self::PROJECT) && $iteration == 1;
            },
            $firstCall
        );
        $this->mockSendRequest(
            InstanceAdminClient::class,
            'listInstanceConfigs',
            function ($args) use (&$iteration) {
                return $this->serializer->encodeMessage($args)['parent']
                    == InstanceAdminClient::projectName(self::PROJECT) && $iteration == 2;
            },
            $secondCall
        );

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->client->___setProperty('serializer', $this->serializer);

        $configs = $this->client->instanceConfigurations();

        $this->assertInstanceOf(ItemIterator::class, $configs);

        $configs = iterator_to_array($configs);
        $this->assertCount(2, $configs);
        $this->assertInstanceOf(InstanceConfiguration::class, $configs[0]);
        $this->assertInstanceOf(InstanceConfiguration::class, $configs[1]);
    }

    /**
     * @group spanner-admin
     */
    public function testInstanceConfiguration()
    {
        $config = $this->client->instanceConfiguration('bar');

        $this->assertInstanceOf(InstanceConfiguration::class, $config);
        $this->assertEquals('bar', InstanceAdminClient::parseName($config->name())['instance_config']);
    }

    /**
     * @group spanner-admin
     */
    public function testCreateInstance()
    {
        $this->mockSendRequest(
            InstanceAdminClient::class,
            'createInstance',
            function ($args) use (&$iteration) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals(
                    $message['instance']['name'],
                    InstanceAdminClient::instanceName(self::PROJECT, self::INSTANCE)
                );
                $this->assertEquals(
                    $message['instance']['config'],
                    InstanceAdminClient::instanceConfigName(self::PROJECT, self::CONFIG)
                );
                return true;
            },
            $this->getOperationResponseMock()
        );

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->client->___setProperty('serializer', $this->serializer);

        $config = $this->prophesize(InstanceConfiguration::class);
        $config->name()->willReturn(InstanceAdminClient::instanceConfigName(self::PROJECT, self::CONFIG));

        $operation = $this->client->createInstance($config->reveal(), self::INSTANCE);

        $this->assertInstanceOf(LongRunningOperationManager::class, $operation);
    }

    /**
     * @group spanner-admin
     */
    public function testCreateInstanceWithNodes()
    {
        $this->mockSendRequest(
            InstanceAdminClient::class,
            'createInstance',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                if ($message['instance']['name'] !== InstanceAdminClient::instanceName(self::PROJECT, self::INSTANCE)) {
                    return false;
                }
    
                if ($message['instance']['config'] !== InstanceAdminClient::instanceConfigName(
                    self::PROJECT,
                    self::CONFIG
                )) {
                    return false;
                }

                return isset($message['instance']['nodeCount']) && $message['instance']['nodeCount'] === 2;
            },
            $this->getOperationResponseMock()
        );

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->client->___setProperty('serializer', $this->serializer);

        $config = $this->prophesize(InstanceConfiguration::class);
        $config->name()->willReturn(InstanceAdminClient::instanceConfigName(self::PROJECT, self::CONFIG));

        $operation = $this->client->createInstance($config->reveal(), self::INSTANCE, [
            'nodeCount' => 2
        ]);

        $this->assertInstanceOf(LongRunningOperationManager::class, $operation);
    }

    /**
     * @group spanner-admin
     */
    public function testCreateInstanceWithProcessingUnits()
    {
        $this->mockSendRequest(
            InstanceAdminClient::class,
            'createInstance',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                if ($message['instance']['name'] !== InstanceAdminClient::instanceName(
                    self::PROJECT,
                    self::INSTANCE
                )) {
                    return false;
                }
                if ($message['instance']['config'] !== InstanceAdminClient::instanceConfigName(
                    self::PROJECT,
                    self::CONFIG
                )) {
                    return false;
                }

                return isset($message['instance']['processingUnits'])
                    && $message['instance']['processingUnits'] === 2000;
            },
            $this->getOperationResponseMock()
        );

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->client->___setProperty('serializer', $this->serializer);

        $config = $this->prophesize(InstanceConfiguration::class);
        $config->name()->willReturn(InstanceAdminClient::instanceConfigName(self::PROJECT, self::CONFIG));

        $operation = $this->client->createInstance($config->reveal(), self::INSTANCE, [
            'processingUnits' => 2000
        ]);

        $this->assertInstanceOf(LongRunningOperationManager::class, $operation);
    }

    /**
     * @group spanner-admin
     */
    public function testCreateInstanceRaisesInvalidArgument()
    {
        $this->expectException(InvalidArgumentException::class);

        $config = $this->prophesize(InstanceConfiguration::class);

        $this->client->createInstance($config->reveal(), self::INSTANCE, [
            'nodeCount' => 2,
            'processingUnits' => 2000,
        ]);
    }

    /**
     * @group spanner-admin
     */
    public function testInstance()
    {
        $i = $this->client->instance('foo');
        $this->assertInstanceOf(Instance::class, $i);
        $this->assertEquals('foo', InstanceAdminClient::parseName($i->name())['instance']);
    }

    /**
     * @group spanner-admin
     */
    public function testInstanceWithInstanceArray()
    {
        $i = $this->client->instance('foo', ['key' => 'val']);
        $this->assertEquals('val', $i->info()['key']);
    }

    /**
     * @group spanner-admin
     */
    public function testInstances()
    {
        $this->mockSendRequest(
            InstanceAdminClient::class,
            'listInstances',
            function ($args) {
                $this->assertEquals(
                    $args->getParent(),
                    InstanceAdminClient::projectName(self::PROJECT)
                );
                return true;
            },
            [
                'instances' => [
                    ['name' => 'projects/test-project/instances/foo'],
                    ['name' => 'projects/test-project/instances/bar'],
                ]
            ]
        );

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->client->___setProperty('serializer', $this->serializer);

        $instances = $this->client->instances();
        $this->assertInstanceOf(ItemIterator::class, $instances);

        $instances = iterator_to_array($instances);
        $this->assertCount(2, $instances);
        $this->assertEquals('foo', InstanceAdminClient::parseName($instances[0]->name())['instance']);
        $this->assertEquals('bar', InstanceAdminClient::parseName($instances[1]->name())['instance']);
    }

    /**
     * @group spanner-admin
     */
    public function testResumeOperation()
    {
        $opName = 'operations/foo';

        $op = $this->client->resumeOperation($opName);
        $this->assertInstanceOf(LongRunningOperationManager::class, $op);
        $this->assertEquals($op->name(), $opName);
    }

    public function testConnect()
    {
        $database = $this->client->connect(self::INSTANCE, self::DATABASE);
        $this->assertInstanceOf(Database::class, $database);
        $this->assertEquals(self::DATABASE, DatabaseAdminClient::parseName($database->name())['database']);
    }

    public function testConnectWithInstance()
    {
        $inst = $this->client->instance(self::INSTANCE);
        $database = $this->client->connect($inst, self::DATABASE);
        $this->assertInstanceOf(Database::class, $database);
        $this->assertEquals(self::DATABASE, DatabaseAdminClient::parseName($database->name())['database']);
    }

    public function testKeyset()
    {
        $ks = $this->client->keySet();
        $this->assertInstanceOf(KeySet::class, $ks);
    }

    public function testKeyRange()
    {
        $kr = $this->client->keyRange();
        $this->assertInstanceOf(KeyRange::class, $kr);
    }

    public function testBytes()
    {
        $b = $this->client->bytes('foo');
        $this->assertInstanceOf(Bytes::class, $b);
        $this->assertEquals(base64_encode('foo'), (string)$b);
    }

    public function testDate()
    {
        $d = $this->client->date(new \DateTime);
        $this->assertInstanceOf(Date::class, $d);
    }

    public function testTimestamp()
    {
        $ts = $this->client->timestamp(new \DateTime);
        $this->assertInstanceOf(Timestamp::class, $ts);
    }

    public function testNumeric()
    {
        $n = $this->client->numeric('12345.123456789');
        $this->assertInstanceOf(Numeric::class, $n);
    }

    public function testPgNumeric()
    {
        $decimalVal = $this->client->pgNumeric('12345.123456789');
        $this->assertInstanceOf(PgNumeric::class, $decimalVal);

        $scientificVal = $this->client->pgNumeric('1.09E100');
        $this->assertInstanceOf(PgNumeric::class, $scientificVal);
    }

    public function testPgJsonB()
    {
        $strVal = $this->client->pgJsonb('{}');
        $this->assertInstanceOf(PgJsonb::class, $strVal);

        $arrVal = $this->client->pgJsonb(["a" => 1, "b" => 2]);
        $this->assertInstanceOf(PgJsonb::class, $arrVal);

        $stub = $this->prophesize('stdClass');
        $stub->willImplement('JsonSerializable');
        $stub->jsonSerialize()->willReturn(["a" => 1, "b" => null]);
        $objVal = $this->client->pgJsonb($stub->reveal());
        $this->assertInstanceOf(PgJsonb::class, $objVal);
    }

    public function testInt64()
    {
        $i64 = $this->client->int64('123');
        $this->assertInstanceOf(Int64::class, $i64);
    }

    public function testDuration()
    {
        $d = $this->client->duration(10, 1);
        $this->assertInstanceOf(Duration::class, $d);
    }

    public function testCommitTimestamp()
    {
        $t = $this->client->commitTimestamp();
        $this->assertInstanceOf(CommitTimestamp::class, $t);
    }

    public function testSpannerClientDatabaseRole()
    {
        $instance = $this->prophesize(Instance::class);
        $instance->database(Argument::any(), ['databaseRole' => 'Reader'])->shouldBeCalled();
        $this->client->connect($instance->reveal(), self::DATABASE, ['databaseRole' => 'Reader']);
    }

    public function testSpannerClientWithDirectedRead()
    {
        $instance = $this->client->instance('testInstance');
        $this->assertEquals(
            $instance->directedReadOptions(),
            $this->directedReadOptionsIncludeReplicas
        );
    }

    private function getOperationResponseMock()
    {
        $operation = $this->serializer->decodeMessage(
            new \Google\LongRunning\Operation(),
            ['metadata' => [
                'typeUrl' => 'type.googleapis.com/google.spanner.admin.database.v1.CreateDatabaseMetadata'
            ]]
        );
        $operationResponse = $this->prophesize(OperationResponse::class);
        $operationResponse->getLastProtoResponse()->willReturn($operation);
        $operationResponse->isDone()->willReturn(false);
        $operationResponse->getError()->willReturn(null);
        return $operationResponse;
    }
}
