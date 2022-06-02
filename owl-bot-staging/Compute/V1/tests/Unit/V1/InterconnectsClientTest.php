<?php
/*
 * Copyright 2022 Google LLC
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

namespace Google\Cloud\Compute\Tests\Unit\V1;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;

use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Compute\V1\GetGlobalOperationRequest;
use Google\Cloud\Compute\V1\GlobalOperationsClient;
use Google\Cloud\Compute\V1\Interconnect;
use Google\Cloud\Compute\V1\InterconnectList;
use Google\Cloud\Compute\V1\InterconnectsClient;
use Google\Cloud\Compute\V1\InterconnectsGetDiagnosticsResponse;
use Google\Cloud\Compute\V1\Operation;
use Google\Cloud\Compute\V1\Operation\Status;
use Google\Rpc\Code;
use stdClass;

/**
 * @group compute
 *
 * @group gapic
 */
class InterconnectsClientTest extends GeneratedTest
{
    /**
     * @return TransportInterface
     */
    private function createTransport($deserialize = null)
    {
        return new MockTransport($deserialize);
    }

    /**
     * @return CredentialsWrapper
     */
    private function createCredentials()
    {
        return $this->getMockBuilder(CredentialsWrapper::class)->disableOriginalConstructor()->getMock();
    }

    /**
     * @return InterconnectsClient
     */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new InterconnectsClient($options);
    }

    /**
     * @test
     */
    public function deleteTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new GlobalOperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('customOperations/deleteTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/deleteTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $interconnect = 'interconnect-849140594';
        $project = 'project-309310695';
        $response = $client->delete($interconnect, $project);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Interconnects/Delete', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInterconnect();
        $this->assertProtobufEquals($interconnect, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $expectedOperationsRequestObject = new GetGlobalOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.GlobalOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function deleteExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new GlobalOperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('customOperations/deleteExceptionTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $interconnect = 'interconnect-849140594';
        $project = 'project-309310695';
        $response = $client->delete($interconnect, $project);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function getTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $adminEnabled = false;
        $creationTimestamp = 'creationTimestamp567396278';
        $customerName = 'customerName-2143818164';
        $description = 'description-1724546052';
        $googleIpAddress = 'googleIpAddress1516847778';
        $googleReferenceId = 'googleReferenceId534944469';
        $id = 3355;
        $interconnectType = 'interconnectType2125777995';
        $kind = 'kind3292052';
        $linkType = 'linkType-1624275873';
        $location = 'location1901043637';
        $name = 'name3373707';
        $nocContactEmail = 'nocContactEmail1087814656';
        $operationalStatus = 'operationalStatus1274812671';
        $peerIpAddress = 'peerIpAddress-1939747879';
        $provisionedLinkCount = 1199724171;
        $requestedLinkCount = 1118793211;
        $satisfiesPzs = false;
        $selfLink = 'selfLink-1691268851';
        $state = 'state109757585';
        $expectedResponse = new Interconnect();
        $expectedResponse->setAdminEnabled($adminEnabled);
        $expectedResponse->setCreationTimestamp($creationTimestamp);
        $expectedResponse->setCustomerName($customerName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setGoogleIpAddress($googleIpAddress);
        $expectedResponse->setGoogleReferenceId($googleReferenceId);
        $expectedResponse->setId($id);
        $expectedResponse->setInterconnectType($interconnectType);
        $expectedResponse->setKind($kind);
        $expectedResponse->setLinkType($linkType);
        $expectedResponse->setLocation($location);
        $expectedResponse->setName($name);
        $expectedResponse->setNocContactEmail($nocContactEmail);
        $expectedResponse->setOperationalStatus($operationalStatus);
        $expectedResponse->setPeerIpAddress($peerIpAddress);
        $expectedResponse->setProvisionedLinkCount($provisionedLinkCount);
        $expectedResponse->setRequestedLinkCount($requestedLinkCount);
        $expectedResponse->setSatisfiesPzs($satisfiesPzs);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setState($state);
        $transport->addResponse($expectedResponse);
        // Mock request
        $interconnect = 'interconnect-849140594';
        $project = 'project-309310695';
        $response = $client->get($interconnect, $project);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Interconnects/Get', $actualFuncCall);
        $actualValue = $actualRequestObject->getInterconnect();
        $this->assertProtobufEquals($interconnect, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $interconnect = 'interconnect-849140594';
        $project = 'project-309310695';
        try {
            $client->get($interconnect, $project);
            // If the $client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getDiagnosticsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new InterconnectsGetDiagnosticsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $interconnect = 'interconnect-849140594';
        $project = 'project-309310695';
        $response = $client->getDiagnostics($interconnect, $project);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Interconnects/GetDiagnostics', $actualFuncCall);
        $actualValue = $actualRequestObject->getInterconnect();
        $this->assertProtobufEquals($interconnect, $actualValue);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getDiagnosticsExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $interconnect = 'interconnect-849140594';
        $project = 'project-309310695';
        try {
            $client->getDiagnostics($interconnect, $project);
            // If the $client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function insertTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new GlobalOperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('customOperations/insertTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/insertTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $interconnectResource = new Interconnect();
        $project = 'project-309310695';
        $response = $client->insert($interconnectResource, $project);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Interconnects/Insert', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInterconnectResource();
        $this->assertProtobufEquals($interconnectResource, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $expectedOperationsRequestObject = new GetGlobalOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.GlobalOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function insertExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new GlobalOperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('customOperations/insertExceptionTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $interconnectResource = new Interconnect();
        $project = 'project-309310695';
        $response = $client->insert($interconnectResource, $project);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function listTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $id = 'id3355';
        $kind = 'kind3292052';
        $nextPageToken = '';
        $selfLink = 'selfLink-1691268851';
        $itemsElement = new Interconnect();
        $items = [
            $itemsElement,
        ];
        $expectedResponse = new InterconnectList();
        $expectedResponse->setId($id);
        $expectedResponse->setKind($kind);
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setItems($items);
        $transport->addResponse($expectedResponse);
        // Mock request
        $project = 'project-309310695';
        $response = $client->list($project);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getItems()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Interconnects/List', $actualFuncCall);
        $actualValue = $actualRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $project = 'project-309310695';
        try {
            $client->list($project);
            // If the $client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function patchTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new GlobalOperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('customOperations/patchTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $completeOperation = new Operation();
        $completeOperation->setName('customOperations/patchTest');
        $completeOperation->setStatus(Status::DONE);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $interconnect = 'interconnect-849140594';
        $interconnectResource = new Interconnect();
        $project = 'project-309310695';
        $response = $client->patch($interconnect, $interconnectResource, $project);
        $this->assertFalse($response->isDone());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.Interconnects/Patch', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getInterconnect();
        $this->assertProtobufEquals($interconnect, $actualValue);
        $actualValue = $actualApiRequestObject->getInterconnectResource();
        $this->assertProtobufEquals($interconnectResource, $actualValue);
        $actualValue = $actualApiRequestObject->getProject();
        $this->assertProtobufEquals($project, $actualValue);
        $expectedOperationsRequestObject = new GetGlobalOperationRequest();
        $expectedOperationsRequestObject->setOperation($completeOperation->getName());
        $expectedOperationsRequestObject->setProject($project);
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.compute.v1.GlobalOperations/Get', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /**
     * @test
     */
    public function patchExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new GlobalOperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('customOperations/patchExceptionTest');
        $incompleteOperation->setStatus(Status::RUNNING);
        $transport->addResponse($incompleteOperation);
        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $interconnect = 'interconnect-849140594';
        $interconnectResource = new Interconnect();
        $project = 'project-309310695';
        $response = $client->patch($interconnect, $interconnectResource, $project);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        try {
            $response->pollUntilComplete([
                'initialPollDelayMillis' => 1,
            ]);
            // If the pollUntilComplete() method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stubs are exhausted
        $transport->popReceivedCalls();
        $operationsTransport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }
}
