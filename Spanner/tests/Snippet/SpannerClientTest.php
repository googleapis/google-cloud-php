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
use Google\ApiCore\OperationResponse;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
use Google\Cloud\Spanner\Batch\BatchClient;
use Google\Cloud\Spanner\Bytes;
use Google\Cloud\Spanner\CommitTimestamp;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Date;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\InstanceConfiguration;
use Google\Cloud\Spanner\KeyRange;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\SpannerClient;
use Google\Cloud\Spanner\Tests\RequestHandlingTestTrait;
use Google\Cloud\Spanner\Timestamp;
use Google\Cloud\Spanner\Numeric;
use Google\Cloud\Spanner\PgNumeric;
use Google\Cloud\Spanner\PgOid;
use Google\Cloud\Spanner\PgJsonb;
use Google\Protobuf\Duration;
use Prophecy\Argument;

/**
 * @group spanner
 */
class SpannerClientTest extends SnippetTestCase
{
    use GrpcTestTrait;
    use RequestHandlingTestTrait;

    const PROJECT = 'my-awesome-project';
    const CONFIG = 'foo';
    const INSTANCE = 'my-instance';

    private $client;
    private $requestHandler;
    private $serializer;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->requestHandler = $this->getRequestHandlerStub();
        $this->serializer = $this->getSerializer();
        $this->client = TestHelpers::stub(
            SpannerClient::class,
            [['projectId' => self::PROJECT]],
            ['requestHandler', 'serializer']
        );
        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->client->___setProperty('serializer', $this->serializer);
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
        $this->mockSendRequest(
            InstanceAdminClient::class,
            'listInstanceConfigs',
            null,
            [
                'instanceConfigs' => [
                    ['name' => 'projects/my-awesome-projects/instanceConfigs/foo'],
                    ['name' => 'projects/my-awesome-projects/instanceConfigs/bar'],
                ]
            ]
        );

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->client->___setProperty('serializer', $this->serializer);

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

        $this->mockSendRequest(
            InstanceAdminClient::class,
            'createInstance',
            null,
            $this->getOperationResponseMock()
        );

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->client->___setProperty('serializer', $this->serializer);

        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(OperationResponse::class, $res->returnVal());
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

        $this->mockSendRequest(
            InstanceAdminClient::class,
            'listInstances',
            null,
            [
                'instances' => [
                    ['name' => InstanceAdminClient::instanceName(self::PROJECT, self::INSTANCE)],
                    ['name' => InstanceAdminClient::instanceName(self::PROJECT, 'bar')]
                ]
            ]
        );

        $this->client->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->client->___setProperty('serializer', $this->serializer);

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
            [PgJsonB::class, 'pgJsonb'],
            [PgOid::class, 'pgOid'],
        ];
    }

    public function testResumeOperation()
    {
        $snippet = $this->snippetFromMagicMethod(SpannerClient::class, 'resumeOperation');
        $snippet->addLocal('spanner', $this->client);
        $snippet->addLocal('operationName', 'operations/foo');

        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(OperationResponse::class, $res->returnVal());
    }

    public function testEmulator()
    {
        $snippet = $this->snippetFromClass(SpannerClient::class, 1);
        $res = $snippet->invoke('spanner');
        $this->assertInstanceOf(SpannerClient::class, $res->returnVal());
        $this->assertEquals('localhost:9010', getenv('SPANNER_EMULATOR_HOST'));
    }

    public function testConnectWithDatabaseRole()
    {
        $snippet = $this->snippetFromMethod(SpannerClient::class, 'connect', 1);
        $snippet->addLocal('spanner', $this->client);

        $res = $snippet->invoke('database');
        $this->assertInstanceOf(Database::class, $res->returnVal());
    }

    public function testBatchWithDatabaseRole()
    {
        $snippet = $this->snippetFromMethod(SpannerClient::class, 'batch', 1);
        $snippet->addLocal('spanner', $this->client);
        $res = $snippet->invoke('batch');
        $this->assertInstanceOf(BatchClient::class, $res->returnVal());
    }

    public function testClassWithDirectedRead()
    {
        $snippet = $this->snippetFromClass(SpannerClient::class, 2);
        $res = $snippet->invoke('spanner');
        $this->assertInstanceOf(SpannerClient::class, $res->returnVal());
    }

    public function testClassWithLar()
    {
        $snippet = $this->snippetFromClass(SpannerClient::class, 3);
        $res = $snippet->invoke('spanner');
        $this->assertInstanceOf(SpannerClient::class, $res->returnVal());
    }
}
