<?php
/*
 * Copyright 2021 Google LLC
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

namespace Google\Cloud\AssuredWorkloads\Tests\Unit\V1beta1;

use Google\ApiCore\ApiException;

use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\Testing\GeneratedTest;

use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\AssuredWorkloads\V1beta1\AssuredWorkloadsServiceClient;
use Google\Cloud\AssuredWorkloads\V1beta1\ListWorkloadsResponse;

use Google\Cloud\AssuredWorkloads\V1beta1\Workload;
use Google\Cloud\AssuredWorkloads\V1beta1\Workload\CJISSettings;
use Google\Cloud\AssuredWorkloads\V1beta1\Workload\ComplianceRegime;
use Google\Cloud\AssuredWorkloads\V1beta1\Workload\FedrampHighSettings;
use Google\Cloud\AssuredWorkloads\V1beta1\Workload\FedrampModerateSettings;
use Google\Cloud\AssuredWorkloads\V1beta1\Workload\IL4Settings;
use Google\Cloud\AssuredWorkloads\V1beta1\Workload\KMSSettings;
use Google\LongRunning\GetOperationRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\Any;
use Google\Protobuf\Duration;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;
use Google\Protobuf\Timestamp;
use Google\Rpc\Code;
use stdClass;

/**
 * @group assuredworkloads
 *
 * @group gapic
 */
class AssuredWorkloadsServiceClientTest extends GeneratedTest
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
     * @return AssuredWorkloadsServiceClient
     */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new AssuredWorkloadsServiceClient($options);
    }

    /**
     * @test
     */
    public function createWorkloadTest()
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
        $incompleteOperation->setName('operations/createWorkloadTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $billingAccount = 'billingAccount-545871767';
        $etag = 'etag3123477';
        $provisionedResourcesParent = 'provisionedResourcesParent-158134097';
        $expectedResponse = new Workload();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setBillingAccount($billingAccount);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setProvisionedResourcesParent($provisionedResourcesParent);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/createWorkloadTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $client->locationName('[ORGANIZATION]', '[LOCATION]');
        $workload = new Workload();
        $workloadDisplayName = 'workloadDisplayName191619702';
        $workload->setDisplayName($workloadDisplayName);
        $workloadComplianceRegime = ComplianceRegime::COMPLIANCE_REGIME_UNSPECIFIED;
        $workload->setComplianceRegime($workloadComplianceRegime);
        $workloadBillingAccount = 'workloadBillingAccount-2106140023';
        $workload->setBillingAccount($workloadBillingAccount);
        $workloadIl4Settings = new IL4Settings();
        $il4SettingsKmsSettings = new KMSSettings();
        $kmsSettingsNextRotationTime = new Timestamp();
        $il4SettingsKmsSettings->setNextRotationTime($kmsSettingsNextRotationTime);
        $kmsSettingsRotationPeriod = new Duration();
        $il4SettingsKmsSettings->setRotationPeriod($kmsSettingsRotationPeriod);
        $workloadIl4Settings->setKmsSettings($il4SettingsKmsSettings);
        $workload->setIl4Settings($workloadIl4Settings);
        $workloadCjisSettings = new CJISSettings();
        $cjisSettingsKmsSettings = new KMSSettings();
        $kmsSettingsNextRotationTime = new Timestamp();
        $cjisSettingsKmsSettings->setNextRotationTime($kmsSettingsNextRotationTime);
        $kmsSettingsRotationPeriod = new Duration();
        $cjisSettingsKmsSettings->setRotationPeriod($kmsSettingsRotationPeriod);
        $workloadCjisSettings->setKmsSettings($cjisSettingsKmsSettings);
        $workload->setCjisSettings($workloadCjisSettings);
        $workloadFedrampHighSettings = new FedrampHighSettings();
        $fedrampHighSettingsKmsSettings = new KMSSettings();
        $kmsSettingsNextRotationTime = new Timestamp();
        $fedrampHighSettingsKmsSettings->setNextRotationTime($kmsSettingsNextRotationTime);
        $kmsSettingsRotationPeriod = new Duration();
        $fedrampHighSettingsKmsSettings->setRotationPeriod($kmsSettingsRotationPeriod);
        $workloadFedrampHighSettings->setKmsSettings($fedrampHighSettingsKmsSettings);
        $workload->setFedrampHighSettings($workloadFedrampHighSettings);
        $workloadFedrampModerateSettings = new FedrampModerateSettings();
        $fedrampModerateSettingsKmsSettings = new KMSSettings();
        $kmsSettingsNextRotationTime = new Timestamp();
        $fedrampModerateSettingsKmsSettings->setNextRotationTime($kmsSettingsNextRotationTime);
        $kmsSettingsRotationPeriod = new Duration();
        $fedrampModerateSettingsKmsSettings->setRotationPeriod($kmsSettingsRotationPeriod);
        $workloadFedrampModerateSettings->setKmsSettings($fedrampModerateSettingsKmsSettings);
        $workload->setFedrampModerateSettings($workloadFedrampModerateSettings);
        $response = $client->createWorkload($formattedParent, $workload);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.assuredworkloads.v1beta1.AssuredWorkloadsService/CreateWorkload', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getWorkload();
        $this->assertProtobufEquals($workload, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createWorkloadTest');
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
    public function createWorkloadExceptionTest()
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
        $incompleteOperation->setName('operations/createWorkloadTest');
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
        $formattedParent = $client->locationName('[ORGANIZATION]', '[LOCATION]');
        $workload = new Workload();
        $workloadDisplayName = 'workloadDisplayName191619702';
        $workload->setDisplayName($workloadDisplayName);
        $workloadComplianceRegime = ComplianceRegime::COMPLIANCE_REGIME_UNSPECIFIED;
        $workload->setComplianceRegime($workloadComplianceRegime);
        $workloadBillingAccount = 'workloadBillingAccount-2106140023';
        $workload->setBillingAccount($workloadBillingAccount);
        $workloadIl4Settings = new IL4Settings();
        $il4SettingsKmsSettings = new KMSSettings();
        $kmsSettingsNextRotationTime = new Timestamp();
        $il4SettingsKmsSettings->setNextRotationTime($kmsSettingsNextRotationTime);
        $kmsSettingsRotationPeriod = new Duration();
        $il4SettingsKmsSettings->setRotationPeriod($kmsSettingsRotationPeriod);
        $workloadIl4Settings->setKmsSettings($il4SettingsKmsSettings);
        $workload->setIl4Settings($workloadIl4Settings);
        $workloadCjisSettings = new CJISSettings();
        $cjisSettingsKmsSettings = new KMSSettings();
        $kmsSettingsNextRotationTime = new Timestamp();
        $cjisSettingsKmsSettings->setNextRotationTime($kmsSettingsNextRotationTime);
        $kmsSettingsRotationPeriod = new Duration();
        $cjisSettingsKmsSettings->setRotationPeriod($kmsSettingsRotationPeriod);
        $workloadCjisSettings->setKmsSettings($cjisSettingsKmsSettings);
        $workload->setCjisSettings($workloadCjisSettings);
        $workloadFedrampHighSettings = new FedrampHighSettings();
        $fedrampHighSettingsKmsSettings = new KMSSettings();
        $kmsSettingsNextRotationTime = new Timestamp();
        $fedrampHighSettingsKmsSettings->setNextRotationTime($kmsSettingsNextRotationTime);
        $kmsSettingsRotationPeriod = new Duration();
        $fedrampHighSettingsKmsSettings->setRotationPeriod($kmsSettingsRotationPeriod);
        $workloadFedrampHighSettings->setKmsSettings($fedrampHighSettingsKmsSettings);
        $workload->setFedrampHighSettings($workloadFedrampHighSettings);
        $workloadFedrampModerateSettings = new FedrampModerateSettings();
        $fedrampModerateSettingsKmsSettings = new KMSSettings();
        $kmsSettingsNextRotationTime = new Timestamp();
        $fedrampModerateSettingsKmsSettings->setNextRotationTime($kmsSettingsNextRotationTime);
        $kmsSettingsRotationPeriod = new Duration();
        $fedrampModerateSettingsKmsSettings->setRotationPeriod($kmsSettingsRotationPeriod);
        $workloadFedrampModerateSettings->setKmsSettings($fedrampModerateSettingsKmsSettings);
        $workload->setFedrampModerateSettings($workloadFedrampModerateSettings);
        $response = $client->createWorkload($formattedParent, $workload);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createWorkloadTest');
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
    public function deleteWorkloadTest()
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
        $formattedName = $client->workloadName('[ORGANIZATION]', '[LOCATION]', '[WORKLOAD]');
        $client->deleteWorkload($formattedName);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.assuredworkloads.v1beta1.AssuredWorkloadsService/DeleteWorkload', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function deleteWorkloadExceptionTest()
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
        $formattedName = $client->workloadName('[ORGANIZATION]', '[LOCATION]', '[WORKLOAD]');
        try {
            $client->deleteWorkload($formattedName);
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
    public function getWorkloadTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $billingAccount = 'billingAccount-545871767';
        $etag = 'etag3123477';
        $provisionedResourcesParent = 'provisionedResourcesParent-158134097';
        $expectedResponse = new Workload();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setBillingAccount($billingAccount);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setProvisionedResourcesParent($provisionedResourcesParent);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $client->workloadName('[ORGANIZATION]', '[LOCATION]', '[WORKLOAD]');
        $response = $client->getWorkload($formattedName);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.assuredworkloads.v1beta1.AssuredWorkloadsService/GetWorkload', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function getWorkloadExceptionTest()
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
        $formattedName = $client->workloadName('[ORGANIZATION]', '[LOCATION]', '[WORKLOAD]');
        try {
            $client->getWorkload($formattedName);
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
    public function listWorkloadsTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $workloadsElement = new Workload();
        $workloads = [
            $workloadsElement,
        ];
        $expectedResponse = new ListWorkloadsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setWorkloads($workloads);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $client->locationName('[ORGANIZATION]', '[LOCATION]');
        $response = $client->listWorkloads($formattedParent);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getWorkloads()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.assuredworkloads.v1beta1.AssuredWorkloadsService/ListWorkloads', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function listWorkloadsExceptionTest()
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
        $formattedParent = $client->locationName('[ORGANIZATION]', '[LOCATION]');
        try {
            $client->listWorkloads($formattedParent);
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
    public function updateWorkloadTest()
    {
        $transport = $this->createTransport();
        $client = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $billingAccount = 'billingAccount-545871767';
        $etag = 'etag3123477';
        $provisionedResourcesParent = 'provisionedResourcesParent-158134097';
        $expectedResponse = new Workload();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setBillingAccount($billingAccount);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setProvisionedResourcesParent($provisionedResourcesParent);
        $transport->addResponse($expectedResponse);
        // Mock request
        $workload = new Workload();
        $workloadDisplayName = 'workloadDisplayName191619702';
        $workload->setDisplayName($workloadDisplayName);
        $workloadComplianceRegime = ComplianceRegime::COMPLIANCE_REGIME_UNSPECIFIED;
        $workload->setComplianceRegime($workloadComplianceRegime);
        $workloadBillingAccount = 'workloadBillingAccount-2106140023';
        $workload->setBillingAccount($workloadBillingAccount);
        $workloadIl4Settings = new IL4Settings();
        $il4SettingsKmsSettings = new KMSSettings();
        $kmsSettingsNextRotationTime = new Timestamp();
        $il4SettingsKmsSettings->setNextRotationTime($kmsSettingsNextRotationTime);
        $kmsSettingsRotationPeriod = new Duration();
        $il4SettingsKmsSettings->setRotationPeriod($kmsSettingsRotationPeriod);
        $workloadIl4Settings->setKmsSettings($il4SettingsKmsSettings);
        $workload->setIl4Settings($workloadIl4Settings);
        $workloadCjisSettings = new CJISSettings();
        $cjisSettingsKmsSettings = new KMSSettings();
        $kmsSettingsNextRotationTime = new Timestamp();
        $cjisSettingsKmsSettings->setNextRotationTime($kmsSettingsNextRotationTime);
        $kmsSettingsRotationPeriod = new Duration();
        $cjisSettingsKmsSettings->setRotationPeriod($kmsSettingsRotationPeriod);
        $workloadCjisSettings->setKmsSettings($cjisSettingsKmsSettings);
        $workload->setCjisSettings($workloadCjisSettings);
        $workloadFedrampHighSettings = new FedrampHighSettings();
        $fedrampHighSettingsKmsSettings = new KMSSettings();
        $kmsSettingsNextRotationTime = new Timestamp();
        $fedrampHighSettingsKmsSettings->setNextRotationTime($kmsSettingsNextRotationTime);
        $kmsSettingsRotationPeriod = new Duration();
        $fedrampHighSettingsKmsSettings->setRotationPeriod($kmsSettingsRotationPeriod);
        $workloadFedrampHighSettings->setKmsSettings($fedrampHighSettingsKmsSettings);
        $workload->setFedrampHighSettings($workloadFedrampHighSettings);
        $workloadFedrampModerateSettings = new FedrampModerateSettings();
        $fedrampModerateSettingsKmsSettings = new KMSSettings();
        $kmsSettingsNextRotationTime = new Timestamp();
        $fedrampModerateSettingsKmsSettings->setNextRotationTime($kmsSettingsNextRotationTime);
        $kmsSettingsRotationPeriod = new Duration();
        $fedrampModerateSettingsKmsSettings->setRotationPeriod($kmsSettingsRotationPeriod);
        $workloadFedrampModerateSettings->setKmsSettings($fedrampModerateSettingsKmsSettings);
        $workload->setFedrampModerateSettings($workloadFedrampModerateSettings);
        $updateMask = new FieldMask();
        $response = $client->updateWorkload($workload, $updateMask);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.assuredworkloads.v1beta1.AssuredWorkloadsService/UpdateWorkload', $actualFuncCall);
        $actualValue = $actualRequestObject->getWorkload();
        $this->assertProtobufEquals($workload, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /**
     * @test
     */
    public function updateWorkloadExceptionTest()
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
        $workload = new Workload();
        $workloadDisplayName = 'workloadDisplayName191619702';
        $workload->setDisplayName($workloadDisplayName);
        $workloadComplianceRegime = ComplianceRegime::COMPLIANCE_REGIME_UNSPECIFIED;
        $workload->setComplianceRegime($workloadComplianceRegime);
        $workloadBillingAccount = 'workloadBillingAccount-2106140023';
        $workload->setBillingAccount($workloadBillingAccount);
        $workloadIl4Settings = new IL4Settings();
        $il4SettingsKmsSettings = new KMSSettings();
        $kmsSettingsNextRotationTime = new Timestamp();
        $il4SettingsKmsSettings->setNextRotationTime($kmsSettingsNextRotationTime);
        $kmsSettingsRotationPeriod = new Duration();
        $il4SettingsKmsSettings->setRotationPeriod($kmsSettingsRotationPeriod);
        $workloadIl4Settings->setKmsSettings($il4SettingsKmsSettings);
        $workload->setIl4Settings($workloadIl4Settings);
        $workloadCjisSettings = new CJISSettings();
        $cjisSettingsKmsSettings = new KMSSettings();
        $kmsSettingsNextRotationTime = new Timestamp();
        $cjisSettingsKmsSettings->setNextRotationTime($kmsSettingsNextRotationTime);
        $kmsSettingsRotationPeriod = new Duration();
        $cjisSettingsKmsSettings->setRotationPeriod($kmsSettingsRotationPeriod);
        $workloadCjisSettings->setKmsSettings($cjisSettingsKmsSettings);
        $workload->setCjisSettings($workloadCjisSettings);
        $workloadFedrampHighSettings = new FedrampHighSettings();
        $fedrampHighSettingsKmsSettings = new KMSSettings();
        $kmsSettingsNextRotationTime = new Timestamp();
        $fedrampHighSettingsKmsSettings->setNextRotationTime($kmsSettingsNextRotationTime);
        $kmsSettingsRotationPeriod = new Duration();
        $fedrampHighSettingsKmsSettings->setRotationPeriod($kmsSettingsRotationPeriod);
        $workloadFedrampHighSettings->setKmsSettings($fedrampHighSettingsKmsSettings);
        $workload->setFedrampHighSettings($workloadFedrampHighSettings);
        $workloadFedrampModerateSettings = new FedrampModerateSettings();
        $fedrampModerateSettingsKmsSettings = new KMSSettings();
        $kmsSettingsNextRotationTime = new Timestamp();
        $fedrampModerateSettingsKmsSettings->setNextRotationTime($kmsSettingsNextRotationTime);
        $kmsSettingsRotationPeriod = new Duration();
        $fedrampModerateSettingsKmsSettings->setRotationPeriod($kmsSettingsRotationPeriod);
        $workloadFedrampModerateSettings->setKmsSettings($fedrampModerateSettingsKmsSettings);
        $workload->setFedrampModerateSettings($workloadFedrampModerateSettings);
        $updateMask = new FieldMask();
        try {
            $client->updateWorkload($workload, $updateMask);
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
