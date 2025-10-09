<?php
/*
 * Copyright 2024 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was automatically generated - do not edit!
 */

namespace Google\Maps\FleetEngine\Delivery\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Maps\FleetEngine\Delivery\V1\BatchCreateTasksRequest;
use Google\Maps\FleetEngine\Delivery\V1\BatchCreateTasksResponse;
use Google\Maps\FleetEngine\Delivery\V1\Client\DeliveryServiceClient;
use Google\Maps\FleetEngine\Delivery\V1\CreateDeliveryVehicleRequest;
use Google\Maps\FleetEngine\Delivery\V1\CreateTaskRequest;
use Google\Maps\FleetEngine\Delivery\V1\DeleteDeliveryVehicleRequest;
use Google\Maps\FleetEngine\Delivery\V1\DeleteTaskRequest;
use Google\Maps\FleetEngine\Delivery\V1\DeliveryVehicle;
use Google\Maps\FleetEngine\Delivery\V1\GetDeliveryVehicleRequest;
use Google\Maps\FleetEngine\Delivery\V1\GetTaskRequest;
use Google\Maps\FleetEngine\Delivery\V1\GetTaskTrackingInfoRequest;
use Google\Maps\FleetEngine\Delivery\V1\ListDeliveryVehiclesRequest;
use Google\Maps\FleetEngine\Delivery\V1\ListDeliveryVehiclesResponse;
use Google\Maps\FleetEngine\Delivery\V1\ListTasksRequest;
use Google\Maps\FleetEngine\Delivery\V1\ListTasksResponse;
use Google\Maps\FleetEngine\Delivery\V1\Task;
use Google\Maps\FleetEngine\Delivery\V1\TaskTrackingInfo;
use Google\Maps\FleetEngine\Delivery\V1\Task\State;
use Google\Maps\FleetEngine\Delivery\V1\Task\Type;
use Google\Maps\FleetEngine\Delivery\V1\UpdateDeliveryVehicleRequest;
use Google\Maps\FleetEngine\Delivery\V1\UpdateTaskRequest;
use Google\Protobuf\Duration;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group delivery
 *
 * @group gapic
 */
class DeliveryServiceClientTest extends GeneratedTest
{
    /** @return TransportInterface */
    private function createTransport($deserialize = null)
    {
        return new MockTransport($deserialize);
    }

    /** @return CredentialsWrapper */
    private function createCredentials()
    {
        return $this->getMockBuilder(CredentialsWrapper::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /** @return DeliveryServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new DeliveryServiceClient($options);
    }

    /** @test */
    public function batchCreateTasksTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchCreateTasksResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->providerName('[PROVIDER]');
        $requests = [];
        $request = (new BatchCreateTasksRequest())->setParent($formattedParent)->setRequests($requests);
        $response = $gapicClient->batchCreateTasks($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/maps.fleetengine.delivery.v1.DeliveryService/BatchCreateTasks', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchCreateTasksExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->providerName('[PROVIDER]');
        $requests = [];
        $request = (new BatchCreateTasksRequest())->setParent($formattedParent)->setRequests($requests);
        try {
            $gapicClient->batchCreateTasks($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createDeliveryVehicleTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $currentRouteSegment = '-9';
        $expectedResponse = new DeliveryVehicle();
        $expectedResponse->setName($name);
        $expectedResponse->setCurrentRouteSegment($currentRouteSegment);
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $deliveryVehicleId = 'deliveryVehicleId-1069581255';
        $deliveryVehicle = new DeliveryVehicle();
        $request = (new CreateDeliveryVehicleRequest())
            ->setParent($parent)
            ->setDeliveryVehicleId($deliveryVehicleId)
            ->setDeliveryVehicle($deliveryVehicle);
        $response = $gapicClient->createDeliveryVehicle($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/maps.fleetengine.delivery.v1.DeliveryService/CreateDeliveryVehicle', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $actualValue = $actualRequestObject->getDeliveryVehicleId();
        $this->assertProtobufEquals($deliveryVehicleId, $actualValue);
        $actualValue = $actualRequestObject->getDeliveryVehicle();
        $this->assertProtobufEquals($deliveryVehicle, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createDeliveryVehicleExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $parent = 'parent-995424086';
        $deliveryVehicleId = 'deliveryVehicleId-1069581255';
        $deliveryVehicle = new DeliveryVehicle();
        $request = (new CreateDeliveryVehicleRequest())
            ->setParent($parent)
            ->setDeliveryVehicleId($deliveryVehicleId)
            ->setDeliveryVehicle($deliveryVehicle);
        try {
            $gapicClient->createDeliveryVehicle($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createTaskTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $trackingId = 'trackingId1878901667';
        $deliveryVehicleId = 'deliveryVehicleId-1069581255';
        $expectedResponse = new Task();
        $expectedResponse->setName($name);
        $expectedResponse->setTrackingId($trackingId);
        $expectedResponse->setDeliveryVehicleId($deliveryVehicleId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $taskId = 'taskId-1537240555';
        $task = new Task();
        $taskType = Type::TYPE_UNSPECIFIED;
        $task->setType($taskType);
        $taskState = State::STATE_UNSPECIFIED;
        $task->setState($taskState);
        $taskTaskDuration = new Duration();
        $task->setTaskDuration($taskTaskDuration);
        $request = (new CreateTaskRequest())
            ->setParent($parent)
            ->setTaskId($taskId)
            ->setTask($task);
        $response = $gapicClient->createTask($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/maps.fleetengine.delivery.v1.DeliveryService/CreateTask', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $actualValue = $actualRequestObject->getTaskId();
        $this->assertProtobufEquals($taskId, $actualValue);
        $actualValue = $actualRequestObject->getTask();
        $this->assertProtobufEquals($task, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createTaskExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $parent = 'parent-995424086';
        $taskId = 'taskId-1537240555';
        $task = new Task();
        $taskType = Type::TYPE_UNSPECIFIED;
        $task->setType($taskType);
        $taskState = State::STATE_UNSPECIFIED;
        $task->setState($taskState);
        $taskTaskDuration = new Duration();
        $task->setTaskDuration($taskTaskDuration);
        $request = (new CreateTaskRequest())
            ->setParent($parent)
            ->setTaskId($taskId)
            ->setTask($task);
        try {
            $gapicClient->createTask($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteDeliveryVehicleTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->deliveryVehicleName('[PROVIDER]', '[VEHICLE]');
        $request = (new DeleteDeliveryVehicleRequest())->setName($formattedName);
        $gapicClient->deleteDeliveryVehicle($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/maps.fleetengine.delivery.v1.DeliveryService/DeleteDeliveryVehicle', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteDeliveryVehicleExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedName = $gapicClient->deliveryVehicleName('[PROVIDER]', '[VEHICLE]');
        $request = (new DeleteDeliveryVehicleRequest())->setName($formattedName);
        try {
            $gapicClient->deleteDeliveryVehicle($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteTaskTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->taskName('[PROVIDER]', '[TASK]');
        $request = (new DeleteTaskRequest())->setName($formattedName);
        $gapicClient->deleteTask($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/maps.fleetengine.delivery.v1.DeliveryService/DeleteTask', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteTaskExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedName = $gapicClient->taskName('[PROVIDER]', '[TASK]');
        $request = (new DeleteTaskRequest())->setName($formattedName);
        try {
            $gapicClient->deleteTask($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getDeliveryVehicleTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $currentRouteSegment = '-9';
        $expectedResponse = new DeliveryVehicle();
        $expectedResponse->setName($name2);
        $expectedResponse->setCurrentRouteSegment($currentRouteSegment);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->deliveryVehicleName('[PROVIDER]', '[VEHICLE]');
        $request = (new GetDeliveryVehicleRequest())->setName($formattedName);
        $response = $gapicClient->getDeliveryVehicle($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/maps.fleetengine.delivery.v1.DeliveryService/GetDeliveryVehicle', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getDeliveryVehicleExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedName = $gapicClient->deliveryVehicleName('[PROVIDER]', '[VEHICLE]');
        $request = (new GetDeliveryVehicleRequest())->setName($formattedName);
        try {
            $gapicClient->getDeliveryVehicle($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getTaskTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $trackingId = 'trackingId1878901667';
        $deliveryVehicleId = 'deliveryVehicleId-1069581255';
        $expectedResponse = new Task();
        $expectedResponse->setName($name2);
        $expectedResponse->setTrackingId($trackingId);
        $expectedResponse->setDeliveryVehicleId($deliveryVehicleId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->taskName('[PROVIDER]', '[TASK]');
        $request = (new GetTaskRequest())->setName($formattedName);
        $response = $gapicClient->getTask($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/maps.fleetengine.delivery.v1.DeliveryService/GetTask', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getTaskExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedName = $gapicClient->taskName('[PROVIDER]', '[TASK]');
        $request = (new GetTaskRequest())->setName($formattedName);
        try {
            $gapicClient->getTask($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getTaskTrackingInfoTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $trackingId = 'trackingId1878901667';
        $expectedResponse = new TaskTrackingInfo();
        $expectedResponse->setName($name2);
        $expectedResponse->setTrackingId($trackingId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->taskTrackingInfoName('[PROVIDER]', '[TRACKING]');
        $request = (new GetTaskTrackingInfoRequest())->setName($formattedName);
        $response = $gapicClient->getTaskTrackingInfo($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/maps.fleetengine.delivery.v1.DeliveryService/GetTaskTrackingInfo', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getTaskTrackingInfoExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedName = $gapicClient->taskTrackingInfoName('[PROVIDER]', '[TRACKING]');
        $request = (new GetTaskTrackingInfoRequest())->setName($formattedName);
        try {
            $gapicClient->getTaskTrackingInfo($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listDeliveryVehiclesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $totalSize = 705419236;
        $deliveryVehiclesElement = new DeliveryVehicle();
        $deliveryVehicles = [$deliveryVehiclesElement];
        $expectedResponse = new ListDeliveryVehiclesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setDeliveryVehicles($deliveryVehicles);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->providerName('[PROVIDER]');
        $request = (new ListDeliveryVehiclesRequest())->setParent($formattedParent);
        $response = $gapicClient->listDeliveryVehicles($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getDeliveryVehicles()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/maps.fleetengine.delivery.v1.DeliveryService/ListDeliveryVehicles', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listDeliveryVehiclesExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->providerName('[PROVIDER]');
        $request = (new ListDeliveryVehiclesRequest())->setParent($formattedParent);
        try {
            $gapicClient->listDeliveryVehicles($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listTasksTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $totalSize = 705419236;
        $tasksElement = new Task();
        $tasks = [$tasksElement];
        $expectedResponse = new ListTasksResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setTasks($tasks);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->providerName('[PROVIDER]');
        $request = (new ListTasksRequest())->setParent($formattedParent);
        $response = $gapicClient->listTasks($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getTasks()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/maps.fleetengine.delivery.v1.DeliveryService/ListTasks', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listTasksExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->providerName('[PROVIDER]');
        $request = (new ListTasksRequest())->setParent($formattedParent);
        try {
            $gapicClient->listTasks($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateDeliveryVehicleTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $currentRouteSegment = '-9';
        $expectedResponse = new DeliveryVehicle();
        $expectedResponse->setName($name);
        $expectedResponse->setCurrentRouteSegment($currentRouteSegment);
        $transport->addResponse($expectedResponse);
        // Mock request
        $deliveryVehicle = new DeliveryVehicle();
        $updateMask = new FieldMask();
        $request = (new UpdateDeliveryVehicleRequest())
            ->setDeliveryVehicle($deliveryVehicle)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateDeliveryVehicle($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/maps.fleetengine.delivery.v1.DeliveryService/UpdateDeliveryVehicle', $actualFuncCall);
        $actualValue = $actualRequestObject->getDeliveryVehicle();
        $this->assertProtobufEquals($deliveryVehicle, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateDeliveryVehicleExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $deliveryVehicle = new DeliveryVehicle();
        $updateMask = new FieldMask();
        $request = (new UpdateDeliveryVehicleRequest())
            ->setDeliveryVehicle($deliveryVehicle)
            ->setUpdateMask($updateMask);
        try {
            $gapicClient->updateDeliveryVehicle($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateTaskTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $trackingId = 'trackingId1878901667';
        $deliveryVehicleId = 'deliveryVehicleId-1069581255';
        $expectedResponse = new Task();
        $expectedResponse->setName($name);
        $expectedResponse->setTrackingId($trackingId);
        $expectedResponse->setDeliveryVehicleId($deliveryVehicleId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $task = new Task();
        $taskType = Type::TYPE_UNSPECIFIED;
        $task->setType($taskType);
        $taskState = State::STATE_UNSPECIFIED;
        $task->setState($taskState);
        $taskTaskDuration = new Duration();
        $task->setTaskDuration($taskTaskDuration);
        $updateMask = new FieldMask();
        $request = (new UpdateTaskRequest())->setTask($task)->setUpdateMask($updateMask);
        $response = $gapicClient->updateTask($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/maps.fleetengine.delivery.v1.DeliveryService/UpdateTask', $actualFuncCall);
        $actualValue = $actualRequestObject->getTask();
        $this->assertProtobufEquals($task, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateTaskExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode(
            [
                'message' => 'internal error',
                'code' => Code::DATA_LOSS,
                'status' => 'DATA_LOSS',
                'details' => [],
            ],
            JSON_PRETTY_PRINT
        );
        $transport->addResponse(null, $status);
        // Mock request
        $task = new Task();
        $taskType = Type::TYPE_UNSPECIFIED;
        $task->setType($taskType);
        $taskState = State::STATE_UNSPECIFIED;
        $task->setState($taskState);
        $taskTaskDuration = new Duration();
        $task->setTaskDuration($taskTaskDuration);
        $updateMask = new FieldMask();
        $request = (new UpdateTaskRequest())->setTask($task)->setUpdateMask($updateMask);
        try {
            $gapicClient->updateTask($request);
            // If the $gapicClient method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchCreateTasksAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchCreateTasksResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->providerName('[PROVIDER]');
        $requests = [];
        $request = (new BatchCreateTasksRequest())->setParent($formattedParent)->setRequests($requests);
        $response = $gapicClient->batchCreateTasksAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/maps.fleetengine.delivery.v1.DeliveryService/BatchCreateTasks', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
