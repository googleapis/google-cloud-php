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

namespace Google\Cloud\AIPlatform\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\ServerStream;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\AIPlatform\V1\BatchCreateTensorboardRunsRequest;
use Google\Cloud\AIPlatform\V1\BatchCreateTensorboardRunsResponse;
use Google\Cloud\AIPlatform\V1\BatchCreateTensorboardTimeSeriesRequest;
use Google\Cloud\AIPlatform\V1\BatchCreateTensorboardTimeSeriesResponse;
use Google\Cloud\AIPlatform\V1\BatchReadTensorboardTimeSeriesDataRequest;
use Google\Cloud\AIPlatform\V1\BatchReadTensorboardTimeSeriesDataResponse;
use Google\Cloud\AIPlatform\V1\Client\TensorboardServiceClient;
use Google\Cloud\AIPlatform\V1\CreateTensorboardExperimentRequest;
use Google\Cloud\AIPlatform\V1\CreateTensorboardRequest;
use Google\Cloud\AIPlatform\V1\CreateTensorboardRunRequest;
use Google\Cloud\AIPlatform\V1\CreateTensorboardTimeSeriesRequest;
use Google\Cloud\AIPlatform\V1\DeleteTensorboardExperimentRequest;
use Google\Cloud\AIPlatform\V1\DeleteTensorboardRequest;
use Google\Cloud\AIPlatform\V1\DeleteTensorboardRunRequest;
use Google\Cloud\AIPlatform\V1\DeleteTensorboardTimeSeriesRequest;
use Google\Cloud\AIPlatform\V1\ExportTensorboardTimeSeriesDataRequest;
use Google\Cloud\AIPlatform\V1\ExportTensorboardTimeSeriesDataResponse;
use Google\Cloud\AIPlatform\V1\GetTensorboardExperimentRequest;
use Google\Cloud\AIPlatform\V1\GetTensorboardRequest;
use Google\Cloud\AIPlatform\V1\GetTensorboardRunRequest;
use Google\Cloud\AIPlatform\V1\GetTensorboardTimeSeriesRequest;
use Google\Cloud\AIPlatform\V1\ListTensorboardExperimentsRequest;
use Google\Cloud\AIPlatform\V1\ListTensorboardExperimentsResponse;
use Google\Cloud\AIPlatform\V1\ListTensorboardRunsRequest;
use Google\Cloud\AIPlatform\V1\ListTensorboardRunsResponse;
use Google\Cloud\AIPlatform\V1\ListTensorboardTimeSeriesRequest;
use Google\Cloud\AIPlatform\V1\ListTensorboardTimeSeriesResponse;
use Google\Cloud\AIPlatform\V1\ListTensorboardsRequest;
use Google\Cloud\AIPlatform\V1\ListTensorboardsResponse;
use Google\Cloud\AIPlatform\V1\ReadTensorboardBlobDataRequest;
use Google\Cloud\AIPlatform\V1\ReadTensorboardBlobDataResponse;
use Google\Cloud\AIPlatform\V1\ReadTensorboardSizeRequest;
use Google\Cloud\AIPlatform\V1\ReadTensorboardSizeResponse;
use Google\Cloud\AIPlatform\V1\ReadTensorboardTimeSeriesDataRequest;
use Google\Cloud\AIPlatform\V1\ReadTensorboardTimeSeriesDataResponse;
use Google\Cloud\AIPlatform\V1\ReadTensorboardUsageRequest;
use Google\Cloud\AIPlatform\V1\ReadTensorboardUsageResponse;
use Google\Cloud\AIPlatform\V1\Tensorboard;
use Google\Cloud\AIPlatform\V1\TensorboardExperiment;
use Google\Cloud\AIPlatform\V1\TensorboardRun;
use Google\Cloud\AIPlatform\V1\TensorboardTimeSeries;
use Google\Cloud\AIPlatform\V1\TensorboardTimeSeries\ValueType;
use Google\Cloud\AIPlatform\V1\TimeSeriesDataPoint;
use Google\Cloud\AIPlatform\V1\UpdateTensorboardExperimentRequest;
use Google\Cloud\AIPlatform\V1\UpdateTensorboardRequest;
use Google\Cloud\AIPlatform\V1\UpdateTensorboardRunRequest;
use Google\Cloud\AIPlatform\V1\UpdateTensorboardTimeSeriesRequest;
use Google\Cloud\AIPlatform\V1\WriteTensorboardExperimentDataRequest;
use Google\Cloud\AIPlatform\V1\WriteTensorboardExperimentDataResponse;
use Google\Cloud\AIPlatform\V1\WriteTensorboardRunDataRequest;
use Google\Cloud\AIPlatform\V1\WriteTensorboardRunDataResponse;
use Google\Cloud\Iam\V1\GetIamPolicyRequest;
use Google\Cloud\Iam\V1\Policy;
use Google\Cloud\Iam\V1\SetIamPolicyRequest;
use Google\Cloud\Iam\V1\TestIamPermissionsRequest;
use Google\Cloud\Iam\V1\TestIamPermissionsResponse;
use Google\Cloud\Location\GetLocationRequest;
use Google\Cloud\Location\ListLocationsRequest;
use Google\Cloud\Location\ListLocationsResponse;
use Google\Cloud\Location\Location;
use Google\LongRunning\Client\OperationsClient;
use Google\LongRunning\GetOperationRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\Any;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group aiplatform
 *
 * @group gapic
 */
class TensorboardServiceClientTest extends GeneratedTest
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

    /** @return TensorboardServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new TensorboardServiceClient($options);
    }

    /** @test */
    public function batchCreateTensorboardRunsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchCreateTensorboardRunsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->tensorboardExperimentName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]'
        );
        $requests = [];
        $request = (new BatchCreateTensorboardRunsRequest())->setParent($formattedParent)->setRequests($requests);
        $response = $gapicClient->batchCreateTensorboardRuns($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.TensorboardService/BatchCreateTensorboardRuns', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchCreateTensorboardRunsExceptionTest()
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
        $formattedParent = $gapicClient->tensorboardExperimentName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]'
        );
        $requests = [];
        $request = (new BatchCreateTensorboardRunsRequest())->setParent($formattedParent)->setRequests($requests);
        try {
            $gapicClient->batchCreateTensorboardRuns($request);
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
    public function batchCreateTensorboardTimeSeriesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchCreateTensorboardTimeSeriesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->tensorboardExperimentName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]'
        );
        $requests = [];
        $request = (new BatchCreateTensorboardTimeSeriesRequest())->setParent($formattedParent)->setRequests($requests);
        $response = $gapicClient->batchCreateTensorboardTimeSeries($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.aiplatform.v1.TensorboardService/BatchCreateTensorboardTimeSeries',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchCreateTensorboardTimeSeriesExceptionTest()
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
        $formattedParent = $gapicClient->tensorboardExperimentName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]'
        );
        $requests = [];
        $request = (new BatchCreateTensorboardTimeSeriesRequest())->setParent($formattedParent)->setRequests($requests);
        try {
            $gapicClient->batchCreateTensorboardTimeSeries($request);
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
    public function batchReadTensorboardTimeSeriesDataTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchReadTensorboardTimeSeriesDataResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedTensorboard = $gapicClient->tensorboardName('[PROJECT]', '[LOCATION]', '[TENSORBOARD]');
        $formattedTimeSeries = [
            $gapicClient->tensorboardTimeSeriesName(
                '[PROJECT]',
                '[LOCATION]',
                '[TENSORBOARD]',
                '[EXPERIMENT]',
                '[RUN]',
                '[TIME_SERIES]'
            ),
        ];
        $request = (new BatchReadTensorboardTimeSeriesDataRequest())
            ->setTensorboard($formattedTensorboard)
            ->setTimeSeries($formattedTimeSeries);
        $response = $gapicClient->batchReadTensorboardTimeSeriesData($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.aiplatform.v1.TensorboardService/BatchReadTensorboardTimeSeriesData',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getTensorboard();
        $this->assertProtobufEquals($formattedTensorboard, $actualValue);
        $actualValue = $actualRequestObject->getTimeSeries();
        $this->assertProtobufEquals($formattedTimeSeries, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchReadTensorboardTimeSeriesDataExceptionTest()
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
        $formattedTensorboard = $gapicClient->tensorboardName('[PROJECT]', '[LOCATION]', '[TENSORBOARD]');
        $formattedTimeSeries = [
            $gapicClient->tensorboardTimeSeriesName(
                '[PROJECT]',
                '[LOCATION]',
                '[TENSORBOARD]',
                '[EXPERIMENT]',
                '[RUN]',
                '[TIME_SERIES]'
            ),
        ];
        $request = (new BatchReadTensorboardTimeSeriesDataRequest())
            ->setTensorboard($formattedTensorboard)
            ->setTimeSeries($formattedTimeSeries);
        try {
            $gapicClient->batchReadTensorboardTimeSeriesData($request);
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
    public function createTensorboardTest()
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
        $incompleteOperation->setName('operations/createTensorboardTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $blobStoragePathPrefix = 'blobStoragePathPrefix566154374';
        $runCount = 485221797;
        $etag = 'etag3123477';
        $isDefault = true;
        $satisfiesPzs = false;
        $satisfiesPzi = false;
        $expectedResponse = new Tensorboard();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setBlobStoragePathPrefix($blobStoragePathPrefix);
        $expectedResponse->setRunCount($runCount);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setIsDefault($isDefault);
        $expectedResponse->setSatisfiesPzs($satisfiesPzs);
        $expectedResponse->setSatisfiesPzi($satisfiesPzi);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/createTensorboardTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $gapicClient->tensorboardName('[PROJECT]', '[LOCATION]', '[TENSORBOARD]');
        $tensorboard = new Tensorboard();
        $tensorboardDisplayName = 'tensorboardDisplayName-448676352';
        $tensorboard->setDisplayName($tensorboardDisplayName);
        $request = (new CreateTensorboardRequest())->setParent($formattedParent)->setTensorboard($tensorboard);
        $response = $gapicClient->createTensorboard($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.TensorboardService/CreateTensorboard', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getTensorboard();
        $this->assertProtobufEquals($tensorboard, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createTensorboardTest');
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
    public function createTensorboardExceptionTest()
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
        $incompleteOperation->setName('operations/createTensorboardTest');
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
        $formattedParent = $gapicClient->tensorboardName('[PROJECT]', '[LOCATION]', '[TENSORBOARD]');
        $tensorboard = new Tensorboard();
        $tensorboardDisplayName = 'tensorboardDisplayName-448676352';
        $tensorboard->setDisplayName($tensorboardDisplayName);
        $request = (new CreateTensorboardRequest())->setParent($formattedParent)->setTensorboard($tensorboard);
        $response = $gapicClient->createTensorboard($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createTensorboardTest');
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
    public function createTensorboardExperimentTest()
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
        $etag = 'etag3123477';
        $source = 'source-896505829';
        $expectedResponse = new TensorboardExperiment();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setSource($source);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->tensorboardExperimentName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]'
        );
        $tensorboardExperimentId = 'tensorboardExperimentId932137483';
        $request = (new CreateTensorboardExperimentRequest())
            ->setParent($formattedParent)
            ->setTensorboardExperimentId($tensorboardExperimentId);
        $response = $gapicClient->createTensorboardExperiment($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.aiplatform.v1.TensorboardService/CreateTensorboardExperiment',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getTensorboardExperimentId();
        $this->assertProtobufEquals($tensorboardExperimentId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createTensorboardExperimentExceptionTest()
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
        $formattedParent = $gapicClient->tensorboardExperimentName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]'
        );
        $tensorboardExperimentId = 'tensorboardExperimentId932137483';
        $request = (new CreateTensorboardExperimentRequest())
            ->setParent($formattedParent)
            ->setTensorboardExperimentId($tensorboardExperimentId);
        try {
            $gapicClient->createTensorboardExperiment($request);
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
    public function createTensorboardRunTest()
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
        $etag = 'etag3123477';
        $expectedResponse = new TensorboardRun();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->tensorboardRunName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]',
            '[RUN]'
        );
        $tensorboardRun = new TensorboardRun();
        $tensorboardRunDisplayName = 'tensorboardRunDisplayName-996156817';
        $tensorboardRun->setDisplayName($tensorboardRunDisplayName);
        $tensorboardRunId = 'tensorboardRunId1793766817';
        $request = (new CreateTensorboardRunRequest())
            ->setParent($formattedParent)
            ->setTensorboardRun($tensorboardRun)
            ->setTensorboardRunId($tensorboardRunId);
        $response = $gapicClient->createTensorboardRun($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.TensorboardService/CreateTensorboardRun', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getTensorboardRun();
        $this->assertProtobufEquals($tensorboardRun, $actualValue);
        $actualValue = $actualRequestObject->getTensorboardRunId();
        $this->assertProtobufEquals($tensorboardRunId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createTensorboardRunExceptionTest()
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
        $formattedParent = $gapicClient->tensorboardRunName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]',
            '[RUN]'
        );
        $tensorboardRun = new TensorboardRun();
        $tensorboardRunDisplayName = 'tensorboardRunDisplayName-996156817';
        $tensorboardRun->setDisplayName($tensorboardRunDisplayName);
        $tensorboardRunId = 'tensorboardRunId1793766817';
        $request = (new CreateTensorboardRunRequest())
            ->setParent($formattedParent)
            ->setTensorboardRun($tensorboardRun)
            ->setTensorboardRunId($tensorboardRunId);
        try {
            $gapicClient->createTensorboardRun($request);
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
    public function createTensorboardTimeSeriesTest()
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
        $etag = 'etag3123477';
        $pluginName = 'pluginName897272855';
        $pluginData = '54';
        $expectedResponse = new TensorboardTimeSeries();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setPluginName($pluginName);
        $expectedResponse->setPluginData($pluginData);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->tensorboardTimeSeriesName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]',
            '[RUN]',
            '[TIME_SERIES]'
        );
        $tensorboardTimeSeries = new TensorboardTimeSeries();
        $tensorboardTimeSeriesDisplayName = 'tensorboardTimeSeriesDisplayName1084140540';
        $tensorboardTimeSeries->setDisplayName($tensorboardTimeSeriesDisplayName);
        $tensorboardTimeSeriesValueType = ValueType::VALUE_TYPE_UNSPECIFIED;
        $tensorboardTimeSeries->setValueType($tensorboardTimeSeriesValueType);
        $request = (new CreateTensorboardTimeSeriesRequest())
            ->setParent($formattedParent)
            ->setTensorboardTimeSeries($tensorboardTimeSeries);
        $response = $gapicClient->createTensorboardTimeSeries($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.aiplatform.v1.TensorboardService/CreateTensorboardTimeSeries',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getTensorboardTimeSeries();
        $this->assertProtobufEquals($tensorboardTimeSeries, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createTensorboardTimeSeriesExceptionTest()
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
        $formattedParent = $gapicClient->tensorboardTimeSeriesName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]',
            '[RUN]',
            '[TIME_SERIES]'
        );
        $tensorboardTimeSeries = new TensorboardTimeSeries();
        $tensorboardTimeSeriesDisplayName = 'tensorboardTimeSeriesDisplayName1084140540';
        $tensorboardTimeSeries->setDisplayName($tensorboardTimeSeriesDisplayName);
        $tensorboardTimeSeriesValueType = ValueType::VALUE_TYPE_UNSPECIFIED;
        $tensorboardTimeSeries->setValueType($tensorboardTimeSeriesValueType);
        $request = (new CreateTensorboardTimeSeriesRequest())
            ->setParent($formattedParent)
            ->setTensorboardTimeSeries($tensorboardTimeSeries);
        try {
            $gapicClient->createTensorboardTimeSeries($request);
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
    public function deleteTensorboardTest()
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
        $incompleteOperation->setName('operations/deleteTensorboardTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new GPBEmpty();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/deleteTensorboardTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->tensorboardName('[PROJECT]', '[LOCATION]', '[TENSORBOARD]');
        $request = (new DeleteTensorboardRequest())->setName($formattedName);
        $response = $gapicClient->deleteTensorboard($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.TensorboardService/DeleteTensorboard', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteTensorboardTest');
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
    public function deleteTensorboardExceptionTest()
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
        $incompleteOperation->setName('operations/deleteTensorboardTest');
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
        $formattedName = $gapicClient->tensorboardName('[PROJECT]', '[LOCATION]', '[TENSORBOARD]');
        $request = (new DeleteTensorboardRequest())->setName($formattedName);
        $response = $gapicClient->deleteTensorboard($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteTensorboardTest');
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
    public function deleteTensorboardExperimentTest()
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
        $incompleteOperation->setName('operations/deleteTensorboardExperimentTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new GPBEmpty();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/deleteTensorboardExperimentTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->tensorboardExperimentName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]'
        );
        $request = (new DeleteTensorboardExperimentRequest())->setName($formattedName);
        $response = $gapicClient->deleteTensorboardExperiment($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.aiplatform.v1.TensorboardService/DeleteTensorboardExperiment',
            $actualApiFuncCall
        );
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteTensorboardExperimentTest');
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
    public function deleteTensorboardExperimentExceptionTest()
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
        $incompleteOperation->setName('operations/deleteTensorboardExperimentTest');
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
        $formattedName = $gapicClient->tensorboardExperimentName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]'
        );
        $request = (new DeleteTensorboardExperimentRequest())->setName($formattedName);
        $response = $gapicClient->deleteTensorboardExperiment($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteTensorboardExperimentTest');
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
    public function deleteTensorboardRunTest()
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
        $incompleteOperation->setName('operations/deleteTensorboardRunTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new GPBEmpty();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/deleteTensorboardRunTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->tensorboardRunName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]',
            '[RUN]'
        );
        $request = (new DeleteTensorboardRunRequest())->setName($formattedName);
        $response = $gapicClient->deleteTensorboardRun($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.TensorboardService/DeleteTensorboardRun', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteTensorboardRunTest');
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
    public function deleteTensorboardRunExceptionTest()
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
        $incompleteOperation->setName('operations/deleteTensorboardRunTest');
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
        $formattedName = $gapicClient->tensorboardRunName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]',
            '[RUN]'
        );
        $request = (new DeleteTensorboardRunRequest())->setName($formattedName);
        $response = $gapicClient->deleteTensorboardRun($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteTensorboardRunTest');
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
    public function deleteTensorboardTimeSeriesTest()
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
        $incompleteOperation->setName('operations/deleteTensorboardTimeSeriesTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new GPBEmpty();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/deleteTensorboardTimeSeriesTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->tensorboardTimeSeriesName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]',
            '[RUN]',
            '[TIME_SERIES]'
        );
        $request = (new DeleteTensorboardTimeSeriesRequest())->setName($formattedName);
        $response = $gapicClient->deleteTensorboardTimeSeries($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.aiplatform.v1.TensorboardService/DeleteTensorboardTimeSeries',
            $actualApiFuncCall
        );
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteTensorboardTimeSeriesTest');
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
    public function deleteTensorboardTimeSeriesExceptionTest()
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
        $incompleteOperation->setName('operations/deleteTensorboardTimeSeriesTest');
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
        $formattedName = $gapicClient->tensorboardTimeSeriesName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]',
            '[RUN]',
            '[TIME_SERIES]'
        );
        $request = (new DeleteTensorboardTimeSeriesRequest())->setName($formattedName);
        $response = $gapicClient->deleteTensorboardTimeSeries($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteTensorboardTimeSeriesTest');
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
    public function exportTensorboardTimeSeriesDataTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $timeSeriesDataPointsElement = new TimeSeriesDataPoint();
        $timeSeriesDataPoints = [$timeSeriesDataPointsElement];
        $expectedResponse = new ExportTensorboardTimeSeriesDataResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTimeSeriesDataPoints($timeSeriesDataPoints);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedTensorboardTimeSeries = $gapicClient->tensorboardTimeSeriesName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]',
            '[RUN]',
            '[TIME_SERIES]'
        );
        $request = (new ExportTensorboardTimeSeriesDataRequest())->setTensorboardTimeSeries(
            $formattedTensorboardTimeSeries
        );
        $response = $gapicClient->exportTensorboardTimeSeriesData($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getTimeSeriesDataPoints()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.aiplatform.v1.TensorboardService/ExportTensorboardTimeSeriesData',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getTensorboardTimeSeries();
        $this->assertProtobufEquals($formattedTensorboardTimeSeries, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function exportTensorboardTimeSeriesDataExceptionTest()
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
        $formattedTensorboardTimeSeries = $gapicClient->tensorboardTimeSeriesName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]',
            '[RUN]',
            '[TIME_SERIES]'
        );
        $request = (new ExportTensorboardTimeSeriesDataRequest())->setTensorboardTimeSeries(
            $formattedTensorboardTimeSeries
        );
        try {
            $gapicClient->exportTensorboardTimeSeriesData($request);
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
    public function getTensorboardTest()
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
        $blobStoragePathPrefix = 'blobStoragePathPrefix566154374';
        $runCount = 485221797;
        $etag = 'etag3123477';
        $isDefault = true;
        $satisfiesPzs = false;
        $satisfiesPzi = false;
        $expectedResponse = new Tensorboard();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setBlobStoragePathPrefix($blobStoragePathPrefix);
        $expectedResponse->setRunCount($runCount);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setIsDefault($isDefault);
        $expectedResponse->setSatisfiesPzs($satisfiesPzs);
        $expectedResponse->setSatisfiesPzi($satisfiesPzi);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->tensorboardName('[PROJECT]', '[LOCATION]', '[TENSORBOARD]');
        $request = (new GetTensorboardRequest())->setName($formattedName);
        $response = $gapicClient->getTensorboard($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.TensorboardService/GetTensorboard', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getTensorboardExceptionTest()
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
        $formattedName = $gapicClient->tensorboardName('[PROJECT]', '[LOCATION]', '[TENSORBOARD]');
        $request = (new GetTensorboardRequest())->setName($formattedName);
        try {
            $gapicClient->getTensorboard($request);
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
    public function getTensorboardExperimentTest()
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
        $etag = 'etag3123477';
        $source = 'source-896505829';
        $expectedResponse = new TensorboardExperiment();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setSource($source);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->tensorboardExperimentName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]'
        );
        $request = (new GetTensorboardExperimentRequest())->setName($formattedName);
        $response = $gapicClient->getTensorboardExperiment($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.TensorboardService/GetTensorboardExperiment', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getTensorboardExperimentExceptionTest()
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
        $formattedName = $gapicClient->tensorboardExperimentName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]'
        );
        $request = (new GetTensorboardExperimentRequest())->setName($formattedName);
        try {
            $gapicClient->getTensorboardExperiment($request);
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
    public function getTensorboardRunTest()
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
        $etag = 'etag3123477';
        $expectedResponse = new TensorboardRun();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->tensorboardRunName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]',
            '[RUN]'
        );
        $request = (new GetTensorboardRunRequest())->setName($formattedName);
        $response = $gapicClient->getTensorboardRun($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.TensorboardService/GetTensorboardRun', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getTensorboardRunExceptionTest()
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
        $formattedName = $gapicClient->tensorboardRunName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]',
            '[RUN]'
        );
        $request = (new GetTensorboardRunRequest())->setName($formattedName);
        try {
            $gapicClient->getTensorboardRun($request);
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
    public function getTensorboardTimeSeriesTest()
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
        $etag = 'etag3123477';
        $pluginName = 'pluginName897272855';
        $pluginData = '54';
        $expectedResponse = new TensorboardTimeSeries();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setPluginName($pluginName);
        $expectedResponse->setPluginData($pluginData);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->tensorboardTimeSeriesName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]',
            '[RUN]',
            '[TIME_SERIES]'
        );
        $request = (new GetTensorboardTimeSeriesRequest())->setName($formattedName);
        $response = $gapicClient->getTensorboardTimeSeries($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.TensorboardService/GetTensorboardTimeSeries', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getTensorboardTimeSeriesExceptionTest()
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
        $formattedName = $gapicClient->tensorboardTimeSeriesName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]',
            '[RUN]',
            '[TIME_SERIES]'
        );
        $request = (new GetTensorboardTimeSeriesRequest())->setName($formattedName);
        try {
            $gapicClient->getTensorboardTimeSeries($request);
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
    public function listTensorboardExperimentsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $tensorboardExperimentsElement = new TensorboardExperiment();
        $tensorboardExperiments = [$tensorboardExperimentsElement];
        $expectedResponse = new ListTensorboardExperimentsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTensorboardExperiments($tensorboardExperiments);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->tensorboardName('[PROJECT]', '[LOCATION]', '[TENSORBOARD]');
        $request = (new ListTensorboardExperimentsRequest())->setParent($formattedParent);
        $response = $gapicClient->listTensorboardExperiments($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getTensorboardExperiments()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.TensorboardService/ListTensorboardExperiments', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listTensorboardExperimentsExceptionTest()
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
        $formattedParent = $gapicClient->tensorboardName('[PROJECT]', '[LOCATION]', '[TENSORBOARD]');
        $request = (new ListTensorboardExperimentsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listTensorboardExperiments($request);
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
    public function listTensorboardRunsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $tensorboardRunsElement = new TensorboardRun();
        $tensorboardRuns = [$tensorboardRunsElement];
        $expectedResponse = new ListTensorboardRunsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTensorboardRuns($tensorboardRuns);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->tensorboardExperimentName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]'
        );
        $request = (new ListTensorboardRunsRequest())->setParent($formattedParent);
        $response = $gapicClient->listTensorboardRuns($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getTensorboardRuns()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.TensorboardService/ListTensorboardRuns', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listTensorboardRunsExceptionTest()
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
        $formattedParent = $gapicClient->tensorboardExperimentName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]'
        );
        $request = (new ListTensorboardRunsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listTensorboardRuns($request);
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
    public function listTensorboardTimeSeriesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $tensorboardTimeSeriesElement = new TensorboardTimeSeries();
        $tensorboardTimeSeries = [$tensorboardTimeSeriesElement];
        $expectedResponse = new ListTensorboardTimeSeriesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTensorboardTimeSeries($tensorboardTimeSeries);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->tensorboardRunName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]',
            '[RUN]'
        );
        $request = (new ListTensorboardTimeSeriesRequest())->setParent($formattedParent);
        $response = $gapicClient->listTensorboardTimeSeries($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getTensorboardTimeSeries()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.TensorboardService/ListTensorboardTimeSeries', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listTensorboardTimeSeriesExceptionTest()
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
        $formattedParent = $gapicClient->tensorboardRunName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]',
            '[RUN]'
        );
        $request = (new ListTensorboardTimeSeriesRequest())->setParent($formattedParent);
        try {
            $gapicClient->listTensorboardTimeSeries($request);
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
    public function listTensorboardsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $tensorboardsElement = new Tensorboard();
        $tensorboards = [$tensorboardsElement];
        $expectedResponse = new ListTensorboardsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTensorboards($tensorboards);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListTensorboardsRequest())->setParent($formattedParent);
        $response = $gapicClient->listTensorboards($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getTensorboards()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.TensorboardService/ListTensorboards', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listTensorboardsExceptionTest()
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
        $request = (new ListTensorboardsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listTensorboards($request);
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
    public function readTensorboardBlobDataTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new ReadTensorboardBlobDataResponse();
        $transport->addResponse($expectedResponse);
        $expectedResponse2 = new ReadTensorboardBlobDataResponse();
        $transport->addResponse($expectedResponse2);
        $expectedResponse3 = new ReadTensorboardBlobDataResponse();
        $transport->addResponse($expectedResponse3);
        // Mock request
        $formattedTimeSeries = $gapicClient->tensorboardTimeSeriesName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]',
            '[RUN]',
            '[TIME_SERIES]'
        );
        $request = (new ReadTensorboardBlobDataRequest())->setTimeSeries($formattedTimeSeries);
        $serverStream = $gapicClient->readTensorboardBlobData($request);
        $this->assertInstanceOf(ServerStream::class, $serverStream);
        $responses = iterator_to_array($serverStream->readAll());
        $expectedResponses = [];
        $expectedResponses[] = $expectedResponse;
        $expectedResponses[] = $expectedResponse2;
        $expectedResponses[] = $expectedResponse3;
        $this->assertEquals($expectedResponses, $responses);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.TensorboardService/ReadTensorboardBlobData', $actualFuncCall);
        $actualValue = $actualRequestObject->getTimeSeries();
        $this->assertProtobufEquals($formattedTimeSeries, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function readTensorboardBlobDataExceptionTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
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
        $transport->setStreamingStatus($status);
        $this->assertTrue($transport->isExhausted());
        // Mock request
        $formattedTimeSeries = $gapicClient->tensorboardTimeSeriesName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]',
            '[RUN]',
            '[TIME_SERIES]'
        );
        $request = (new ReadTensorboardBlobDataRequest())->setTimeSeries($formattedTimeSeries);
        $serverStream = $gapicClient->readTensorboardBlobData($request);
        $results = $serverStream->readAll();
        try {
            iterator_to_array($results);
            // If the close stream method call did not throw, fail the test
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
    public function readTensorboardSizeTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $storageSizeByte = 126045758;
        $expectedResponse = new ReadTensorboardSizeResponse();
        $expectedResponse->setStorageSizeByte($storageSizeByte);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedTensorboard = $gapicClient->tensorboardName('[PROJECT]', '[LOCATION]', '[TENSORBOARD]');
        $request = (new ReadTensorboardSizeRequest())->setTensorboard($formattedTensorboard);
        $response = $gapicClient->readTensorboardSize($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.TensorboardService/ReadTensorboardSize', $actualFuncCall);
        $actualValue = $actualRequestObject->getTensorboard();
        $this->assertProtobufEquals($formattedTensorboard, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function readTensorboardSizeExceptionTest()
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
        $formattedTensorboard = $gapicClient->tensorboardName('[PROJECT]', '[LOCATION]', '[TENSORBOARD]');
        $request = (new ReadTensorboardSizeRequest())->setTensorboard($formattedTensorboard);
        try {
            $gapicClient->readTensorboardSize($request);
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
    public function readTensorboardTimeSeriesDataTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new ReadTensorboardTimeSeriesDataResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedTensorboardTimeSeries = $gapicClient->tensorboardTimeSeriesName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]',
            '[RUN]',
            '[TIME_SERIES]'
        );
        $request = (new ReadTensorboardTimeSeriesDataRequest())->setTensorboardTimeSeries(
            $formattedTensorboardTimeSeries
        );
        $response = $gapicClient->readTensorboardTimeSeriesData($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.aiplatform.v1.TensorboardService/ReadTensorboardTimeSeriesData',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getTensorboardTimeSeries();
        $this->assertProtobufEquals($formattedTensorboardTimeSeries, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function readTensorboardTimeSeriesDataExceptionTest()
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
        $formattedTensorboardTimeSeries = $gapicClient->tensorboardTimeSeriesName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]',
            '[RUN]',
            '[TIME_SERIES]'
        );
        $request = (new ReadTensorboardTimeSeriesDataRequest())->setTensorboardTimeSeries(
            $formattedTensorboardTimeSeries
        );
        try {
            $gapicClient->readTensorboardTimeSeriesData($request);
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
    public function readTensorboardUsageTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new ReadTensorboardUsageResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedTensorboard = $gapicClient->tensorboardName('[PROJECT]', '[LOCATION]', '[TENSORBOARD]');
        $request = (new ReadTensorboardUsageRequest())->setTensorboard($formattedTensorboard);
        $response = $gapicClient->readTensorboardUsage($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.TensorboardService/ReadTensorboardUsage', $actualFuncCall);
        $actualValue = $actualRequestObject->getTensorboard();
        $this->assertProtobufEquals($formattedTensorboard, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function readTensorboardUsageExceptionTest()
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
        $formattedTensorboard = $gapicClient->tensorboardName('[PROJECT]', '[LOCATION]', '[TENSORBOARD]');
        $request = (new ReadTensorboardUsageRequest())->setTensorboard($formattedTensorboard);
        try {
            $gapicClient->readTensorboardUsage($request);
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
    public function updateTensorboardTest()
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
        $incompleteOperation->setName('operations/updateTensorboardTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $blobStoragePathPrefix = 'blobStoragePathPrefix566154374';
        $runCount = 485221797;
        $etag = 'etag3123477';
        $isDefault = true;
        $satisfiesPzs = false;
        $satisfiesPzi = false;
        $expectedResponse = new Tensorboard();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setBlobStoragePathPrefix($blobStoragePathPrefix);
        $expectedResponse->setRunCount($runCount);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setIsDefault($isDefault);
        $expectedResponse->setSatisfiesPzs($satisfiesPzs);
        $expectedResponse->setSatisfiesPzi($satisfiesPzi);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/updateTensorboardTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $updateMask = new FieldMask();
        $tensorboard = new Tensorboard();
        $tensorboardDisplayName = 'tensorboardDisplayName-448676352';
        $tensorboard->setDisplayName($tensorboardDisplayName);
        $request = (new UpdateTensorboardRequest())->setUpdateMask($updateMask)->setTensorboard($tensorboard);
        $response = $gapicClient->updateTensorboard($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.TensorboardService/UpdateTensorboard', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $actualValue = $actualApiRequestObject->getTensorboard();
        $this->assertProtobufEquals($tensorboard, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/updateTensorboardTest');
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
    public function updateTensorboardExceptionTest()
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
        $incompleteOperation->setName('operations/updateTensorboardTest');
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
        $updateMask = new FieldMask();
        $tensorboard = new Tensorboard();
        $tensorboardDisplayName = 'tensorboardDisplayName-448676352';
        $tensorboard->setDisplayName($tensorboardDisplayName);
        $request = (new UpdateTensorboardRequest())->setUpdateMask($updateMask)->setTensorboard($tensorboard);
        $response = $gapicClient->updateTensorboard($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/updateTensorboardTest');
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
    public function updateTensorboardExperimentTest()
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
        $etag = 'etag3123477';
        $source = 'source-896505829';
        $expectedResponse = new TensorboardExperiment();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setSource($source);
        $transport->addResponse($expectedResponse);
        // Mock request
        $updateMask = new FieldMask();
        $tensorboardExperiment = new TensorboardExperiment();
        $request = (new UpdateTensorboardExperimentRequest())
            ->setUpdateMask($updateMask)
            ->setTensorboardExperiment($tensorboardExperiment);
        $response = $gapicClient->updateTensorboardExperiment($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.aiplatform.v1.TensorboardService/UpdateTensorboardExperiment',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $actualValue = $actualRequestObject->getTensorboardExperiment();
        $this->assertProtobufEquals($tensorboardExperiment, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateTensorboardExperimentExceptionTest()
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
        $updateMask = new FieldMask();
        $tensorboardExperiment = new TensorboardExperiment();
        $request = (new UpdateTensorboardExperimentRequest())
            ->setUpdateMask($updateMask)
            ->setTensorboardExperiment($tensorboardExperiment);
        try {
            $gapicClient->updateTensorboardExperiment($request);
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
    public function updateTensorboardRunTest()
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
        $etag = 'etag3123477';
        $expectedResponse = new TensorboardRun();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $updateMask = new FieldMask();
        $tensorboardRun = new TensorboardRun();
        $tensorboardRunDisplayName = 'tensorboardRunDisplayName-996156817';
        $tensorboardRun->setDisplayName($tensorboardRunDisplayName);
        $request = (new UpdateTensorboardRunRequest())->setUpdateMask($updateMask)->setTensorboardRun($tensorboardRun);
        $response = $gapicClient->updateTensorboardRun($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.TensorboardService/UpdateTensorboardRun', $actualFuncCall);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $actualValue = $actualRequestObject->getTensorboardRun();
        $this->assertProtobufEquals($tensorboardRun, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateTensorboardRunExceptionTest()
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
        $updateMask = new FieldMask();
        $tensorboardRun = new TensorboardRun();
        $tensorboardRunDisplayName = 'tensorboardRunDisplayName-996156817';
        $tensorboardRun->setDisplayName($tensorboardRunDisplayName);
        $request = (new UpdateTensorboardRunRequest())->setUpdateMask($updateMask)->setTensorboardRun($tensorboardRun);
        try {
            $gapicClient->updateTensorboardRun($request);
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
    public function updateTensorboardTimeSeriesTest()
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
        $etag = 'etag3123477';
        $pluginName = 'pluginName897272855';
        $pluginData = '54';
        $expectedResponse = new TensorboardTimeSeries();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setPluginName($pluginName);
        $expectedResponse->setPluginData($pluginData);
        $transport->addResponse($expectedResponse);
        // Mock request
        $updateMask = new FieldMask();
        $tensorboardTimeSeries = new TensorboardTimeSeries();
        $tensorboardTimeSeriesDisplayName = 'tensorboardTimeSeriesDisplayName1084140540';
        $tensorboardTimeSeries->setDisplayName($tensorboardTimeSeriesDisplayName);
        $tensorboardTimeSeriesValueType = ValueType::VALUE_TYPE_UNSPECIFIED;
        $tensorboardTimeSeries->setValueType($tensorboardTimeSeriesValueType);
        $request = (new UpdateTensorboardTimeSeriesRequest())
            ->setUpdateMask($updateMask)
            ->setTensorboardTimeSeries($tensorboardTimeSeries);
        $response = $gapicClient->updateTensorboardTimeSeries($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.aiplatform.v1.TensorboardService/UpdateTensorboardTimeSeries',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $actualValue = $actualRequestObject->getTensorboardTimeSeries();
        $this->assertProtobufEquals($tensorboardTimeSeries, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateTensorboardTimeSeriesExceptionTest()
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
        $updateMask = new FieldMask();
        $tensorboardTimeSeries = new TensorboardTimeSeries();
        $tensorboardTimeSeriesDisplayName = 'tensorboardTimeSeriesDisplayName1084140540';
        $tensorboardTimeSeries->setDisplayName($tensorboardTimeSeriesDisplayName);
        $tensorboardTimeSeriesValueType = ValueType::VALUE_TYPE_UNSPECIFIED;
        $tensorboardTimeSeries->setValueType($tensorboardTimeSeriesValueType);
        $request = (new UpdateTensorboardTimeSeriesRequest())
            ->setUpdateMask($updateMask)
            ->setTensorboardTimeSeries($tensorboardTimeSeries);
        try {
            $gapicClient->updateTensorboardTimeSeries($request);
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
    public function writeTensorboardExperimentDataTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new WriteTensorboardExperimentDataResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedTensorboardExperiment = $gapicClient->tensorboardExperimentName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]'
        );
        $writeRunDataRequests = [];
        $request = (new WriteTensorboardExperimentDataRequest())
            ->setTensorboardExperiment($formattedTensorboardExperiment)
            ->setWriteRunDataRequests($writeRunDataRequests);
        $response = $gapicClient->writeTensorboardExperimentData($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.aiplatform.v1.TensorboardService/WriteTensorboardExperimentData',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getTensorboardExperiment();
        $this->assertProtobufEquals($formattedTensorboardExperiment, $actualValue);
        $actualValue = $actualRequestObject->getWriteRunDataRequests();
        $this->assertProtobufEquals($writeRunDataRequests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function writeTensorboardExperimentDataExceptionTest()
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
        $formattedTensorboardExperiment = $gapicClient->tensorboardExperimentName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]'
        );
        $writeRunDataRequests = [];
        $request = (new WriteTensorboardExperimentDataRequest())
            ->setTensorboardExperiment($formattedTensorboardExperiment)
            ->setWriteRunDataRequests($writeRunDataRequests);
        try {
            $gapicClient->writeTensorboardExperimentData($request);
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
    public function writeTensorboardRunDataTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new WriteTensorboardRunDataResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedTensorboardRun = $gapicClient->tensorboardRunName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]',
            '[RUN]'
        );
        $timeSeriesData = [];
        $request = (new WriteTensorboardRunDataRequest())
            ->setTensorboardRun($formattedTensorboardRun)
            ->setTimeSeriesData($timeSeriesData);
        $response = $gapicClient->writeTensorboardRunData($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.TensorboardService/WriteTensorboardRunData', $actualFuncCall);
        $actualValue = $actualRequestObject->getTensorboardRun();
        $this->assertProtobufEquals($formattedTensorboardRun, $actualValue);
        $actualValue = $actualRequestObject->getTimeSeriesData();
        $this->assertProtobufEquals($timeSeriesData, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function writeTensorboardRunDataExceptionTest()
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
        $formattedTensorboardRun = $gapicClient->tensorboardRunName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]',
            '[RUN]'
        );
        $timeSeriesData = [];
        $request = (new WriteTensorboardRunDataRequest())
            ->setTensorboardRun($formattedTensorboardRun)
            ->setTimeSeriesData($timeSeriesData);
        try {
            $gapicClient->writeTensorboardRunData($request);
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
    public function getLocationTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $locationId = 'locationId552319461';
        $displayName = 'displayName1615086568';
        $expectedResponse = new Location();
        $expectedResponse->setName($name2);
        $expectedResponse->setLocationId($locationId);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        $request = new GetLocationRequest();
        $response = $gapicClient->getLocation($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.location.Locations/GetLocation', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getLocationExceptionTest()
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
        $request = new GetLocationRequest();
        try {
            $gapicClient->getLocation($request);
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
    public function listLocationsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $locationsElement = new Location();
        $locations = [$locationsElement];
        $expectedResponse = new ListLocationsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setLocations($locations);
        $transport->addResponse($expectedResponse);
        $request = new ListLocationsRequest();
        $response = $gapicClient->listLocations($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getLocations()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.location.Locations/ListLocations', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listLocationsExceptionTest()
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
        $request = new ListLocationsRequest();
        try {
            $gapicClient->listLocations($request);
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
    public function getIamPolicyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $version = 351608024;
        $etag = '21';
        $expectedResponse = new Policy();
        $expectedResponse->setVersion($version);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $resource = 'resource-341064690';
        $request = (new GetIamPolicyRequest())->setResource($resource);
        $response = $gapicClient->getIamPolicy($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.iam.v1.IAMPolicy/GetIamPolicy', $actualFuncCall);
        $actualValue = $actualRequestObject->getResource();
        $this->assertProtobufEquals($resource, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getIamPolicyExceptionTest()
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
        $resource = 'resource-341064690';
        $request = (new GetIamPolicyRequest())->setResource($resource);
        try {
            $gapicClient->getIamPolicy($request);
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
    public function setIamPolicyTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $version = 351608024;
        $etag = '21';
        $expectedResponse = new Policy();
        $expectedResponse->setVersion($version);
        $expectedResponse->setEtag($etag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $resource = 'resource-341064690';
        $policy = new Policy();
        $request = (new SetIamPolicyRequest())->setResource($resource)->setPolicy($policy);
        $response = $gapicClient->setIamPolicy($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.iam.v1.IAMPolicy/SetIamPolicy', $actualFuncCall);
        $actualValue = $actualRequestObject->getResource();
        $this->assertProtobufEquals($resource, $actualValue);
        $actualValue = $actualRequestObject->getPolicy();
        $this->assertProtobufEquals($policy, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function setIamPolicyExceptionTest()
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
        $resource = 'resource-341064690';
        $policy = new Policy();
        $request = (new SetIamPolicyRequest())->setResource($resource)->setPolicy($policy);
        try {
            $gapicClient->setIamPolicy($request);
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
    public function testIamPermissionsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new TestIamPermissionsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $resource = 'resource-341064690';
        $permissions = [];
        $request = (new TestIamPermissionsRequest())->setResource($resource)->setPermissions($permissions);
        $response = $gapicClient->testIamPermissions($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.iam.v1.IAMPolicy/TestIamPermissions', $actualFuncCall);
        $actualValue = $actualRequestObject->getResource();
        $this->assertProtobufEquals($resource, $actualValue);
        $actualValue = $actualRequestObject->getPermissions();
        $this->assertProtobufEquals($permissions, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function testIamPermissionsExceptionTest()
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
        $resource = 'resource-341064690';
        $permissions = [];
        $request = (new TestIamPermissionsRequest())->setResource($resource)->setPermissions($permissions);
        try {
            $gapicClient->testIamPermissions($request);
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
    public function batchCreateTensorboardRunsAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchCreateTensorboardRunsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->tensorboardExperimentName(
            '[PROJECT]',
            '[LOCATION]',
            '[TENSORBOARD]',
            '[EXPERIMENT]'
        );
        $requests = [];
        $request = (new BatchCreateTensorboardRunsRequest())->setParent($formattedParent)->setRequests($requests);
        $response = $gapicClient->batchCreateTensorboardRunsAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.TensorboardService/BatchCreateTensorboardRuns', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
