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
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\AIPlatform\V1\BatchPredictionJob;
use Google\Cloud\AIPlatform\V1\BatchPredictionJob\InputConfig;
use Google\Cloud\AIPlatform\V1\BatchPredictionJob\OutputConfig;
use Google\Cloud\AIPlatform\V1\CancelBatchPredictionJobRequest;
use Google\Cloud\AIPlatform\V1\CancelCustomJobRequest;
use Google\Cloud\AIPlatform\V1\CancelDataLabelingJobRequest;
use Google\Cloud\AIPlatform\V1\CancelHyperparameterTuningJobRequest;
use Google\Cloud\AIPlatform\V1\CancelNasJobRequest;
use Google\Cloud\AIPlatform\V1\Client\JobServiceClient;
use Google\Cloud\AIPlatform\V1\CreateBatchPredictionJobRequest;
use Google\Cloud\AIPlatform\V1\CreateCustomJobRequest;
use Google\Cloud\AIPlatform\V1\CreateDataLabelingJobRequest;
use Google\Cloud\AIPlatform\V1\CreateHyperparameterTuningJobRequest;
use Google\Cloud\AIPlatform\V1\CreateModelDeploymentMonitoringJobRequest;
use Google\Cloud\AIPlatform\V1\CreateNasJobRequest;
use Google\Cloud\AIPlatform\V1\CustomJob;
use Google\Cloud\AIPlatform\V1\CustomJobSpec;
use Google\Cloud\AIPlatform\V1\DataLabelingJob;
use Google\Cloud\AIPlatform\V1\DeleteBatchPredictionJobRequest;
use Google\Cloud\AIPlatform\V1\DeleteCustomJobRequest;
use Google\Cloud\AIPlatform\V1\DeleteDataLabelingJobRequest;
use Google\Cloud\AIPlatform\V1\DeleteHyperparameterTuningJobRequest;
use Google\Cloud\AIPlatform\V1\DeleteModelDeploymentMonitoringJobRequest;
use Google\Cloud\AIPlatform\V1\DeleteNasJobRequest;
use Google\Cloud\AIPlatform\V1\GetBatchPredictionJobRequest;
use Google\Cloud\AIPlatform\V1\GetCustomJobRequest;
use Google\Cloud\AIPlatform\V1\GetDataLabelingJobRequest;
use Google\Cloud\AIPlatform\V1\GetHyperparameterTuningJobRequest;
use Google\Cloud\AIPlatform\V1\GetModelDeploymentMonitoringJobRequest;
use Google\Cloud\AIPlatform\V1\GetNasJobRequest;
use Google\Cloud\AIPlatform\V1\GetNasTrialDetailRequest;
use Google\Cloud\AIPlatform\V1\HyperparameterTuningJob;
use Google\Cloud\AIPlatform\V1\ListBatchPredictionJobsRequest;
use Google\Cloud\AIPlatform\V1\ListBatchPredictionJobsResponse;
use Google\Cloud\AIPlatform\V1\ListCustomJobsRequest;
use Google\Cloud\AIPlatform\V1\ListCustomJobsResponse;
use Google\Cloud\AIPlatform\V1\ListDataLabelingJobsRequest;
use Google\Cloud\AIPlatform\V1\ListDataLabelingJobsResponse;
use Google\Cloud\AIPlatform\V1\ListHyperparameterTuningJobsRequest;
use Google\Cloud\AIPlatform\V1\ListHyperparameterTuningJobsResponse;
use Google\Cloud\AIPlatform\V1\ListModelDeploymentMonitoringJobsRequest;
use Google\Cloud\AIPlatform\V1\ListModelDeploymentMonitoringJobsResponse;
use Google\Cloud\AIPlatform\V1\ListNasJobsRequest;
use Google\Cloud\AIPlatform\V1\ListNasJobsResponse;
use Google\Cloud\AIPlatform\V1\ListNasTrialDetailsRequest;
use Google\Cloud\AIPlatform\V1\ListNasTrialDetailsResponse;
use Google\Cloud\AIPlatform\V1\ModelDeploymentMonitoringJob;
use Google\Cloud\AIPlatform\V1\ModelDeploymentMonitoringScheduleConfig;
use Google\Cloud\AIPlatform\V1\ModelMonitoringStatsAnomalies;
use Google\Cloud\AIPlatform\V1\NasJob;
use Google\Cloud\AIPlatform\V1\NasJobSpec;
use Google\Cloud\AIPlatform\V1\NasTrialDetail;
use Google\Cloud\AIPlatform\V1\PauseModelDeploymentMonitoringJobRequest;
use Google\Cloud\AIPlatform\V1\ResumeModelDeploymentMonitoringJobRequest;
use Google\Cloud\AIPlatform\V1\SamplingStrategy;
use Google\Cloud\AIPlatform\V1\SearchModelDeploymentMonitoringStatsAnomaliesRequest;
use Google\Cloud\AIPlatform\V1\SearchModelDeploymentMonitoringStatsAnomaliesResponse;
use Google\Cloud\AIPlatform\V1\StudySpec;
use Google\Cloud\AIPlatform\V1\UpdateModelDeploymentMonitoringJobRequest;
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
use Google\Protobuf\Duration;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;
use Google\Protobuf\Value;
use Google\Rpc\Code;
use stdClass;

/**
 * @group aiplatform
 *
 * @group gapic
 */
class JobServiceClientTest extends GeneratedTest
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

    /** @return JobServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new JobServiceClient($options);
    }

    /** @test */
    public function cancelBatchPredictionJobTest()
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
        $formattedName = $gapicClient->batchPredictionJobName('[PROJECT]', '[LOCATION]', '[BATCH_PREDICTION_JOB]');
        $request = (new CancelBatchPredictionJobRequest())->setName($formattedName);
        $gapicClient->cancelBatchPredictionJob($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/CancelBatchPredictionJob', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function cancelBatchPredictionJobExceptionTest()
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
        $formattedName = $gapicClient->batchPredictionJobName('[PROJECT]', '[LOCATION]', '[BATCH_PREDICTION_JOB]');
        $request = (new CancelBatchPredictionJobRequest())->setName($formattedName);
        try {
            $gapicClient->cancelBatchPredictionJob($request);
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
    public function cancelCustomJobTest()
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
        $formattedName = $gapicClient->customJobName('[PROJECT]', '[LOCATION]', '[CUSTOM_JOB]');
        $request = (new CancelCustomJobRequest())->setName($formattedName);
        $gapicClient->cancelCustomJob($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/CancelCustomJob', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function cancelCustomJobExceptionTest()
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
        $formattedName = $gapicClient->customJobName('[PROJECT]', '[LOCATION]', '[CUSTOM_JOB]');
        $request = (new CancelCustomJobRequest())->setName($formattedName);
        try {
            $gapicClient->cancelCustomJob($request);
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
    public function cancelDataLabelingJobTest()
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
        $formattedName = $gapicClient->dataLabelingJobName('[PROJECT]', '[LOCATION]', '[DATA_LABELING_JOB]');
        $request = (new CancelDataLabelingJobRequest())->setName($formattedName);
        $gapicClient->cancelDataLabelingJob($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/CancelDataLabelingJob', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function cancelDataLabelingJobExceptionTest()
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
        $formattedName = $gapicClient->dataLabelingJobName('[PROJECT]', '[LOCATION]', '[DATA_LABELING_JOB]');
        $request = (new CancelDataLabelingJobRequest())->setName($formattedName);
        try {
            $gapicClient->cancelDataLabelingJob($request);
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
    public function cancelHyperparameterTuningJobTest()
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
        $formattedName = $gapicClient->hyperparameterTuningJobName(
            '[PROJECT]',
            '[LOCATION]',
            '[HYPERPARAMETER_TUNING_JOB]'
        );
        $request = (new CancelHyperparameterTuningJobRequest())->setName($formattedName);
        $gapicClient->cancelHyperparameterTuningJob($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/CancelHyperparameterTuningJob', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function cancelHyperparameterTuningJobExceptionTest()
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
        $formattedName = $gapicClient->hyperparameterTuningJobName(
            '[PROJECT]',
            '[LOCATION]',
            '[HYPERPARAMETER_TUNING_JOB]'
        );
        $request = (new CancelHyperparameterTuningJobRequest())->setName($formattedName);
        try {
            $gapicClient->cancelHyperparameterTuningJob($request);
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
    public function cancelNasJobTest()
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
        $formattedName = $gapicClient->nasJobName('[PROJECT]', '[LOCATION]', '[NAS_JOB]');
        $request = (new CancelNasJobRequest())->setName($formattedName);
        $gapicClient->cancelNasJob($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/CancelNasJob', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function cancelNasJobExceptionTest()
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
        $formattedName = $gapicClient->nasJobName('[PROJECT]', '[LOCATION]', '[NAS_JOB]');
        $request = (new CancelNasJobRequest())->setName($formattedName);
        try {
            $gapicClient->cancelNasJob($request);
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
    public function createBatchPredictionJobTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $model = 'model104069929';
        $modelVersionId = 'modelVersionId-1385431880';
        $serviceAccount = 'serviceAccount-1948028253';
        $generateExplanation = false;
        $disableContainerLogging = true;
        $expectedResponse = new BatchPredictionJob();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setModel($model);
        $expectedResponse->setModelVersionId($modelVersionId);
        $expectedResponse->setServiceAccount($serviceAccount);
        $expectedResponse->setGenerateExplanation($generateExplanation);
        $expectedResponse->setDisableContainerLogging($disableContainerLogging);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $batchPredictionJob = new BatchPredictionJob();
        $batchPredictionJobDisplayName = 'batchPredictionJobDisplayName-916867527';
        $batchPredictionJob->setDisplayName($batchPredictionJobDisplayName);
        $batchPredictionJobInputConfig = new InputConfig();
        $inputConfigInstancesFormat = 'inputConfigInstancesFormat883633865';
        $batchPredictionJobInputConfig->setInstancesFormat($inputConfigInstancesFormat);
        $batchPredictionJob->setInputConfig($batchPredictionJobInputConfig);
        $batchPredictionJobOutputConfig = new OutputConfig();
        $outputConfigPredictionsFormat = 'outputConfigPredictionsFormat999432568';
        $batchPredictionJobOutputConfig->setPredictionsFormat($outputConfigPredictionsFormat);
        $batchPredictionJob->setOutputConfig($batchPredictionJobOutputConfig);
        $request = (new CreateBatchPredictionJobRequest())
            ->setParent($formattedParent)
            ->setBatchPredictionJob($batchPredictionJob);
        $response = $gapicClient->createBatchPredictionJob($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/CreateBatchPredictionJob', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getBatchPredictionJob();
        $this->assertProtobufEquals($batchPredictionJob, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createBatchPredictionJobExceptionTest()
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
        $batchPredictionJob = new BatchPredictionJob();
        $batchPredictionJobDisplayName = 'batchPredictionJobDisplayName-916867527';
        $batchPredictionJob->setDisplayName($batchPredictionJobDisplayName);
        $batchPredictionJobInputConfig = new InputConfig();
        $inputConfigInstancesFormat = 'inputConfigInstancesFormat883633865';
        $batchPredictionJobInputConfig->setInstancesFormat($inputConfigInstancesFormat);
        $batchPredictionJob->setInputConfig($batchPredictionJobInputConfig);
        $batchPredictionJobOutputConfig = new OutputConfig();
        $outputConfigPredictionsFormat = 'outputConfigPredictionsFormat999432568';
        $batchPredictionJobOutputConfig->setPredictionsFormat($outputConfigPredictionsFormat);
        $batchPredictionJob->setOutputConfig($batchPredictionJobOutputConfig);
        $request = (new CreateBatchPredictionJobRequest())
            ->setParent($formattedParent)
            ->setBatchPredictionJob($batchPredictionJob);
        try {
            $gapicClient->createBatchPredictionJob($request);
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
    public function createCustomJobTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $expectedResponse = new CustomJob();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $customJob = new CustomJob();
        $customJobDisplayName = 'customJobDisplayName-299624383';
        $customJob->setDisplayName($customJobDisplayName);
        $customJobJobSpec = new CustomJobSpec();
        $jobSpecWorkerPoolSpecs = [];
        $customJobJobSpec->setWorkerPoolSpecs($jobSpecWorkerPoolSpecs);
        $customJob->setJobSpec($customJobJobSpec);
        $request = (new CreateCustomJobRequest())->setParent($formattedParent)->setCustomJob($customJob);
        $response = $gapicClient->createCustomJob($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/CreateCustomJob', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getCustomJob();
        $this->assertProtobufEquals($customJob, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createCustomJobExceptionTest()
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
        $customJob = new CustomJob();
        $customJobDisplayName = 'customJobDisplayName-299624383';
        $customJob->setDisplayName($customJobDisplayName);
        $customJobJobSpec = new CustomJobSpec();
        $jobSpecWorkerPoolSpecs = [];
        $customJobJobSpec->setWorkerPoolSpecs($jobSpecWorkerPoolSpecs);
        $customJob->setJobSpec($customJobJobSpec);
        $request = (new CreateCustomJobRequest())->setParent($formattedParent)->setCustomJob($customJob);
        try {
            $gapicClient->createCustomJob($request);
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
    public function createDataLabelingJobTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $labelerCount = 1457777167;
        $instructionUri = 'instructionUri1537272379';
        $inputsSchemaUri = 'inputsSchemaUri990382564';
        $labelingProgress = 685978914;
        $expectedResponse = new DataLabelingJob();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setLabelerCount($labelerCount);
        $expectedResponse->setInstructionUri($instructionUri);
        $expectedResponse->setInputsSchemaUri($inputsSchemaUri);
        $expectedResponse->setLabelingProgress($labelingProgress);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $dataLabelingJob = new DataLabelingJob();
        $dataLabelingJobDisplayName = 'dataLabelingJobDisplayName708178632';
        $dataLabelingJob->setDisplayName($dataLabelingJobDisplayName);
        $dataLabelingJobDatasets = [$gapicClient->datasetName('[PROJECT]', '[LOCATION]', '[DATASET]')];
        $dataLabelingJob->setDatasets($dataLabelingJobDatasets);
        $dataLabelingJobLabelerCount = 500093453;
        $dataLabelingJob->setLabelerCount($dataLabelingJobLabelerCount);
        $dataLabelingJobInstructionUri = 'dataLabelingJobInstructionUri-886362173';
        $dataLabelingJob->setInstructionUri($dataLabelingJobInstructionUri);
        $dataLabelingJobInputsSchemaUri = 'dataLabelingJobInputsSchemaUri-1486933251';
        $dataLabelingJob->setInputsSchemaUri($dataLabelingJobInputsSchemaUri);
        $dataLabelingJobInputs = new Value();
        $dataLabelingJob->setInputs($dataLabelingJobInputs);
        $request = (new CreateDataLabelingJobRequest())
            ->setParent($formattedParent)
            ->setDataLabelingJob($dataLabelingJob);
        $response = $gapicClient->createDataLabelingJob($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/CreateDataLabelingJob', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getDataLabelingJob();
        $this->assertProtobufEquals($dataLabelingJob, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createDataLabelingJobExceptionTest()
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
        $dataLabelingJob = new DataLabelingJob();
        $dataLabelingJobDisplayName = 'dataLabelingJobDisplayName708178632';
        $dataLabelingJob->setDisplayName($dataLabelingJobDisplayName);
        $dataLabelingJobDatasets = [$gapicClient->datasetName('[PROJECT]', '[LOCATION]', '[DATASET]')];
        $dataLabelingJob->setDatasets($dataLabelingJobDatasets);
        $dataLabelingJobLabelerCount = 500093453;
        $dataLabelingJob->setLabelerCount($dataLabelingJobLabelerCount);
        $dataLabelingJobInstructionUri = 'dataLabelingJobInstructionUri-886362173';
        $dataLabelingJob->setInstructionUri($dataLabelingJobInstructionUri);
        $dataLabelingJobInputsSchemaUri = 'dataLabelingJobInputsSchemaUri-1486933251';
        $dataLabelingJob->setInputsSchemaUri($dataLabelingJobInputsSchemaUri);
        $dataLabelingJobInputs = new Value();
        $dataLabelingJob->setInputs($dataLabelingJobInputs);
        $request = (new CreateDataLabelingJobRequest())
            ->setParent($formattedParent)
            ->setDataLabelingJob($dataLabelingJob);
        try {
            $gapicClient->createDataLabelingJob($request);
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
    public function createHyperparameterTuningJobTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $maxTrialCount = 445994933;
        $parallelTrialCount = 1813795950;
        $maxFailedTrialCount = 887662497;
        $expectedResponse = new HyperparameterTuningJob();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setMaxTrialCount($maxTrialCount);
        $expectedResponse->setParallelTrialCount($parallelTrialCount);
        $expectedResponse->setMaxFailedTrialCount($maxFailedTrialCount);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $hyperparameterTuningJob = new HyperparameterTuningJob();
        $hyperparameterTuningJobDisplayName = 'hyperparameterTuningJobDisplayName279209698';
        $hyperparameterTuningJob->setDisplayName($hyperparameterTuningJobDisplayName);
        $hyperparameterTuningJobStudySpec = new StudySpec();
        $studySpecMetrics = [];
        $hyperparameterTuningJobStudySpec->setMetrics($studySpecMetrics);
        $studySpecParameters = [];
        $hyperparameterTuningJobStudySpec->setParameters($studySpecParameters);
        $hyperparameterTuningJob->setStudySpec($hyperparameterTuningJobStudySpec);
        $hyperparameterTuningJobMaxTrialCount = 1019368622;
        $hyperparameterTuningJob->setMaxTrialCount($hyperparameterTuningJobMaxTrialCount);
        $hyperparameterTuningJobParallelTrialCount = 1531269397;
        $hyperparameterTuningJob->setParallelTrialCount($hyperparameterTuningJobParallelTrialCount);
        $hyperparameterTuningJobTrialJobSpec = new CustomJobSpec();
        $trialJobSpecWorkerPoolSpecs = [];
        $hyperparameterTuningJobTrialJobSpec->setWorkerPoolSpecs($trialJobSpecWorkerPoolSpecs);
        $hyperparameterTuningJob->setTrialJobSpec($hyperparameterTuningJobTrialJobSpec);
        $request = (new CreateHyperparameterTuningJobRequest())
            ->setParent($formattedParent)
            ->setHyperparameterTuningJob($hyperparameterTuningJob);
        $response = $gapicClient->createHyperparameterTuningJob($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/CreateHyperparameterTuningJob', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getHyperparameterTuningJob();
        $this->assertProtobufEquals($hyperparameterTuningJob, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createHyperparameterTuningJobExceptionTest()
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
        $hyperparameterTuningJob = new HyperparameterTuningJob();
        $hyperparameterTuningJobDisplayName = 'hyperparameterTuningJobDisplayName279209698';
        $hyperparameterTuningJob->setDisplayName($hyperparameterTuningJobDisplayName);
        $hyperparameterTuningJobStudySpec = new StudySpec();
        $studySpecMetrics = [];
        $hyperparameterTuningJobStudySpec->setMetrics($studySpecMetrics);
        $studySpecParameters = [];
        $hyperparameterTuningJobStudySpec->setParameters($studySpecParameters);
        $hyperparameterTuningJob->setStudySpec($hyperparameterTuningJobStudySpec);
        $hyperparameterTuningJobMaxTrialCount = 1019368622;
        $hyperparameterTuningJob->setMaxTrialCount($hyperparameterTuningJobMaxTrialCount);
        $hyperparameterTuningJobParallelTrialCount = 1531269397;
        $hyperparameterTuningJob->setParallelTrialCount($hyperparameterTuningJobParallelTrialCount);
        $hyperparameterTuningJobTrialJobSpec = new CustomJobSpec();
        $trialJobSpecWorkerPoolSpecs = [];
        $hyperparameterTuningJobTrialJobSpec->setWorkerPoolSpecs($trialJobSpecWorkerPoolSpecs);
        $hyperparameterTuningJob->setTrialJobSpec($hyperparameterTuningJobTrialJobSpec);
        $request = (new CreateHyperparameterTuningJobRequest())
            ->setParent($formattedParent)
            ->setHyperparameterTuningJob($hyperparameterTuningJob);
        try {
            $gapicClient->createHyperparameterTuningJob($request);
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
    public function createModelDeploymentMonitoringJobTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $endpoint = 'endpoint1741102485';
        $predictInstanceSchemaUri = 'predictInstanceSchemaUri1705398098';
        $analysisInstanceSchemaUri = 'analysisInstanceSchemaUri1555410389';
        $enableMonitoringPipelineLogs = false;
        $expectedResponse = new ModelDeploymentMonitoringJob();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setEndpoint($endpoint);
        $expectedResponse->setPredictInstanceSchemaUri($predictInstanceSchemaUri);
        $expectedResponse->setAnalysisInstanceSchemaUri($analysisInstanceSchemaUri);
        $expectedResponse->setEnableMonitoringPipelineLogs($enableMonitoringPipelineLogs);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $modelDeploymentMonitoringJob = new ModelDeploymentMonitoringJob();
        $modelDeploymentMonitoringJobDisplayName = 'modelDeploymentMonitoringJobDisplayName-563611194';
        $modelDeploymentMonitoringJob->setDisplayName($modelDeploymentMonitoringJobDisplayName);
        $modelDeploymentMonitoringJobEndpoint = $gapicClient->endpointName('[PROJECT]', '[LOCATION]', '[ENDPOINT]');
        $modelDeploymentMonitoringJob->setEndpoint($modelDeploymentMonitoringJobEndpoint);
        $modelDeploymentMonitoringJobModelDeploymentMonitoringObjectiveConfigs = [];
        $modelDeploymentMonitoringJob->setModelDeploymentMonitoringObjectiveConfigs(
            $modelDeploymentMonitoringJobModelDeploymentMonitoringObjectiveConfigs
        );
        $modelDeploymentMonitoringJobModelDeploymentMonitoringScheduleConfig = new ModelDeploymentMonitoringScheduleConfig();
        $modelDeploymentMonitoringScheduleConfigMonitorInterval = new Duration();
        $modelDeploymentMonitoringJobModelDeploymentMonitoringScheduleConfig->setMonitorInterval(
            $modelDeploymentMonitoringScheduleConfigMonitorInterval
        );
        $modelDeploymentMonitoringJob->setModelDeploymentMonitoringScheduleConfig(
            $modelDeploymentMonitoringJobModelDeploymentMonitoringScheduleConfig
        );
        $modelDeploymentMonitoringJobLoggingSamplingStrategy = new SamplingStrategy();
        $modelDeploymentMonitoringJob->setLoggingSamplingStrategy($modelDeploymentMonitoringJobLoggingSamplingStrategy);
        $request = (new CreateModelDeploymentMonitoringJobRequest())
            ->setParent($formattedParent)
            ->setModelDeploymentMonitoringJob($modelDeploymentMonitoringJob);
        $response = $gapicClient->createModelDeploymentMonitoringJob($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/CreateModelDeploymentMonitoringJob', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getModelDeploymentMonitoringJob();
        $this->assertProtobufEquals($modelDeploymentMonitoringJob, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createModelDeploymentMonitoringJobExceptionTest()
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
        $modelDeploymentMonitoringJob = new ModelDeploymentMonitoringJob();
        $modelDeploymentMonitoringJobDisplayName = 'modelDeploymentMonitoringJobDisplayName-563611194';
        $modelDeploymentMonitoringJob->setDisplayName($modelDeploymentMonitoringJobDisplayName);
        $modelDeploymentMonitoringJobEndpoint = $gapicClient->endpointName('[PROJECT]', '[LOCATION]', '[ENDPOINT]');
        $modelDeploymentMonitoringJob->setEndpoint($modelDeploymentMonitoringJobEndpoint);
        $modelDeploymentMonitoringJobModelDeploymentMonitoringObjectiveConfigs = [];
        $modelDeploymentMonitoringJob->setModelDeploymentMonitoringObjectiveConfigs(
            $modelDeploymentMonitoringJobModelDeploymentMonitoringObjectiveConfigs
        );
        $modelDeploymentMonitoringJobModelDeploymentMonitoringScheduleConfig = new ModelDeploymentMonitoringScheduleConfig();
        $modelDeploymentMonitoringScheduleConfigMonitorInterval = new Duration();
        $modelDeploymentMonitoringJobModelDeploymentMonitoringScheduleConfig->setMonitorInterval(
            $modelDeploymentMonitoringScheduleConfigMonitorInterval
        );
        $modelDeploymentMonitoringJob->setModelDeploymentMonitoringScheduleConfig(
            $modelDeploymentMonitoringJobModelDeploymentMonitoringScheduleConfig
        );
        $modelDeploymentMonitoringJobLoggingSamplingStrategy = new SamplingStrategy();
        $modelDeploymentMonitoringJob->setLoggingSamplingStrategy($modelDeploymentMonitoringJobLoggingSamplingStrategy);
        $request = (new CreateModelDeploymentMonitoringJobRequest())
            ->setParent($formattedParent)
            ->setModelDeploymentMonitoringJob($modelDeploymentMonitoringJob);
        try {
            $gapicClient->createModelDeploymentMonitoringJob($request);
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
    public function createNasJobTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $enableRestrictedImageTraining = true;
        $expectedResponse = new NasJob();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setEnableRestrictedImageTraining($enableRestrictedImageTraining);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $nasJob = new NasJob();
        $nasJobDisplayName = 'nasJobDisplayName-279570512';
        $nasJob->setDisplayName($nasJobDisplayName);
        $nasJobNasJobSpec = new NasJobSpec();
        $nasJob->setNasJobSpec($nasJobNasJobSpec);
        $request = (new CreateNasJobRequest())->setParent($formattedParent)->setNasJob($nasJob);
        $response = $gapicClient->createNasJob($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/CreateNasJob', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNasJob();
        $this->assertProtobufEquals($nasJob, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createNasJobExceptionTest()
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
        $nasJob = new NasJob();
        $nasJobDisplayName = 'nasJobDisplayName-279570512';
        $nasJob->setDisplayName($nasJobDisplayName);
        $nasJobNasJobSpec = new NasJobSpec();
        $nasJob->setNasJobSpec($nasJobNasJobSpec);
        $request = (new CreateNasJobRequest())->setParent($formattedParent)->setNasJob($nasJob);
        try {
            $gapicClient->createNasJob($request);
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
    public function deleteBatchPredictionJobTest()
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
        $incompleteOperation->setName('operations/deleteBatchPredictionJobTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new GPBEmpty();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/deleteBatchPredictionJobTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->batchPredictionJobName('[PROJECT]', '[LOCATION]', '[BATCH_PREDICTION_JOB]');
        $request = (new DeleteBatchPredictionJobRequest())->setName($formattedName);
        $response = $gapicClient->deleteBatchPredictionJob($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/DeleteBatchPredictionJob', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteBatchPredictionJobTest');
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
    public function deleteBatchPredictionJobExceptionTest()
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
        $incompleteOperation->setName('operations/deleteBatchPredictionJobTest');
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
        $formattedName = $gapicClient->batchPredictionJobName('[PROJECT]', '[LOCATION]', '[BATCH_PREDICTION_JOB]');
        $request = (new DeleteBatchPredictionJobRequest())->setName($formattedName);
        $response = $gapicClient->deleteBatchPredictionJob($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteBatchPredictionJobTest');
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
    public function deleteCustomJobTest()
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
        $incompleteOperation->setName('operations/deleteCustomJobTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new GPBEmpty();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/deleteCustomJobTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->customJobName('[PROJECT]', '[LOCATION]', '[CUSTOM_JOB]');
        $request = (new DeleteCustomJobRequest())->setName($formattedName);
        $response = $gapicClient->deleteCustomJob($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/DeleteCustomJob', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteCustomJobTest');
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
    public function deleteCustomJobExceptionTest()
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
        $incompleteOperation->setName('operations/deleteCustomJobTest');
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
        $formattedName = $gapicClient->customJobName('[PROJECT]', '[LOCATION]', '[CUSTOM_JOB]');
        $request = (new DeleteCustomJobRequest())->setName($formattedName);
        $response = $gapicClient->deleteCustomJob($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteCustomJobTest');
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
    public function deleteDataLabelingJobTest()
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
        $incompleteOperation->setName('operations/deleteDataLabelingJobTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new GPBEmpty();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/deleteDataLabelingJobTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->dataLabelingJobName('[PROJECT]', '[LOCATION]', '[DATA_LABELING_JOB]');
        $request = (new DeleteDataLabelingJobRequest())->setName($formattedName);
        $response = $gapicClient->deleteDataLabelingJob($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/DeleteDataLabelingJob', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteDataLabelingJobTest');
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
    public function deleteDataLabelingJobExceptionTest()
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
        $incompleteOperation->setName('operations/deleteDataLabelingJobTest');
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
        $formattedName = $gapicClient->dataLabelingJobName('[PROJECT]', '[LOCATION]', '[DATA_LABELING_JOB]');
        $request = (new DeleteDataLabelingJobRequest())->setName($formattedName);
        $response = $gapicClient->deleteDataLabelingJob($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteDataLabelingJobTest');
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
    public function deleteHyperparameterTuningJobTest()
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
        $incompleteOperation->setName('operations/deleteHyperparameterTuningJobTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new GPBEmpty();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/deleteHyperparameterTuningJobTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->hyperparameterTuningJobName(
            '[PROJECT]',
            '[LOCATION]',
            '[HYPERPARAMETER_TUNING_JOB]'
        );
        $request = (new DeleteHyperparameterTuningJobRequest())->setName($formattedName);
        $response = $gapicClient->deleteHyperparameterTuningJob($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/DeleteHyperparameterTuningJob', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteHyperparameterTuningJobTest');
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
    public function deleteHyperparameterTuningJobExceptionTest()
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
        $incompleteOperation->setName('operations/deleteHyperparameterTuningJobTest');
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
        $formattedName = $gapicClient->hyperparameterTuningJobName(
            '[PROJECT]',
            '[LOCATION]',
            '[HYPERPARAMETER_TUNING_JOB]'
        );
        $request = (new DeleteHyperparameterTuningJobRequest())->setName($formattedName);
        $response = $gapicClient->deleteHyperparameterTuningJob($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteHyperparameterTuningJobTest');
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
    public function deleteModelDeploymentMonitoringJobTest()
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
        $incompleteOperation->setName('operations/deleteModelDeploymentMonitoringJobTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new GPBEmpty();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/deleteModelDeploymentMonitoringJobTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->modelDeploymentMonitoringJobName(
            '[PROJECT]',
            '[LOCATION]',
            '[MODEL_DEPLOYMENT_MONITORING_JOB]'
        );
        $request = (new DeleteModelDeploymentMonitoringJobRequest())->setName($formattedName);
        $response = $gapicClient->deleteModelDeploymentMonitoringJob($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.aiplatform.v1.JobService/DeleteModelDeploymentMonitoringJob',
            $actualApiFuncCall
        );
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteModelDeploymentMonitoringJobTest');
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
    public function deleteModelDeploymentMonitoringJobExceptionTest()
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
        $incompleteOperation->setName('operations/deleteModelDeploymentMonitoringJobTest');
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
        $formattedName = $gapicClient->modelDeploymentMonitoringJobName(
            '[PROJECT]',
            '[LOCATION]',
            '[MODEL_DEPLOYMENT_MONITORING_JOB]'
        );
        $request = (new DeleteModelDeploymentMonitoringJobRequest())->setName($formattedName);
        $response = $gapicClient->deleteModelDeploymentMonitoringJob($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteModelDeploymentMonitoringJobTest');
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
    public function deleteNasJobTest()
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
        $incompleteOperation->setName('operations/deleteNasJobTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new GPBEmpty();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/deleteNasJobTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->nasJobName('[PROJECT]', '[LOCATION]', '[NAS_JOB]');
        $request = (new DeleteNasJobRequest())->setName($formattedName);
        $response = $gapicClient->deleteNasJob($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/DeleteNasJob', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteNasJobTest');
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
    public function deleteNasJobExceptionTest()
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
        $incompleteOperation->setName('operations/deleteNasJobTest');
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
        $formattedName = $gapicClient->nasJobName('[PROJECT]', '[LOCATION]', '[NAS_JOB]');
        $request = (new DeleteNasJobRequest())->setName($formattedName);
        $response = $gapicClient->deleteNasJob($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteNasJobTest');
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
    public function getBatchPredictionJobTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $model = 'model104069929';
        $modelVersionId = 'modelVersionId-1385431880';
        $serviceAccount = 'serviceAccount-1948028253';
        $generateExplanation = false;
        $disableContainerLogging = true;
        $expectedResponse = new BatchPredictionJob();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setModel($model);
        $expectedResponse->setModelVersionId($modelVersionId);
        $expectedResponse->setServiceAccount($serviceAccount);
        $expectedResponse->setGenerateExplanation($generateExplanation);
        $expectedResponse->setDisableContainerLogging($disableContainerLogging);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->batchPredictionJobName('[PROJECT]', '[LOCATION]', '[BATCH_PREDICTION_JOB]');
        $request = (new GetBatchPredictionJobRequest())->setName($formattedName);
        $response = $gapicClient->getBatchPredictionJob($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/GetBatchPredictionJob', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getBatchPredictionJobExceptionTest()
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
        $formattedName = $gapicClient->batchPredictionJobName('[PROJECT]', '[LOCATION]', '[BATCH_PREDICTION_JOB]');
        $request = (new GetBatchPredictionJobRequest())->setName($formattedName);
        try {
            $gapicClient->getBatchPredictionJob($request);
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
    public function getCustomJobTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $expectedResponse = new CustomJob();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->customJobName('[PROJECT]', '[LOCATION]', '[CUSTOM_JOB]');
        $request = (new GetCustomJobRequest())->setName($formattedName);
        $response = $gapicClient->getCustomJob($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/GetCustomJob', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getCustomJobExceptionTest()
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
        $formattedName = $gapicClient->customJobName('[PROJECT]', '[LOCATION]', '[CUSTOM_JOB]');
        $request = (new GetCustomJobRequest())->setName($formattedName);
        try {
            $gapicClient->getCustomJob($request);
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
    public function getDataLabelingJobTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $labelerCount = 1457777167;
        $instructionUri = 'instructionUri1537272379';
        $inputsSchemaUri = 'inputsSchemaUri990382564';
        $labelingProgress = 685978914;
        $expectedResponse = new DataLabelingJob();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setLabelerCount($labelerCount);
        $expectedResponse->setInstructionUri($instructionUri);
        $expectedResponse->setInputsSchemaUri($inputsSchemaUri);
        $expectedResponse->setLabelingProgress($labelingProgress);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->dataLabelingJobName('[PROJECT]', '[LOCATION]', '[DATA_LABELING_JOB]');
        $request = (new GetDataLabelingJobRequest())->setName($formattedName);
        $response = $gapicClient->getDataLabelingJob($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/GetDataLabelingJob', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getDataLabelingJobExceptionTest()
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
        $formattedName = $gapicClient->dataLabelingJobName('[PROJECT]', '[LOCATION]', '[DATA_LABELING_JOB]');
        $request = (new GetDataLabelingJobRequest())->setName($formattedName);
        try {
            $gapicClient->getDataLabelingJob($request);
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
    public function getHyperparameterTuningJobTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $maxTrialCount = 445994933;
        $parallelTrialCount = 1813795950;
        $maxFailedTrialCount = 887662497;
        $expectedResponse = new HyperparameterTuningJob();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setMaxTrialCount($maxTrialCount);
        $expectedResponse->setParallelTrialCount($parallelTrialCount);
        $expectedResponse->setMaxFailedTrialCount($maxFailedTrialCount);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->hyperparameterTuningJobName(
            '[PROJECT]',
            '[LOCATION]',
            '[HYPERPARAMETER_TUNING_JOB]'
        );
        $request = (new GetHyperparameterTuningJobRequest())->setName($formattedName);
        $response = $gapicClient->getHyperparameterTuningJob($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/GetHyperparameterTuningJob', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getHyperparameterTuningJobExceptionTest()
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
        $formattedName = $gapicClient->hyperparameterTuningJobName(
            '[PROJECT]',
            '[LOCATION]',
            '[HYPERPARAMETER_TUNING_JOB]'
        );
        $request = (new GetHyperparameterTuningJobRequest())->setName($formattedName);
        try {
            $gapicClient->getHyperparameterTuningJob($request);
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
    public function getModelDeploymentMonitoringJobTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $endpoint = 'endpoint1741102485';
        $predictInstanceSchemaUri = 'predictInstanceSchemaUri1705398098';
        $analysisInstanceSchemaUri = 'analysisInstanceSchemaUri1555410389';
        $enableMonitoringPipelineLogs = false;
        $expectedResponse = new ModelDeploymentMonitoringJob();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setEndpoint($endpoint);
        $expectedResponse->setPredictInstanceSchemaUri($predictInstanceSchemaUri);
        $expectedResponse->setAnalysisInstanceSchemaUri($analysisInstanceSchemaUri);
        $expectedResponse->setEnableMonitoringPipelineLogs($enableMonitoringPipelineLogs);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->modelDeploymentMonitoringJobName(
            '[PROJECT]',
            '[LOCATION]',
            '[MODEL_DEPLOYMENT_MONITORING_JOB]'
        );
        $request = (new GetModelDeploymentMonitoringJobRequest())->setName($formattedName);
        $response = $gapicClient->getModelDeploymentMonitoringJob($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/GetModelDeploymentMonitoringJob', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getModelDeploymentMonitoringJobExceptionTest()
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
        $formattedName = $gapicClient->modelDeploymentMonitoringJobName(
            '[PROJECT]',
            '[LOCATION]',
            '[MODEL_DEPLOYMENT_MONITORING_JOB]'
        );
        $request = (new GetModelDeploymentMonitoringJobRequest())->setName($formattedName);
        try {
            $gapicClient->getModelDeploymentMonitoringJob($request);
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
    public function getNasJobTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $enableRestrictedImageTraining = true;
        $expectedResponse = new NasJob();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setEnableRestrictedImageTraining($enableRestrictedImageTraining);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->nasJobName('[PROJECT]', '[LOCATION]', '[NAS_JOB]');
        $request = (new GetNasJobRequest())->setName($formattedName);
        $response = $gapicClient->getNasJob($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/GetNasJob', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getNasJobExceptionTest()
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
        $formattedName = $gapicClient->nasJobName('[PROJECT]', '[LOCATION]', '[NAS_JOB]');
        $request = (new GetNasJobRequest())->setName($formattedName);
        try {
            $gapicClient->getNasJob($request);
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
    public function getNasTrialDetailTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $parameters = 'parameters458736106';
        $expectedResponse = new NasTrialDetail();
        $expectedResponse->setName($name2);
        $expectedResponse->setParameters($parameters);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->nasTrialDetailName('[PROJECT]', '[LOCATION]', '[NAS_JOB]', '[NAS_TRIAL_DETAIL]');
        $request = (new GetNasTrialDetailRequest())->setName($formattedName);
        $response = $gapicClient->getNasTrialDetail($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/GetNasTrialDetail', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getNasTrialDetailExceptionTest()
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
        $formattedName = $gapicClient->nasTrialDetailName('[PROJECT]', '[LOCATION]', '[NAS_JOB]', '[NAS_TRIAL_DETAIL]');
        $request = (new GetNasTrialDetailRequest())->setName($formattedName);
        try {
            $gapicClient->getNasTrialDetail($request);
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
    public function listBatchPredictionJobsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $batchPredictionJobsElement = new BatchPredictionJob();
        $batchPredictionJobs = [$batchPredictionJobsElement];
        $expectedResponse = new ListBatchPredictionJobsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setBatchPredictionJobs($batchPredictionJobs);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListBatchPredictionJobsRequest())->setParent($formattedParent);
        $response = $gapicClient->listBatchPredictionJobs($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getBatchPredictionJobs()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/ListBatchPredictionJobs', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listBatchPredictionJobsExceptionTest()
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
        $request = (new ListBatchPredictionJobsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listBatchPredictionJobs($request);
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
    public function listCustomJobsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $customJobsElement = new CustomJob();
        $customJobs = [$customJobsElement];
        $expectedResponse = new ListCustomJobsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setCustomJobs($customJobs);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListCustomJobsRequest())->setParent($formattedParent);
        $response = $gapicClient->listCustomJobs($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCustomJobs()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/ListCustomJobs', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listCustomJobsExceptionTest()
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
        $request = (new ListCustomJobsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listCustomJobs($request);
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
    public function listDataLabelingJobsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $dataLabelingJobsElement = new DataLabelingJob();
        $dataLabelingJobs = [$dataLabelingJobsElement];
        $expectedResponse = new ListDataLabelingJobsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setDataLabelingJobs($dataLabelingJobs);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListDataLabelingJobsRequest())->setParent($formattedParent);
        $response = $gapicClient->listDataLabelingJobs($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getDataLabelingJobs()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/ListDataLabelingJobs', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listDataLabelingJobsExceptionTest()
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
        $request = (new ListDataLabelingJobsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listDataLabelingJobs($request);
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
    public function listHyperparameterTuningJobsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $hyperparameterTuningJobsElement = new HyperparameterTuningJob();
        $hyperparameterTuningJobs = [$hyperparameterTuningJobsElement];
        $expectedResponse = new ListHyperparameterTuningJobsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setHyperparameterTuningJobs($hyperparameterTuningJobs);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListHyperparameterTuningJobsRequest())->setParent($formattedParent);
        $response = $gapicClient->listHyperparameterTuningJobs($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getHyperparameterTuningJobs()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/ListHyperparameterTuningJobs', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listHyperparameterTuningJobsExceptionTest()
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
        $request = (new ListHyperparameterTuningJobsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listHyperparameterTuningJobs($request);
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
    public function listModelDeploymentMonitoringJobsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $modelDeploymentMonitoringJobsElement = new ModelDeploymentMonitoringJob();
        $modelDeploymentMonitoringJobs = [$modelDeploymentMonitoringJobsElement];
        $expectedResponse = new ListModelDeploymentMonitoringJobsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setModelDeploymentMonitoringJobs($modelDeploymentMonitoringJobs);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListModelDeploymentMonitoringJobsRequest())->setParent($formattedParent);
        $response = $gapicClient->listModelDeploymentMonitoringJobs($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getModelDeploymentMonitoringJobs()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/ListModelDeploymentMonitoringJobs', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listModelDeploymentMonitoringJobsExceptionTest()
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
        $request = (new ListModelDeploymentMonitoringJobsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listModelDeploymentMonitoringJobs($request);
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
    public function listNasJobsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $nasJobsElement = new NasJob();
        $nasJobs = [$nasJobsElement];
        $expectedResponse = new ListNasJobsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setNasJobs($nasJobs);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListNasJobsRequest())->setParent($formattedParent);
        $response = $gapicClient->listNasJobs($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getNasJobs()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/ListNasJobs', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listNasJobsExceptionTest()
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
        $request = (new ListNasJobsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listNasJobs($request);
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
    public function listNasTrialDetailsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $nasTrialDetailsElement = new NasTrialDetail();
        $nasTrialDetails = [$nasTrialDetailsElement];
        $expectedResponse = new ListNasTrialDetailsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setNasTrialDetails($nasTrialDetails);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->nasJobName('[PROJECT]', '[LOCATION]', '[NAS_JOB]');
        $request = (new ListNasTrialDetailsRequest())->setParent($formattedParent);
        $response = $gapicClient->listNasTrialDetails($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getNasTrialDetails()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/ListNasTrialDetails', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listNasTrialDetailsExceptionTest()
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
        $formattedParent = $gapicClient->nasJobName('[PROJECT]', '[LOCATION]', '[NAS_JOB]');
        $request = (new ListNasTrialDetailsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listNasTrialDetails($request);
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
    public function pauseModelDeploymentMonitoringJobTest()
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
        $formattedName = $gapicClient->modelDeploymentMonitoringJobName(
            '[PROJECT]',
            '[LOCATION]',
            '[MODEL_DEPLOYMENT_MONITORING_JOB]'
        );
        $request = (new PauseModelDeploymentMonitoringJobRequest())->setName($formattedName);
        $gapicClient->pauseModelDeploymentMonitoringJob($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/PauseModelDeploymentMonitoringJob', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function pauseModelDeploymentMonitoringJobExceptionTest()
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
        $formattedName = $gapicClient->modelDeploymentMonitoringJobName(
            '[PROJECT]',
            '[LOCATION]',
            '[MODEL_DEPLOYMENT_MONITORING_JOB]'
        );
        $request = (new PauseModelDeploymentMonitoringJobRequest())->setName($formattedName);
        try {
            $gapicClient->pauseModelDeploymentMonitoringJob($request);
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
    public function resumeModelDeploymentMonitoringJobTest()
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
        $formattedName = $gapicClient->modelDeploymentMonitoringJobName(
            '[PROJECT]',
            '[LOCATION]',
            '[MODEL_DEPLOYMENT_MONITORING_JOB]'
        );
        $request = (new ResumeModelDeploymentMonitoringJobRequest())->setName($formattedName);
        $gapicClient->resumeModelDeploymentMonitoringJob($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/ResumeModelDeploymentMonitoringJob', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function resumeModelDeploymentMonitoringJobExceptionTest()
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
        $formattedName = $gapicClient->modelDeploymentMonitoringJobName(
            '[PROJECT]',
            '[LOCATION]',
            '[MODEL_DEPLOYMENT_MONITORING_JOB]'
        );
        $request = (new ResumeModelDeploymentMonitoringJobRequest())->setName($formattedName);
        try {
            $gapicClient->resumeModelDeploymentMonitoringJob($request);
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
    public function searchModelDeploymentMonitoringStatsAnomaliesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $monitoringStatsElement = new ModelMonitoringStatsAnomalies();
        $monitoringStats = [$monitoringStatsElement];
        $expectedResponse = new SearchModelDeploymentMonitoringStatsAnomaliesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setMonitoringStats($monitoringStats);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedModelDeploymentMonitoringJob = $gapicClient->modelDeploymentMonitoringJobName(
            '[PROJECT]',
            '[LOCATION]',
            '[MODEL_DEPLOYMENT_MONITORING_JOB]'
        );
        $deployedModelId = 'deployedModelId866642506';
        $objectives = [];
        $request = (new SearchModelDeploymentMonitoringStatsAnomaliesRequest())
            ->setModelDeploymentMonitoringJob($formattedModelDeploymentMonitoringJob)
            ->setDeployedModelId($deployedModelId)
            ->setObjectives($objectives);
        $response = $gapicClient->searchModelDeploymentMonitoringStatsAnomalies($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getMonitoringStats()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.aiplatform.v1.JobService/SearchModelDeploymentMonitoringStatsAnomalies',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getModelDeploymentMonitoringJob();
        $this->assertProtobufEquals($formattedModelDeploymentMonitoringJob, $actualValue);
        $actualValue = $actualRequestObject->getDeployedModelId();
        $this->assertProtobufEquals($deployedModelId, $actualValue);
        $actualValue = $actualRequestObject->getObjectives();
        $this->assertProtobufEquals($objectives, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function searchModelDeploymentMonitoringStatsAnomaliesExceptionTest()
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
        $formattedModelDeploymentMonitoringJob = $gapicClient->modelDeploymentMonitoringJobName(
            '[PROJECT]',
            '[LOCATION]',
            '[MODEL_DEPLOYMENT_MONITORING_JOB]'
        );
        $deployedModelId = 'deployedModelId866642506';
        $objectives = [];
        $request = (new SearchModelDeploymentMonitoringStatsAnomaliesRequest())
            ->setModelDeploymentMonitoringJob($formattedModelDeploymentMonitoringJob)
            ->setDeployedModelId($deployedModelId)
            ->setObjectives($objectives);
        try {
            $gapicClient->searchModelDeploymentMonitoringStatsAnomalies($request);
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
    public function updateModelDeploymentMonitoringJobTest()
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
        $incompleteOperation->setName('operations/updateModelDeploymentMonitoringJobTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $endpoint = 'endpoint1741102485';
        $predictInstanceSchemaUri = 'predictInstanceSchemaUri1705398098';
        $analysisInstanceSchemaUri = 'analysisInstanceSchemaUri1555410389';
        $enableMonitoringPipelineLogs = false;
        $expectedResponse = new ModelDeploymentMonitoringJob();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setEndpoint($endpoint);
        $expectedResponse->setPredictInstanceSchemaUri($predictInstanceSchemaUri);
        $expectedResponse->setAnalysisInstanceSchemaUri($analysisInstanceSchemaUri);
        $expectedResponse->setEnableMonitoringPipelineLogs($enableMonitoringPipelineLogs);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/updateModelDeploymentMonitoringJobTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $modelDeploymentMonitoringJob = new ModelDeploymentMonitoringJob();
        $modelDeploymentMonitoringJobDisplayName = 'modelDeploymentMonitoringJobDisplayName-563611194';
        $modelDeploymentMonitoringJob->setDisplayName($modelDeploymentMonitoringJobDisplayName);
        $modelDeploymentMonitoringJobEndpoint = $gapicClient->endpointName('[PROJECT]', '[LOCATION]', '[ENDPOINT]');
        $modelDeploymentMonitoringJob->setEndpoint($modelDeploymentMonitoringJobEndpoint);
        $modelDeploymentMonitoringJobModelDeploymentMonitoringObjectiveConfigs = [];
        $modelDeploymentMonitoringJob->setModelDeploymentMonitoringObjectiveConfigs(
            $modelDeploymentMonitoringJobModelDeploymentMonitoringObjectiveConfigs
        );
        $modelDeploymentMonitoringJobModelDeploymentMonitoringScheduleConfig = new ModelDeploymentMonitoringScheduleConfig();
        $modelDeploymentMonitoringScheduleConfigMonitorInterval = new Duration();
        $modelDeploymentMonitoringJobModelDeploymentMonitoringScheduleConfig->setMonitorInterval(
            $modelDeploymentMonitoringScheduleConfigMonitorInterval
        );
        $modelDeploymentMonitoringJob->setModelDeploymentMonitoringScheduleConfig(
            $modelDeploymentMonitoringJobModelDeploymentMonitoringScheduleConfig
        );
        $modelDeploymentMonitoringJobLoggingSamplingStrategy = new SamplingStrategy();
        $modelDeploymentMonitoringJob->setLoggingSamplingStrategy($modelDeploymentMonitoringJobLoggingSamplingStrategy);
        $updateMask = new FieldMask();
        $request = (new UpdateModelDeploymentMonitoringJobRequest())
            ->setModelDeploymentMonitoringJob($modelDeploymentMonitoringJob)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateModelDeploymentMonitoringJob($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.aiplatform.v1.JobService/UpdateModelDeploymentMonitoringJob',
            $actualApiFuncCall
        );
        $actualValue = $actualApiRequestObject->getModelDeploymentMonitoringJob();
        $this->assertProtobufEquals($modelDeploymentMonitoringJob, $actualValue);
        $actualValue = $actualApiRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/updateModelDeploymentMonitoringJobTest');
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
    public function updateModelDeploymentMonitoringJobExceptionTest()
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
        $incompleteOperation->setName('operations/updateModelDeploymentMonitoringJobTest');
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
        $modelDeploymentMonitoringJob = new ModelDeploymentMonitoringJob();
        $modelDeploymentMonitoringJobDisplayName = 'modelDeploymentMonitoringJobDisplayName-563611194';
        $modelDeploymentMonitoringJob->setDisplayName($modelDeploymentMonitoringJobDisplayName);
        $modelDeploymentMonitoringJobEndpoint = $gapicClient->endpointName('[PROJECT]', '[LOCATION]', '[ENDPOINT]');
        $modelDeploymentMonitoringJob->setEndpoint($modelDeploymentMonitoringJobEndpoint);
        $modelDeploymentMonitoringJobModelDeploymentMonitoringObjectiveConfigs = [];
        $modelDeploymentMonitoringJob->setModelDeploymentMonitoringObjectiveConfigs(
            $modelDeploymentMonitoringJobModelDeploymentMonitoringObjectiveConfigs
        );
        $modelDeploymentMonitoringJobModelDeploymentMonitoringScheduleConfig = new ModelDeploymentMonitoringScheduleConfig();
        $modelDeploymentMonitoringScheduleConfigMonitorInterval = new Duration();
        $modelDeploymentMonitoringJobModelDeploymentMonitoringScheduleConfig->setMonitorInterval(
            $modelDeploymentMonitoringScheduleConfigMonitorInterval
        );
        $modelDeploymentMonitoringJob->setModelDeploymentMonitoringScheduleConfig(
            $modelDeploymentMonitoringJobModelDeploymentMonitoringScheduleConfig
        );
        $modelDeploymentMonitoringJobLoggingSamplingStrategy = new SamplingStrategy();
        $modelDeploymentMonitoringJob->setLoggingSamplingStrategy($modelDeploymentMonitoringJobLoggingSamplingStrategy);
        $updateMask = new FieldMask();
        $request = (new UpdateModelDeploymentMonitoringJobRequest())
            ->setModelDeploymentMonitoringJob($modelDeploymentMonitoringJob)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateModelDeploymentMonitoringJob($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/updateModelDeploymentMonitoringJobTest');
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
    public function cancelBatchPredictionJobAsyncTest()
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
        $formattedName = $gapicClient->batchPredictionJobName('[PROJECT]', '[LOCATION]', '[BATCH_PREDICTION_JOB]');
        $request = (new CancelBatchPredictionJobRequest())->setName($formattedName);
        $gapicClient->cancelBatchPredictionJobAsync($request)->wait();
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/CancelBatchPredictionJob', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
