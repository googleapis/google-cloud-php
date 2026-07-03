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
use Google\Cloud\Chronicle\V1\BatchGetDashboardChartsRequest;
use Google\Cloud\Chronicle\V1\BatchGetDashboardChartsResponse;
use Google\Cloud\Chronicle\V1\Client\DashboardChartServiceClient;
use Google\Cloud\Chronicle\V1\DashboardChart;
use Google\Cloud\Chronicle\V1\GetDashboardChartRequest;
use Google\Rpc\Code;
use stdClass;

/**
 * @group chronicle
 *
 * @group gapic
 */
class DashboardChartServiceClientTest extends GeneratedTest
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

    /** @return DashboardChartServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new DashboardChartServiceClient($options);
    }

    /** @test */
    public function batchGetDashboardChartsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchGetDashboardChartsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $formattedNames = [
            $gapicClient->dashboardChartName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[CHART]'),
        ];
        $request = (new BatchGetDashboardChartsRequest())
            ->setParent($formattedParent)
            ->setNames($formattedNames);
        $response = $gapicClient->batchGetDashboardCharts($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.DashboardChartService/BatchGetDashboardCharts', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($formattedNames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchGetDashboardChartsExceptionTest()
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
        $formattedNames = [
            $gapicClient->dashboardChartName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[CHART]'),
        ];
        $request = (new BatchGetDashboardChartsRequest())
            ->setParent($formattedParent)
            ->setNames($formattedNames);
        try {
            $gapicClient->batchGetDashboardCharts($request);
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
    public function getDashboardChartTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $nativeDashboard = 'nativeDashboard-671726484';
        $etag = 'etag3123477';
        $expectedResponse = new DashboardChart();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setNativeDashboard($nativeDashboard);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->dashboardChartName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[CHART]');
        $request = (new GetDashboardChartRequest())
            ->setName($formattedName);
        $response = $gapicClient->getDashboardChart($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.DashboardChartService/GetDashboardChart', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getDashboardChartExceptionTest()
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
        $formattedName = $gapicClient->dashboardChartName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[CHART]');
        $request = (new GetDashboardChartRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getDashboardChart($request);
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
    public function batchGetDashboardChartsAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchGetDashboardChartsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $formattedNames = [
            $gapicClient->dashboardChartName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[CHART]'),
        ];
        $request = (new BatchGetDashboardChartsRequest())
            ->setParent($formattedParent)
            ->setNames($formattedNames);
        $response = $gapicClient->batchGetDashboardChartsAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.DashboardChartService/BatchGetDashboardCharts', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($formattedNames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
