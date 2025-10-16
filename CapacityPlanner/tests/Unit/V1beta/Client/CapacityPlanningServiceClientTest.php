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

namespace Google\Cloud\CapacityPlanner\Tests\Unit\V1beta\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\CapacityPlanner\V1beta\CapacityPlan;
use Google\Cloud\CapacityPlanner\V1beta\CapacityPlanFilters;
use Google\Cloud\CapacityPlanner\V1beta\Client\CapacityPlanningServiceClient;
use Google\Cloud\CapacityPlanner\V1beta\GetCapacityPlanRequest;
use Google\Cloud\CapacityPlanner\V1beta\QueryCapacityPlanInsightsRequest;
use Google\Cloud\CapacityPlanner\V1beta\QueryCapacityPlanInsightsResponse;
use Google\Cloud\CapacityPlanner\V1beta\QueryCapacityPlansRequest;
use Google\Cloud\CapacityPlanner\V1beta\QueryCapacityPlansResponse;
use Google\Rpc\Code;
use stdClass;

/**
 * @group capacityplanner
 *
 * @group gapic
 */
class CapacityPlanningServiceClientTest extends GeneratedTest
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

    /** @return CapacityPlanningServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new CapacityPlanningServiceClient($options);
    }

    /** @test */
    public function getCapacityPlanTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $description = 'description-1724546052';
        $title = 'title110371416';
        $expectedResponse = new CapacityPlan();
        $expectedResponse->setName($name2);
        $expectedResponse->setDescription($description);
        $expectedResponse->setTitle($title);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->capacityPlanName('[PROJECT]', '[CAPACITY_PLAN]');
        $request = (new GetCapacityPlanRequest())->setName($formattedName);
        $response = $gapicClient->getCapacityPlan($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.capacityplanner.v1beta.CapacityPlanningService/GetCapacityPlan',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getCapacityPlanExceptionTest()
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
        $formattedName = $gapicClient->capacityPlanName('[PROJECT]', '[CAPACITY_PLAN]');
        $request = (new GetCapacityPlanRequest())->setName($formattedName);
        try {
            $gapicClient->getCapacityPlan($request);
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
    public function queryCapacityPlanInsightsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new QueryCapacityPlanInsightsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $capacityPlanFilters = new CapacityPlanFilters();
        $capacityPlanFiltersKeys = [];
        $capacityPlanFilters->setKeys($capacityPlanFiltersKeys);
        $capacityPlanFiltersCapacityTypes = [];
        $capacityPlanFilters->setCapacityTypes($capacityPlanFiltersCapacityTypes);
        $request = (new QueryCapacityPlanInsightsRequest())
            ->setParent($parent)
            ->setCapacityPlanFilters($capacityPlanFilters);
        $response = $gapicClient->queryCapacityPlanInsights($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.capacityplanner.v1beta.CapacityPlanningService/QueryCapacityPlanInsights',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $actualValue = $actualRequestObject->getCapacityPlanFilters();
        $this->assertProtobufEquals($capacityPlanFilters, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function queryCapacityPlanInsightsExceptionTest()
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
        $capacityPlanFilters = new CapacityPlanFilters();
        $capacityPlanFiltersKeys = [];
        $capacityPlanFilters->setKeys($capacityPlanFiltersKeys);
        $capacityPlanFiltersCapacityTypes = [];
        $capacityPlanFilters->setCapacityTypes($capacityPlanFiltersCapacityTypes);
        $request = (new QueryCapacityPlanInsightsRequest())
            ->setParent($parent)
            ->setCapacityPlanFilters($capacityPlanFilters);
        try {
            $gapicClient->queryCapacityPlanInsights($request);
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
    public function queryCapacityPlansTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $capacityPlansElement = new CapacityPlan();
        $capacityPlans = [$capacityPlansElement];
        $expectedResponse = new QueryCapacityPlansResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setCapacityPlans($capacityPlans);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $request = (new QueryCapacityPlansRequest())->setParent($formattedParent);
        $response = $gapicClient->queryCapacityPlans($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCapacityPlans()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.capacityplanner.v1beta.CapacityPlanningService/QueryCapacityPlans',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function queryCapacityPlansExceptionTest()
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
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $request = (new QueryCapacityPlansRequest())->setParent($formattedParent);
        try {
            $gapicClient->queryCapacityPlans($request);
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
    public function getCapacityPlanAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $description = 'description-1724546052';
        $title = 'title110371416';
        $expectedResponse = new CapacityPlan();
        $expectedResponse->setName($name2);
        $expectedResponse->setDescription($description);
        $expectedResponse->setTitle($title);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->capacityPlanName('[PROJECT]', '[CAPACITY_PLAN]');
        $request = (new GetCapacityPlanRequest())->setName($formattedName);
        $response = $gapicClient->getCapacityPlanAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.capacityplanner.v1beta.CapacityPlanningService/GetCapacityPlan',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
