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

namespace Google\Cloud\Tests\Snippets\Spanner;

use Google\Cloud\Core\Int64;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Spanner\Bytes;
use Google\Cloud\Spanner\Configuration;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Date;
use Google\Cloud\Spanner\Duration;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\KeyRange;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\SpannerClient;
use Google\Cloud\Spanner\Timestamp;
use Prophecy\Argument;

/**
 * @group spanner
 */
class SpannerClientTest extends SnippetTestCase
{
    const CONFIG = 'Foo';
    const INSTANCE = 'my-instance';

    private $client;
    private $connection;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->client = \Google\Cloud\Dev\stub(SpannerClient::class);
        $this->client->___setProperty('connection', $this->connection->reveal());
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(SpannerClient::class);
        $res = $snippet->invoke('spanner');
        $this->assertInstanceOf(SpannerClient::class, $res->returnVal());
    }

    /**
     * @group spanneradmin
     */
    public function testConfigurations()
    {
        $this->connection->listConfigs(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'instanceConfigs' => [
                    ['name' => 'projects/my-awesome-projects/instanceConfigs/Foo'],
                    ['name' => 'projects/my-awesome-projects/instanceConfigs/Bar'],
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(SpannerClient::class, 'configurations');
        $snippet->addLocal('spanner', $this->client);

        $res = $snippet->invoke('configurations');

        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertInstanceOf(Configuration::class, $res->returnVal()->current());
        $this->assertEquals('Foo', $res->returnVal()->current()->name());
    }

    /**
     * @group spanneradmin
     */
    public function testConfiguration()
    {
        $configName = 'foo';

        $snippet = $this->snippetFromMethod(SpannerClient::class, 'configuration');
        $snippet->addLocal('spanner', $this->client);
        $snippet->addLocal('configurationName', self::CONFIG);

        $res = $snippet->invoke('configuration');
        $this->assertInstanceOf(Configuration::class, $res->returnVal());
        $this->assertEquals(self::CONFIG, $res->returnVal()->name());
    }

    /**
     * @group spanneradmin
     */
    public function testCreateInstance()
    {
        $snippet = $this->snippetFromMethod(SpannerClient::class, 'createInstance');
        $snippet->addLocal('spanner', $this->client);
        $snippet->addLocal('configuration', $this->client->configuration(self::CONFIG));

        $this->connection->createInstance(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['name' => 'operations/foo']);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(LongRunningOperation::class, $res->returnVal());
    }

    /**
     * @group spanneradmin
     */
    public function testInstance()
    {
        $snippet = $this->snippetFromMethod(SpannerClient::class, 'instance');
        $snippet->addLocal('spanner', $this->client);

        $res = $snippet->invoke('instance');
        $this->assertInstanceOf(Instance::class, $res->returnVal());
        $this->assertEquals(self::INSTANCE, $res->returnVal()->name());
    }

    /**
     * @group spanneradmin
     */
    public function testInstances()
    {
        $snippet = $this->snippetFromMethod(SpannerClient::class, 'instances');
        $snippet->addLocal('spanner', $this->client);

        $this->connection->listInstances(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'instances' => [
                    ['name' => 'projects/my-awesome-project/instances/'. self::INSTANCE],
                    ['name' => 'projects/my-awesome-project/instances/Bar']
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('instances');
        $this->assertInstanceOf(ItemIterator::class, $res->returnVal());
        $this->assertInstanceOf(Instance::class, $res->returnVal()->current());
        $this->assertEquals(self::INSTANCE, $res->returnVal()->current()->name());
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

    public function testBytes()
    {
        $snippet = $this->snippetFromMethod(SpannerClient::class, 'bytes');
        $snippet->addLocal('spanner', $this->client);

        $res = $snippet->invoke('bytes');
        $this->assertInstanceOf(Bytes::class, $res->returnVal());
    }

    public function testDate()
    {
        $snippet = $this->snippetFromMethod(SpannerClient::class, 'date');
        $snippet->addLocal('spanner', $this->client);

        $res = $snippet->invoke('date');
        $this->assertInstanceOf(Date::class, $res->returnVal());
    }

    public function testTimestamp()
    {
        $snippet = $this->snippetFromMethod(SpannerClient::class, 'timestamp');
        $snippet->addLocal('spanner', $this->client);

        $res = $snippet->invoke('timestamp');
        $this->assertInstanceOf(Timestamp::class, $res->returnVal());
    }

    public function testInt64()
    {
        $snippet = $this->snippetFromMethod(SpannerClient::class, 'int64');
        $snippet->addLocal('spanner', $this->client);

        $res = $snippet->invoke('int64');
        $this->assertInstanceOf(Int64::class, $res->returnVal());
    }

    public function testDuration()
    {
        $snippet = $this->snippetFromMethod(SpannerClient::class, 'duration');
        $snippet->addLocal('spanner', $this->client);

        $res = $snippet->invoke('duration');
        $this->assertInstanceOf(Duration::class, $res->returnVal());
    }

    public function testResumeOperation()
    {
        $snippet = $this->snippetFromMethod(SpannerClient::class, 'resumeOperation');
        $snippet->addLocal('spanner', $this->client);
        $snippet->addLocal('operationName', 'operations/foo');

        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(LongRunningOperation::class, $res->returnVal());
    }
}
