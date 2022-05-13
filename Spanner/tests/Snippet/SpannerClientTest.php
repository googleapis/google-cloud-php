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

namespace Google\Cloud\Spanner\Tests\Snippet;

use Google\Cloud\Core\Int64;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
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
use Google\Cloud\Spanner\SpannerClient;
use Google\Cloud\Spanner\Tests\StubCreationTrait;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\Numeric;
use Google\Cloud\Spanner\PgNumeric;
use Prophecy\Argument;

/**
 * @group spanner
 */
class SpannerClientTest extends SnippetTestCase
{
    use GrpcTestTrait;
    use StubCreationTrait;

    const PROJECT = 'my-awesome-project';
    const CONFIG = 'foo';
    const INSTANCE = 'my-instance';

    private $client;
    private $connection;

    public function set_up()
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->getConnStub();
        $this->client = TestHelpers::stub(SpannerClient::class);
        $this->client->___setProperty('connection', $this->connection->reveal());
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(SpannerClient::class);
        $res = $snippet->invoke('spanner');
        $this->assertInstanceOf(SpannerClient::class, $res->returnVal());
    }

    public function testBatch()
    {
        $snippet = $this->snippetFromMethod(SpannerClient::class, 'batch');
        $snippet->addLocal('spanner', $this->client);
        $res = $snippet->invoke('batch');
        $this->assertInstanceOf(BatchClient::class, $res->returnVal());
    }

    /**
     * @group spanner-admin
     */
    public function testInstanceConfigurations()
    {
        $this->connection->listInstanceConfigs(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'instanceConfigs' => [
                    ['name' => 'projects/my-awesome-projects/instanceConfigs/foo'],
                    ['name' => 'projects/my-awesome-projects/instanceConfigs/bar'],
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(SpannerClient::class, 'instanceConfigurations');
        $snippet->addLocal('spanner', $this->client);

        $res = $snippet->invoke('configurations');

        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertInstanceOf(InstanceConfiguration::class, $res->returnVal()->current());
        $this->assertEquals('projects/my-awesome-projects/instanceConfigs/foo', $res->returnVal()->current()->name());
    }

    /**
     * @group spanner-admin
     */
    public function testInstanceConfiguration()
    {
        $configName = 'foo';

        $snippet = $this->snippetFromMethod(SpannerClient::class, 'instanceConfiguration');
        $snippet->addLocal('spanner', $this->client);
        $snippet->addLocal('configurationName', self::CONFIG);

        $res = $snippet->invoke('configuration');
        $this->assertInstanceOf(InstanceConfiguration::class, $res->returnVal());
        $this->assertEquals(
            InstanceAdminClient::instanceConfigName(self::PROJECT, $configName),
            $res->returnVal()->name()
        );
    }

    /**
     * @group spanner-admin
     */
    public function testCreateInstance()
    {
        $snippet = $this->snippetFromMethod(SpannerClient::class, 'createInstance');
        $snippet->addLocal('spanner', $this->client);
        $snippet->addLocal('configuration', $this->client->instanceConfiguration(self::CONFIG));

        $this->connection->createInstance(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['name' => 'operations/foo']);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(LongRunningOperation::class, $res->returnVal());
    }

    /**
     * @group spanner-admin
     */
    public function testInstance()
    {
        $snippet = $this->snippetFromMethod(SpannerClient::class, 'instance');
        $snippet->addLocal('spanner', $this->client);

        $res = $snippet->invoke('instance');
        $this->assertInstanceOf(Instance::class, $res->returnVal());
        $this->assertEquals(
            InstanceAdminClient::instanceName(self::PROJECT, self::INSTANCE),
            $res->returnVal()->name()
        );
    }

    /**
     * @group spanner-admin
     */
    public function testInstances()
    {
        $snippet = $this->snippetFromMethod(SpannerClient::class, 'instances');
        $snippet->addLocal('spanner', $this->client);

        $this->connection->listInstances(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'instances' => [
                    ['name' => InstanceAdminClient::instanceName(self::PROJECT, self::INSTANCE)],
                    ['name' => InstanceAdminClient::instanceName(self::PROJECT, 'bar')]
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('instances');
        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertInstanceOf(Instance::class, $res->returnVal()->current());
        $this->assertEquals(
            InstanceAdminClient::instanceName(self::PROJECT, self::INSTANCE),
            $res->returnVal()->current()->name()
        );
    }

    public function testConnect()
    {
        $snippet = $this->snippetFromMethod(SpannerClient::class, 'connect');
        $snippet->addLocal('spanner', $this->client);

        $res = $snippet->invoke('database');
        $this->assertInstanceOf(Database::class, $res->returnVal());
    }

    public function testKeySet()
    {
        $snippet = $this->snippetFromMethod(SpannerClient::class, 'keySet');
        $snippet->addLocal('spanner', $this->client);

        $res = $snippet->invoke('keySet');
        $this->assertInstanceOf(KeySet::class, $res->returnVal());
    }

    public function testKeySetAll()
    {
        $snippet = $this->snippetFromMethod(SpannerClient::class, 'keySet', 1);
        $snippet->addLocal('spanner', $this->client);

        $res = $snippet->invoke('keySet');
        $this->assertInstanceOf(KeySet::class, $res->returnVal());
        $this->assertTrue($res->returnVal()->matchAll());
    }

    public function testKeyRange()
    {
        $snippet = $this->snippetFromMethod(SpannerClient::class, 'keyRange');
        $snippet->addLocal('spanner', $this->client);

        $res = $snippet->invoke('range');
        $this->assertInstanceOf(KeyRange::class, $res->returnVal());
    }

    public function testKeyRangeComplete()
    {
        $snippet = $this->snippetFromMethod(SpannerClient::class, 'keyRange', 1);
        $snippet->addLocal('spanner', $this->client);
        $snippet->addUse(KeyRange::class);

        $res = $snippet->invoke('range');
        $this->assertInstanceOf(KeyRange::class, $res->returnVal());
        $res->returnVal()->keyRangeObject();
    }

    /**
     * @dataProvider factoriesProvider
     */
    public function testFactories($type, $name)
    {
        $snippet = $this->snippetFromMethod(SpannerClient::class, $name);
        $snippet->addLocal('spanner', $this->client);

        $res = $snippet->invoke($name);
        $this->assertInstanceOf($type, $res->returnVal());
    }

    public function factoriesProvider()
    {
        return [
            [Bytes::class, 'bytes'],
            [Date::class, 'date'],
            [Timestamp::class, 'timestamp'],
            [Int64::class, 'int64'],
            [Duration::class, 'duration'],
            [CommitTimestamp::class, 'commitTimestamp'],
            [Numeric::class, 'numeric'],
            [PgNumeric::class, 'pgNumeric'],
        ];
    }

    public function testResumeOperation()
    {
        $snippet = $this->snippetFromMagicMethod(SpannerClient::class, 'resumeOperation');
        $snippet->addLocal('spanner', $this->client);
        $snippet->addLocal('operationName', 'operations/foo');

        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(LongRunningOperation::class, $res->returnVal());
    }

    public function testEmulator()
    {
        $snippet = $this->snippetFromClass(SpannerClient::class, 1);
        $res = $snippet->invoke('spanner');
        $this->assertInstanceOf(SpannerClient::class, $res->returnVal());
        $this->assertEquals('localhost:9010', getenv('SPANNER_EMULATOR_HOST'));
    }
}
