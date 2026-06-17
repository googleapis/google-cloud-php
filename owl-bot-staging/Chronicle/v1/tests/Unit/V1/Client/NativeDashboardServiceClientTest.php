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
use Google\Cloud\Chronicle\V1\AddChartRequest;
use Google\Cloud\Chronicle\V1\AddChartResponse;
use Google\Cloud\Chronicle\V1\Client\NativeDashboardServiceClient;
use Google\Cloud\Chronicle\V1\CreateNativeDashboardRequest;
use Google\Cloud\Chronicle\V1\DashboardChart;
use Google\Cloud\Chronicle\V1\DashboardChart\Visualization;
use Google\Cloud\Chronicle\V1\DashboardDefinition\ChartConfig\ChartLayout;
use Google\Cloud\Chronicle\V1\DeleteNativeDashboardRequest;
use Google\Cloud\Chronicle\V1\DuplicateChartRequest;
use Google\Cloud\Chronicle\V1\DuplicateChartResponse;
use Google\Cloud\Chronicle\V1\DuplicateNativeDashboardRequest;
use Google\Cloud\Chronicle\V1\EditChartRequest;
use Google\Cloud\Chronicle\V1\EditChartResponse;
use Google\Cloud\Chronicle\V1\ExportNativeDashboardsRequest;
use Google\Cloud\Chronicle\V1\ExportNativeDashboardsResponse;
use Google\Cloud\Chronicle\V1\GetNativeDashboardRequest;
use Google\Cloud\Chronicle\V1\ImportNativeDashboardsInlineSource;
use Google\Cloud\Chronicle\V1\ImportNativeDashboardsRequest;
use Google\Cloud\Chronicle\V1\ImportNativeDashboardsResponse;
use Google\Cloud\Chronicle\V1\ListNativeDashboardsRequest;
use Google\Cloud\Chronicle\V1\ListNativeDashboardsResponse;
use Google\Cloud\Chronicle\V1\NativeDashboard;
use Google\Cloud\Chronicle\V1\RemoveChartRequest;
use Google\Cloud\Chronicle\V1\UpdateNativeDashboardRequest;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group chronicle
 *
 * @group gapic
 */
class NativeDashboardServiceClientTest extends GeneratedTest
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

    /** @return NativeDashboardServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new NativeDashboardServiceClient($options);
    }

    /** @test */
    public function addChartTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new AddChartResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->nativeDashboardName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[DASHBOARD]');
        $dashboardChart = new DashboardChart();
        $dashboardChartDisplayName = 'dashboardChartDisplayName-260950429';
        $dashboardChart->setDisplayName($dashboardChartDisplayName);
        $dashboardChartVisualization = new Visualization();
        $dashboardChart->setVisualization($dashboardChartVisualization);
        $chartLayout = new ChartLayout();
        $request = (new AddChartRequest())
            ->setName($formattedName)
            ->setDashboardChart($dashboardChart)
            ->setChartLayout($chartLayout);
        $response = $gapicClient->addChart($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.NativeDashboardService/AddChart', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getDashboardChart();
        $this->assertProtobufEquals($dashboardChart, $actualValue);
        $actualValue = $actualRequestObject->getChartLayout();
        $this->assertProtobufEquals($chartLayout, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function addChartExceptionTest()
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
        $formattedName = $gapicClient->nativeDashboardName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[DASHBOARD]');
        $dashboardChart = new DashboardChart();
        $dashboardChartDisplayName = 'dashboardChartDisplayName-260950429';
        $dashboardChart->setDisplayName($dashboardChartDisplayName);
        $dashboardChartVisualization = new Visualization();
        $dashboardChart->setVisualization($dashboardChartVisualization);
        $chartLayout = new ChartLayout();
        $request = (new AddChartRequest())
            ->setName($formattedName)
            ->setDashboardChart($dashboardChart)
            ->setChartLayout($chartLayout);
        try {
            $gapicClient->addChart($request);
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
    public function createNativeDashboardTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $createUserId = 'createUserId-1225950772';
        $updateUserId = 'updateUserId-1278348135';
        $etag = 'etag3123477';
        $expectedResponse = new NativeDashboard();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setCreateUserId($createUserId);
        $expectedResponse->setUpdateUserId($updateUserId);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $nativeDashboard = new NativeDashboard();
        $nativeDashboardDisplayName = 'nativeDashboardDisplayName-400195088';
        $nativeDashboard->setDisplayName($nativeDashboardDisplayName);
        $request = (new CreateNativeDashboardRequest())
            ->setParent($formattedParent)
            ->setNativeDashboard($nativeDashboard);
        $response = $gapicClient->createNativeDashboard($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.NativeDashboardService/CreateNativeDashboard', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNativeDashboard();
        $this->assertProtobufEquals($nativeDashboard, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createNativeDashboardExceptionTest()
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
        $nativeDashboard = new NativeDashboard();
        $nativeDashboardDisplayName = 'nativeDashboardDisplayName-400195088';
        $nativeDashboard->setDisplayName($nativeDashboardDisplayName);
        $request = (new CreateNativeDashboardRequest())
            ->setParent($formattedParent)
            ->setNativeDashboard($nativeDashboard);
        try {
            $gapicClient->createNativeDashboard($request);
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
    public function deleteNativeDashboardTest()
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
        $formattedName = $gapicClient->nativeDashboardName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[DASHBOARD]');
        $request = (new DeleteNativeDashboardRequest())
            ->setName($formattedName);
        $gapicClient->deleteNativeDashboard($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.NativeDashboardService/DeleteNativeDashboard', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteNativeDashboardExceptionTest()
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
        $formattedName = $gapicClient->nativeDashboardName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[DASHBOARD]');
        $request = (new DeleteNativeDashboardRequest())
            ->setName($formattedName);
        try {
            $gapicClient->deleteNativeDashboard($request);
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
    public function duplicateChartTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new DuplicateChartResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->nativeDashboardName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[DASHBOARD]');
        $formattedDashboardChart = $gapicClient->dashboardChartName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[CHART]');
        $request = (new DuplicateChartRequest())
            ->setName($formattedName)
            ->setDashboardChart($formattedDashboardChart);
        $response = $gapicClient->duplicateChart($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.NativeDashboardService/DuplicateChart', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getDashboardChart();
        $this->assertProtobufEquals($formattedDashboardChart, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function duplicateChartExceptionTest()
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
        $formattedName = $gapicClient->nativeDashboardName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[DASHBOARD]');
        $formattedDashboardChart = $gapicClient->dashboardChartName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[CHART]');
        $request = (new DuplicateChartRequest())
            ->setName($formattedName)
            ->setDashboardChart($formattedDashboardChart);
        try {
            $gapicClient->duplicateChart($request);
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
    public function duplicateNativeDashboardTest()
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
        $createUserId = 'createUserId-1225950772';
        $updateUserId = 'updateUserId-1278348135';
        $etag = 'etag3123477';
        $expectedResponse = new NativeDashboard();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setCreateUserId($createUserId);
        $expectedResponse->setUpdateUserId($updateUserId);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->nativeDashboardName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[DASHBOARD]');
        $nativeDashboard = new NativeDashboard();
        $nativeDashboardDisplayName = 'nativeDashboardDisplayName-400195088';
        $nativeDashboard->setDisplayName($nativeDashboardDisplayName);
        $request = (new DuplicateNativeDashboardRequest())
            ->setName($formattedName)
            ->setNativeDashboard($nativeDashboard);
        $response = $gapicClient->duplicateNativeDashboard($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.NativeDashboardService/DuplicateNativeDashboard', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getNativeDashboard();
        $this->assertProtobufEquals($nativeDashboard, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function duplicateNativeDashboardExceptionTest()
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
        $formattedName = $gapicClient->nativeDashboardName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[DASHBOARD]');
        $nativeDashboard = new NativeDashboard();
        $nativeDashboardDisplayName = 'nativeDashboardDisplayName-400195088';
        $nativeDashboard->setDisplayName($nativeDashboardDisplayName);
        $request = (new DuplicateNativeDashboardRequest())
            ->setName($formattedName)
            ->setNativeDashboard($nativeDashboard);
        try {
            $gapicClient->duplicateNativeDashboard($request);
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
    public function editChartTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new EditChartResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->nativeDashboardName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[DASHBOARD]');
        $editMask = new FieldMask();
        $request = (new EditChartRequest())
            ->setName($formattedName)
            ->setEditMask($editMask);
        $response = $gapicClient->editChart($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.NativeDashboardService/EditChart', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getEditMask();
        $this->assertProtobufEquals($editMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function editChartExceptionTest()
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
        $formattedName = $gapicClient->nativeDashboardName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[DASHBOARD]');
        $editMask = new FieldMask();
        $request = (new EditChartRequest())
            ->setName($formattedName)
            ->setEditMask($editMask);
        try {
            $gapicClient->editChart($request);
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
    public function exportNativeDashboardsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new ExportNativeDashboardsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $names = [];
        $request = (new ExportNativeDashboardsRequest())
            ->setParent($formattedParent)
            ->setNames($names);
        $response = $gapicClient->exportNativeDashboards($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.NativeDashboardService/ExportNativeDashboards', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($names, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function exportNativeDashboardsExceptionTest()
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
        $names = [];
        $request = (new ExportNativeDashboardsRequest())
            ->setParent($formattedParent)
            ->setNames($names);
        try {
            $gapicClient->exportNativeDashboards($request);
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
    public function getNativeDashboardTest()
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
        $createUserId = 'createUserId-1225950772';
        $updateUserId = 'updateUserId-1278348135';
        $etag = 'etag3123477';
        $expectedResponse = new NativeDashboard();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setCreateUserId($createUserId);
        $expectedResponse->setUpdateUserId($updateUserId);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->nativeDashboardName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[DASHBOARD]');
        $request = (new GetNativeDashboardRequest())
            ->setName($formattedName);
        $response = $gapicClient->getNativeDashboard($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.NativeDashboardService/GetNativeDashboard', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getNativeDashboardExceptionTest()
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
        $formattedName = $gapicClient->nativeDashboardName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[DASHBOARD]');
        $request = (new GetNativeDashboardRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getNativeDashboard($request);
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
    public function importNativeDashboardsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new ImportNativeDashboardsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $source = new ImportNativeDashboardsInlineSource();
        $sourceDashboards = [];
        $source->setDashboards($sourceDashboards);
        $request = (new ImportNativeDashboardsRequest())
            ->setParent($formattedParent)
            ->setSource($source);
        $response = $gapicClient->importNativeDashboards($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.NativeDashboardService/ImportNativeDashboards', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getSource();
        $this->assertProtobufEquals($source, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function importNativeDashboardsExceptionTest()
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
        $source = new ImportNativeDashboardsInlineSource();
        $sourceDashboards = [];
        $source->setDashboards($sourceDashboards);
        $request = (new ImportNativeDashboardsRequest())
            ->setParent($formattedParent)
            ->setSource($source);
        try {
            $gapicClient->importNativeDashboards($request);
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
    public function listNativeDashboardsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $nativeDashboardsElement = new NativeDashboard();
        $nativeDashboards = [
            $nativeDashboardsElement,
        ];
        $expectedResponse = new ListNativeDashboardsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setNativeDashboards($nativeDashboards);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $request = (new ListNativeDashboardsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listNativeDashboards($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getNativeDashboards()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.NativeDashboardService/ListNativeDashboards', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listNativeDashboardsExceptionTest()
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
        $request = (new ListNativeDashboardsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listNativeDashboards($request);
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
    public function removeChartTest()
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
        $createUserId = 'createUserId-1225950772';
        $updateUserId = 'updateUserId-1278348135';
        $etag = 'etag3123477';
        $expectedResponse = new NativeDashboard();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setCreateUserId($createUserId);
        $expectedResponse->setUpdateUserId($updateUserId);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->nativeDashboardName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[DASHBOARD]');
        $formattedDashboardChart = $gapicClient->dashboardChartName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[CHART]');
        $request = (new RemoveChartRequest())
            ->setName($formattedName)
            ->setDashboardChart($formattedDashboardChart);
        $response = $gapicClient->removeChart($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.NativeDashboardService/RemoveChart', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getDashboardChart();
        $this->assertProtobufEquals($formattedDashboardChart, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function removeChartExceptionTest()
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
        $formattedName = $gapicClient->nativeDashboardName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[DASHBOARD]');
        $formattedDashboardChart = $gapicClient->dashboardChartName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[CHART]');
        $request = (new RemoveChartRequest())
            ->setName($formattedName)
            ->setDashboardChart($formattedDashboardChart);
        try {
            $gapicClient->removeChart($request);
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
    public function updateNativeDashboardTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $createUserId = 'createUserId-1225950772';
        $updateUserId = 'updateUserId-1278348135';
        $etag = 'etag3123477';
        $expectedResponse = new NativeDashboard();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setCreateUserId($createUserId);
        $expectedResponse->setUpdateUserId($updateUserId);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $nativeDashboard = new NativeDashboard();
        $nativeDashboardDisplayName = 'nativeDashboardDisplayName-400195088';
        $nativeDashboard->setDisplayName($nativeDashboardDisplayName);
        $updateMask = new FieldMask();
        $request = (new UpdateNativeDashboardRequest())
            ->setNativeDashboard($nativeDashboard)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateNativeDashboard($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.NativeDashboardService/UpdateNativeDashboard', $actualFuncCall);
        $actualValue = $actualRequestObject->getNativeDashboard();
        $this->assertProtobufEquals($nativeDashboard, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateNativeDashboardExceptionTest()
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
        $nativeDashboard = new NativeDashboard();
        $nativeDashboardDisplayName = 'nativeDashboardDisplayName-400195088';
        $nativeDashboard->setDisplayName($nativeDashboardDisplayName);
        $updateMask = new FieldMask();
        $request = (new UpdateNativeDashboardRequest())
            ->setNativeDashboard($nativeDashboard)
            ->setUpdateMask($updateMask);
        try {
            $gapicClient->updateNativeDashboard($request);
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
    public function addChartAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new AddChartResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->nativeDashboardName('[PROJECT]', '[LOCATION]', '[INSTANCE]', '[DASHBOARD]');
        $dashboardChart = new DashboardChart();
        $dashboardChartDisplayName = 'dashboardChartDisplayName-260950429';
        $dashboardChart->setDisplayName($dashboardChartDisplayName);
        $dashboardChartVisualization = new Visualization();
        $dashboardChart->setVisualization($dashboardChartVisualization);
        $chartLayout = new ChartLayout();
        $request = (new AddChartRequest())
            ->setName($formattedName)
            ->setDashboardChart($dashboardChart)
            ->setChartLayout($chartLayout);
        $response = $gapicClient->addChartAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.chronicle.v1.NativeDashboardService/AddChart', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getDashboardChart();
        $this->assertProtobufEquals($dashboardChart, $actualValue);
        $actualValue = $actualRequestObject->getChartLayout();
        $this->assertProtobufEquals($chartLayout, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
