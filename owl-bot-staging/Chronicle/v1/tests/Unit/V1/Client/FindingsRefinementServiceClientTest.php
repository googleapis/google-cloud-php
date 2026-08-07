<?php
/*
 * Copyright 2026 Google LLC
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

namespace Google\Cloud\Chronicle\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Chronicle\V1\Client\FindingsRefinementServiceClient;
use Google\Cloud\Chronicle\V1\ComputeAllFindingsRefinementActivitiesRequest;
use Google\Cloud\Chronicle\V1\ComputeAllFindingsRefinementActivitiesResponse;
use Google\Cloud\Chronicle\V1\ComputeFindingsRefinementActivityRequest;
use Google\Cloud\Chronicle\V1\ComputeFindingsRefinementActivityResponse;
use Google\Cloud\Chronicle\V1\CreateFindingsRefinementRequest;
use Google\Cloud\Chronicle\V1\FindingsRefinement;
use Google\Cloud\Chronicle\V1\FindingsRefinementDeployment;
use Google\Cloud\Chronicle\V1\GetFindingsRefinementDeploymentRequest;
use Google\Cloud\Chronicle\V1\GetFindingsRefinementRequest;
use Google\Cloud\Chronicle\V1\ListAllFindingsRefinementDeploymentsRequest;
use Google\Cloud\Chronicle\V1\ListAllFindingsRefinementDeploymentsResponse;
use Google\Cloud\Chronicle\V1\ListFindingsRefinementsRequest;
use Google\Cloud\Chronicle\V1\ListFindingsRefinementsResponse;
use Google\Cloud\Chronicle\V1\UpdateFindingsRefinementDeploymentRequest;
use Google\Cloud\Chronicle\V1\UpdateFindingsRefinementRequest;
use Google\Protobuf\FieldMask;
use Google\Rpc\Code;
use stdClass;

/**
 * @group chronicle
 *
 * @group gapic
 */
class FindingsRefinementServiceClientTest extends GeneratedTest
{
    /** @return TransportInterface */
    private function createTransport($deserialize = null)
    {
        return new MockTransport($deserialize);
    }

    /** @return CredentialsWrapper */
    private function createCredentials()
    {
        return $this->getMockBuilder(CredentialsWrapper::class)->disableOriginalConstructor()->getMock();
    }

    /** @return FindingsRefinementServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new FindingsRefinementServiceClient($options);
    }

    /** @test */
    public function computeAllFindingsRefinementActivitiesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new ComputeAllFindingsRefinementActivitiesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedInstance = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $request = (new ComputeAllFindingsRefinementActivitiesRequest())
            ->setInstance($formattedInstance);
        $response = $gapicClient->computeAllFindingsRefinementActivities($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.FindingsRefinementService/ComputeAllFindingsRefinementActivities', $actualFuncCall);
        $actualValue = $actualRequestObject->getInstance();
        $this->assertProtobufEquals($formattedInstance, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function computeAllFindingsRefinementActivitiesExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
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
        $formattedInstance = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $request = (new ComputeAllFindingsRefinementActivitiesRequest())
            ->setInstance($formattedInstance);
        try {
            $gapicClient->computeAllFindingsRefinementActivities($request);
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
    public function computeFindingsRefinementActivityTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new ComputeFindingsRefinementActivityResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->findingsRefinementName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[FINDINGS_REFINEMENT]');
        $request = (new ComputeFindingsRefinementActivityRequest())
            ->setName($formattedName);
        $response = $gapicClient->computeFindingsRefinementActivity($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.FindingsRefinementService/ComputeFindingsRefinementActivity', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function computeFindingsRefinementActivityExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
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
        $formattedName = $gapicClient->findingsRefinementName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[FINDINGS_REFINEMENT]');
        $request = (new ComputeFindingsRefinementActivityRequest())
            ->setName($formattedName);
        try {
            $gapicClient->computeFindingsRefinementActivity($request);
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
    public function createFindingsRefinementTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $query = 'query107944136';
        $expectedResponse = new FindingsRefinement();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setQuery($query);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $findingsRefinement = new FindingsRefinement();
        $request = (new CreateFindingsRefinementRequest())
            ->setParent($formattedParent)
            ->setFindingsRefinement($findingsRefinement);
        $response = $gapicClient->createFindingsRefinement($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.FindingsRefinementService/CreateFindingsRefinement', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getFindingsRefinement();
        $this->assertProtobufEquals($findingsRefinement, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createFindingsRefinementExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
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
        $formattedParent = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $findingsRefinement = new FindingsRefinement();
        $request = (new CreateFindingsRefinementRequest())
            ->setParent($formattedParent)
            ->setFindingsRefinement($findingsRefinement);
        try {
            $gapicClient->createFindingsRefinement($request);
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
    public function getFindingsRefinementTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $query = 'query107944136';
        $expectedResponse = new FindingsRefinement();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setQuery($query);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->findingsRefinementName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[FINDINGS_REFINEMENT]');
        $request = (new GetFindingsRefinementRequest())
            ->setName($formattedName);
        $response = $gapicClient->getFindingsRefinement($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.FindingsRefinementService/GetFindingsRefinement', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getFindingsRefinementExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
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
        $formattedName = $gapicClient->findingsRefinementName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[FINDINGS_REFINEMENT]');
        $request = (new GetFindingsRefinementRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getFindingsRefinement($request);
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
    public function getFindingsRefinementDeploymentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $enabled = false;
        $archived = true;
        $expectedResponse = new FindingsRefinementDeployment();
        $expectedResponse->setName($name2);
        $expectedResponse->setEnabled($enabled);
        $expectedResponse->setArchived($archived);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->findingsRefinementDeploymentName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[FINDINGS_REFINEMENT]');
        $request = (new GetFindingsRefinementDeploymentRequest())
            ->setName($formattedName);
        $response = $gapicClient->getFindingsRefinementDeployment($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.FindingsRefinementService/GetFindingsRefinementDeployment', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getFindingsRefinementDeploymentExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
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
        $formattedName = $gapicClient->findingsRefinementDeploymentName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[FINDINGS_REFINEMENT]');
        $request = (new GetFindingsRefinementDeploymentRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getFindingsRefinementDeployment($request);
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
    public function listAllFindingsRefinementDeploymentsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $allFindingsRefinementDeploymentsElement = new FindingsRefinementDeployment();
        $allFindingsRefinementDeployments = [
            $allFindingsRefinementDeploymentsElement,
        ];
        $expectedResponse = new ListAllFindingsRefinementDeploymentsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setAllFindingsRefinementDeployments($allFindingsRefinementDeployments);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedInstance = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $request = (new ListAllFindingsRefinementDeploymentsRequest())
            ->setInstance($formattedInstance);
        $response = $gapicClient->listAllFindingsRefinementDeployments($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAllFindingsRefinementDeployments()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.FindingsRefinementService/ListAllFindingsRefinementDeployments', $actualFuncCall);
        $actualValue = $actualRequestObject->getInstance();
        $this->assertProtobufEquals($formattedInstance, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listAllFindingsRefinementDeploymentsExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
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
        $formattedInstance = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $request = (new ListAllFindingsRefinementDeploymentsRequest())
            ->setInstance($formattedInstance);
        try {
            $gapicClient->listAllFindingsRefinementDeployments($request);
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
    public function listFindingsRefinementsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $findingsRefinementsElement = new FindingsRefinement();
        $findingsRefinements = [
            $findingsRefinementsElement,
        ];
        $expectedResponse = new ListFindingsRefinementsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setFindingsRefinements($findingsRefinements);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $request = (new ListFindingsRefinementsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listFindingsRefinements($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getFindingsRefinements()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.FindingsRefinementService/ListFindingsRefinements', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listFindingsRefinementsExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
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
        $formattedParent = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $request = (new ListFindingsRefinementsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listFindingsRefinements($request);
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
    public function updateFindingsRefinementTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $query = 'query107944136';
        $expectedResponse = new FindingsRefinement();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setQuery($query);
        $transport->addResponse($expectedResponse);
        // Mock request
        $findingsRefinement = new FindingsRefinement();
        $request = (new UpdateFindingsRefinementRequest())
            ->setFindingsRefinement($findingsRefinement);
        $response = $gapicClient->updateFindingsRefinement($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.FindingsRefinementService/UpdateFindingsRefinement', $actualFuncCall);
        $actualValue = $actualRequestObject->getFindingsRefinement();
        $this->assertProtobufEquals($findingsRefinement, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateFindingsRefinementExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
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
        $findingsRefinement = new FindingsRefinement();
        $request = (new UpdateFindingsRefinementRequest())
            ->setFindingsRefinement($findingsRefinement);
        try {
            $gapicClient->updateFindingsRefinement($request);
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
    public function updateFindingsRefinementDeploymentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $enabled = false;
        $archived = true;
        $expectedResponse = new FindingsRefinementDeployment();
        $expectedResponse->setName($name);
        $expectedResponse->setEnabled($enabled);
        $expectedResponse->setArchived($archived);
        $transport->addResponse($expectedResponse);
        // Mock request
        $findingsRefinementDeployment = new FindingsRefinementDeployment();
        $findingsRefinementDeploymentName = 'findingsRefinementDeploymentName-2066435771';
        $findingsRefinementDeployment->setName($findingsRefinementDeploymentName);
        $updateMask = new FieldMask();
        $request = (new UpdateFindingsRefinementDeploymentRequest())
            ->setFindingsRefinementDeployment($findingsRefinementDeployment)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateFindingsRefinementDeployment($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.FindingsRefinementService/UpdateFindingsRefinementDeployment', $actualFuncCall);
        $actualValue = $actualRequestObject->getFindingsRefinementDeployment();
        $this->assertProtobufEquals($findingsRefinementDeployment, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateFindingsRefinementDeploymentExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
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
        $findingsRefinementDeployment = new FindingsRefinementDeployment();
        $findingsRefinementDeploymentName = 'findingsRefinementDeploymentName-2066435771';
        $findingsRefinementDeployment->setName($findingsRefinementDeploymentName);
        $updateMask = new FieldMask();
        $request = (new UpdateFindingsRefinementDeploymentRequest())
            ->setFindingsRefinementDeployment($findingsRefinementDeployment)
            ->setUpdateMask($updateMask);
        try {
            $gapicClient->updateFindingsRefinementDeployment($request);
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
    public function computeAllFindingsRefinementActivitiesAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new ComputeAllFindingsRefinementActivitiesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedInstance = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $request = (new ComputeAllFindingsRefinementActivitiesRequest())
            ->setInstance($formattedInstance);
        $response = $gapicClient->computeAllFindingsRefinementActivitiesAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.FindingsRefinementService/ComputeAllFindingsRefinementActivities', $actualFuncCall);
        $actualValue = $actualRequestObject->getInstance();
        $this->assertProtobufEquals($formattedInstance, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
