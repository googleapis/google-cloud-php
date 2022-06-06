<?php
/*
 * Copyright 2022 Google LLC
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

namespace Google\Cloud\AIPlatform\Tests\Unit\V1;

use Google\ApiCore\ApiException;

use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\Testing\GeneratedTest;

use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\AIPlatform\V1\BatchPredictionJob;
use Google\Cloud\AIPlatform\V1\BatchPredictionJob\InputConfig;

use Google\Cloud\AIPlatform\V1\BatchPredictionJob\OutputConfig;
use Google\Cloud\AIPlatform\V1\CustomJob;
use Google\Cloud\AIPlatform\V1\CustomJobSpec;
use Google\Cloud\AIPlatform\V1\DataLabelingJob;
use Google\Cloud\AIPlatform\V1\HyperparameterTuningJob;
use Google\Cloud\AIPlatform\V1\JobServiceClient;
use Google\Cloud\AIPlatform\V1\ListBatchPredictionJobsResponse;
use Google\Cloud\AIPlatform\V1\ListCustomJobsResponse;
use Google\Cloud\AIPlatform\V1\ListDataLabelingJobsResponse;
use Google\Cloud\AIPlatform\V1\ListHyperparameterTuningJobsResponse;
use Google\Cloud\AIPlatform\V1\ListModelDeploymentMonitoringJobsResponse;
use Google\Cloud\AIPlatform\V1\ModelDeploymentMonitoringJob;
use Google\Cloud\AIPlatform\V1\ModelDeploymentMonitoringScheduleConfig;
use Google\Cloud\AIPlatform\V1\ModelMonitoringStatsAnomalies;
use Google\Cloud\AIPlatform\V1\SamplingStrategy;
use Google\Cloud\AIPlatform\V1\SearchModelDeploymentMonitoringStatsAnomaliesResponse;
use Google\Cloud\AIPlatform\V1\StudySpec;
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
    /**
     * @return TransportInterface
     */
    private function createTransport($deserialize = null)
    {
        return new MockTransport($deserialize);
    }

    /**
     * @return CredentialsWrapper
     */
    private function createCredentials()
    {
        return $this->getMockBuilder(CredentialsWrapper::class)->disableOriginalConstructor()->getMock();
    }

    /**
     * @return JobServiceClient
     */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new JobServiceClient($options);
    }

    /**
     * @test
     */
    public function cancelBatchPredictionJobTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $client->batchPredictionJobName('[PROJECT]', '[LOCATION]', '[BATCH_PREDICTION_JOB]');
        $client->cancelBatchPredictionJob($formattedName);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/CancelBatchPredictionJob', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function cancelBatchPredictionJobExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedName = $client->batchPredictionJobName('[PROJECT]', '[LOCATION]', '[BATCH_PREDICTION_JOB]');
        try {
            $client->cancelBatchPredictionJob($formattedName);
            // If the $client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function cancelCustomJobTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $client->customJobName('[PROJECT]', '[LOCATION]', '[CUSTOM_JOB]');
        $client->cancelCustomJob($formattedName);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/CancelCustomJob', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function cancelCustomJobExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedName = $client->customJobName('[PROJECT]', '[LOCATION]', '[CUSTOM_JOB]');
        try {
            $client->cancelCustomJob($formattedName);
            // If the $client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function cancelDataLabelingJobTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $client->dataLabelingJobName('[PROJECT]', '[LOCATION]', '[DATA_LABELING_JOB]');
        $client->cancelDataLabelingJob($formattedName);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/CancelDataLabelingJob', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function cancelDataLabelingJobExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedName = $client->dataLabelingJobName('[PROJECT]', '[LOCATION]', '[DATA_LABELING_JOB]');
        try {
            $client->cancelDataLabelingJob($formattedName);
            // If the $client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function cancelHyperparameterTuningJobTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $client->hyperparameterTuningJobName('[PROJECT]', '[LOCATION]', '[HYPERPARAMETER_TUNING_JOB]');
        $client->cancelHyperparameterTuningJob($formattedName);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/CancelHyperparameterTuningJob', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function cancelHyperparameterTuningJobExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedName = $client->hyperparameterTuningJobName('[PROJECT]', '[LOCATION]', '[HYPERPARAMETER_TUNING_JOB]');
        try {
            $client->cancelHyperparameterTuningJob($formattedName);
            // If the $client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function createBatchPredictionJobTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $model = 'model104069929';
        $generateExplanation = false;
        $expectedResponse = new BatchPredictionJob();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setModel($model);
        $expectedResponse->setGenerateExplanation($generateExplanation);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
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
        $response = $client->createBatchPredictionJob($formattedParent, $batchPredictionJob);
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

    /**
     * @test
     */
    public function createBatchPredictionJobExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
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
        try {
            $client->createBatchPredictionJob($formattedParent, $batchPredictionJob);
            // If the $client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function createCustomJobTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
        $customJob = new CustomJob();
        $customJobDisplayName = 'customJobDisplayName-299624383';
        $customJob->setDisplayName($customJobDisplayName);
        $customJobJobSpec = new CustomJobSpec();
        $jobSpecWorkerPoolSpecs = [];
        $customJobJobSpec->setWorkerPoolSpecs($jobSpecWorkerPoolSpecs);
        $customJob->setJobSpec($customJobJobSpec);
        $response = $client->createCustomJob($formattedParent, $customJob);
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

    /**
     * @test
     */
    public function createCustomJobExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
        $customJob = new CustomJob();
        $customJobDisplayName = 'customJobDisplayName-299624383';
        $customJob->setDisplayName($customJobDisplayName);
        $customJobJobSpec = new CustomJobSpec();
        $jobSpecWorkerPoolSpecs = [];
        $customJobJobSpec->setWorkerPoolSpecs($jobSpecWorkerPoolSpecs);
        $customJob->setJobSpec($customJobJobSpec);
        try {
            $client->createCustomJob($formattedParent, $customJob);
            // If the $client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function createDataLabelingJobTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
        $dataLabelingJob = new DataLabelingJob();
        $dataLabelingJobDisplayName = 'dataLabelingJobDisplayName708178632';
        $dataLabelingJob->setDisplayName($dataLabelingJobDisplayName);
        $dataLabelingJobDatasets = [
            $client->datasetName('[PROJECT]', '[LOCATION]', '[DATASET]'),
        ];
        $dataLabelingJob->setDatasets($dataLabelingJobDatasets);
        $dataLabelingJobLabelerCount = 500093453;
        $dataLabelingJob->setLabelerCount($dataLabelingJobLabelerCount);
        $dataLabelingJobInstructionUri = 'dataLabelingJobInstructionUri-886362173';
        $dataLabelingJob->setInstructionUri($dataLabelingJobInstructionUri);
        $dataLabelingJobInputsSchemaUri = 'dataLabelingJobInputsSchemaUri-1486933251';
        $dataLabelingJob->setInputsSchemaUri($dataLabelingJobInputsSchemaUri);
        $dataLabelingJobInputs = new Value();
        $dataLabelingJob->setInputs($dataLabelingJobInputs);
        $response = $client->createDataLabelingJob($formattedParent, $dataLabelingJob);
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

    /**
     * @test
     */
    public function createDataLabelingJobExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
        $dataLabelingJob = new DataLabelingJob();
        $dataLabelingJobDisplayName = 'dataLabelingJobDisplayName708178632';
        $dataLabelingJob->setDisplayName($dataLabelingJobDisplayName);
        $dataLabelingJobDatasets = [
            $client->datasetName('[PROJECT]', '[LOCATION]', '[DATASET]'),
        ];
        $dataLabelingJob->setDatasets($dataLabelingJobDatasets);
        $dataLabelingJobLabelerCount = 500093453;
        $dataLabelingJob->setLabelerCount($dataLabelingJobLabelerCount);
        $dataLabelingJobInstructionUri = 'dataLabelingJobInstructionUri-886362173';
        $dataLabelingJob->setInstructionUri($dataLabelingJobInstructionUri);
        $dataLabelingJobInputsSchemaUri = 'dataLabelingJobInputsSchemaUri-1486933251';
        $dataLabelingJob->setInputsSchemaUri($dataLabelingJobInputsSchemaUri);
        $dataLabelingJobInputs = new Value();
        $dataLabelingJob->setInputs($dataLabelingJobInputs);
        try {
            $client->createDataLabelingJob($formattedParent, $dataLabelingJob);
            // If the $client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function createHyperparameterTuningJobTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
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
        $response = $client->createHyperparameterTuningJob($formattedParent, $hyperparameterTuningJob);
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

    /**
     * @test
     */
    public function createHyperparameterTuningJobExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
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
        try {
            $client->createHyperparameterTuningJob($formattedParent, $hyperparameterTuningJob);
            // If the $client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function createModelDeploymentMonitoringJobTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
        $modelDeploymentMonitoringJob = new ModelDeploymentMonitoringJob();
        $modelDeploymentMonitoringJobDisplayName = 'modelDeploymentMonitoringJobDisplayName-563611194';
        $modelDeploymentMonitoringJob->setDisplayName($modelDeploymentMonitoringJobDisplayName);
        $modelDeploymentMonitoringJobEndpoint = $client->endpointName('[PROJECT]', '[LOCATION]', '[ENDPOINT]');
        $modelDeploymentMonitoringJob->setEndpoint($modelDeploymentMonitoringJobEndpoint);
        $modelDeploymentMonitoringJobModelDeploymentMonitoringObjectiveConfigs = [];
        $modelDeploymentMonitoringJob->setModelDeploymentMonitoringObjectiveConfigs($modelDeploymentMonitoringJobModelDeploymentMonitoringObjectiveConfigs);
        $modelDeploymentMonitoringJobModelDeploymentMonitoringScheduleConfig = new ModelDeploymentMonitoringScheduleConfig();
        $modelDeploymentMonitoringScheduleConfigMonitorInterval = new Duration();
        $modelDeploymentMonitoringJobModelDeploymentMonitoringScheduleConfig->setMonitorInterval($modelDeploymentMonitoringScheduleConfigMonitorInterval);
        $modelDeploymentMonitoringJob->setModelDeploymentMonitoringScheduleConfig($modelDeploymentMonitoringJobModelDeploymentMonitoringScheduleConfig);
        $modelDeploymentMonitoringJobLoggingSamplingStrategy = new SamplingStrategy();
        $modelDeploymentMonitoringJob->setLoggingSamplingStrategy($modelDeploymentMonitoringJobLoggingSamplingStrategy);
        $response = $client->createModelDeploymentMonitoringJob($formattedParent, $modelDeploymentMonitoringJob);
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

    /**
     * @test
     */
    public function createModelDeploymentMonitoringJobExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
        $modelDeploymentMonitoringJob = new ModelDeploymentMonitoringJob();
        $modelDeploymentMonitoringJobDisplayName = 'modelDeploymentMonitoringJobDisplayName-563611194';
        $modelDeploymentMonitoringJob->setDisplayName($modelDeploymentMonitoringJobDisplayName);
        $modelDeploymentMonitoringJobEndpoint = $client->endpointName('[PROJECT]', '[LOCATION]', '[ENDPOINT]');
        $modelDeploymentMonitoringJob->setEndpoint($modelDeploymentMonitoringJobEndpoint);
        $modelDeploymentMonitoringJobModelDeploymentMonitoringObjectiveConfigs = [];
        $modelDeploymentMonitoringJob->setModelDeploymentMonitoringObjectiveConfigs($modelDeploymentMonitoringJobModelDeploymentMonitoringObjectiveConfigs);
        $modelDeploymentMonitoringJobModelDeploymentMonitoringScheduleConfig = new ModelDeploymentMonitoringScheduleConfig();
        $modelDeploymentMonitoringScheduleConfigMonitorInterval = new Duration();
        $modelDeploymentMonitoringJobModelDeploymentMonitoringScheduleConfig->setMonitorInterval($modelDeploymentMonitoringScheduleConfigMonitorInterval);
        $modelDeploymentMonitoringJob->setModelDeploymentMonitoringScheduleConfig($modelDeploymentMonitoringJobModelDeploymentMonitoringScheduleConfig);
        $modelDeploymentMonitoringJobLoggingSamplingStrategy = new SamplingStrategy();
        $modelDeploymentMonitoringJob->setLoggingSamplingStrategy($modelDeploymentMonitoringJobLoggingSamplingStrategy);
        try {
            $client->createModelDeploymentMonitoringJob($formattedParent, $modelDeploymentMonitoringJob);
            // If the $client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function deleteBatchPredictionJobTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedName = $client->batchPredictionJobName('[PROJECT]', '[LOCATION]', '[BATCH_PREDICTION_JOB]');
        $response = $client->deleteBatchPredictionJob($formattedName);
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

    /**
     * @test
     */
    public function deleteBatchPredictionJobExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedName = $client->batchPredictionJobName('[PROJECT]', '[LOCATION]', '[BATCH_PREDICTION_JOB]');
        $response = $client->deleteBatchPredictionJob($formattedName);
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

    /**
     * @test
     */
    public function deleteCustomJobTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedName = $client->customJobName('[PROJECT]', '[LOCATION]', '[CUSTOM_JOB]');
        $response = $client->deleteCustomJob($formattedName);
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

    /**
     * @test
     */
    public function deleteCustomJobExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedName = $client->customJobName('[PROJECT]', '[LOCATION]', '[CUSTOM_JOB]');
        $response = $client->deleteCustomJob($formattedName);
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

    /**
     * @test
     */
    public function deleteDataLabelingJobTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedName = $client->dataLabelingJobName('[PROJECT]', '[LOCATION]', '[DATA_LABELING_JOB]');
        $response = $client->deleteDataLabelingJob($formattedName);
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

    /**
     * @test
     */
    public function deleteDataLabelingJobExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedName = $client->dataLabelingJobName('[PROJECT]', '[LOCATION]', '[DATA_LABELING_JOB]');
        $response = $client->deleteDataLabelingJob($formattedName);
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

    /**
     * @test
     */
    public function deleteHyperparameterTuningJobTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedName = $client->hyperparameterTuningJobName('[PROJECT]', '[LOCATION]', '[HYPERPARAMETER_TUNING_JOB]');
        $response = $client->deleteHyperparameterTuningJob($formattedName);
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

    /**
     * @test
     */
    public function deleteHyperparameterTuningJobExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedName = $client->hyperparameterTuningJobName('[PROJECT]', '[LOCATION]', '[HYPERPARAMETER_TUNING_JOB]');
        $response = $client->deleteHyperparameterTuningJob($formattedName);
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

    /**
     * @test
     */
    public function deleteModelDeploymentMonitoringJobTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedName = $client->modelDeploymentMonitoringJobName('[PROJECT]', '[LOCATION]', '[MODEL_DEPLOYMENT_MONITORING_JOB]');
        $response = $client->deleteModelDeploymentMonitoringJob($formattedName);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/DeleteModelDeploymentMonitoringJob', $actualApiFuncCall);
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

    /**
     * @test
     */
    public function deleteModelDeploymentMonitoringJobExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $formattedName = $client->modelDeploymentMonitoringJobName('[PROJECT]', '[LOCATION]', '[MODEL_DEPLOYMENT_MONITORING_JOB]');
        $response = $client->deleteModelDeploymentMonitoringJob($formattedName);
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

    /**
     * @test
     */
    public function getBatchPredictionJobTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $model = 'model104069929';
        $generateExplanation = false;
        $expectedResponse = new BatchPredictionJob();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setModel($model);
        $expectedResponse->setGenerateExplanation($generateExplanation);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $client->batchPredictionJobName('[PROJECT]', '[LOCATION]', '[BATCH_PREDICTION_JOB]');
        $response = $client->getBatchPredictionJob($formattedName);
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

    /**
     * @test
     */
    public function getBatchPredictionJobExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedName = $client->batchPredictionJobName('[PROJECT]', '[LOCATION]', '[BATCH_PREDICTION_JOB]');
        try {
            $client->getBatchPredictionJob($formattedName);
            // If the $client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getCustomJobTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedName = $client->customJobName('[PROJECT]', '[LOCATION]', '[CUSTOM_JOB]');
        $response = $client->getCustomJob($formattedName);
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

    /**
     * @test
     */
    public function getCustomJobExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedName = $client->customJobName('[PROJECT]', '[LOCATION]', '[CUSTOM_JOB]');
        try {
            $client->getCustomJob($formattedName);
            // If the $client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getDataLabelingJobTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedName = $client->dataLabelingJobName('[PROJECT]', '[LOCATION]', '[DATA_LABELING_JOB]');
        $response = $client->getDataLabelingJob($formattedName);
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

    /**
     * @test
     */
    public function getDataLabelingJobExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedName = $client->dataLabelingJobName('[PROJECT]', '[LOCATION]', '[DATA_LABELING_JOB]');
        try {
            $client->getDataLabelingJob($formattedName);
            // If the $client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getHyperparameterTuningJobTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedName = $client->hyperparameterTuningJobName('[PROJECT]', '[LOCATION]', '[HYPERPARAMETER_TUNING_JOB]');
        $response = $client->getHyperparameterTuningJob($formattedName);
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

    /**
     * @test
     */
    public function getHyperparameterTuningJobExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedName = $client->hyperparameterTuningJobName('[PROJECT]', '[LOCATION]', '[HYPERPARAMETER_TUNING_JOB]');
        try {
            $client->getHyperparameterTuningJob($formattedName);
            // If the $client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getModelDeploymentMonitoringJobTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedName = $client->modelDeploymentMonitoringJobName('[PROJECT]', '[LOCATION]', '[MODEL_DEPLOYMENT_MONITORING_JOB]');
        $response = $client->getModelDeploymentMonitoringJob($formattedName);
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

    /**
     * @test
     */
    public function getModelDeploymentMonitoringJobExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedName = $client->modelDeploymentMonitoringJobName('[PROJECT]', '[LOCATION]', '[MODEL_DEPLOYMENT_MONITORING_JOB]');
        try {
            $client->getModelDeploymentMonitoringJob($formattedName);
            // If the $client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listBatchPredictionJobsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $batchPredictionJobsElement = new BatchPredictionJob();
        $batchPredictionJobs = [
            $batchPredictionJobsElement,
        ];
        $expectedResponse = new ListBatchPredictionJobsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setBatchPredictionJobs($batchPredictionJobs);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
        $response = $client->listBatchPredictionJobs($formattedParent);
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

    /**
     * @test
     */
    public function listBatchPredictionJobsExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
        try {
            $client->listBatchPredictionJobs($formattedParent);
            // If the $client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listCustomJobsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $customJobsElement = new CustomJob();
        $customJobs = [
            $customJobsElement,
        ];
        $expectedResponse = new ListCustomJobsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setCustomJobs($customJobs);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
        $response = $client->listCustomJobs($formattedParent);
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

    /**
     * @test
     */
    public function listCustomJobsExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
        try {
            $client->listCustomJobs($formattedParent);
            // If the $client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listDataLabelingJobsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $dataLabelingJobsElement = new DataLabelingJob();
        $dataLabelingJobs = [
            $dataLabelingJobsElement,
        ];
        $expectedResponse = new ListDataLabelingJobsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setDataLabelingJobs($dataLabelingJobs);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
        $response = $client->listDataLabelingJobs($formattedParent);
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

    /**
     * @test
     */
    public function listDataLabelingJobsExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
        try {
            $client->listDataLabelingJobs($formattedParent);
            // If the $client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listHyperparameterTuningJobsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $hyperparameterTuningJobsElement = new HyperparameterTuningJob();
        $hyperparameterTuningJobs = [
            $hyperparameterTuningJobsElement,
        ];
        $expectedResponse = new ListHyperparameterTuningJobsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setHyperparameterTuningJobs($hyperparameterTuningJobs);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
        $response = $client->listHyperparameterTuningJobs($formattedParent);
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

    /**
     * @test
     */
    public function listHyperparameterTuningJobsExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
        try {
            $client->listHyperparameterTuningJobs($formattedParent);
            // If the $client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listModelDeploymentMonitoringJobsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $modelDeploymentMonitoringJobsElement = new ModelDeploymentMonitoringJob();
        $modelDeploymentMonitoringJobs = [
            $modelDeploymentMonitoringJobsElement,
        ];
        $expectedResponse = new ListModelDeploymentMonitoringJobsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setModelDeploymentMonitoringJobs($modelDeploymentMonitoringJobs);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
        $response = $client->listModelDeploymentMonitoringJobs($formattedParent);
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

    /**
     * @test
     */
    public function listModelDeploymentMonitoringJobsExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedParent = $client->locationName('[PROJECT]', '[LOCATION]');
        try {
            $client->listModelDeploymentMonitoringJobs($formattedParent);
            // If the $client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function pauseModelDeploymentMonitoringJobTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $client->modelDeploymentMonitoringJobName('[PROJECT]', '[LOCATION]', '[MODEL_DEPLOYMENT_MONITORING_JOB]');
        $client->pauseModelDeploymentMonitoringJob($formattedName);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/PauseModelDeploymentMonitoringJob', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function pauseModelDeploymentMonitoringJobExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedName = $client->modelDeploymentMonitoringJobName('[PROJECT]', '[LOCATION]', '[MODEL_DEPLOYMENT_MONITORING_JOB]');
        try {
            $client->pauseModelDeploymentMonitoringJob($formattedName);
            // If the $client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function resumeModelDeploymentMonitoringJobTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $client->modelDeploymentMonitoringJobName('[PROJECT]', '[LOCATION]', '[MODEL_DEPLOYMENT_MONITORING_JOB]');
        $client->resumeModelDeploymentMonitoringJob($formattedName);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/ResumeModelDeploymentMonitoringJob', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function resumeModelDeploymentMonitoringJobExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedName = $client->modelDeploymentMonitoringJobName('[PROJECT]', '[LOCATION]', '[MODEL_DEPLOYMENT_MONITORING_JOB]');
        try {
            $client->resumeModelDeploymentMonitoringJob($formattedName);
            // If the $client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function searchModelDeploymentMonitoringStatsAnomaliesTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $monitoringStatsElement = new ModelMonitoringStatsAnomalies();
        $monitoringStats = [
            $monitoringStatsElement,
        ];
        $expectedResponse = new SearchModelDeploymentMonitoringStatsAnomaliesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setMonitoringStats($monitoringStats);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedModelDeploymentMonitoringJob = $client->modelDeploymentMonitoringJobName('[PROJECT]', '[LOCATION]', '[MODEL_DEPLOYMENT_MONITORING_JOB]');
        $deployedModelId = 'deployedModelId866642506';
        $objectives = [];
        $response = $client->searchModelDeploymentMonitoringStatsAnomalies($formattedModelDeploymentMonitoringJob, $deployedModelId, $objectives);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getMonitoringStats()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/SearchModelDeploymentMonitoringStatsAnomalies', $actualFuncCall);
        $actualValue = $actualRequestObject->getModelDeploymentMonitoringJob();
        $this->assertProtobufEquals($formattedModelDeploymentMonitoringJob, $actualValue);
        $actualValue = $actualRequestObject->getDeployedModelId();
        $this->assertProtobufEquals($deployedModelId, $actualValue);
        $actualValue = $actualRequestObject->getObjectives();
        $this->assertProtobufEquals($objectives, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function searchModelDeploymentMonitoringStatsAnomaliesExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $formattedModelDeploymentMonitoringJob = $client->modelDeploymentMonitoringJobName('[PROJECT]', '[LOCATION]', '[MODEL_DEPLOYMENT_MONITORING_JOB]');
        $deployedModelId = 'deployedModelId866642506';
        $objectives = [];
        try {
            $client->searchModelDeploymentMonitoringStatsAnomalies($formattedModelDeploymentMonitoringJob, $deployedModelId, $objectives);
            // If the $client method call did not throw, fail the test
            $this->fail('Expected an ApiException, but no exception was thrown.');
        } catch (ApiException $ex) {
            $this->assertEquals($status->code, $ex->getCode());
            $this->assertEquals($expectedExceptionMessage, $ex->getMessage());
        }
        // Call popReceivedCalls to ensure the stub is exhausted
        $transport->popReceivedCalls();
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function updateModelDeploymentMonitoringJobTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $modelDeploymentMonitoringJobEndpoint = $client->endpointName('[PROJECT]', '[LOCATION]', '[ENDPOINT]');
        $modelDeploymentMonitoringJob->setEndpoint($modelDeploymentMonitoringJobEndpoint);
        $modelDeploymentMonitoringJobModelDeploymentMonitoringObjectiveConfigs = [];
        $modelDeploymentMonitoringJob->setModelDeploymentMonitoringObjectiveConfigs($modelDeploymentMonitoringJobModelDeploymentMonitoringObjectiveConfigs);
        $modelDeploymentMonitoringJobModelDeploymentMonitoringScheduleConfig = new ModelDeploymentMonitoringScheduleConfig();
        $modelDeploymentMonitoringScheduleConfigMonitorInterval = new Duration();
        $modelDeploymentMonitoringJobModelDeploymentMonitoringScheduleConfig->setMonitorInterval($modelDeploymentMonitoringScheduleConfigMonitorInterval);
        $modelDeploymentMonitoringJob->setModelDeploymentMonitoringScheduleConfig($modelDeploymentMonitoringJobModelDeploymentMonitoringScheduleConfig);
        $modelDeploymentMonitoringJobLoggingSamplingStrategy = new SamplingStrategy();
        $modelDeploymentMonitoringJob->setLoggingSamplingStrategy($modelDeploymentMonitoringJobLoggingSamplingStrategy);
        $updateMask = new FieldMask();
        $response = $client->updateModelDeploymentMonitoringJob($modelDeploymentMonitoringJob, $updateMask);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.aiplatform.v1.JobService/UpdateModelDeploymentMonitoringJob', $actualApiFuncCall);
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

    /**
     * @test
     */
    public function updateModelDeploymentMonitoringJobExceptionTest()
    {
        $operationsTransport = $this->createTransport();
        $operationsClient = new OperationsClient([
            'serviceAddress' => '',
            'transport' => $operationsTransport,
            'credentials' => $this->createCredentials(),
        ]);
        $transport = $this->createTransport();
        $client = $this->createClient([
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
        $expectedExceptionMessage = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $operationsTransport->addResponse(null, $status);
        // Mock request
        $modelDeploymentMonitoringJob = new ModelDeploymentMonitoringJob();
        $modelDeploymentMonitoringJobDisplayName = 'modelDeploymentMonitoringJobDisplayName-563611194';
        $modelDeploymentMonitoringJob->setDisplayName($modelDeploymentMonitoringJobDisplayName);
        $modelDeploymentMonitoringJobEndpoint = $client->endpointName('[PROJECT]', '[LOCATION]', '[ENDPOINT]');
        $modelDeploymentMonitoringJob->setEndpoint($modelDeploymentMonitoringJobEndpoint);
        $modelDeploymentMonitoringJobModelDeploymentMonitoringObjectiveConfigs = [];
        $modelDeploymentMonitoringJob->setModelDeploymentMonitoringObjectiveConfigs($modelDeploymentMonitoringJobModelDeploymentMonitoringObjectiveConfigs);
        $modelDeploymentMonitoringJobModelDeploymentMonitoringScheduleConfig = new ModelDeploymentMonitoringScheduleConfig();
        $modelDeploymentMonitoringScheduleConfigMonitorInterval = new Duration();
        $modelDeploymentMonitoringJobModelDeploymentMonitoringScheduleConfig->setMonitorInterval($modelDeploymentMonitoringScheduleConfigMonitorInterval);
        $modelDeploymentMonitoringJob->setModelDeploymentMonitoringScheduleConfig($modelDeploymentMonitoringJobModelDeploymentMonitoringScheduleConfig);
        $modelDeploymentMonitoringJobLoggingSamplingStrategy = new SamplingStrategy();
        $modelDeploymentMonitoringJob->setLoggingSamplingStrategy($modelDeploymentMonitoringJobLoggingSamplingStrategy);
        $updateMask = new FieldMask();
        $response = $client->updateModelDeploymentMonitoringJob($modelDeploymentMonitoringJob, $updateMask);
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
}
