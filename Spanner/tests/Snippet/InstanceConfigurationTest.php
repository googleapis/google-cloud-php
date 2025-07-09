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

use Google\ApiCore\OperationResponse;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\CreateInstanceConfigRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\DeleteInstanceConfigRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\GetInstanceConfigRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceConfig;
use Google\Cloud\Spanner\Admin\Instance\V1\UpdateInstanceConfigRequest;
use Google\Cloud\Spanner\InstanceConfiguration;
use Google\Cloud\Spanner\Serializer;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group spanner
 * @group spanner-admin
 */
class InstanceConfigurationTest extends SnippetTestCase
{
    use GrpcTestTrait;
    use ProphecyTrait;

    const PROJECT = 'my-awesome-project';
    const CONFIG = 'regional-europe-west';

    private $instanceAdminClient;
    private $operationResponse;
    private $serializer;
    private $config;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->serializer = new Serializer();
        $this->instanceAdminClient = $this->prophesize(InstanceAdminClient::class);
        $this->operationResponse = $this->prophesize(OperationResponse::class);

        $this->config = new InstanceConfiguration(
            $this->instanceAdminClient->reveal(),
            $this->serializer,
            self::PROJECT,
            self::CONFIG,
            [],
        );
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(InstanceConfiguration::class);
        $snippet->addLocal('projectId', self::PROJECT);

        $res = $snippet->invoke('configuration');

        $this->assertInstanceOf(InstanceConfiguration::class, $res->returnVal());
        $this->assertEquals(
            InstanceAdminClient::instanceConfigName(self::PROJECT, self::CONFIG),
            $res->returnVal()->name()
        );
    }

    public function testCreate()
    {
        $snippet = $this->snippetFromMethod(InstanceConfiguration::class, 'create');
        $this->instanceAdminClient->createInstanceConfig(
            Argument::type(CreateInstanceConfigRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->operationResponse->reveal());

        $baseConfig = new InstanceConfiguration(
            $this->instanceAdminClient->reveal(),
            $this->serializer,
            self::PROJECT,
            self::CONFIG,
            []
        );
        $snippet->addLocal('baseConfig', $baseConfig);
        $snippet->addLocal('options', []);
        $snippet->addLocal('instanceConfig', $this->config);

        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(LongRunningOperation::class, $res->returnVal());
    }

    public function testUpdate()
    {
        $snippet = $this->snippetFromMethod(InstanceConfiguration::class, 'update');
        $snippet->addLocal('instanceConfig', $this->config);

        $this->instanceAdminClient->updateInstanceConfig(
            Argument::type(UpdateInstanceConfigRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->operationResponse->reveal());

        $snippet->invoke();
    }

    public function testDelete()
    {
        $snippet = $this->snippetFromMethod(InstanceConfiguration::class, 'delete');
        $snippet->addLocal('instanceConfig', $this->config);

        $this->instanceAdminClient->deleteInstanceConfig(
            Argument::type(DeleteInstanceConfigRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce();

        $snippet->invoke();
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

        $this->instanceAdminClient->getInstanceConfig(
            Argument::type(GetInstanceConfigRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new InstanceConfig([
                'name' => $info['name'],
                'display_name' => $info['displayName']
            ]));

        $res = $snippet->invoke('info');
        $this->assertEquals($info['name'], $res->returnVal()['name']);
        $this->assertEquals($info['displayName'], $res->returnVal()['displayName']);
    }

    public function testExists()
    {
        $snippet = $this->snippetFromMethod(InstanceConfiguration::class, 'exists');
        $snippet->addLocal('configuration', $this->config);

        $this->instanceAdminClient->getInstanceConfig(
            Argument::type(GetInstanceConfigRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new InstanceConfig([
                'name' => InstanceAdminClient::instanceConfigName(self::PROJECT, self::CONFIG),
                'display_name' => self::CONFIG
            ]));

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

        $this->instanceAdminClient->getInstanceConfig(
            Argument::type(GetInstanceConfigRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new InstanceConfig([
                'name' => $info['name'],
                'display_name' => $info['displayName']
            ]));

        $res = $snippet->invoke('info');
        $this->assertEquals($info['name'], $res->returnVal()['name']);
        $this->assertEquals($info['displayName'], $res->returnVal()['displayName']);
    }
}
