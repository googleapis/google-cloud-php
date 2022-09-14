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

use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceAdminClient;
use Google\Cloud\Spanner\InstanceConfiguration;
use Google\Cloud\Spanner\Tests\StubCreationTrait;
use Prophecy\Argument;

/**
 * @group spanner
 * @group spanner-admin
 */
class InstanceConfigurationTest extends SnippetTestCase
{
    use GrpcTestTrait;
    use StubCreationTrait;

    const PROJECT = 'my-awesome-project';
    const CONFIG = 'regional-europe-west';

    private $connection;
    private $config;

    public function set_up()
    {
        $this->checkAndSkipGrpcTests();

        $this->connection = $this->getConnStub();
        $this->config = TestHelpers::stub(InstanceConfiguration::class, [
            $this->connection->reveal(),
            self::PROJECT,
            self::CONFIG
        ]);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(InstanceConfiguration::class);
        $res = $snippet->invoke('configuration');

        $this->assertInstanceOf(InstanceConfiguration::class, $res->returnVal());
        $this->assertEquals(
            InstanceAdminClient::instanceConfigName(self::PROJECT, self::CONFIG),
            $res->returnVal()->name()
        );
    }

    public function testName()
    {
        $snippet = $this->snippetFromMethod(InstanceConfiguration::class, 'name');
        $snippet->addLocal('configuration', $this->config);

        $res = $snippet->invoke('name');
        $this->assertEquals(InstanceAdminClient::instanceConfigName(self::PROJECT, self::CONFIG), $res->returnVal());
    }

    public function testInfo()
    {
        $snippet = $this->snippetFromMethod(InstanceConfiguration::class, 'info');
        $snippet->addLocal('configuration', $this->config);

        $info = [
            'name' => InstanceAdminClient::instanceConfigName(self::PROJECT, self::CONFIG),
            'displayName' => self::CONFIG
        ];

        $this->connection->getInstanceConfig(Argument::any())
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

        $this->connection->getInstanceConfig(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'name' => InstanceAdminClient::instanceConfigName(self::PROJECT, self::CONFIG),
                'displayName' => self::CONFIG
            ]);

        $this->config->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('Configuration exists!', $res->output());
    }

    public function testReload()
    {
        $info = [
            'name' => InstanceAdminClient::instanceConfigName(self::PROJECT, self::CONFIG),
            'displayName' => self::CONFIG
        ];

        $snippet = $this->snippetFromMethod(InstanceConfiguration::class, 'reload');
        $snippet->addLocal('configuration', $this->config);

        $this->connection->getInstanceConfig(Argument::any())
            ->shouldBeCalled()
            ->willReturn($info);

        $this->config->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('info');
        $this->assertEquals($info, $res->returnVal());
    }
}
