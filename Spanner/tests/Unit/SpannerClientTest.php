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

use Google\Cloud\Core\Int64;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;
use Google\Cloud\Spanner\Batch\BatchClient;
use Google\Cloud\Spanner\Bytes;
use Google\Cloud\Spanner\CommitTimestamp;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Date;
use Google\Cloud\Spanner\Duration;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\InstanceConfiguration;
use Google\Cloud\Spanner\KeyRange;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Numeric;
use Google\Cloud\Spanner\PgNumeric;
use Google\Cloud\Spanner\SpannerClient;
use Google\Cloud\Spanner\Tests\StubCreationTrait;
use Google\Cloud\Spanner\Timestamp;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Prophecy\Argument;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * @group spanner
 */
class SpannerClientTest extends TestCase
{
    use ExpectException;
    use GrpcTestTrait;
    use StubCreationTrait;

    const PROJECT = 'my-awesome-project';
    const INSTANCE = 'inst';
    const DATABASE = 'db';
    const CONFIG = 'conf';

    private $client;
    private $connection;

    public function set_up()
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->getConnStub();
        $this->client = TestHelpers::stub(SpannerClient::class, [
            ['projectId' => self::PROJECT]
        ]);
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
        $this->connection->listInstanceConfigs(
            Argument::withEntry('projectName', InstanceAdminClient::projectName(self::PROJECT))
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

        $this->client->___setProperty('connection', $this->connection->reveal());

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

        $this->connection->listInstanceConfigs(
            Argument::withEntry('projectName', InstanceAdminClient::projectName(self::PROJECT))
        )
            ->shouldBeCalledTimes(2)
            ->willReturn($firstCall, $secondCall);

        $this->client->___setProperty('connection', $this->connection->reveal());

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
        $this->connection->createInstance(Argument::that(function ($arg) {
            if ($arg['name'] !== InstanceAdminClient::instanceName(self::PROJECT, self::INSTANCE)) {
                return false;
            }

            return $arg['config'] === InstanceAdminClient::instanceConfigName(self::PROJECT, self::CONFIG);
        }))
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'operations/foo'
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $config = $this->prophesize(InstanceConfiguration::class);
        $config->name()->willReturn(InstanceAdminClient::instanceConfigName(self::PROJECT, self::CONFIG));

        $operation = $this->client->createInstance($config->reveal(), self::INSTANCE);

        $this->assertInstanceOf(LongRunningOperation::class, $operation);
    }

    /**
     * @group spanner-admin
     */
    public function testCreateInstanceWithNodes()
    {
        $this->connection->createInstance(Argument::that(function ($arg) {
            if ($arg['name'] !== InstanceAdminClient::instanceName(self::PROJECT, self::INSTANCE)) {
                return false;
            }

            if ($arg['config'] !== InstanceAdminClient::instanceConfigName(self::PROJECT, self::CONFIG)) {
                return false;
            }

            return isset($arg['nodeCount']) && $arg['nodeCount'] === 2;
        }))
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'operations/foo'
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $config = $this->prophesize(InstanceConfiguration::class);
        $config->name()->willReturn(InstanceAdminClient::instanceConfigName(self::PROJECT, self::CONFIG));

        $operation = $this->client->createInstance($config->reveal(), self::INSTANCE, [
            'nodeCount' => 2
        ]);

        $this->assertInstanceOf(LongRunningOperation::class, $operation);
    }

    /**
     * @group spanner-admin
     */
    public function testCreateInstanceWithProcessingUnits()
    {
        $this->connection->createInstance(Argument::that(function ($arg) {
            if ($arg['name'] !== InstanceAdminClient::instanceName(self::PROJECT, self::INSTANCE)) {
                return false;
            }

            if ($arg['config'] !== InstanceAdminClient::instanceConfigName(self::PROJECT, self::CONFIG)) {
                return false;
            }

            return isset($arg['processingUnits']) && $arg['processingUnits'] === 2000;
        }))
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'operations/foo'
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $config = $this->prophesize(InstanceConfiguration::class);
        $config->name()->willReturn(InstanceAdminClient::instanceConfigName(self::PROJECT, self::CONFIG));

        $operation = $this->client->createInstance($config->reveal(), self::INSTANCE, [
            'processingUnits' => 2000
        ]);

        $this->assertInstanceOf(LongRunningOperation::class, $operation);
    }

    /**
     * @group spanner-admin
     */
    public function testCreateInstanceRaisesInvalidArgument()
    {
        $this->expectException('\InvalidArgumentException');

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
        $this->connection->listInstances(
            Argument::withEntry('projectName', InstanceAdminClient::projectName(self::PROJECT))
        )
            ->shouldBeCalled()
            ->willReturn([
                'instances' => [
                    ['name' => 'projects/test-project/instances/foo'],
                    ['name' => 'projects/test-project/instances/bar'],
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

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
        $this->assertInstanceOf(LongRunningOperation::class, $op);
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
}
