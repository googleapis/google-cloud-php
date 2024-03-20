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

namespace Google\Cloud\CloudControlsPartner\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\CloudControlsPartner\V1\Client\CloudControlsPartnerMonitoringClient;
use Google\Cloud\CloudControlsPartner\V1\GetViolationRequest;
use Google\Cloud\CloudControlsPartner\V1\ListViolationsRequest;
use Google\Cloud\CloudControlsPartner\V1\ListViolationsResponse;
use Google\Cloud\CloudControlsPartner\V1\Violation;
use Google\Rpc\Code;
use stdClass;

/**
 * @group cloudcontrolspartner
 *
 * @group gapic
 */
class CloudControlsPartnerMonitoringClientTest extends GeneratedTest
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

    /** @return CloudControlsPartnerMonitoringClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new CloudControlsPartnerMonitoringClient($options);
    }

    /** @test */
    public function getViolationTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $description = 'description-1724546052';
        $category = 'category50511102';
        $nonCompliantOrgPolicy = 'nonCompliantOrgPolicy-1555127741';
        $folderId = 527488652;
        $expectedResponse = new Violation();
        $expectedResponse->setName($name2);
        $expectedResponse->setDescription($description);
        $expectedResponse->setCategory($category);
        $expectedResponse->setNonCompliantOrgPolicy($nonCompliantOrgPolicy);
        $expectedResponse->setFolderId($folderId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->violationName(
            '[ORGANIZATION]',
            '[LOCATION]',
            '[CUSTOMER]',
            '[WORKLOAD]',
            '[VIOLATION]'
        );
        $request = (new GetViolationRequest())->setName($formattedName);
        $response = $gapicClient->getViolation($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.cloudcontrolspartner.v1.CloudControlsPartnerMonitoring/GetViolation',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getViolationExceptionTest()
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
        $formattedName = $gapicClient->violationName(
            '[ORGANIZATION]',
            '[LOCATION]',
            '[CUSTOMER]',
            '[WORKLOAD]',
            '[VIOLATION]'
        );
        $request = (new GetViolationRequest())->setName($formattedName);
        try {
            $gapicClient->getViolation($request);
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
    public function listViolationsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $violationsElement = new Violation();
        $violations = [$violationsElement];
        $expectedResponse = new ListViolationsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setViolations($violations);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->workloadName('[ORGANIZATION]', '[LOCATION]', '[CUSTOMER]', '[WORKLOAD]');
        $request = (new ListViolationsRequest())->setParent($formattedParent);
        $response = $gapicClient->listViolations($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getViolations()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.cloudcontrolspartner.v1.CloudControlsPartnerMonitoring/ListViolations',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listViolationsExceptionTest()
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
        $formattedParent = $gapicClient->workloadName('[ORGANIZATION]', '[LOCATION]', '[CUSTOMER]', '[WORKLOAD]');
        $request = (new ListViolationsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listViolations($request);
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
    public function getViolationAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $description = 'description-1724546052';
        $category = 'category50511102';
        $nonCompliantOrgPolicy = 'nonCompliantOrgPolicy-1555127741';
        $folderId = 527488652;
        $expectedResponse = new Violation();
        $expectedResponse->setName($name2);
        $expectedResponse->setDescription($description);
        $expectedResponse->setCategory($category);
        $expectedResponse->setNonCompliantOrgPolicy($nonCompliantOrgPolicy);
        $expectedResponse->setFolderId($folderId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->violationName(
            '[ORGANIZATION]',
            '[LOCATION]',
            '[CUSTOMER]',
            '[WORKLOAD]',
            '[VIOLATION]'
        );
        $request = (new GetViolationRequest())->setName($formattedName);
        $response = $gapicClient->getViolationAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.cloudcontrolspartner.v1.CloudControlsPartnerMonitoring/GetViolation',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
