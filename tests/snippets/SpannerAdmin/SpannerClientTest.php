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

namespace Google\Cloud\Tests\Snippets\SpannerAdmin;

use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Spanner\Configuration;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Instance;
use Google\Cloud\Spanner\SpannerClient;
use Prophecy\Argument;

/**
 * @group spanneradmin
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
        $this->client->setConnection($this->connection->reveal());
    }

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

        $this->client->setConnection($this->connection->reveal());

        $snippet = $this->snippetFromMethod(SpannerClient::class, 'configurations');
        $snippet->addLocal('spanner', $this->client);

        $res = $snippet->invoke('configurations');

        $this->assertInstanceOf(\Generator::class, $res->returnVal());
        $this->assertInstanceOf(Configuration::class, $res->returnVal()->current());
        $this->assertEquals('Foo', $res->returnVal()->current()->name());
    }

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

    public function testCreateInstance()
    {
        $snippet = $this->snippetFromMethod(SpannerClient::class, 'createInstance');
        $snippet->addLocal('spanner', $this->client);
        $snippet->addLocal('configuration', $this->client->configuration(self::CONFIG));

        $this->connection->createInstance(Argument::any())
            ->shouldBeCalled()
            ->willReturn([]);

        $this->client->setConnection($this->connection->reveal());

        $res = $snippet->invoke('instance');
        $this->assertInstanceOf(Instance::class, $res->returnVal());
        $this->assertEquals(self::INSTANCE, $res->returnVal()->name());
    }

    public function testInstance()
    {
        $snippet = $this->snippetFromMethod(SpannerClient::class, 'instance');
        $snippet->addLocal('spanner', $this->client);

        $res = $snippet->invoke('instance');
        $this->assertInstanceOf(Instance::class, $res->returnVal());
        $this->assertEquals(self::INSTANCE, $res->returnVal()->name());
    }

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

        $this->client->setConnection($this->connection->reveal());

        $res = $snippet->invoke('instances');
        $this->assertInstanceOf(\Generator::class, $res->returnVal());
        $this->assertInstanceOf(Instance::class, $res->returnVal()->current());
        $this->assertEquals(self::INSTANCE, $res->returnVal()->current()->name());
    }
}
