<?php
/*
 * Copyright 2025 Google LLC
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

namespace Google\Cloud\PolicySimulator\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\PolicySimulator\V1\Client\OrgPolicyViolationsPreviewServiceClient;
use Google\Cloud\PolicySimulator\V1\CreateOrgPolicyViolationsPreviewRequest;
use Google\Cloud\PolicySimulator\V1\GetOrgPolicyViolationsPreviewRequest;
use Google\Cloud\PolicySimulator\V1\ListOrgPolicyViolationsPreviewsRequest;
use Google\Cloud\PolicySimulator\V1\ListOrgPolicyViolationsPreviewsResponse;
use Google\Cloud\PolicySimulator\V1\ListOrgPolicyViolationsRequest;
use Google\Cloud\PolicySimulator\V1\ListOrgPolicyViolationsResponse;
use Google\Cloud\PolicySimulator\V1\OrgPolicyOverlay;
use Google\Cloud\PolicySimulator\V1\OrgPolicyViolation;
use Google\Cloud\PolicySimulator\V1\OrgPolicyViolationsPreview;
use Google\LongRunning\Client\OperationsClient;
use Google\LongRunning\GetOperationRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\Any;
use Google\Rpc\Code;
use stdClass;

/**
 * @group policysimulator
 *
 * @group gapic
 */
class OrgPolicyViolationsPreviewServiceClientTest extends GeneratedTest
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

    /** @return OrgPolicyViolationsPreviewServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new OrgPolicyViolationsPreviewServiceClient($options);
    }

    /** @test */
    public function createOrgPolicyViolationsPreviewTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/createOrgPolicyViolationsPreviewTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $violationsCount = 1314508158;
        $expectedResponse = new OrgPolicyViolationsPreview();
        $expectedResponse->setName($name);
        $expectedResponse->setViolationsCount($violationsCount);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/createOrgPolicyViolationsPreviewTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $gapicClient->organizationLocationName('[ORGANIZATION]', '[LOCATION]');
        $orgPolicyViolationsPreview = new OrgPolicyViolationsPreview();
        $orgPolicyViolationsPreviewOverlay = new OrgPolicyOverlay();
        $orgPolicyViolationsPreview->setOverlay($orgPolicyViolationsPreviewOverlay);
        $request = (new CreateOrgPolicyViolationsPreviewRequest())
            ->setParent($formattedParent)
            ->setOrgPolicyViolationsPreview($orgPolicyViolationsPreview);
        $response = $gapicClient->createOrgPolicyViolationsPreview($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.policysimulator.v1.OrgPolicyViolationsPreviewService/CreateOrgPolicyViolationsPreview',
            $actualApiFuncCall
        );
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getOrgPolicyViolationsPreview();
        $this->assertProtobufEquals($orgPolicyViolationsPreview, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createOrgPolicyViolationsPreviewTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }

    /** @test */
    public function createOrgPolicyViolationsPreviewExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/createOrgPolicyViolationsPreviewTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
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
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedParent = $gapicClient->organizationLocationName('[ORGANIZATION]', '[LOCATION]');
        $orgPolicyViolationsPreview = new OrgPolicyViolationsPreview();
        $orgPolicyViolationsPreviewOverlay = new OrgPolicyOverlay();
        $orgPolicyViolationsPreview->setOverlay($orgPolicyViolationsPreviewOverlay);
        $request = (new CreateOrgPolicyViolationsPreviewRequest())
            ->setParent($formattedParent)
            ->setOrgPolicyViolationsPreview($orgPolicyViolationsPreview);
        $response = $gapicClient->createOrgPolicyViolationsPreview($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createOrgPolicyViolationsPreviewTest');
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

    /** @test */
    public function getOrgPolicyViolationsPreviewTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $violationsCount = 1314508158;
        $expectedResponse = new OrgPolicyViolationsPreview();
        $expectedResponse->setName($name2);
        $expectedResponse->setViolationsCount($violationsCount);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->orgPolicyViolationsPreviewName(
            '[ORGANIZATION]',
            '[LOCATION]',
            '[ORG_POLICY_VIOLATIONS_PREVIEW]'
        );
        $request = (new GetOrgPolicyViolationsPreviewRequest())->setName($formattedName);
        $response = $gapicClient->getOrgPolicyViolationsPreview($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.policysimulator.v1.OrgPolicyViolationsPreviewService/GetOrgPolicyViolationsPreview',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getOrgPolicyViolationsPreviewExceptionTest()
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
        $formattedName = $gapicClient->orgPolicyViolationsPreviewName(
            '[ORGANIZATION]',
            '[LOCATION]',
            '[ORG_POLICY_VIOLATIONS_PREVIEW]'
        );
        $request = (new GetOrgPolicyViolationsPreviewRequest())->setName($formattedName);
        try {
            $gapicClient->getOrgPolicyViolationsPreview($request);
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
    public function listOrgPolicyViolationsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $orgPolicyViolationsElement = new OrgPolicyViolation();
        $orgPolicyViolations = [$orgPolicyViolationsElement];
        $expectedResponse = new ListOrgPolicyViolationsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setOrgPolicyViolations($orgPolicyViolations);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->orgPolicyViolationsPreviewName(
            '[ORGANIZATION]',
            '[LOCATION]',
            '[ORG_POLICY_VIOLATIONS_PREVIEW]'
        );
        $request = (new ListOrgPolicyViolationsRequest())->setParent($formattedParent);
        $response = $gapicClient->listOrgPolicyViolations($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getOrgPolicyViolations()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.policysimulator.v1.OrgPolicyViolationsPreviewService/ListOrgPolicyViolations',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listOrgPolicyViolationsExceptionTest()
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
        $formattedParent = $gapicClient->orgPolicyViolationsPreviewName(
            '[ORGANIZATION]',
            '[LOCATION]',
            '[ORG_POLICY_VIOLATIONS_PREVIEW]'
        );
        $request = (new ListOrgPolicyViolationsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listOrgPolicyViolations($request);
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
    public function listOrgPolicyViolationsPreviewsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $orgPolicyViolationsPreviewsElement = new OrgPolicyViolationsPreview();
        $orgPolicyViolationsPreviews = [$orgPolicyViolationsPreviewsElement];
        $expectedResponse = new ListOrgPolicyViolationsPreviewsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setOrgPolicyViolationsPreviews($orgPolicyViolationsPreviews);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->organizationLocationName('[ORGANIZATION]', '[LOCATION]');
        $request = (new ListOrgPolicyViolationsPreviewsRequest())->setParent($formattedParent);
        $response = $gapicClient->listOrgPolicyViolationsPreviews($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getOrgPolicyViolationsPreviews()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.policysimulator.v1.OrgPolicyViolationsPreviewService/ListOrgPolicyViolationsPreviews',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listOrgPolicyViolationsPreviewsExceptionTest()
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
        $formattedParent = $gapicClient->organizationLocationName('[ORGANIZATION]', '[LOCATION]');
        $request = (new ListOrgPolicyViolationsPreviewsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listOrgPolicyViolationsPreviews($request);
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
    public function createOrgPolicyViolationsPreviewAsyncTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'apiEndpoint' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
            'operationsClient' => $operationsClient,
        ]);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
        // Mock response
        $incompleteOperation = new Operation();
        $incompleteOperation->setName('operations/createOrgPolicyViolationsPreviewTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $violationsCount = 1314508158;
        $expectedResponse = new OrgPolicyViolationsPreview();
        $expectedResponse->setName($name);
        $expectedResponse->setViolationsCount($violationsCount);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/createOrgPolicyViolationsPreviewTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $gapicClient->organizationLocationName('[ORGANIZATION]', '[LOCATION]');
        $orgPolicyViolationsPreview = new OrgPolicyViolationsPreview();
        $orgPolicyViolationsPreviewOverlay = new OrgPolicyOverlay();
        $orgPolicyViolationsPreview->setOverlay($orgPolicyViolationsPreviewOverlay);
        $request = (new CreateOrgPolicyViolationsPreviewRequest())
            ->setParent($formattedParent)
            ->setOrgPolicyViolationsPreview($orgPolicyViolationsPreview);
        $response = $gapicClient->createOrgPolicyViolationsPreviewAsync($request)->wait();
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.policysimulator.v1.OrgPolicyViolationsPreviewService/CreateOrgPolicyViolationsPreview',
            $actualApiFuncCall
        );
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getOrgPolicyViolationsPreview();
        $this->assertProtobufEquals($orgPolicyViolationsPreview, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createOrgPolicyViolationsPreviewTest');
        $response->pollUntilComplete([
            'initialPollDelayMillis' => 1,
        ]);
        $this->assertTrue($response->isDone());
        $this->assertEquals($expectedResponse, $response->getResult());
        $apiRequestsEmpty = $transport->popReceivedCalls();
        $this->assertSame(0, count($apiRequestsEmpty));
        $operationsRequests = $operationsTransport->popReceivedCalls();
        $this->assertSame(1, count($operationsRequests));
        $actualOperationsFuncCall = $operationsRequests[0]->getFuncCall();
        $actualOperationsRequestObject = $operationsRequests[0]->getRequestObject();
        $this->assertSame('/google.longrunning.Operations/GetOperation', $actualOperationsFuncCall);
        $this->assertEquals($expectedOperationsRequestObject, $actualOperationsRequestObject);
        $this->assertTrue($transport->isExhausted());
        $this->assertTrue($operationsTransport->isExhausted());
    }
}
