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

namespace Google\Cloud\Tests\Unit\SpannerAdmin;

use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Spanner\Configuration;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\SpannerClient;
use Prophecy\Argument;

/**
 * @group spanneradmin
 */
class SpannerClientTest extends \PHPUnit_Framework_TestCase
{
    private $client;

    private $connection;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);

        $this->client = \Google\Cloud\Dev\stub(SpannerClient::class, [['projectId' => 'test-project']]);
        $this->client->___setProperty('connection', $this->connection->reveal());
    }

    public function testConfigurations()
    {
        $this->connection->listConfigs(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'instanceConfigs' => [
                    [
                        'name' => 'projects/foo/instanceConfigs/bar',
                        'displayName' => 'Bar'
                    ], [
                        'name' => 'projects/foo/instanceConfigs/bat',
                        'displayName' => 'Bat'
                    ]
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $configs = $this->client->configurations();

        $this->assertInstanceOf(\Generator::class, $configs);

        $configs = iterator_to_array($configs);
        $this->assertEquals(2, count($configs));
        $this->assertInstanceOf(Configuration::class, $configs[0]);
        $this->assertInstanceOf(Configuration::class, $configs[1]);
    }

    public function testPagedConfigurations()
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

        $this->connection->listConfigs(Argument::any())
            ->shouldBeCalledTimes(2)
            ->willReturn($firstCall, $secondCall);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $configs = $this->client->configurations();

        $this->assertInstanceOf(\Generator::class, $configs);

        $configs = iterator_to_array($configs);
        $this->assertEquals(2, count($configs));
        $this->assertInstanceOf(Configuration::class, $configs[0]);
        $this->assertInstanceOf(Configuration::class, $configs[1]);
    }

    public function testConfiguration()
    {
        $config = $this->client->configuration('bar');

        $this->assertInstanceOf(Configuration::class, $config);
        $this->assertEquals('bar', $config->name());
    }

    public function testCreateInstance()
    {
        $this->connection->createInstance(Argument::that(function ($arg) {
            if ($arg['name'] !== 'projects/test-project/instances/foo') return false;
            if ($arg['config'] !== 'projects/test-project/instanceConfigs/my-config') return false;

            return true;
        }))
            ->shouldBeCalled()
            ->willReturn([
                'name' => 'operations/foo'
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $config = $this->prophesize(Configuration::class);
        $config->name()->willReturn('my-config');

        $operation = $this->client->createInstance($config->reveal(), 'foo');

        $this->assertInstanceOf(LongRunningOperation::class, $operation);
    }

    public function testInstance()
    {
        $i = $this->client->instance('foo');
        $this->assertInstanceOf(Instance::class, $i);
        $this->assertEquals('foo', $i->name());
    }

    public function testInstanceWithInstanceArray()
    {
        $i = $this->client->instance('foo', ['key' => 'val']);
        $this->assertEquals('val', $i->info()['key']);
    }

    public function testInstances()
    {
        $this->connection->listInstances(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'instances' => [
                    ['name' => 'projects/test-project/instances/foo'],
                    ['name' => 'projects/test-project/instances/bar'],
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $instances = $this->client->instances();
        $this->assertInstanceOf(\Generator::class, $instances);

        $instances = iterator_to_array($instances);
        $this->assertEquals(2, count($instances));
        $this->assertEquals('foo', $instances[0]->name());
        $this->assertEquals('bar', $instances[1]->name());
    }
}
