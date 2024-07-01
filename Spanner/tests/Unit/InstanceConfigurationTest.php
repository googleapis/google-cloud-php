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

use Google\ApiCore\OperationResponse;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
use Google\Cloud\Spanner\InstanceConfiguration;
use Google\Cloud\Spanner\Tests\RequestHandlingTestTrait;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group spanner-admin
 * @group spanner
 */
class InstanceConfigurationTest extends TestCase
{
    use GrpcTestTrait;
    use ProphecyTrait;
    use RequestHandlingTestTrait;

    const PROJECT_ID = 'test-project';
    const NAME = 'test-config';

    private $requestHandler;
    private $serializer;
    private $configuration;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->requestHandler = $this->getRequestHandlerStub();
        $this->serializer = $this->getSerializer();
        $this->configuration = TestHelpers::stub(InstanceConfiguration::class, [
            $this->requestHandler->reveal(),
            $this->serializer,
            self::PROJECT_ID,
            self::NAME,
            []
        ], ['requestHandler', 'serializer']);
    }

    public function testName()
    {
        $this->assertEquals(
            InstanceAdminClient::parseName($this->configuration->name())['instance_config'],
            self::NAME
        );
    }

    public function testInfo()
    {
        $this->mockSendRequest(InstanceAdminClient::class, 'getInstanceConfig', null, null, 0);

        $this->configuration->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->configuration->___setProperty('serializer', $this->serializer);

        $info = ['foo' => 'bar'];
        $config = TestHelpers::stub(InstanceConfiguration::class, [
            $this->requestHandler->reveal(),
            $this->serializer,
            self::PROJECT_ID,
            self::NAME,
            $info
        ], ['requestHandler','serializer']);

        $this->assertEquals($info, $config->info());
    }

    public function testInfoWithReload()
    {
        $info = ['foo' => 'bar'];

        $this->mockSendRequest(
            InstanceAdminClient::class,
            'getInstanceConfig',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals(
                    $message['name'],
                    InstanceAdminClient::instanceConfigName(self::PROJECT_ID, self::NAME)
                );
                return true;
            },
            $info
        );

        $this->configuration->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->configuration->___setProperty('serializer', $this->serializer);

        $this->assertEquals($info, $this->configuration->info());
    }

    public function testExists()
    {
        $this->mockSendRequest(
            InstanceAdminClient::class,
            'getInstanceConfig',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals(
                    $message['name'],
                    InstanceAdminClient::instanceConfigName(self::PROJECT_ID, self::NAME)
                );
                return true;
            },
            []
        );

        $this->configuration->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->configuration->___setProperty('serializer', $this->serializer);

        $this->assertTrue($this->configuration->exists());
    }

    public function testExistsDoesntExist()
    {
        $this->mockSendRequest(
            InstanceAdminClient::class,
            'getInstanceConfig',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals(
                    $message['name'],
                    InstanceAdminClient::instanceConfigName(self::PROJECT_ID, self::NAME)
                );
                return true;
            },
            new NotFoundException('', 404)
        );

        $this->configuration->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->configuration->___setProperty('serializer', $this->serializer);

        $this->assertFalse($this->configuration->exists());
    }

    public function testReload()
    {
        $info = ['foo' => 'bar'];

        $this->mockSendRequest(
            InstanceAdminClient::class,
            'getInstanceConfig',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals(
                    $message['name'],
                    InstanceAdminClient::instanceConfigName(self::PROJECT_ID, self::NAME)
                );
                return true;
            },
            $info
        );

        $this->configuration->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->configuration->___setProperty('serializer', $this->serializer);

        $info = $this->configuration->reload();

        $info2 = $this->configuration->info();

        $this->assertEquals($info, $info2);
    }

    public function testUpdate()
    {
        $config = $this->getDefaultInstance();

        $this->mockSendRequest(
            InstanceAdminClient::class,
            'updateInstanceConfig',
            function ($args) use ($config) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['instanceConfig']['name'], $config['name']);
                $this->assertEquals($message['instanceConfig']['displayName'], 'bar');
                return true;
            },
            $this->getOperationResponseMock()
        );

        $this->configuration->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->configuration->___setProperty('serializer', $this->serializer);

        $this->configuration->update(['displayName' => 'bar']);
    }

    public function testUpdateWithExistingLabels()
    {
        $config = $this->getDefaultInstance();
        $config['labels'] = ['foo' => 'bar'];

        $this->mockSendRequest(
            InstanceAdminClient::class,
            'updateInstanceConfig',
            function ($args) use ($config) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['instanceConfig']['name'], $config['name']);
                $this->assertEquals($message['instanceConfig']['labels'], $config['labels']);
                return true;
            },
            $this->getOperationResponseMock()
        );

        $this->configuration->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->configuration->___setProperty('serializer', $this->serializer);

        $this->configuration->update(['labels' => $config['labels']]);
    }

    public function testUpdateWithChanges()
    {
        $config = $this->getDefaultInstance();

        $changes = [
            'labels' => [
                'foo' => 'bar'
            ],
            'displayName' => 'New Name',
        ];

        $this->mockSendRequest(
            InstanceAdminClient::class,
            'updateInstanceConfig',
            function ($args) use ($changes, $config) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals($message['instanceConfig']['name'], $config['name']);
                $this->assertEquals($message['instanceConfig']['displayName'], $changes['displayName']);
                $this->assertEquals($message['instanceConfig']['labels'], $changes['labels']);
                return true;
            },
            $this->getOperationResponseMock()
        );

        $this->configuration->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->configuration->___setProperty('serializer', $this->serializer);

        $this->configuration->update($changes);
    }

    public function testDelete()
    {
        $this->mockSendRequest(
            InstanceAdminClient::class,
            'deleteInstanceConfig',
            function ($args) {
                $message = $this->serializer->encodeMessage($args);
                $this->assertEquals(
                    $message['name'],
                    InstanceAdminClient::instanceConfigName(self::PROJECT_ID, self::NAME)
                );
                return true;
            },
            null
        );

        $this->configuration->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->configuration->___setProperty('serializer', $this->serializer);

        $this->configuration->delete();
    }

    private function getDefaultInstance()
    {
        return json_decode(file_get_contents(Fixtures::INSTANCE_CONFIG_FIXTURE()), true);
    }
}
