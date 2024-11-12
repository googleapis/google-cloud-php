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

namespace Google\Cloud\Core\Tests\Snippet\LongRunning;

use Google\ApiCore\OperationResponse;
use Google\ApiCore\Serializer;
use Google\Cloud\Core\LongRunning\OperationResponseTrait;
use Google\Cloud\Audit\RequestMetadata;
use Google\Cloud\Audit\AuthorizationInfo;
use Google\Cloud\Core\LongRunning\LongRunningOperationManager;
use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Spanner\Admin\Database\V1\DatabaseAdminClient;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group core
 * @group longrunning
 */
class LongRunningOperationManagerTest extends SnippetTestCase
{
    use OperationResponseTrait;
    use ProphecyTrait;

    const RESULT_TYPE = 'resp-type';
    const METADATA_TYPE = 'meta-type';
    const OPERATION_NAME = 'test-operation';
    const NAME = 'operations/foo';
    const TYPE = 'test-type';

    private $spannerClient;
    private $serializer;
    private $operation;
    private $callables;
    private $lroResponseMappers = [
        [
            'typeUrl' => self::METADATA_TYPE,
            'message' => RequestMetadata::class,
        ], [
            'typeUrl' => self::RESULT_TYPE,
            'message' => AuthorizationInfo::class,
        ],
    ];

    public function setUp(): void
    {
        $this->requestHandler = $this->prophesize(RequestHandler::class);
        $serializer = $this->prophesize(Serializer::class);
        $serializer->encodeMessage(Argument::any())->will(function ($arg) {
            if (is_bool($arg[0]) || is_array($arg[0])) {
                return $arg[0];
            }
            if (method_exists($arg[0], 'serializeToJsonString')) {
                $json = $arg[0]->serializeToJsonString();
                return json_decode($json, true);
            }
        });
        $this->serializer = $serializer->reveal();
        $this->callables = [
            [
                'typeUrl' => self::TYPE,
                'callable' => function ($res) {
                    return $res;
                }
            ]
        ];
        $this->operation = TestHelpers::stub(LongRunningOperationManager::class, [
            $this->requestHandler->reveal(),
            $this->serializer,
            $this->callables,
            $this->lroResponseMappers,
            DatabaseAdminClient::class,
            self::NAME,        );
    }

    public function testName()
    {
        $snippet = $this->snippetFromMethod(LongRunningOperationManager::class, 'name');
        $snippet->addLocal('operation', $this->operation);

        $res = $snippet->invoke('name');
        $this->assertEquals(self::NAME, $res->returnVal());
    }

    public function testDone()
    {
        $this->mockResumeOperation();

        $snippet = $this->snippetFromMethod(LongRunningOperationManager::class, 'done');
        $snippet->addLocal('operation', $this->operation);

        $res = $snippet->invoke();
        $this->assertEquals('The operation is done!', $res->output());
    }

    public function testStateInProgress()
    {
        $this->mockResumeOperation(false);

        $snippet = $this->snippetFromMethod(LongRunningOperationManager::class, 'state');
        $snippet->addLocal('operation', $this->operation);
        $snippet->addUse(LongRunningOperationManager::class);

        $res = $snippet->invoke();
        $this->assertEquals('Operation is in progress', $res->output());
    }

    public function testStateDone()
    {
        $this->mockResumeOperation();

        $snippet = $this->snippetFromMethod(LongRunningOperationManager::class, 'state');
        $snippet->addUse(LongRunningOperationManager::class);
        $snippet->addLocal('operation', $this->operation);

        $res = $snippet->invoke();
        $this->assertEquals('Operation succeeded', $res->output());
    }

    public function testStateFailed()
    {
        $this->mockResumeOperation(true, false);

        $snippet = $this->snippetFromMethod(LongRunningOperationManager::class, 'state');
        $snippet->addLocal('operation', $this->operation);
        $snippet->addUse(LongRunningOperationManager::class);

        $res = $snippet->invoke();
        $this->assertEquals('Operation failed', $res->output());
    }

    public function testResult()
    {
        $result = [
            'resource' => 'any',
            'permission' => 'all',
            'granted' => true,
        ];
        $this->mockResumeOperation();

        $snippet = $this->snippetFromMethod(LongRunningOperationManager::class, 'result');
        $snippet->addLocal('operation', $this->operation);

        $res = $snippet->invoke('result');
        $this->assertEquals($result, $res->returnVal());
    }

    public function testError()
    {
        $result = [
            'foo' => 'bar'
        ];
        $this->mockResumeOperation(true, false, true);

        $snippet = $this->snippetFromMethod(LongRunningOperationManager::class, 'error');
        $snippet->addLocal('operation', $this->operation);

        $res = $snippet->invoke('error');
        $this->assertEquals($result, $res->returnVal());
    }

    public function testInfo()
    {
        $result = [
            'resource' => 'any',
            'permission' => 'all',
            'granted' => true,
        ];
        $this->mockResumeOperation();

        $snippet = $this->snippetFromMethod(LongRunningOperationManager::class, 'info');
        $snippet->addLocal('operation', $this->operation);

        $res = $snippet->invoke('info');
        $this->assertEquals($result, $res->returnVal()['response']);

        $snippet->invoke();
    }

    public function testReload()
    {
        $result = [
            'resource' => 'any',
            'permission' => 'all',
            'granted' => true,
        ];
        $this->mockResumeOperation(true, true, false, 2);

        $snippet = $this->snippetFromMethod(LongRunningOperationManager::class, 'reload');
        $snippet->addLocal('operation', $this->operation);

        $res = $snippet->invoke('result');
        $this->assertEquals($result, $res->returnVal()['response']);

        $snippet->invoke();
    }

    public function testPollUntilComplete()
    {
        $iteration = 0;
        $result = [
            'resource' => 'any',
            'permission' => 'all',
            'granted' => true,
        ];
        $incompleteOp = $this->getOperationResponseMock(false);
        $completeOp = $this->getOperationResponseMock();
        $databaseAdminClient = $this->prophesize(DatabaseAdminClient::class);
        $this->requestHandler->getClientObject(Argument::any())
            ->shouldBeCalled()
            ->willReturn($databaseAdminClient);
        $databaseAdminClient->resumeOperation(Argument::that(function ($arg) use (&$iteration) {
            $iteration++;
            return $iteration == 1;
        }), Argument::any())->willReturn($incompleteOp);
        $databaseAdminClient->resumeOperation(Argument::that(function ($arg) use (&$iteration) {
            return $iteration != 1;
        }), Argument::any())->willReturn($completeOp);

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->operation->___setProperty('serializer', $this->serializer);

        $snippet = $this->snippetFromMethod(LongRunningOperationManager::class, 'pollUntilComplete');
        $snippet->addLocal('operation', $this->operation);

        $res = $snippet->invoke('result');
        $this->assertEquals($result, $res->returnVal());
    }

    public function testCancel()
    {
        $this->checkAndSkipTest([
            DatabaseAdminClient::class,
        ]);
        $operation = $this->prophesize(OperationResponse::class);
        $databaseAdminClient = $this->prophesize(DatabaseAdminClient::class);
        $operation->cancel(Argument::any())->shouldBeCalled();
        $this->requestHandler->getClientObject(Argument::any())
            ->shouldBeCalled()
            ->willReturn($databaseAdminClient);
        $databaseAdminClient->resumeOperation(Argument::cetera())
            ->willReturn($operation->reveal());

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->operation->___setProperty('serializer', $this->serializer);

        $snippet = $this->snippetFromMethod(LongRunningOperationManager::class, 'cancel');
        $snippet->addLocal('operation', $this->operation);

        $res = $snippet->invoke();
    }

    public function testDelete()
    {
        $this->checkAndSkipTest([
            DatabaseAdminClient::class,
        ]);
        $operation = $this->prophesize(OperationResponse::class);
        $databaseAdminClient = $this->prophesize(DatabaseAdminClient::class);
        $operation->delete(Argument::any())->shouldBeCalled();
        $this->requestHandler->getClientObject(Argument::any())
            ->shouldBeCalled()
            ->willReturn($databaseAdminClient);
        $databaseAdminClient->resumeOperation(Argument::cetera())
            ->willReturn($operation->reveal());

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->operation->___setProperty('serializer', $this->serializer);

        $snippet = $this->snippetFromMethod(LongRunningOperationManager::class, 'delete');
        $snippet->addLocal('operation', $this->operation);

        $res = $snippet->invoke();
    }

    private function mockResumeOperation(
        bool $done = true,
        bool $result = true,
        bool $error = false,
        int $times = 1
    ) {
        $operation = $this->getOperationResponseMock($done, $result, $error);
        $databaseAdminClient = $this->prophesize(DatabaseAdminClient::class);
        $this->requestHandler->getClientObject(Argument::any())
            ->shouldBeCalledTimes($times)
            ->willReturn($databaseAdminClient);
        $databaseAdminClient->resumeOperation(Argument::cetera())->willReturn($operation);

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());
        $this->operation->___setProperty('serializer', $this->serializer);
    }

    private function getOperationResponseMock(
        bool $done = true,
        bool $result = true,
        bool $error = false,
        int $times = 1
    ) {
        $this->checkAndSkipTest([
            DatabaseAdminClient::class,
        ]);
        if ($result) {
            $result = new AuthorizationInfo([
                'resource' => 'any',
                'permission' => 'all',
                'granted' => true,
            ]);
        }
        if ($error) {
            $error = ['foo' => 'bar'];
        }
        $meta = new RequestMetadata([
            'caller_ip' => '127.8.9.10', // Sic(!)
        ]);
        $response = new Response(self::METADATA_TYPE, $meta, $done, self::RESULT_TYPE, $result, $error);
        $operation = new OperationResponse(self::OPERATION_NAME, null, ['lastProtoResponse' => $response]);
        return $operation;
    }
}

//@codingStandardsIgnoreStart

class Value
{
    public $value;

    public function __construct($value = null)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }
}

class Response
{
    private $metadataType;
    private $metadata;
    private $responseType;
    private $response = null;
    private $error = null;
    private $done = true;

    public function __construct(
        $metaType,
        $metadata,
        $done = true,
        $respType = null,
        $response = null,
        $error = null
    ) {
        $this->metadataType = $metaType;
        $this->metadata = $metadata->serializeToString();
        $this->responseType = $respType;
        $this->done = $done;
        if ($response) {
            $this->response = $response->serializeToString();
        }
        $this->error = $error;
    }

    public function getResponse()
    {
        return new Value($this->response);
    }

    public function getMetadata()
    {
        return new Value($this->metadata);
    }

    public function getDone()
    {
        return (isset($this->response) or isset($this->error));
    }

    public function getError()
    {
        return $this->error;
    }

    public function serializeToJsonString()
    {
        $result = [
            'done' => $this->done,
            'metadata' => [
                'typeUrl' => $this->metadataType,
                'value' => $this->metadata,
            ],
        ];
        if (isset($this->response)) {
            $result['response'] = [
                'typeUrl' => $this->responseType,
                'value' => $this->response,
            ];
        }

        return json_encode($result);
    }
}
