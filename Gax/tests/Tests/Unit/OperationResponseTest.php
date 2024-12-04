<?php
/*
 * Copyright 2016 Google LLC
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are
 * met:
 *
 *     * Redistributions of source code must retain the above copyright
 * notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above
 * copyright notice, this list of conditions and the following disclaimer
 * in the documentation and/or other materials provided with the
 * distribution.
 *     * Neither the name of Google Inc. nor the names of its
 * contributors may be used to endorse or promote products derived from
 * this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */
namespace Google\ApiCore\Tests\Unit;

use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\OperationResponse;
use Google\LongRunning\CancelOperationRequest;
use Google\LongRunning\Client\OperationsClient as LROOperationsClient;
use Google\LongRunning\DeleteOperationRequest;
use Google\LongRunning\GetOperationRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\Any;
use Google\Rpc\Code;
use LogicException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

class OperationResponseTest extends TestCase
{
    use ProphecyTrait;
    use TestTrait;

    /**
     * @dataProvider provideOperationsClients
     */
    public function testBasic($opClient)
    {
        $opName = 'operations/opname';
        $op = new OperationResponse($opName, $opClient);

        $this->assertSame($opName, $op->getName());
        $this->assertSame($opClient, $op->getOperationsClient());
    }

    public function provideOperationsClients()
    {
        return [
            [$this->createOperationsClient()],
            [$this->prophesize(LROOperationsClient::class)->reveal()],
        ];
    }

    /**
     * @dataProvider provideOperationsClients
     */
    public function testWithoutResponse($opClient)
    {
        $opName = 'operations/opname';
        $op = new OperationResponse($opName, $opClient);

        $this->assertNull($op->getLastProtoResponse());
        $this->assertFalse($op->isDone());
        $this->assertNull($op->getResult());
        $this->assertNull($op->getError());
        $this->assertNull($op->getMetadata());
        $this->assertFalse($op->operationSucceeded());
        $this->assertFalse($op->operationFailed());
        $this->assertEquals([
            'operationReturnType' => null,
            'metadataReturnType' => null,
            'initialPollDelayMillis' => 1000.0,
            'pollDelayMultiplier' => 2.0,
            'maxPollDelayMillis' => 60000.0,
            'totalPollTimeoutMillis' => 0.0,
        ], $op->getDescriptorOptions());
    }

    /**
     * @dataProvider provideOperationsClients
     */
    public function testWithResponse($opClient)
    {
        $opName = 'operations/opname';
        $protoResponse = new Operation();
        $op = new OperationResponse($opName, $opClient, [
            'lastProtoResponse' => $protoResponse,
        ]);

        $this->assertSame($protoResponse, $op->getLastProtoResponse());
        $this->assertFalse($op->isDone());
        $this->assertNull($op->getResult());
        $this->assertNull($op->getError());
        $this->assertNull($op->getMetadata());
        $this->assertFalse($op->operationSucceeded());
        $this->assertFalse($op->operationFailed());
        $this->assertEquals([
            'operationReturnType' => null,
            'metadataReturnType' => null,
            'initialPollDelayMillis' => 1000.0,
            'pollDelayMultiplier' => 2.0,
            'maxPollDelayMillis' => 60000.0,
            'totalPollTimeoutMillis' => 0.0,
        ], $op->getDescriptorOptions());

        $response = $this->createAny($this->createStatus(0, 'response'));
        $error = $this->createStatus(2, 'error');
        $metadata = $this->createAny($this->createStatus(0, 'metadata'));

        $protoResponse->setDone(true);
        $protoResponse->setResponse($response);
        $protoResponse->setMetadata($metadata);
        $this->assertTrue($op->isDone());
        $this->assertSame($response, $op->getResult());
        $this->assertSame($metadata, $op->getMetadata());
        $this->assertTrue($op->operationSucceeded());
        $this->assertFalse($op->operationFailed());

        $protoResponse->setError($error);
        $this->assertNull($op->getResult());
        $this->assertSame($error, $op->getError());
        $this->assertFalse($op->operationSucceeded());
        $this->assertTrue($op->operationFailed());
    }

    /**
     * @dataProvider provideOperationsClients
     */
    public function testWithOptions($opClient)
    {
        $opName = 'operations/opname';
        $protoResponse = new Operation();
        $op = new OperationResponse($opName, $opClient, [
            'operationReturnType' => '\Google\Rpc\Status',
            'metadataReturnType' => '\Google\Protobuf\Any',
            'lastProtoResponse' => $protoResponse,
        ]);

        $this->assertSame($protoResponse, $op->getLastProtoResponse());
        $this->assertFalse($op->isDone());
        $this->assertNull($op->getResult());
        $this->assertNull($op->getError());
        $this->assertNull($op->getMetadata());
        $this->assertEquals([
            'operationReturnType' => '\Google\Rpc\Status',
            'metadataReturnType' => '\Google\Protobuf\Any',
            'initialPollDelayMillis' => 1000.0,
            'pollDelayMultiplier' => 2.0,
            'maxPollDelayMillis' => 60000.0,
            'totalPollTimeoutMillis' => 0.0,

        ], $op->getDescriptorOptions());

        $innerResponse = $this->createStatus(0, 'response');
        $innerMetadata = new Any();
        $innerMetadata->setValue('metadata');

        $response = $this->createAny($innerResponse);
        $metadata = $this->createAny($innerMetadata);

        $protoResponse->setDone(true);
        $protoResponse->setResponse($response);
        $protoResponse->setMetadata($metadata);
        $this->assertTrue($op->isDone());
        $this->assertEquals($innerResponse, $op->getResult());
        $this->assertEquals($innerMetadata, $op->getMetadata());
    }

    /**
     * @dataProvider pollingDataProvider
     */
    public function testPolling($op, $pollArgs, $expectedSleeps, $expectedComplete)
    {
        $op->pollUntilComplete($pollArgs);

        $this->assertEquals($op->isDone(), $expectedComplete);
        $this->assertEquals($op->getSleeps(), $expectedSleeps);
    }

    public function pollingDataProvider()
    {
        $pollingArgs = [
            'initialPollDelayMillis' => 10.0,
            'pollDelayMultiplier' => 3.0,
            'maxPollDelayMillis' => 50.0,
            'totalPollTimeoutMillis' => 100.0,
        ];
        return [
            [$this->createOperationResponse([], 3), [], [1000.0, 2000.0, 4000.0], true], // Defaults
            [$this->createOperationResponse([], 3), $pollingArgs, [10, 30, 50], true], // Args to pollUntilComplete
            [$this->createOperationResponse($pollingArgs, 3), [], [10, 30, 50], true], // Args to constructor
            [$this->createOperationResponse([], 4), [
                'totalPollTimeoutMillis' => 80.0,
            ] + $pollingArgs, [10, 30, 50], false], // Polling timeout
        ];
    }

    public function testCustomOperation()
    {
        $operationName = 'test-123';
        $operation = $this->prophesize(CustomOperation::class);
        $operation->isThisOperationDoneOrWhat()
            ->shouldBeCalledTimes(2)
            ->willReturn('Yes, it is!');
        $operation->getError()
            ->shouldBeCalledOnce()
            ->willReturn(null);
        $operationClient = $this->prophesize(CustomOperationClient::class);
        $operationClient->getMyOperationPlease($operationName, 'arg1', 'arg2')
            ->shouldBeCalledOnce()
            ->willReturn($operation->reveal());
        $operationClient->cancelMyOperationPlease($operationName, 'arg1', 'arg2')
            ->shouldBeCalledOnce()
            ->willReturn(true);
        $operationClient->deleteMyOperationPlease($operationName, 'arg1', 'arg2')
            ->shouldBeCalledOnce()
            ->willReturn(true);
        $options = [
            'getOperationMethod' => 'getMyOperationPlease',
            'cancelOperationMethod' => 'cancelMyOperationPlease',
            'deleteOperationMethod' => 'deleteMyOperationPlease',
            'additionalOperationArguments' => ['arg1', 'arg2'],
            'operationStatusMethod' => 'isThisOperationDoneOrWhat',
            'operationStatusDoneValue' => 'Yes, it is!',
        ];
        $operationResponse = new OperationResponse($operationName, $operationClient->reveal(), $options);

        // Test getOperationMethod
        $operationResponse->reload();

        // Test operationStatusMethod and operationStatusDoneValue
        $this->assertTrue($operationResponse->isDone());

        $this->assertTrue($operationResponse->operationSucceeded());

        // test cancelOperationMethod
        $operationResponse->cancel();

        // test deleteOperationMethod
        $operationResponse->delete();
    }

    public function testNewSurfaceCustomOperation()
    {
        // This mock requires a specific namespace, so it must be defined in a separate file
        require_once __DIR__ . '/testdata/src/CustomOperationClient.php';

        $phpunit = $this;
        $operationName = 'test-123';
        $operationClient = $this->prophesize(Client\NewSurfaceCustomOperationClient::class);
        $operationClient->getNewSurfaceOperation(Argument::type(Client\GetOperationRequest::class))
            ->shouldBeCalledOnce()
            ->will(function ($args) use ($phpunit) {
                list($request) = $args;
                $phpunit->assertEquals('test-123', $request->name);
                $phpunit->assertEquals('arg2', $request->arg2);
                $phpunit->assertEquals('arg3', $request->arg3);
                return new \stdClass();
            });
        $operationClient->cancelNewSurfaceOperation(Argument::type(Client\CancelOperationRequest::class))
            ->shouldBeCalledOnce()
            ->will(function ($args) use ($phpunit) {
                list($request) = $args;
                $phpunit->assertEquals('test-123', $request->name);
                $phpunit->assertEquals('arg2', $request->arg2);
                $phpunit->assertEquals('arg3', $request->arg3);
                return true;
            });
        $operationClient->deleteNewSurfaceOperation(Argument::type(Client\DeleteOperationRequest::class))
            ->shouldBeCalledOnce()
            ->will(function ($args) use ($phpunit) {
                list($request) = $args;
                $phpunit->assertEquals('test-123', $request->name);
                $phpunit->assertEquals('arg2', $request->arg2);
                $phpunit->assertEquals('arg3', $request->arg3);
                return true;
            });
        $options = [
            'getOperationMethod' => 'getNewSurfaceOperation',
            'cancelOperationMethod' => 'cancelNewSurfaceOperation',
            'deleteOperationMethod' => 'deleteNewSurfaceOperation',
            'additionalOperationArguments' => [
                'setArgumentTwo' => 'arg2',
                'setArgumentThree' => 'arg3'
            ],
            'getOperationRequest' => Client\GetOperationRequest::class,
            'cancelOperationRequest' => Client\CancelOperationRequest::class,
            'deleteOperationRequest' => Client\DeleteOperationRequest::class,
        ];
        $operationResponse = new OperationResponse($operationName, $operationClient->reveal(), $options);

        // Test getOperationMethod
        $operationResponse->reload();

        // test cancelOperationMethod
        $operationResponse->cancel();

        // test deleteOperationMethod
        $operationResponse->delete();
    }

    public function testRequestClassWithoutBuildThrowsException()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Request class must support the static build method');

        // This mock requires a specific namespace, so it must be defined in a separate file
        require_once __DIR__ . '/testdata/src/CustomOperationClient.php';

        $operationClient = $this->prophesize(Client\NewSurfaceCustomOperationClient::class);
        $options = [
            'getOperationRequest' => \stdClass::class, // a class that does not have a "build" method.
        ];
        $operationResponse = new OperationResponse('test-123', $operationClient->reveal(), $options);

        // Test getOperationMethod
        $operationResponse->reload();
    }

    /**
     * @dataProvider provideOperationsClients
     */
    public function testCustomOperationError($operationClient)
    {
        $operationName = 'test-123';
        $operation = $this->prophesize(CustomOperationWithErrorAnnotations::class);
        $operation->isThisOperationDoneOrWhat()
            ->shouldBeCalledTimes(2)
            ->willReturn('Yes, it is!');
        $operation->getTheErrorCode()
            ->shouldBeCalledTimes(2)
            ->willReturn(500);
        $operation->getTheErrorMessage()
            ->shouldBeCalledOnce()
            ->willReturn('It failed, sorry :(');
        $options = [
            'operationStatusMethod' => 'isThisOperationDoneOrWhat',
            'operationStatusDoneValue' => 'Yes, it is!',
            'operationErrorCodeMethod' => 'getTheErrorCode',
            'operationErrorMessageMethod' => 'getTheErrorMessage',
            'lastProtoResponse' => $operation->reveal(),
        ];
        $operationResponse = new OperationResponse($operationName, $operationClient, $options);

        $this->assertFalse($operationResponse->operationSucceeded());

        $error = $operationResponse->getError();

        $this->assertNotNull($error);
        $this->assertEquals(Code::INTERNAL, $error->getCode());
        $this->assertSame('It failed, sorry :(', $error->getMessage());
    }

    /**
     * @dataProvider provideOperationsClients
     */
    public function testEmptyCustomOperationErrorIsSuccessful($operationClient)
    {
        $operationName = 'test-123';
        $operation = $this->prophesize(CustomOperationWithErrorAnnotations::class);
        $operation->isThisOperationDoneOrWhat()
            ->shouldBeCalledOnce()
            ->willReturn('Yes, it is!');
        $operation->getTheErrorCode()
            ->shouldBeCalledOnce()
            ->willReturn(null);
        $options = [
            'operationStatusMethod' => 'isThisOperationDoneOrWhat',
            'operationStatusDoneValue' => 'Yes, it is!',
            'operationErrorCodeMethod' => 'getTheErrorCode',
            'lastProtoResponse' => $operation->reveal(),
        ];
        $operationResponse = new OperationResponse($operationName, $operationClient, $options);

        $this->assertTrue($operationResponse->operationSucceeded());
    }

    /**
     * @dataProvider provideOperationsClients
     */
    public function testMisconfiguredCustomOperationThrowsException($operationClient)
    {
        $operationName = 'test-123';
        $operation = $this->prophesize(CustomOperationWithErrorAnnotations::class);
        $operation->isThisOperationDoneOrWhat()
            ->shouldBeCalledOnce()
            ->willReturn('Yes, it is!');
        $options = [
            'operationStatusMethod' => 'isThisOperationDoneOrWhat',
            'operationStatusDoneValue' => 'Yes, it is!',
            'operationErrorCodeMethod' => null, // The OperationResponse has no way to determine error status
            'lastProtoResponse' => $operation->reveal(),
        ];
        $operationResponse = new OperationResponse($operationName, $operationClient, $options);

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Unable to determine operation error status for this service');

        $operationResponse->operationSucceeded();
    }

    /**
     * @dataProvider provideOperationsClients
     */
    public function testNoCancelOperation($operationClient)
    {
        $options = [
            'cancelOperationMethod' => null,
        ];
        $operationResponse = new OperationResponse('test-123', $operationClient, $options);

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('The cancel operation is not supported by this API');

        $operationResponse->cancel();
    }

    /**
     * @dataProvider provideOperationsClients
     */
    public function testNoDeleteOperation($operationClient)
    {
        $options = [
            'deleteOperationMethod' => null,
        ];
        $operationResponse = new OperationResponse('test-123', $operationClient, $options);

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('The delete operation is not supported by this API');
        $operationResponse->delete();
    }

    public function testPollingCastToInt()
    {
        $op = $this->createOperationResponse([], 3);
        $op->pollUntilComplete([
            'initialPollDelayMillis' => 3.0,
            'pollDelayMultiplier' => 1.5,
        ]);

        $this->assertEquals($op->isDone(), true);
        $this->assertEquals($op->getSleeps(), [3, 4, 6]);
    }

    public function testReloadWithLROOperationsClient()
    {
        $operationClient = $this->prophesize(LROOperationsClient::class);
        $request = new GetOperationRequest(['name' => 'test-123']);
        $operationClient->getOperation($request)
            ->shouldBeCalledOnce()
            ->willReturn(new Operation());

        $operationResponse = new OperationResponse('test-123', $operationClient->reveal());
        $operationResponse->reload();
    }

    public function testCancelWithLROOperationsClient()
    {
        $operationClient = $this->prophesize(LROOperationsClient::class);
        $request = new CancelOperationRequest(['name' => 'test-123']);
        $operationClient->cancelOperation($request)
            ->shouldBeCalledOnce();

        $operationResponse = new OperationResponse('test-123', $operationClient->reveal());
        $operationResponse->cancel();
    }

    public function testDeleteWithLROOperationsClient()
    {
        $operationClient = $this->prophesize(LROOperationsClient::class);
        $request = new DeleteOperationRequest(['name' => 'test-123']);
        $operationClient->deleteOperation($request)
            ->shouldBeCalledOnce();

        $operationResponse = new OperationResponse('test-123', $operationClient->reveal());
        $operationResponse->delete();
    }

    private function createOperationResponse($options, $reloadCount)
    {
        $opName = 'operations/opname';
        return new FakeOperationResponse($opName, $this->createOperationClient($reloadCount), $options);
    }

    private function createOperationClient($reloadCount)
    {
        $consecutiveCalls = [];
        for ($i = 0; $i < $reloadCount - 1; $i++) {
            $consecutiveCalls[] = $this->returnValue(new Operation());
        }
        $consecutiveCalls[] = $this->returnValue(new Operation(['done' => true]));

        $opClient = $this->getMockBuilder(OperationsClient::class)
            ->setConstructorArgs([[
                'apiEndpoint' => '',
                'scopes' => [],
            ]])
            ->setMethods(['getOperation'])
            ->getMock();

        $opClient->expects($this->exactly($reloadCount))
            ->method('getOperation')
            ->will($this->onConsecutiveCalls(...$consecutiveCalls));

        return $opClient;
    }
}

class FakeOperationResponse extends OperationResponse
{
    private $currentTime = 0;
    private $sleeps;

    public function getSleeps()
    {
        return $this->sleeps;
    }

    public function sleepMillis(int $millis)
    {
        $this->currentTime += $millis;
        $this->sleeps[] = $millis;
    }

    public function setTimes($times)
    {
        $this->times = $times;
    }

    public function getCurrentTimeMillis()
    {
        return $this->currentTime;
    }
}

interface CustomOperationClient
{
    public function getMyOperationPlease($name, $requiredArg1, $requiredArg2);
    public function cancelMyOperationPlease($name, $requiredArg1, $requiredArg2);
    public function deleteMyOperationPlease($name, $requiredArg1, $requiredArg2);
}

interface CustomOperation
{
    public function isThisOperationDoneOrWhat();
    public function getError();
}

interface CustomOperationWithErrorAnnotations
{
    public function isThisOperationDoneOrWhat();
    public function getTheErrorCode();
    public function getTheErrorMessage();
}
