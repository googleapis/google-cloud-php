<?php
/*
 * Copyright 2020 Google LLC
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

namespace Google\Cloud\OsConfig\Tests\Unit\V1;

use Google\ApiCore\ApiException;

use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;

use Google\Cloud\OsConfig\V1\ListPatchDeploymentsResponse;
use Google\Cloud\OsConfig\V1\ListPatchJobInstanceDetailsResponse;
use Google\Cloud\OsConfig\V1\ListPatchJobsResponse;
use Google\Cloud\OsConfig\V1\MonthlySchedule;
use Google\Cloud\OsConfig\V1\OneTimeSchedule;
use Google\Cloud\OsConfig\V1\OsConfigServiceClient;
use Google\Cloud\OsConfig\V1\PatchDeployment;
use Google\Cloud\OsConfig\V1\PatchInstanceFilter;
use Google\Cloud\OsConfig\V1\PatchJob;
use Google\Cloud\OsConfig\V1\PatchJobInstanceDetails;
use Google\Cloud\OsConfig\V1\RecurringSchedule;
use Google\Cloud\OsConfig\V1\RecurringSchedule\Frequency;
use Google\Cloud\OsConfig\V1\WeekDayOfMonth;
use Google\Cloud\OsConfig\V1\WeeklySchedule;
use Google\Protobuf\GPBEmpty;
use Google\Protobuf\Timestamp;
use Google\Rpc\Code;
use Google\Type\DayOfWeek;
use Google\Type\TimeOfDay;
use Google\Type\TimeZone;
use stdClass;

/**
 * @group osconfig
 *
 * @group gapic
 */
class OsConfigServiceClientTest extends GeneratedTest
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
     * @return OsConfigServiceClient
     */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new OsConfigServiceClient($options);
    }

    /**
     * @test
     */
    public function cancelPatchJobTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $dryRun = false;
        $errorMessage = 'errorMessage-1938755376';
        $percentComplete = -1.96096922E8;
        $patchDeployment = 'patchDeployment633565980';
        $expectedResponse = new PatchJob();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setDryRun($dryRun);
        $expectedResponse->setErrorMessage($errorMessage);
        $expectedResponse->setPercentComplete($percentComplete);
        $expectedResponse->setPatchDeployment($patchDeployment);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $client->patchJobName('[PROJECT]', '[PATCH_JOB]');
        $response = $client->cancelPatchJob($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.osconfig.v1.OsConfigService/CancelPatchJob', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function cancelPatchJobExceptionTest()
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
        $formattedName = $client->patchJobName('[PROJECT]', '[PATCH_JOB]');
        try {
            $client->cancelPatchJob($formattedName);
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
    public function createPatchDeploymentTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $description = 'description-1724546052';
        $expectedResponse = new PatchDeployment();
        $expectedResponse->setName($name);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $client->projectName('[PROJECT]');
        $patchDeploymentId = 'patchDeploymentId-1817061090';
        $patchDeployment = new PatchDeployment();
        $patchDeploymentInstanceFilter = new PatchInstanceFilter();
        $patchDeployment->setInstanceFilter($patchDeploymentInstanceFilter);
        $patchDeploymentOneTimeSchedule = new OneTimeSchedule();
        $oneTimeScheduleExecuteTime = new Timestamp();
        $patchDeploymentOneTimeSchedule->setExecuteTime($oneTimeScheduleExecuteTime);
        $patchDeployment->setOneTimeSchedule($patchDeploymentOneTimeSchedule);
        $patchDeploymentRecurringSchedule = new RecurringSchedule();
        $recurringScheduleTimeZone = new TimeZone();
        $patchDeploymentRecurringSchedule->setTimeZone($recurringScheduleTimeZone);
        $recurringScheduleTimeOfDay = new TimeOfDay();
        $patchDeploymentRecurringSchedule->setTimeOfDay($recurringScheduleTimeOfDay);
        $recurringScheduleFrequency = Frequency::FREQUENCY_UNSPECIFIED;
        $patchDeploymentRecurringSchedule->setFrequency($recurringScheduleFrequency);
        $recurringScheduleWeekly = new WeeklySchedule();
        $weeklyDayOfWeek = DayOfWeek::DAY_OF_WEEK_UNSPECIFIED;
        $recurringScheduleWeekly->setDayOfWeek($weeklyDayOfWeek);
        $patchDeploymentRecurringSchedule->setWeekly($recurringScheduleWeekly);
        $recurringScheduleMonthly = new MonthlySchedule();
        $monthlyWeekDayOfMonth = new WeekDayOfMonth();
        $weekDayOfMonthWeekOrdinal = 1918414244;
        $monthlyWeekDayOfMonth->setWeekOrdinal($weekDayOfMonthWeekOrdinal);
        $weekDayOfMonthDayOfWeek = DayOfWeek::DAY_OF_WEEK_UNSPECIFIED;
        $monthlyWeekDayOfMonth->setDayOfWeek($weekDayOfMonthDayOfWeek);
        $recurringScheduleMonthly->setWeekDayOfMonth($monthlyWeekDayOfMonth);
        $monthlyMonthDay = 1149931479;
        $recurringScheduleMonthly->setMonthDay($monthlyMonthDay);
        $patchDeploymentRecurringSchedule->setMonthly($recurringScheduleMonthly);
        $patchDeployment->setRecurringSchedule($patchDeploymentRecurringSchedule);
        $response = $client->createPatchDeployment($formattedParent, $patchDeploymentId, $patchDeployment);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.osconfig.v1.OsConfigService/CreatePatchDeployment', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getPatchDeploymentId();
        $this->assertProtobufEquals($patchDeploymentId, $actualValue);
        $actualValue = $actualRequestObject->getPatchDeployment();
        $this->assertProtobufEquals($patchDeployment, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function createPatchDeploymentExceptionTest()
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
        $formattedParent = $client->projectName('[PROJECT]');
        $patchDeploymentId = 'patchDeploymentId-1817061090';
        $patchDeployment = new PatchDeployment();
        $patchDeploymentInstanceFilter = new PatchInstanceFilter();
        $patchDeployment->setInstanceFilter($patchDeploymentInstanceFilter);
        $patchDeploymentOneTimeSchedule = new OneTimeSchedule();
        $oneTimeScheduleExecuteTime = new Timestamp();
        $patchDeploymentOneTimeSchedule->setExecuteTime($oneTimeScheduleExecuteTime);
        $patchDeployment->setOneTimeSchedule($patchDeploymentOneTimeSchedule);
        $patchDeploymentRecurringSchedule = new RecurringSchedule();
        $recurringScheduleTimeZone = new TimeZone();
        $patchDeploymentRecurringSchedule->setTimeZone($recurringScheduleTimeZone);
        $recurringScheduleTimeOfDay = new TimeOfDay();
        $patchDeploymentRecurringSchedule->setTimeOfDay($recurringScheduleTimeOfDay);
        $recurringScheduleFrequency = Frequency::FREQUENCY_UNSPECIFIED;
        $patchDeploymentRecurringSchedule->setFrequency($recurringScheduleFrequency);
        $recurringScheduleWeekly = new WeeklySchedule();
        $weeklyDayOfWeek = DayOfWeek::DAY_OF_WEEK_UNSPECIFIED;
        $recurringScheduleWeekly->setDayOfWeek($weeklyDayOfWeek);
        $patchDeploymentRecurringSchedule->setWeekly($recurringScheduleWeekly);
        $recurringScheduleMonthly = new MonthlySchedule();
        $monthlyWeekDayOfMonth = new WeekDayOfMonth();
        $weekDayOfMonthWeekOrdinal = 1918414244;
        $monthlyWeekDayOfMonth->setWeekOrdinal($weekDayOfMonthWeekOrdinal);
        $weekDayOfMonthDayOfWeek = DayOfWeek::DAY_OF_WEEK_UNSPECIFIED;
        $monthlyWeekDayOfMonth->setDayOfWeek($weekDayOfMonthDayOfWeek);
        $recurringScheduleMonthly->setWeekDayOfMonth($monthlyWeekDayOfMonth);
        $monthlyMonthDay = 1149931479;
        $recurringScheduleMonthly->setMonthDay($monthlyMonthDay);
        $patchDeploymentRecurringSchedule->setMonthly($recurringScheduleMonthly);
        $patchDeployment->setRecurringSchedule($patchDeploymentRecurringSchedule);
        try {
            $client->createPatchDeployment($formattedParent, $patchDeploymentId, $patchDeployment);
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
    public function deletePatchDeploymentTest()
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
        $formattedName = $client->patchDeploymentName('[PROJECT]', '[PATCH_DEPLOYMENT]');
        $client->deletePatchDeployment($formattedName);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.osconfig.v1.OsConfigService/DeletePatchDeployment', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function deletePatchDeploymentExceptionTest()
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
        $formattedName = $client->patchDeploymentName('[PROJECT]', '[PATCH_DEPLOYMENT]');
        try {
            $client->deletePatchDeployment($formattedName);
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
    public function executePatchJobTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName2 = 'displayName21615000987';
        $description2 = 'description2568623279';
        $dryRun2 = true;
        $errorMessage = 'errorMessage-1938755376';
        $percentComplete = -1.96096922E8;
        $patchDeployment = 'patchDeployment633565980';
        $expectedResponse = new PatchJob();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName2);
        $expectedResponse->setDescription($description2);
        $expectedResponse->setDryRun($dryRun2);
        $expectedResponse->setErrorMessage($errorMessage);
        $expectedResponse->setPercentComplete($percentComplete);
        $expectedResponse->setPatchDeployment($patchDeployment);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $client->projectName('[PROJECT]');
        $instanceFilter = new PatchInstanceFilter();
        $response = $client->executePatchJob($formattedParent, $instanceFilter);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.osconfig.v1.OsConfigService/ExecutePatchJob', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getInstanceFilter();
        $this->assertProtobufEquals($instanceFilter, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function executePatchJobExceptionTest()
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
        $formattedParent = $client->projectName('[PROJECT]');
        $instanceFilter = new PatchInstanceFilter();
        try {
            $client->executePatchJob($formattedParent, $instanceFilter);
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
    public function getPatchDeploymentTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $description = 'description-1724546052';
        $expectedResponse = new PatchDeployment();
        $expectedResponse->setName($name2);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $client->patchDeploymentName('[PROJECT]', '[PATCH_DEPLOYMENT]');
        $response = $client->getPatchDeployment($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.osconfig.v1.OsConfigService/GetPatchDeployment', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getPatchDeploymentExceptionTest()
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
        $formattedName = $client->patchDeploymentName('[PROJECT]', '[PATCH_DEPLOYMENT]');
        try {
            $client->getPatchDeployment($formattedName);
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
    public function getPatchJobTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $dryRun = false;
        $errorMessage = 'errorMessage-1938755376';
        $percentComplete = -1.96096922E8;
        $patchDeployment = 'patchDeployment633565980';
        $expectedResponse = new PatchJob();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setDryRun($dryRun);
        $expectedResponse->setErrorMessage($errorMessage);
        $expectedResponse->setPercentComplete($percentComplete);
        $expectedResponse->setPatchDeployment($patchDeployment);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $client->patchJobName('[PROJECT]', '[PATCH_JOB]');
        $response = $client->getPatchJob($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.osconfig.v1.OsConfigService/GetPatchJob', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getPatchJobExceptionTest()
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
        $formattedName = $client->patchJobName('[PROJECT]', '[PATCH_JOB]');
        try {
            $client->getPatchJob($formattedName);
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
    public function listPatchDeploymentsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $patchDeploymentsElement = new PatchDeployment();
        $patchDeployments = [
            $patchDeploymentsElement,
        ];
        $expectedResponse = new ListPatchDeploymentsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setPatchDeployments($patchDeployments);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $client->projectName('[PROJECT]');
        $response = $client->listPatchDeployments($formattedParent);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getPatchDeployments()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.osconfig.v1.OsConfigService/ListPatchDeployments', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listPatchDeploymentsExceptionTest()
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
        $formattedParent = $client->projectName('[PROJECT]');
        try {
            $client->listPatchDeployments($formattedParent);
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
    public function listPatchJobInstanceDetailsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $patchJobInstanceDetailsElement = new PatchJobInstanceDetails();
        $patchJobInstanceDetails = [
            $patchJobInstanceDetailsElement,
        ];
        $expectedResponse = new ListPatchJobInstanceDetailsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setPatchJobInstanceDetails($patchJobInstanceDetails);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $client->patchJobName('[PROJECT]', '[PATCH_JOB]');
        $response = $client->listPatchJobInstanceDetails($formattedParent);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getPatchJobInstanceDetails()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.osconfig.v1.OsConfigService/ListPatchJobInstanceDetails', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listPatchJobInstanceDetailsExceptionTest()
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
        $formattedParent = $client->patchJobName('[PROJECT]', '[PATCH_JOB]');
        try {
            $client->listPatchJobInstanceDetails($formattedParent);
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
    public function listPatchJobsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $patchJobsElement = new PatchJob();
        $patchJobs = [
            $patchJobsElement,
        ];
        $expectedResponse = new ListPatchJobsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setPatchJobs($patchJobs);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $client->projectName('[PROJECT]');
        $response = $client->listPatchJobs($formattedParent);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getPatchJobs()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.osconfig.v1.OsConfigService/ListPatchJobs', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listPatchJobsExceptionTest()
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
        $formattedParent = $client->projectName('[PROJECT]');
        try {
            $client->listPatchJobs($formattedParent);
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
