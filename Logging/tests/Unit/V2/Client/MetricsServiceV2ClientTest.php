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

namespace Google\Cloud\Logging\Tests\Unit\V2\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Logging\V2\Client\MetricsServiceV2Client;
use Google\Cloud\Logging\V2\CreateLogMetricRequest;
use Google\Cloud\Logging\V2\DeleteLogMetricRequest;
use Google\Cloud\Logging\V2\GetLogMetricRequest;
use Google\Cloud\Logging\V2\ListLogMetricsRequest;
use Google\Cloud\Logging\V2\ListLogMetricsResponse;
use Google\Cloud\Logging\V2\LogMetric;
use Google\Cloud\Logging\V2\UpdateLogMetricRequest;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group logging
 *
 * @group gapic
 */
class MetricsServiceV2ClientTest extends GeneratedTest
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

    /** @return MetricsServiceV2Client */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new MetricsServiceV2Client($options);
    }

    /** @test */
    public function createLogMetricTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $description = 'description-1724546052';
        $filter = 'filter-1274492040';
        $bucketName = 'bucketName283610048';
        $disabled = true;
        $valueExtractor = 'valueExtractor2047672534';
        $expectedResponse = new LogMetric();
        $expectedResponse->setName($name);
        $expectedResponse->setDescription($description);
        $expectedResponse->setFilter($filter);
        $expectedResponse->setBucketName($bucketName);
        $expectedResponse->setDisabled($disabled);
        $expectedResponse->setValueExtractor($valueExtractor);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $metric = new LogMetric();
        $metricName = 'metricName-610759589';
        $metric->setName($metricName);
        $metricFilter = 'metricFilter1248897352';
        $metric->setFilter($metricFilter);
        $request = (new CreateLogMetricRequest())
            ->setParent($formattedParent)
            ->setMetric($metric);
        $response = $gapicClient->createLogMetric($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.logging.v2.MetricsServiceV2/CreateLogMetric', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getMetric();
        $this->assertProtobufEquals($metric, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createLogMetricExceptionTest()
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
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $metric = new LogMetric();
        $metricName = 'metricName-610759589';
        $metric->setName($metricName);
        $metricFilter = 'metricFilter1248897352';
        $metric->setFilter($metricFilter);
        $request = (new CreateLogMetricRequest())
            ->setParent($formattedParent)
            ->setMetric($metric);
        try {
            $gapicClient->createLogMetric($request);
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
    public function deleteLogMetricTest()
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
        $formattedMetricName = $gapicClient->logMetricName('[PROJECT]', '[METRIC]');
        $request = (new DeleteLogMetricRequest())
            ->setMetricName($formattedMetricName);
        $gapicClient->deleteLogMetric($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.logging.v2.MetricsServiceV2/DeleteLogMetric', $actualFuncCall);
        $actualValue = $actualRequestObject->getMetricName();
        $this->assertProtobufEquals($formattedMetricName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteLogMetricExceptionTest()
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
        $formattedMetricName = $gapicClient->logMetricName('[PROJECT]', '[METRIC]');
        $request = (new DeleteLogMetricRequest())
            ->setMetricName($formattedMetricName);
        try {
            $gapicClient->deleteLogMetric($request);
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
    public function getLogMetricTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $description = 'description-1724546052';
        $filter = 'filter-1274492040';
        $bucketName = 'bucketName283610048';
        $disabled = true;
        $valueExtractor = 'valueExtractor2047672534';
        $expectedResponse = new LogMetric();
        $expectedResponse->setName($name);
        $expectedResponse->setDescription($description);
        $expectedResponse->setFilter($filter);
        $expectedResponse->setBucketName($bucketName);
        $expectedResponse->setDisabled($disabled);
        $expectedResponse->setValueExtractor($valueExtractor);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedMetricName = $gapicClient->logMetricName('[PROJECT]', '[METRIC]');
        $request = (new GetLogMetricRequest())
            ->setMetricName($formattedMetricName);
        $response = $gapicClient->getLogMetric($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.logging.v2.MetricsServiceV2/GetLogMetric', $actualFuncCall);
        $actualValue = $actualRequestObject->getMetricName();
        $this->assertProtobufEquals($formattedMetricName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getLogMetricExceptionTest()
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
        $formattedMetricName = $gapicClient->logMetricName('[PROJECT]', '[METRIC]');
        $request = (new GetLogMetricRequest())
            ->setMetricName($formattedMetricName);
        try {
            $gapicClient->getLogMetric($request);
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
    public function listLogMetricsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $metricsElement = new LogMetric();
        $metrics = [
            $metricsElement,
        ];
        $expectedResponse = new ListLogMetricsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setMetrics($metrics);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $request = (new ListLogMetricsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listLogMetrics($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getMetrics()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.logging.v2.MetricsServiceV2/ListLogMetrics', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listLogMetricsExceptionTest()
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
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $request = (new ListLogMetricsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listLogMetrics($request);
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
    public function updateLogMetricTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $description = 'description-1724546052';
        $filter = 'filter-1274492040';
        $bucketName = 'bucketName283610048';
        $disabled = true;
        $valueExtractor = 'valueExtractor2047672534';
        $expectedResponse = new LogMetric();
        $expectedResponse->setName($name);
        $expectedResponse->setDescription($description);
        $expectedResponse->setFilter($filter);
        $expectedResponse->setBucketName($bucketName);
        $expectedResponse->setDisabled($disabled);
        $expectedResponse->setValueExtractor($valueExtractor);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedMetricName = $gapicClient->logMetricName('[PROJECT]', '[METRIC]');
        $metric = new LogMetric();
        $metricName = 'metricName-610759589';
        $metric->setName($metricName);
        $metricFilter = 'metricFilter1248897352';
        $metric->setFilter($metricFilter);
        $request = (new UpdateLogMetricRequest())
            ->setMetricName($formattedMetricName)
            ->setMetric($metric);
        $response = $gapicClient->updateLogMetric($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.logging.v2.MetricsServiceV2/UpdateLogMetric', $actualFuncCall);
        $actualValue = $actualRequestObject->getMetricName();
        $this->assertProtobufEquals($formattedMetricName, $actualValue);
        $actualValue = $actualRequestObject->getMetric();
        $this->assertProtobufEquals($metric, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateLogMetricExceptionTest()
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
        $formattedMetricName = $gapicClient->logMetricName('[PROJECT]', '[METRIC]');
        $metric = new LogMetric();
        $metricName = 'metricName-610759589';
        $metric->setName($metricName);
        $metricFilter = 'metricFilter1248897352';
        $metric->setFilter($metricFilter);
        $request = (new UpdateLogMetricRequest())
            ->setMetricName($formattedMetricName)
            ->setMetric($metric);
        try {
            $gapicClient->updateLogMetric($request);
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
    public function createLogMetricAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $description = 'description-1724546052';
        $filter = 'filter-1274492040';
        $bucketName = 'bucketName283610048';
        $disabled = true;
        $valueExtractor = 'valueExtractor2047672534';
        $expectedResponse = new LogMetric();
        $expectedResponse->setName($name);
        $expectedResponse->setDescription($description);
        $expectedResponse->setFilter($filter);
        $expectedResponse->setBucketName($bucketName);
        $expectedResponse->setDisabled($disabled);
        $expectedResponse->setValueExtractor($valueExtractor);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $metric = new LogMetric();
        $metricName = 'metricName-610759589';
        $metric->setName($metricName);
        $metricFilter = 'metricFilter1248897352';
        $metric->setFilter($metricFilter);
        $request = (new CreateLogMetricRequest())
            ->setParent($formattedParent)
            ->setMetric($metric);
        $response = $gapicClient->createLogMetricAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.logging.v2.MetricsServiceV2/CreateLogMetric', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getMetric();
        $this->assertProtobufEquals($metric, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
