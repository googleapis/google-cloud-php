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

use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Spanner\Admin\Instance\V1\Client\InstanceAdminClient;
use Google\Cloud\Spanner\Admin\Instance\V1\CreateInstanceConfigRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\DeleteInstanceConfigRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\GetInstanceConfigRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceConfig;
use Google\Cloud\Spanner\Admin\Instance\V1\UpdateInstanceConfigMetadata;
use Google\Cloud\Spanner\Admin\Instance\V1\UpdateInstanceConfigRequest;
use Google\Cloud\Spanner\InstanceConfiguration;
use Google\Cloud\Spanner\Serializer;
use Google\LongRunning\Client\OperationsClient;
use Google\LongRunning\Operation;
use Google\Protobuf\Any;
use Google\Rpc\Code;
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

    const PROJECT_ID = 'test-project';
    const NAME = 'test-config';

    private $instanceAdminClient;
    private $operationsClient;
    private Serializer $serializer;

    public function setUp(): void
    {
        $this->checkAndSkipGrpcTests();

        $this->operationsClient = $this->prophesize(OperationsClient::class);
        $this->instanceAdminClient = $this->prophesize(InstanceAdminClient::class);
        $this->instanceAdminClient->getOperationsClient()
            ->willReturn($this->operationsClient->reveal());
        $this->serializer = new Serializer();
    }

    public function testName()
    {
        $instanceConfig = new InstanceConfiguration(
            $this->instanceAdminClient->reveal(),
            $this->serializer,
            self::PROJECT_ID,
            self::NAME
        );

        $this->assertEquals(
            InstanceAdminClient::parseName($instanceConfig->name())['instance_config'],
            self::NAME
        );
    }

    public function testInfo()
    {
        $info = ['foo' => 'bar'];
        $this->instanceAdminClient->getInstanceConfig(Argument::cetera())
            ->shouldNotBeCalled();

        $instanceConfig = new InstanceConfiguration(
            $this->instanceAdminClient->reveal(),
            $this->serializer,
            self::PROJECT_ID,
            self::NAME,
            ['instanceConfig' => $info],
        );

        $this->assertEquals($info, $instanceConfig->info());
    }

    public function testInfoWithReload()
    {
        $expected = ['display_name' => 'foo'];
        $this->instanceAdminClient->getInstanceConfig(
            Argument::type(GetInstanceConfigRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new InstanceConfig($expected));

        $instanceConfig = new InstanceConfiguration(
            $this->instanceAdminClient->reveal(),
            $this->serializer,
            self::PROJECT_ID,
            self::NAME
        );
        $info = $instanceConfig->info();

        $this->assertArrayHasKey('displayName', $info);
        $this->assertEquals($expected['display_name'], $info['displayName']);
    }

    public function testExists()
    {
        $this->instanceAdminClient->getInstanceConfig(
            Argument::type(GetInstanceConfigRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new InstanceConfig());

        $instanceConfig = new InstanceConfiguration(
            $this->instanceAdminClient->reveal(),
            $this->serializer,
            self::PROJECT_ID,
            self::NAME
        );
        $this->assertTrue($instanceConfig->exists());
    }

    public function testExistsDoesntExist()
    {
        $this->instanceAdminClient->getInstanceConfig(
            Argument::type(GetInstanceConfigRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->will(function () {
                throw new ApiException('', Code::NOT_FOUND);
            });

        $instanceConfig = new InstanceConfiguration(
            $this->instanceAdminClient->reveal(),
            $this->serializer,
            self::PROJECT_ID,
            self::NAME
        );

        $this->assertFalse($instanceConfig->exists());
    }

    public function testReload()
    {
        $expected1 = ['some' => 'info'];
        $expected2 = ['display_name' => 'bar'];
        $this->instanceAdminClient->getInstanceConfig(
            Argument::type(GetInstanceConfigRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new InstanceConfig($expected2));

        $instanceConfig = new InstanceConfiguration(
            $this->instanceAdminClient->reveal(),
            $this->serializer,
            self::PROJECT_ID,
            self::NAME,
            ['instanceConfig' => $expected1],
        );

        $info1 = $instanceConfig->info();
        $info2 = $instanceConfig->reload();
        $info3 = $instanceConfig->info();

        $this->assertEquals($expected1, $info1);
        $this->assertNotEquals($info1, $info2);
        $this->assertArrayHasKey('displayName', $info2);
        $this->assertEquals($expected2['display_name'], $info2['displayName']);
        $this->assertEquals($info2, $info3);
    }

    public function testUpdate()
    {
        $expectedInstanceConfig = new InstanceConfig([
            'name' => InstanceAdminClient::instanceConfigName(self::PROJECT_ID, 'foo'),
            'display_name' => 'bar2'
        ]);
        $result = new Any();
        $result->pack($expectedInstanceConfig);
        $metadata = new Any();
        $metadata->pack(new UpdateInstanceConfigMetadata());
        $operationProto = new Operation([
            'response' => $result,
            'metadata' => $metadata,
            'done' => true
        ]);

        $operationResponse = new OperationResponse('operation-name', $this->operationsClient->reveal(), [
            'operationReturnType' => InstanceConfig::class,
            'lastProtoResponse' => $operationProto,
        ]);
        $this->instanceAdminClient->resumeOperation($operationResponse->getName())
            ->shouldBeCalledOnce()
            ->willReturn($operationResponse);

        $this->instanceAdminClient->updateInstanceConfig(
            Argument::that(function (UpdateInstanceConfigRequest $request) use ($expectedInstanceConfig) {
                $instanceConfig = $request->getInstanceConfig();
                return $instanceConfig->getDisplayName() === $expectedInstanceConfig->getDisplayName()
                    && $instanceConfig->getName() === $expectedInstanceConfig->getName();
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($operationResponse);

        $instanceConfig = new InstanceConfiguration(
            $this->instanceAdminClient->reveal(),
            $this->serializer,
            self::PROJECT_ID,
            'foo',
        );

        $operation = $instanceConfig->update(['displayName' => 'bar2']);
        $operation->pollUntilComplete();
        $updatedInstanceConfig = $operation->result();

        $info = $updatedInstanceConfig->info();
        $this->assertEquals('bar2', $info['displayName']);
    }

    public function testUpdateWithChanges()
    {
        $config = [
            'name' => InstanceAdminClient::instanceConfigName(self::PROJECT_ID, self::NAME),
            'labels' => ['foo' => 'bar'],
            'displayName' => 'New Name',
        ];

        $this->instanceAdminClient->updateInstanceConfig(
            Argument::that(function (UpdateInstanceConfigRequest $request) use ($config) {
                $instanceConfig = $request->getInstanceConfig()->serializeToJsonString();
                return json_decode($instanceConfig, true) == $config;
            }),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->prophesize(OperationResponse::class)->reveal());

        $instanceConfig = new InstanceConfiguration(
            $this->instanceAdminClient->reveal(),
            $this->serializer,
            self::PROJECT_ID,
            self::NAME
        );

        $instanceConfig->update(['displayName' => 'New Name', 'labels' => ['foo' => 'bar']]);
    }

    public function testDelete()
    {
        $this->instanceAdminClient->deleteInstanceConfig(
            Argument::type(DeleteInstanceConfigRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce();

        $instanceConfig = new InstanceConfiguration(
            $this->instanceAdminClient->reveal(),
            $this->serializer,
            self::PROJECT_ID,
            self::NAME
        );

        $instanceConfig->delete();
    }

    private function getDefaultInstance()
    {
        return json_decode(file_get_contents(Fixtures::INSTANCE_CONFIG_FIXTURE()), true);
    }

    public function testCreate()
    {
        $expectedInstanceConfig = new InstanceConfig([
            'name' => InstanceAdminClient::instanceConfigName(self::PROJECT_ID, 'foo'),
            'display_name' => 'bar2'
        ]);
        $result = new Any();
        $result->pack($expectedInstanceConfig);
        $metadata = new Any();
        $metadata->pack(new UpdateInstanceConfigMetadata());
        $operationProto = new Operation([
            'response' => $result,
            'metadata' => $metadata,
            'done' => true
        ]);

        $operationResponse = new OperationResponse(
            'operation-name',
            $this->operationsClient->reveal(),
            [
                'operationReturnType' => InstanceConfig::class,
                'lastProtoResponse' => $operationProto,
            ]
        );

        $this->instanceAdminClient->resumeOperation($operationResponse->getName())
            ->shouldBeCalledOnce()
            ->willReturn($operationResponse);

        $this->instanceAdminClient->createInstanceConfig(
            Argument::type(CreateInstanceConfigRequest::class),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn($operationResponse);

        $instanceConfig = new InstanceConfiguration(
            $this->instanceAdminClient->reveal(),
            $this->serializer,
            self::PROJECT_ID,
            self::NAME
        );

        $baseConfig = $this->prophesize(InstanceConfiguration::class);
        $baseConfig->name()->willReturn('base-config');
        $baseConfig->info()->willReturn([]);

        $operation = $instanceConfig->create(
            $baseConfig->reveal(),
            [],  // Add some replicas if needed for a valid request
            ['displayName' => self::NAME]
        );
        $operation->pollUntilComplete();
        $createdInstanceConfig = $operation->result();

        $this->assertInstanceOf(InstanceConfiguration::class, $createdInstanceConfig);
        $this->assertEquals($expectedInstanceConfig->getName(), $createdInstanceConfig->name());
        $this->assertEquals($expectedInstanceConfig->getDisplayName(), $createdInstanceConfig->info()['displayName']);
    }
}
