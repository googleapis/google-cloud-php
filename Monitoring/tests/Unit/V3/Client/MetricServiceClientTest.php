<?php
/*
 * Copyright 2023 Google LLC
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

namespace Google\Cloud\Monitoring\Tests\Unit\V3\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Api\MetricDescriptor;
use Google\Api\MonitoredResourceDescriptor;
use Google\Cloud\Monitoring\V3\Client\MetricServiceClient;
use Google\Cloud\Monitoring\V3\CreateMetricDescriptorRequest;
use Google\Cloud\Monitoring\V3\CreateTimeSeriesRequest;
use Google\Cloud\Monitoring\V3\DeleteMetricDescriptorRequest;
use Google\Cloud\Monitoring\V3\GetMetricDescriptorRequest;
use Google\Cloud\Monitoring\V3\GetMonitoredResourceDescriptorRequest;
use Google\Cloud\Monitoring\V3\ListMetricDescriptorsRequest;
use Google\Cloud\Monitoring\V3\ListMetricDescriptorsResponse;
use Google\Cloud\Monitoring\V3\ListMonitoredResourceDescriptorsRequest;
use Google\Cloud\Monitoring\V3\ListMonitoredResourceDescriptorsResponse;
use Google\Cloud\Monitoring\V3\ListTimeSeriesRequest;
use Google\Cloud\Monitoring\V3\ListTimeSeriesRequest\TimeSeriesView;
use Google\Cloud\Monitoring\V3\ListTimeSeriesResponse;
use Google\Cloud\Monitoring\V3\TimeInterval;
use Google\Cloud\Monitoring\V3\TimeSeries;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group monitoring
 *
 * @group gapic
 */
class MetricServiceClientTest extends GeneratedTest
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

    /** @return MetricServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new MetricServiceClient($options);
    }

    /** @test */
    public function createMetricDescriptorTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $type = 'type3575610';
        $unit = 'unit3594628';
        $description = 'description-1724546052';
        $displayName = 'displayName1615086568';
        $expectedResponse = new MetricDescriptor();
        $expectedResponse->setName($name2);
        $expectedResponse->setType($type);
        $expectedResponse->setUnit($unit);
        $expectedResponse->setDescription($description);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $name = 'name3373707';
        $metricDescriptor = new MetricDescriptor();
        $request = (new CreateMetricDescriptorRequest())
            ->setName($name)
            ->setMetricDescriptor($metricDescriptor);
        $response = $gapicClient->createMetricDescriptor($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.monitoring.v3.MetricService/CreateMetricDescriptor', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($name, $actualValue);
        $actualValue = $actualRequestObject->getMetricDescriptor();
        $this->assertProtobufEquals($metricDescriptor, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createMetricDescriptorExceptionTest()
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
        $name = 'name3373707';
        $metricDescriptor = new MetricDescriptor();
        $request = (new CreateMetricDescriptorRequest())
            ->setName($name)
            ->setMetricDescriptor($metricDescriptor);
        try {
            $gapicClient->createMetricDescriptor($request);
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
    public function createServiceTimeSeriesTest()
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
        $formattedName = $gapicClient->projectName('[PROJECT]');
        $timeSeries = [];
        $request = (new CreateTimeSeriesRequest())
            ->setName($formattedName)
            ->setTimeSeries($timeSeries);
        $gapicClient->createServiceTimeSeries($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.monitoring.v3.MetricService/CreateServiceTimeSeries', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getTimeSeries();
        $this->assertProtobufEquals($timeSeries, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createServiceTimeSeriesExceptionTest()
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
        $formattedName = $gapicClient->projectName('[PROJECT]');
        $timeSeries = [];
        $request = (new CreateTimeSeriesRequest())
            ->setName($formattedName)
            ->setTimeSeries($timeSeries);
        try {
            $gapicClient->createServiceTimeSeries($request);
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
    public function createTimeSeriesTest()
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
        $formattedName = $gapicClient->projectName('[PROJECT]');
        $timeSeries = [];
        $request = (new CreateTimeSeriesRequest())
            ->setName($formattedName)
            ->setTimeSeries($timeSeries);
        $gapicClient->createTimeSeries($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.monitoring.v3.MetricService/CreateTimeSeries', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getTimeSeries();
        $this->assertProtobufEquals($timeSeries, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createTimeSeriesExceptionTest()
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
        $formattedName = $gapicClient->projectName('[PROJECT]');
        $timeSeries = [];
        $request = (new CreateTimeSeriesRequest())
            ->setName($formattedName)
            ->setTimeSeries($timeSeries);
        try {
            $gapicClient->createTimeSeries($request);
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
    public function deleteMetricDescriptorTest()
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
        $formattedName = $gapicClient->metricDescriptorName('[PROJECT]', '[METRIC_DESCRIPTOR]');
        $request = (new DeleteMetricDescriptorRequest())
            ->setName($formattedName);
        $gapicClient->deleteMetricDescriptor($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.monitoring.v3.MetricService/DeleteMetricDescriptor', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteMetricDescriptorExceptionTest()
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
        $formattedName = $gapicClient->metricDescriptorName('[PROJECT]', '[METRIC_DESCRIPTOR]');
        $request = (new DeleteMetricDescriptorRequest())
            ->setName($formattedName);
        try {
            $gapicClient->deleteMetricDescriptor($request);
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
    public function getMetricDescriptorTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $type = 'type3575610';
        $unit = 'unit3594628';
        $description = 'description-1724546052';
        $displayName = 'displayName1615086568';
        $expectedResponse = new MetricDescriptor();
        $expectedResponse->setName($name2);
        $expectedResponse->setType($type);
        $expectedResponse->setUnit($unit);
        $expectedResponse->setDescription($description);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->metricDescriptorName('[PROJECT]', '[METRIC_DESCRIPTOR]');
        $request = (new GetMetricDescriptorRequest())
            ->setName($formattedName);
        $response = $gapicClient->getMetricDescriptor($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.monitoring.v3.MetricService/GetMetricDescriptor', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getMetricDescriptorExceptionTest()
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
        $formattedName = $gapicClient->metricDescriptorName('[PROJECT]', '[METRIC_DESCRIPTOR]');
        $request = (new GetMetricDescriptorRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getMetricDescriptor($request);
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
    public function getMonitoredResourceDescriptorTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $type = 'type3575610';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $expectedResponse = new MonitoredResourceDescriptor();
        $expectedResponse->setName($name2);
        $expectedResponse->setType($type);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->monitoredResourceDescriptorName('[PROJECT]', '[MONITORED_RESOURCE_DESCRIPTOR]');
        $request = (new GetMonitoredResourceDescriptorRequest())
            ->setName($formattedName);
        $response = $gapicClient->getMonitoredResourceDescriptor($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.monitoring.v3.MetricService/GetMonitoredResourceDescriptor', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getMonitoredResourceDescriptorExceptionTest()
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
        $formattedName = $gapicClient->monitoredResourceDescriptorName('[PROJECT]', '[MONITORED_RESOURCE_DESCRIPTOR]');
        $request = (new GetMonitoredResourceDescriptorRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getMonitoredResourceDescriptor($request);
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
    public function listMetricDescriptorsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $metricDescriptorsElement = new MetricDescriptor();
        $metricDescriptors = [
            $metricDescriptorsElement,
        ];
        $expectedResponse = new ListMetricDescriptorsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setMetricDescriptors($metricDescriptors);
        $transport->addResponse($expectedResponse);
        // Mock request
        $name = 'name3373707';
        $request = (new ListMetricDescriptorsRequest())
            ->setName($name);
        $response = $gapicClient->listMetricDescriptors($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getMetricDescriptors()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.monitoring.v3.MetricService/ListMetricDescriptors', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($name, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listMetricDescriptorsExceptionTest()
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
        $name = 'name3373707';
        $request = (new ListMetricDescriptorsRequest())
            ->setName($name);
        try {
            $gapicClient->listMetricDescriptors($request);
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
    public function listMonitoredResourceDescriptorsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $resourceDescriptorsElement = new MonitoredResourceDescriptor();
        $resourceDescriptors = [
            $resourceDescriptorsElement,
        ];
        $expectedResponse = new ListMonitoredResourceDescriptorsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setResourceDescriptors($resourceDescriptors);
        $transport->addResponse($expectedResponse);
        // Mock request
        $name = 'name3373707';
        $request = (new ListMonitoredResourceDescriptorsRequest())
            ->setName($name);
        $response = $gapicClient->listMonitoredResourceDescriptors($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getResourceDescriptors()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.monitoring.v3.MetricService/ListMonitoredResourceDescriptors', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($name, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listMonitoredResourceDescriptorsExceptionTest()
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
        $name = 'name3373707';
        $request = (new ListMonitoredResourceDescriptorsRequest())
            ->setName($name);
        try {
            $gapicClient->listMonitoredResourceDescriptors($request);
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
    public function listTimeSeriesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $unit = 'unit3594628';
        $timeSeriesElement = new TimeSeries();
        $timeSeries = [
            $timeSeriesElement,
        ];
        $expectedResponse = new ListTimeSeriesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setUnit($unit);
        $expectedResponse->setTimeSeries($timeSeries);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->workspaceName('[PROJECT]');
        $filter = 'filter-1274492040';
        $interval = new TimeInterval();
        $view = TimeSeriesView::FULL;
        $request = (new ListTimeSeriesRequest())
            ->setName($formattedName)
            ->setFilter($filter)
            ->setInterval($interval)
            ->setView($view);
        $response = $gapicClient->listTimeSeries($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getTimeSeries()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.monitoring.v3.MetricService/ListTimeSeries', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getFilter();
        $this->assertProtobufEquals($filter, $actualValue);
        $actualValue = $actualRequestObject->getInterval();
        $this->assertProtobufEquals($interval, $actualValue);
        $actualValue = $actualRequestObject->getView();
        $this->assertProtobufEquals($view, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listTimeSeriesExceptionTest()
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
        $formattedName = $gapicClient->workspaceName('[PROJECT]');
        $filter = 'filter-1274492040';
        $interval = new TimeInterval();
        $view = TimeSeriesView::FULL;
        $request = (new ListTimeSeriesRequest())
            ->setName($formattedName)
            ->setFilter($filter)
            ->setInterval($interval)
            ->setView($view);
        try {
            $gapicClient->listTimeSeries($request);
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
    public function createMetricDescriptorAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $type = 'type3575610';
        $unit = 'unit3594628';
        $description = 'description-1724546052';
        $displayName = 'displayName1615086568';
        $expectedResponse = new MetricDescriptor();
        $expectedResponse->setName($name2);
        $expectedResponse->setType($type);
        $expectedResponse->setUnit($unit);
        $expectedResponse->setDescription($description);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $name = 'name3373707';
        $metricDescriptor = new MetricDescriptor();
        $request = (new CreateMetricDescriptorRequest())
            ->setName($name)
            ->setMetricDescriptor($metricDescriptor);
        $response = $gapicClient->createMetricDescriptorAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.monitoring.v3.MetricService/CreateMetricDescriptor', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($name, $actualValue);
        $actualValue = $actualRequestObject->getMetricDescriptor();
        $this->assertProtobufEquals($metricDescriptor, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
