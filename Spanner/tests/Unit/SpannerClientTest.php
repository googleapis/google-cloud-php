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
use Google\ApiCore\Serializer;
use Google\Cloud\Core\Int64;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\Fixtures;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Spanner\Admin\Database\V1\Client\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
use Google\Cloud\Spanner\Batch\BatchClient;
use Google\Cloud\Spanner\Bytes;
use Google\Cloud\Spanner\CommitTimestamp;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Date;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\InstanceConfiguration;
use Google\Cloud\Spanner\PgJsonb;
use Google\Cloud\Spanner\PgOid;
use Google\Cloud\Spanner\KeyRange;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Numeric;
use Google\Cloud\Spanner\PgNumeric;
use Google\Cloud\Spanner\SpannerClient;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\V1\Client\SpannerClient as GapicSpannerClient;
use Google\Protobuf\Duration;
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

    const PROJECT = 'my-awesome-project';
    const INSTANCE = 'inst';
    const DATABASE = 'db';
    const CONFIG = 'conf';

    private $requestHandler;
    private $serializer;
    private $spannerClient;
    private $directedReadOptionsIncludeReplicas;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->serializer = new Serializer();

        $this->directedReadOptionsIncludeReplicas = [
            'includeReplicas' => [
                'replicaSelections' => [
                    'location' => 'us-central1',
                    'type' => 'READ_WRITE',
                    'autoFailoverDisabled' => false
                ]
            ]
        ];
        $this->spannerClient = new SpannerClient([
            'projectId' => self::PROJECT,
            'credentials' => Fixtures::KEYFILE_STUB_FIXTURE(),
            'directedReadOptions' => $this->directedReadOptionsIncludeReplicas
        ]);
    }

    public function testBatch()
    {
        $batch = $this->spannerClient->batch('foo', 'bar');
        $this->assertInstanceOf(BatchClient::class, $batch);

        $ref = new \ReflectionObject($batch);
        $prop = $ref->getProperty('databaseName');
        $prop->setAccessible(true);

        $this->assertEquals(
            GapicSpannerClient::databaseName(
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
        $this->instanceAdminClient->listInstanceConfigs(
            Argument::that(function ($request) {
                return $request->getParent() == InstanceAdminClient::projectName(self::PROJECT);
            }),
            Argument::type('array')
        )
            ->shouldBeCalled()
            ->willReturn([
                'instanceConfigs' => [
                    [
                        'name' => InstanceAdminClient::instanceConfigName(self::PROJECT, self::CONFIG),
                        'displayName' => 'Bar'
                    ], [
                        'name' => InstanceAdminClient::instanceConfigName(self::PROJECT, self::CONFIG),
                        'displayName' => 'Bat'
                    ]
                ]
            ]);

        $configs = $this->spannerClient->instanceConfigurations();

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
        $this->instanceAdminClient->listInstanceConfigs(
            Argument::that(function ($request) use (&$iteration) {
                $iteration++;
                return $this->serializer->encodeMessage($request)['parent']
                    == InstanceAdminClient::projectName(self::PROJECT) && $iteration == 1;
            }),
            Argument::type('array')
        )
            ->shouldBeCalled()
            ->willReturn($firstCall);

        $this->instanceAdminClient->listInstanceConfigs(
            Argument::that(function ($request) use (&$iteration) {
                return $this->serializer->encodeMessage($request)['parent']
                    == InstanceAdminClient::projectName(self::PROJECT) && $iteration == 2;
            }),
            Argument::type('array')
        )
            ->shouldBeCalled()
            ->willReturn($secondCall);

        $configs = $this->spannerClient->instanceConfigurations();

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
        $config = $this->spannerClient->instanceConfiguration('bar');

        $this->assertInstanceOf(InstanceConfiguration::class, $config);
        $this->assertEquals('bar', InstanceAdminClient::parseName($config->name())['instance_config']);
    }

    /**
     * @group spanner-admin
     */
    public function testCreateInstance()
    {
        $this->instanceAdminClient->createInstance(
            Argument::that(function ($request) use (&$iteration) {
                $message = $this->serializer->encodeMessage($request);
                $this->assertEquals(
                    $message['instance']['name'],
                    InstanceAdminClient::instanceName(self::PROJECT, self::INSTANCE)
                );
                $this->assertEquals(
                    $message['instance']['config'],
                    InstanceAdminClient::instanceConfigName(self::PROJECT, self::CONFIG)
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalled()
            ->willReturn($this->getOperationResponseMock());

        $config = $this->prophesize(InstanceConfiguration::class);
        $config->name()->willReturn(InstanceAdminClient::instanceConfigName(self::PROJECT, self::CONFIG));

        $operation = $this->spannerClient->createInstance($config->reveal(), self::INSTANCE);

        $this->assertInstanceOf(OperationResponse::class, $operation);
    }

    /**
     * @group spanner-admin
     */
    public function testCreateInstanceWithNodes()
    {
        $this->instanceAdminClient->createInstance(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
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
            }),
            Argument::type('array')
        )
            ->shouldBeCalled()
            ->willReturn($this->getOperationResponseMock());

        $config = $this->prophesize(InstanceConfiguration::class);
        $config->name()->willReturn(InstanceAdminClient::instanceConfigName(self::PROJECT, self::CONFIG));

        $operation = $this->spannerClient->createInstance($config->reveal(), self::INSTANCE, [
            'nodeCount' => 2
        ]);

        $this->assertInstanceOf(OperationResponse::class, $operation);
    }

    /**
     * @group spanner-admin
     */
    public function testCreateInstanceWithProcessingUnits()
    {
        $this->instanceAdminClient->createInstance(
            Argument::that(function ($request) {
                $message = $this->serializer->encodeMessage($request);
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
            }),
            Argument::type('array')
        )
            ->shouldBeCalled()
            ->willReturn($this->getOperationResponseMock());

        $config = $this->prophesize(InstanceConfiguration::class);
        $config->name()->willReturn(InstanceAdminClient::instanceConfigName(self::PROJECT, self::CONFIG));

        $operation = $this->spannerClient->createInstance($config->reveal(), self::INSTANCE, [
            'processingUnits' => 2000
        ]);

        $this->assertInstanceOf(OperationResponse::class, $operation);
    }

    /**
     * @group spanner-admin
     */
    public function testCreateInstanceRaisesInvalidArgument()
    {
        $this->expectException(InvalidArgumentException::class);

        $config = $this->prophesize(InstanceConfiguration::class);

        $this->spannerClient->createInstance($config->reveal(), self::INSTANCE, [
            'nodeCount' => 2,
            'processingUnits' => 2000,
        ]);
    }

    /**
     * @group spanner-admin
     */
    public function testInstance()
    {
        $i = $this->spannerClient->instance('foo');
        $this->assertInstanceOf(Instance::class, $i);
        $this->assertEquals('foo', InstanceAdminClient::parseName($i->name())['instance']);
    }

    /**
     * @group spanner-admin
     */
    public function testInstanceWithInstanceArray()
    {
        $i = $this->spannerClient->instance('foo', ['key' => 'val']);
        $this->assertEquals('val', $i->info()['key']);
    }

    /**
     * @group spanner-admin
     */
    public function testInstances()
    {
        $this->instanceAdminClient->listInstances(
            Argument::that(function ($request) {
                $this->assertEquals(
                    $request->getParent(),
                    InstanceAdminClient::projectName(self::PROJECT)
                );
                return true;
            }),
            Argument::type('array')
        )
            ->shouldBeCalled()
            ->willReturn([
                'instances' => [
                    ['name' => 'projects/test-project/instances/foo'],
                    ['name' => 'projects/test-project/instances/bar'],
                ]
            ]);

        $instances = $this->spannerClient->instances();
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

        $op = $this->spannerClient->resumeOperation($opName);
        $this->assertInstanceOf(OperationResponse::class, $op);
        $this->assertEquals($op->getName(), $opName);
    }

    public function testConnect()
    {
        $database = $this->spannerClient->connect(self::INSTANCE, self::DATABASE);
        $this->assertInstanceOf(Database::class, $database);
        $this->assertEquals(self::DATABASE, DatabaseAdminClient::parseName($database->name())['database']);
    }

    public function testConnectWithInstance()
    {
        $inst = $this->spannerClient->instance(self::INSTANCE);
        $database = $this->spannerClient->connect($inst, self::DATABASE);
        $this->assertInstanceOf(Database::class, $database);
        $this->assertEquals(self::DATABASE, DatabaseAdminClient::parseName($database->name())['database']);
    }

    public function testKeyset()
    {
        $ks = $this->spannerClient->keySet();
        $this->assertInstanceOf(KeySet::class, $ks);
    }

    public function testKeyRange()
    {
        $kr = $this->spannerClient->keyRange();
        $this->assertInstanceOf(KeyRange::class, $kr);
    }

    public function testBytes()
    {
        $b = $this->spannerClient->bytes('foo');
        $this->assertInstanceOf(Bytes::class, $b);
        $this->assertEquals(base64_encode('foo'), (string)$b);
    }

    public function testDate()
    {
        $d = $this->spannerClient->date(new \DateTime);
        $this->assertInstanceOf(Date::class, $d);
    }

    public function testTimestamp()
    {
        $ts = $this->spannerClient->timestamp(new \DateTime);
        $this->assertInstanceOf(Timestamp::class, $ts);
    }

    public function testNumeric()
    {
        $n = $this->spannerClient->numeric('12345.123456789');
        $this->assertInstanceOf(Numeric::class, $n);
    }

    public function testPgNumeric()
    {
        $decimalVal = $this->spannerClient->pgNumeric('12345.123456789');
        $this->assertInstanceOf(PgNumeric::class, $decimalVal);

        $scientificVal = $this->spannerClient->pgNumeric('1.09E100');
        $this->assertInstanceOf(PgNumeric::class, $scientificVal);
    }

    public function testPgJsonB()
    {
        $strVal = $this->spannerClient->pgJsonb('{}');
        $this->assertInstanceOf(PgJsonb::class, $strVal);

        $arrVal = $this->spannerClient->pgJsonb(["a" => 1, "b" => 2]);
        $this->assertInstanceOf(PgJsonb::class, $arrVal);

        $stub = $this->prophesize('stdClass');
        $stub->willImplement('JsonSerializable');
        $stub->jsonSerialize()->willReturn(["a" => 1, "b" => null]);
        $objVal = $this->spannerClient->pgJsonb($stub->reveal());
        $this->assertInstanceOf(PgJsonb::class, $objVal);
    }

    public function testPgOid()
    {
        $oidVal = $this->spannerClient->pgOid('123');
        $this->assertInstanceOf(PgOid::class, $oidVal);
    }

    public function testInt64()
    {
        $i64 = $this->spannerClient->int64('123');
        $this->assertInstanceOf(Int64::class, $i64);
    }

    public function testDuration()
    {
        $d = $this->spannerClient->duration(10, 1);
        $this->assertInstanceOf(Duration::class, $d);
    }

    public function testCommitTimestamp()
    {
        $t = $this->spannerClient->commitTimestamp();
        $this->assertInstanceOf(CommitTimestamp::class, $t);
    }

    public function testSpannerClientDatabaseRole()
    {
        $instance = $this->prophesize(Instance::class);
        $instance->database(Argument::any(), ['databaseRole' => 'Reader'])->shouldBeCalled();
        $this->spannerClient->connect($instance->reveal(), self::DATABASE, ['databaseRole' => 'Reader']);
    }

    public function testSpannerClientWithDirectedRead()
    {
        $instance = $this->spannerClient->instance('testInstance');
        $this->assertEquals(
            $instance->directedReadOptions(),
            $this->directedReadOptionsIncludeReplicas
        );
    }
}
