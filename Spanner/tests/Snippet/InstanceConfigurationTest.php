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
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
use Google\Cloud\Spanner\InstanceConfiguration;
use Google\Cloud\Spanner\Tests\RequestHandlingTestTrait;
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
    use RequestHandlingTestTrait;

    const PROJECT = 'my-awesome-project';
    const CONFIG = 'regional-europe-west';

    private $requestHandler;
    private $serializer;
    private $config;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->requestHandler = $this->getRequestHandlerStub();
        $this->serializer = $this->getSerializer();
        $this->config = TestHelpers::stub(InstanceConfiguration::class, [
            $this->requestHandler->reveal(),
            $this->serializer,
            self::PROJECT,
            self::CONFIG,
            [],
        ], ['requestHandler', 'serializer']);
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
        $this->mockSendRequest(
            InstanceAdminClient::class,
            'createInstanceConfig',
            null,
            $this->getOperationResponseMock(),
        );

        $baseConfig = new InstanceConfiguration(
            $this->requestHandler->reveal(),
            $this->serializer,
            self::PROJECT,
            self::CONFIG,
            []
        );
        $this->config->___setProperty(
            'requestHandler',
            $this->requestHandler->reveal()
        );
        $this->config->___setProperty(
            'serializer',
            $this->serializer
        );
        $snippet->addLocal('baseConfig', $baseConfig);
        $snippet->addLocal('options', []);
        $snippet->addLocal('instanceConfig', $this->config);

        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(OperationResponse::class, $res->returnVal());
    }

    public function testUpdate()
    {
        $snippet = $this->snippetFromMethod(InstanceConfiguration::class, 'update');
        $snippet->addLocal('instanceConfig', $this->config);

        $this->mockSendRequest(
            InstanceAdminClient::class,
            'updateInstanceConfig',
            null,
            $this->getOperationResponseMock()
        );

        $this->config->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->config->___setProperty('serializer', $this->serializer);

        $snippet->invoke();
    }

    public function testDelete()
    {
        $snippet = $this->snippetFromMethod(InstanceConfiguration::class, 'delete');
        $snippet->addLocal('instanceConfig', $this->config);

        $this->mockSendRequest(InstanceAdminClient::class, 'deleteInstanceConfig', null, null);

        $this->config->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->config->___setProperty('serializer', $this->serializer);
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

        $this->mockSendRequest(InstanceAdminClient::class, 'getInstanceConfig', null, $info);

        $this->config->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->config->___setProperty('serializer', $this->serializer);

        $res = $snippet->invoke('info');
        $this->assertEquals($info, $res->returnVal());
    }

    public function testExists()
    {
        $snippet = $this->snippetFromMethod(InstanceConfiguration::class, 'exists');
        $snippet->addLocal('configuration', $this->config);

        $this->mockSendRequest(
            InstanceAdminClient::class,
            'getInstanceConfig',
            null,
            [
                'name' => InstanceAdminClient::instanceConfigName(self::PROJECT, self::CONFIG),
                'displayName' => self::CONFIG
            ]
        );

        $this->config->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->config->___setProperty('serializer', $this->serializer);

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

        $this->mockSendRequest(InstanceAdminClient::class, 'getInstanceConfig', null, $info);

        $this->config->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->config->___setProperty('serializer', $this->serializer);

        $res = $snippet->invoke('info');
        $this->assertEquals($info, $res->returnVal());
    }
}
