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

namespace Google\Cloud\Sql\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Sql\V1\BlueGreenDeployment;
use Google\Cloud\Sql\V1\Client\BlueGreenDeploymentsServiceClient;
use Google\Cloud\Sql\V1\CreateBlueGreenDeploymentRequest;
use Google\Cloud\Sql\V1\DeleteBlueGreenDeploymentRequest;
use Google\Cloud\Sql\V1\GetBlueGreenDeploymentRequest;
use Google\Cloud\Sql\V1\ListBlueGreenDeploymentsRequest;
use Google\Cloud\Sql\V1\ListBlueGreenDeploymentsResponse;
use Google\Cloud\Sql\V1\Operation;
use Google\Cloud\Sql\V1\SwitchoverBlueGreenDeploymentRequest;
use Google\Rpc\Code;
use stdClass;

/**
 * @group sql
 *
 * @group gapic
 */
class BlueGreenDeploymentsServiceClientTest extends GeneratedTest
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

    /** @return BlueGreenDeploymentsServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new BlueGreenDeploymentsServiceClient($options);
    }

    /** @test */
    public function createBlueGreenDeploymentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $targetLink = 'targetLink-2084812312';
        $user = 'user3599307';
        $name = 'name3373707';
        $targetId = 'targetId-815576439';
        $selfLink = 'selfLink-1691268851';
        $targetProject = 'targetProject392184427';
        $expectedResponse = new Operation();
        $expectedResponse->setKind($kind);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setName($name);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetProject($targetProject);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $blueGreenDeploymentId = 'blueGreenDeploymentId-1195134668';
        $blueGreenDeployment = new BlueGreenDeployment();
        $blueGreenDeploymentSourceInstance = $gapicClient->instanceName('[PROJECT]', '[INSTANCE]');
        $blueGreenDeployment->setSourceInstance($blueGreenDeploymentSourceInstance);
        $request = (new CreateBlueGreenDeploymentRequest())
            ->setParent($formattedParent)
            ->setBlueGreenDeploymentId($blueGreenDeploymentId)
            ->setBlueGreenDeployment($blueGreenDeployment);
        $response = $gapicClient->createBlueGreenDeployment($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.sql.v1.BlueGreenDeploymentsService/CreateBlueGreenDeployment',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getBlueGreenDeploymentId();
        $this->assertProtobufEquals($blueGreenDeploymentId, $actualValue);
        $actualValue = $actualRequestObject->getBlueGreenDeployment();
        $this->assertProtobufEquals($blueGreenDeployment, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createBlueGreenDeploymentExceptionTest()
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $blueGreenDeploymentId = 'blueGreenDeploymentId-1195134668';
        $blueGreenDeployment = new BlueGreenDeployment();
        $blueGreenDeploymentSourceInstance = $gapicClient->instanceName('[PROJECT]', '[INSTANCE]');
        $blueGreenDeployment->setSourceInstance($blueGreenDeploymentSourceInstance);
        $request = (new CreateBlueGreenDeploymentRequest())
            ->setParent($formattedParent)
            ->setBlueGreenDeploymentId($blueGreenDeploymentId)
            ->setBlueGreenDeployment($blueGreenDeployment);
        try {
            $gapicClient->createBlueGreenDeployment($request);
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
    public function deleteBlueGreenDeploymentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $targetLink = 'targetLink-2084812312';
        $user = 'user3599307';
        $name2 = 'name2-1052831874';
        $targetId = 'targetId-815576439';
        $selfLink = 'selfLink-1691268851';
        $targetProject = 'targetProject392184427';
        $expectedResponse = new Operation();
        $expectedResponse->setKind($kind);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setName($name2);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetProject($targetProject);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->blueGreenDeploymentName('[PROJECT]', '[LOCATION]', '[BLUE_GREEN_DEPLOYMENT]');
        $request = (new DeleteBlueGreenDeploymentRequest())->setName($formattedName);
        $response = $gapicClient->deleteBlueGreenDeployment($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.sql.v1.BlueGreenDeploymentsService/DeleteBlueGreenDeployment',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteBlueGreenDeploymentExceptionTest()
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
        $formattedName = $gapicClient->blueGreenDeploymentName('[PROJECT]', '[LOCATION]', '[BLUE_GREEN_DEPLOYMENT]');
        $request = (new DeleteBlueGreenDeploymentRequest())->setName($formattedName);
        try {
            $gapicClient->deleteBlueGreenDeployment($request);
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
    public function getBlueGreenDeploymentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $description = 'description-1724546052';
        $sourceInstance = 'sourceInstance-677426119';
        $switchoverTargetInstance = 'switchoverTargetInstance22742860';
        $errorDetail = 'errorDetail-43095448';
        $expectedResponse = new BlueGreenDeployment();
        $expectedResponse->setName($name2);
        $expectedResponse->setDescription($description);
        $expectedResponse->setSourceInstance($sourceInstance);
        $expectedResponse->setSwitchoverTargetInstance($switchoverTargetInstance);
        $expectedResponse->setErrorDetail($errorDetail);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->blueGreenDeploymentName('[PROJECT]', '[LOCATION]', '[BLUE_GREEN_DEPLOYMENT]');
        $request = (new GetBlueGreenDeploymentRequest())->setName($formattedName);
        $response = $gapicClient->getBlueGreenDeployment($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1.BlueGreenDeploymentsService/GetBlueGreenDeployment', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getBlueGreenDeploymentExceptionTest()
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
        $formattedName = $gapicClient->blueGreenDeploymentName('[PROJECT]', '[LOCATION]', '[BLUE_GREEN_DEPLOYMENT]');
        $request = (new GetBlueGreenDeploymentRequest())->setName($formattedName);
        try {
            $gapicClient->getBlueGreenDeployment($request);
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
    public function listBlueGreenDeploymentsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $blueGreenDeploymentsElement = new BlueGreenDeployment();
        $blueGreenDeployments = [$blueGreenDeploymentsElement];
        $expectedResponse = new ListBlueGreenDeploymentsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setBlueGreenDeployments($blueGreenDeployments);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListBlueGreenDeploymentsRequest())->setParent($formattedParent);
        $response = $gapicClient->listBlueGreenDeployments($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getBlueGreenDeployments()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1.BlueGreenDeploymentsService/ListBlueGreenDeployments', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listBlueGreenDeploymentsExceptionTest()
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListBlueGreenDeploymentsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listBlueGreenDeployments($request);
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
    public function switchoverBlueGreenDeploymentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $targetLink = 'targetLink-2084812312';
        $user = 'user3599307';
        $name2 = 'name2-1052831874';
        $targetId = 'targetId-815576439';
        $selfLink = 'selfLink-1691268851';
        $targetProject = 'targetProject392184427';
        $expectedResponse = new Operation();
        $expectedResponse->setKind($kind);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setName($name2);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetProject($targetProject);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->blueGreenDeploymentName('[PROJECT]', '[LOCATION]', '[BLUE_GREEN_DEPLOYMENT]');
        $request = (new SwitchoverBlueGreenDeploymentRequest())->setName($formattedName);
        $response = $gapicClient->switchoverBlueGreenDeployment($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.sql.v1.BlueGreenDeploymentsService/SwitchoverBlueGreenDeployment',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function switchoverBlueGreenDeploymentExceptionTest()
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
        $formattedName = $gapicClient->blueGreenDeploymentName('[PROJECT]', '[LOCATION]', '[BLUE_GREEN_DEPLOYMENT]');
        $request = (new SwitchoverBlueGreenDeploymentRequest())->setName($formattedName);
        try {
            $gapicClient->switchoverBlueGreenDeployment($request);
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
    public function createBlueGreenDeploymentAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $targetLink = 'targetLink-2084812312';
        $user = 'user3599307';
        $name = 'name3373707';
        $targetId = 'targetId-815576439';
        $selfLink = 'selfLink-1691268851';
        $targetProject = 'targetProject392184427';
        $expectedResponse = new Operation();
        $expectedResponse->setKind($kind);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setName($name);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetProject($targetProject);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $blueGreenDeploymentId = 'blueGreenDeploymentId-1195134668';
        $blueGreenDeployment = new BlueGreenDeployment();
        $blueGreenDeploymentSourceInstance = $gapicClient->instanceName('[PROJECT]', '[INSTANCE]');
        $blueGreenDeployment->setSourceInstance($blueGreenDeploymentSourceInstance);
        $request = (new CreateBlueGreenDeploymentRequest())
            ->setParent($formattedParent)
            ->setBlueGreenDeploymentId($blueGreenDeploymentId)
            ->setBlueGreenDeployment($blueGreenDeployment);
        $response = $gapicClient->createBlueGreenDeploymentAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.sql.v1.BlueGreenDeploymentsService/CreateBlueGreenDeployment',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getBlueGreenDeploymentId();
        $this->assertProtobufEquals($blueGreenDeploymentId, $actualValue);
        $actualValue = $actualRequestObject->getBlueGreenDeployment();
        $this->assertProtobufEquals($blueGreenDeployment, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
