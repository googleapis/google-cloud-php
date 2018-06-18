<?php
/*
 * Copyright 2018, Google LLC All rights reserved.
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

namespace Google\Cloud\Bigtable\Tests\Snippet;

use Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient as InstanceAdminClient;
use Google\Cloud\Bigtable\Connection\ConnectionInterface;
use Google\Cloud\Bigtable\InstanceConfiguration;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Prophecy\Argument;

/**
 * @group bigtable
 * @group bigtable-admin
 */
class InstanceConfigurationTest extends SnippetTestCase
{
    use GrpcTestTrait;

    const PROJECT = 'my-awesome-project';
    const INSTANCE = 'my-instance';

    private $connection;
    private $config;

    public function setUp()
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->config = \Google\Cloud\Core\Testing\TestHelpers::stub(InstanceConfiguration::class, [
            $this->connection->reveal(),
            self::PROJECT,
            self::INSTANCE
        ]);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(InstanceConfiguration::class);
        $res = $snippet->invoke('configuration');

        $this->assertInstanceOf(InstanceConfiguration::class, $res->returnVal());
        $this->assertEquals(InstanceAdminClient::instanceName(self::PROJECT, self::INSTANCE), $res->returnVal()->name());
    }

    public function testName()
    {
        $snippet = $this->snippetFromMethod(InstanceConfiguration::class, 'name');
        $snippet->addLocal('configuration', $this->config);

        $res = $snippet->invoke('name');
        $this->assertEquals(InstanceAdminClient::instanceName(self::PROJECT, self::INSTANCE), $res->returnVal());
    }

    public function testInfo()
    {
        $snippet = $this->snippetFromMethod(InstanceConfiguration::class, 'info');
        $snippet->addLocal('configuration', $this->config);

        $info = [
            'name' => InstanceAdminClient::instanceName(self::PROJECT, self::INSTANCE),
            'displayName' => self::INSTANCE
        ];

        $this->connection->getInstance(Argument::any())
            ->shouldBeCalled()
            ->willReturn($info);

        $this->config->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('info');
        $this->assertEquals($info, $res->returnVal());
    }

    public function testExists()
    {
        $snippet = $this->snippetFromMethod(InstanceConfiguration::class, 'exists');
        $snippet->addLocal('configuration', $this->config);

        $this->connection->getInstance(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => InstanceAdminClient::instanceName(self::PROJECT, self::INSTANCE),
                'displayName' => self::INSTANCE
            ]);

        $this->config->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('Configuration exists!', $res->output());
    }

    public function testReload()
    {
        $info = [
            'name' => InstanceAdminClient::instanceName(self::PROJECT, self::INSTANCE),
            'displayName' => self::INSTANCE
        ];

        $snippet = $this->snippetFromMethod(InstanceConfiguration::class, 'reload');
        $snippet->addLocal('configuration', $this->config);

        $this->connection->getInstance(Argument::any())
            ->shouldBeCalled()
            ->willReturn($info);

        $this->config->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('info');
        $this->assertEquals($info, $res->returnVal());
    }
}
