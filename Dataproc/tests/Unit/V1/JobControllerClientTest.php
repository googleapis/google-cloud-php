<?php
/*
 * Copyright 2018 Google LLC
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

namespace Google\Cloud\Dataproc\Tests\Unit\V1;

use Google\Cloud\Dataproc\V1\JobControllerClient;
use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Dataproc\V1\Job;
use Google\Cloud\Dataproc\V1\ListJobsResponse;
use Google\Protobuf\Any;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group dataproc
 * @group gapic
 */
class JobControllerClientTest extends GeneratedTest
{
    /**
     * @return TransportInterface
     */
    private function createTransport($deserialize = null)
    {
        return new MockTransport($deserialize);
    }

    /**
     * @return JobControllerClient
     */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->getMockBuilder(CredentialsWrapper::class)
                ->disableOriginalConstructor()
                ->getMock(),
        ];

        return new JobControllerClient($options);
    }

    /**
     * @test
     */
    public function submitJobTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $driverOutputResourceUri = 'driverOutputResourceUri-542229086';
        $driverControlFilesUri = 'driverControlFilesUri207057643';
        $expectedResponse = new Job();
        $expectedResponse->setDriverOutputResourceUri($driverOutputResourceUri);
        $expectedResponse->setDriverControlFilesUri($driverControlFilesUri);
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $region = 'region-934795532';
        $job = new Job();

        $response = $client->submitJob($projectId, $region, $job);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataproc.v1.JobController/SubmitJob', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getRegion();

        $this->assertProtobufEquals($region, $actualValue);
        $actualValue = $actualRequestObject->getJob();

        $this->assertProtobufEquals($job, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function submitJobExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $region = 'region-934795532';
        $job = new Job();

        try {
            $client->submitJob($projectId, $region, $job);
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
    public function getJobTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $driverOutputResourceUri = 'driverOutputResourceUri-542229086';
        $driverControlFilesUri = 'driverControlFilesUri207057643';
        $expectedResponse = new Job();
        $expectedResponse->setDriverOutputResourceUri($driverOutputResourceUri);
        $expectedResponse->setDriverControlFilesUri($driverControlFilesUri);
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $region = 'region-934795532';
        $jobId = 'jobId-1154752291';

        $response = $client->getJob($projectId, $region, $jobId);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataproc.v1.JobController/GetJob', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getRegion();

        $this->assertProtobufEquals($region, $actualValue);
        $actualValue = $actualRequestObject->getJobId();

        $this->assertProtobufEquals($jobId, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getJobExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $region = 'region-934795532';
        $jobId = 'jobId-1154752291';

        try {
            $client->getJob($projectId, $region, $jobId);
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
    public function listJobsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $nextPageToken = '';
        $jobsElement = new Job();
        $jobs = [$jobsElement];
        $expectedResponse = new ListJobsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setJobs($jobs);
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $region = 'region-934795532';

        $response = $client->listJobs($projectId, $region);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getJobs()[0], $resources[0]);

        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataproc.v1.JobController/ListJobs', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getRegion();

        $this->assertProtobufEquals($region, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listJobsExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $region = 'region-934795532';

        try {
            $client->listJobs($projectId, $region);
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
    public function updateJobTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $driverOutputResourceUri = 'driverOutputResourceUri-542229086';
        $driverControlFilesUri = 'driverControlFilesUri207057643';
        $expectedResponse = new Job();
        $expectedResponse->setDriverOutputResourceUri($driverOutputResourceUri);
        $expectedResponse->setDriverControlFilesUri($driverControlFilesUri);
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $region = 'region-934795532';
        $jobId = 'jobId-1154752291';
        $job = new Job();
        $updateMask = new FieldMask();

        $response = $client->updateJob($projectId, $region, $jobId, $job, $updateMask);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataproc.v1.JobController/UpdateJob', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getRegion();

        $this->assertProtobufEquals($region, $actualValue);
        $actualValue = $actualRequestObject->getJobId();

        $this->assertProtobufEquals($jobId, $actualValue);
        $actualValue = $actualRequestObject->getJob();

        $this->assertProtobufEquals($job, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();

        $this->assertProtobufEquals($updateMask, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function updateJobExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $region = 'region-934795532';
        $jobId = 'jobId-1154752291';
        $job = new Job();
        $updateMask = new FieldMask();

        try {
            $client->updateJob($projectId, $region, $jobId, $job, $updateMask);
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
    public function cancelJobTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $driverOutputResourceUri = 'driverOutputResourceUri-542229086';
        $driverControlFilesUri = 'driverControlFilesUri207057643';
        $expectedResponse = new Job();
        $expectedResponse->setDriverOutputResourceUri($driverOutputResourceUri);
        $expectedResponse->setDriverControlFilesUri($driverControlFilesUri);
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $region = 'region-934795532';
        $jobId = 'jobId-1154752291';

        $response = $client->cancelJob($projectId, $region, $jobId);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataproc.v1.JobController/CancelJob', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getRegion();

        $this->assertProtobufEquals($region, $actualValue);
        $actualValue = $actualRequestObject->getJobId();

        $this->assertProtobufEquals($jobId, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function cancelJobExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $region = 'region-934795532';
        $jobId = 'jobId-1154752291';

        try {
            $client->cancelJob($projectId, $region, $jobId);
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
    public function deleteJobTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);

        // Mock request
        $projectId = 'projectId-1969970175';
        $region = 'region-934795532';
        $jobId = 'jobId-1154752291';

        $client->deleteJob($projectId, $region, $jobId);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.dataproc.v1.JobController/DeleteJob', $actualFuncCall);

        $actualValue = $actualRequestObject->getProjectId();

        $this->assertProtobufEquals($projectId, $actualValue);
        $actualValue = $actualRequestObject->getRegion();

        $this->assertProtobufEquals($region, $actualValue);
        $actualValue = $actualRequestObject->getJobId();

        $this->assertProtobufEquals($jobId, $actualValue);

        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function deleteJobExceptionTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient(['transport' => $transport]);

        $this->assertTrue($transport->isExhausted());

        $status = new stdClass();
        $status->code = Code::DATA_LOSS;
        $status->details = 'internal error';

        $expectedExceptionMessage = json_encode([
           'message' => 'internal error',
           'code' => Code::DATA_LOSS,
           'status' => 'DATA_LOSS',
           'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);

        // Mock request
        $projectId = 'projectId-1969970175';
        $region = 'region-934795532';
        $jobId = 'jobId-1154752291';

        try {
            $client->deleteJob($projectId, $region, $jobId);
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
}
