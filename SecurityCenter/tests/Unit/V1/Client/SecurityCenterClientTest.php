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

namespace Google\Cloud\SecurityCenter\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Iam\V1\GetIamPolicyRequest;
use Google\Cloud\Iam\V1\Policy;
use Google\Cloud\Iam\V1\SetIamPolicyRequest;
use Google\Cloud\Iam\V1\TestIamPermissionsRequest;
use Google\Cloud\Iam\V1\TestIamPermissionsResponse;
use Google\Cloud\SecurityCenter\V1\BigQueryExport;
use Google\Cloud\SecurityCenter\V1\BulkMuteFindingsRequest;
use Google\Cloud\SecurityCenter\V1\BulkMuteFindingsResponse;
use Google\Cloud\SecurityCenter\V1\Client\SecurityCenterClient;
use Google\Cloud\SecurityCenter\V1\CreateBigQueryExportRequest;
use Google\Cloud\SecurityCenter\V1\CreateFindingRequest;
use Google\Cloud\SecurityCenter\V1\CreateMuteConfigRequest;
use Google\Cloud\SecurityCenter\V1\CreateNotificationConfigRequest;
use Google\Cloud\SecurityCenter\V1\CreateSecurityHealthAnalyticsCustomModuleRequest;
use Google\Cloud\SecurityCenter\V1\CreateSourceRequest;
use Google\Cloud\SecurityCenter\V1\CustomConfig;
use Google\Cloud\SecurityCenter\V1\DeleteBigQueryExportRequest;
use Google\Cloud\SecurityCenter\V1\DeleteMuteConfigRequest;
use Google\Cloud\SecurityCenter\V1\DeleteNotificationConfigRequest;
use Google\Cloud\SecurityCenter\V1\DeleteSecurityHealthAnalyticsCustomModuleRequest;
use Google\Cloud\SecurityCenter\V1\EffectiveSecurityHealthAnalyticsCustomModule;
use Google\Cloud\SecurityCenter\V1\ExternalSystem;
use Google\Cloud\SecurityCenter\V1\Finding;
use Google\Cloud\SecurityCenter\V1\Finding\Mute;
use Google\Cloud\SecurityCenter\V1\Finding\State;
use Google\Cloud\SecurityCenter\V1\GetBigQueryExportRequest;
use Google\Cloud\SecurityCenter\V1\GetEffectiveSecurityHealthAnalyticsCustomModuleRequest;
use Google\Cloud\SecurityCenter\V1\GetMuteConfigRequest;
use Google\Cloud\SecurityCenter\V1\GetNotificationConfigRequest;
use Google\Cloud\SecurityCenter\V1\GetOrganizationSettingsRequest;
use Google\Cloud\SecurityCenter\V1\GetSecurityHealthAnalyticsCustomModuleRequest;
use Google\Cloud\SecurityCenter\V1\GetSourceRequest;
use Google\Cloud\SecurityCenter\V1\GroupAssetsRequest;
use Google\Cloud\SecurityCenter\V1\GroupAssetsResponse;
use Google\Cloud\SecurityCenter\V1\GroupFindingsRequest;
use Google\Cloud\SecurityCenter\V1\GroupFindingsResponse;
use Google\Cloud\SecurityCenter\V1\GroupResult;
use Google\Cloud\SecurityCenter\V1\ListAssetsRequest;
use Google\Cloud\SecurityCenter\V1\ListAssetsResponse;
use Google\Cloud\SecurityCenter\V1\ListAssetsResponse\ListAssetsResult;
use Google\Cloud\SecurityCenter\V1\ListBigQueryExportsRequest;
use Google\Cloud\SecurityCenter\V1\ListBigQueryExportsResponse;
use Google\Cloud\SecurityCenter\V1\ListDescendantSecurityHealthAnalyticsCustomModulesRequest;
use Google\Cloud\SecurityCenter\V1\ListDescendantSecurityHealthAnalyticsCustomModulesResponse;
use Google\Cloud\SecurityCenter\V1\ListEffectiveSecurityHealthAnalyticsCustomModulesRequest;
use Google\Cloud\SecurityCenter\V1\ListEffectiveSecurityHealthAnalyticsCustomModulesResponse;
use Google\Cloud\SecurityCenter\V1\ListFindingsRequest;
use Google\Cloud\SecurityCenter\V1\ListFindingsResponse;
use Google\Cloud\SecurityCenter\V1\ListFindingsResponse\ListFindingsResult;
use Google\Cloud\SecurityCenter\V1\ListMuteConfigsRequest;
use Google\Cloud\SecurityCenter\V1\ListMuteConfigsResponse;
use Google\Cloud\SecurityCenter\V1\ListNotificationConfigsRequest;
use Google\Cloud\SecurityCenter\V1\ListNotificationConfigsResponse;
use Google\Cloud\SecurityCenter\V1\ListSecurityHealthAnalyticsCustomModulesRequest;
use Google\Cloud\SecurityCenter\V1\ListSecurityHealthAnalyticsCustomModulesResponse;
use Google\Cloud\SecurityCenter\V1\ListSourcesRequest;
use Google\Cloud\SecurityCenter\V1\ListSourcesResponse;
use Google\Cloud\SecurityCenter\V1\MuteConfig;
use Google\Cloud\SecurityCenter\V1\NotificationConfig;
use Google\Cloud\SecurityCenter\V1\OrganizationSettings;
use Google\Cloud\SecurityCenter\V1\RunAssetDiscoveryRequest;
use Google\Cloud\SecurityCenter\V1\RunAssetDiscoveryResponse;
use Google\Cloud\SecurityCenter\V1\SecurityHealthAnalyticsCustomModule;
use Google\Cloud\SecurityCenter\V1\SecurityMarks;
use Google\Cloud\SecurityCenter\V1\SetFindingStateRequest;
use Google\Cloud\SecurityCenter\V1\SetMuteRequest;
use Google\Cloud\SecurityCenter\V1\SimulateSecurityHealthAnalyticsCustomModuleRequest;
use Google\Cloud\SecurityCenter\V1\SimulateSecurityHealthAnalyticsCustomModuleRequest\SimulatedResource;
use Google\Cloud\SecurityCenter\V1\SimulateSecurityHealthAnalyticsCustomModuleResponse;
use Google\Cloud\SecurityCenter\V1\Source;
use Google\Cloud\SecurityCenter\V1\UpdateBigQueryExportRequest;
use Google\Cloud\SecurityCenter\V1\UpdateExternalSystemRequest;
use Google\Cloud\SecurityCenter\V1\UpdateFindingRequest;
use Google\Cloud\SecurityCenter\V1\UpdateMuteConfigRequest;
use Google\Cloud\SecurityCenter\V1\UpdateNotificationConfigRequest;
use Google\Cloud\SecurityCenter\V1\UpdateOrganizationSettingsRequest;
use Google\Cloud\SecurityCenter\V1\UpdateSecurityHealthAnalyticsCustomModuleRequest;
use Google\Cloud\SecurityCenter\V1\UpdateSecurityMarksRequest;
use Google\Cloud\SecurityCenter\V1\UpdateSourceRequest;
use Google\LongRunning\GetOperationRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\Any;
use Google\Protobuf\GPBEmpty;
use Google\Protobuf\Timestamp;
use Google\Rpc\Code;
use stdClass;

/**
 * @group securitycenter
 *
 * @group gapic
 */
class SecurityCenterClientTest extends GeneratedTest
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

    /** @return SecurityCenterClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new SecurityCenterClient($options);
    }

    /** @test */
    public function bulkMuteFindingsTest()
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
        $incompleteOperation->setName('operations/bulkMuteFindingsTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new BulkMuteFindingsResponse();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/bulkMuteFindingsTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $parent = 'parent-995424086';
        $request = (new BulkMuteFindingsRequest())
            ->setParent($parent);
        $response = $gapicClient->bulkMuteFindings($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/BulkMuteFindings', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/bulkMuteFindingsTest');
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
    public function bulkMuteFindingsExceptionTest()
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
        $incompleteOperation->setName('operations/bulkMuteFindingsTest');
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
        $parent = 'parent-995424086';
        $request = (new BulkMuteFindingsRequest())
            ->setParent($parent);
        $response = $gapicClient->bulkMuteFindings($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/bulkMuteFindingsTest');
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
    public function createBigQueryExportTest()
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
        $dataset = 'dataset1443214456';
        $mostRecentEditor = 'mostRecentEditor-657770475';
        $principal = 'principal-1812041682';
        $expectedResponse = new BigQueryExport();
        $expectedResponse->setName($name);
        $expectedResponse->setDescription($description);
        $expectedResponse->setFilter($filter);
        $expectedResponse->setDataset($dataset);
        $expectedResponse->setMostRecentEditor($mostRecentEditor);
        $expectedResponse->setPrincipal($principal);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $bigQueryExport = new BigQueryExport();
        $bigQueryExportId = 'bigQueryExportId269737360';
        $request = (new CreateBigQueryExportRequest())
            ->setParent($formattedParent)
            ->setBigQueryExport($bigQueryExport)
            ->setBigQueryExportId($bigQueryExportId);
        $response = $gapicClient->createBigQueryExport($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/CreateBigQueryExport', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getBigQueryExport();
        $this->assertProtobufEquals($bigQueryExport, $actualValue);
        $actualValue = $actualRequestObject->getBigQueryExportId();
        $this->assertProtobufEquals($bigQueryExportId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createBigQueryExportExceptionTest()
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
        $bigQueryExport = new BigQueryExport();
        $bigQueryExportId = 'bigQueryExportId269737360';
        $request = (new CreateBigQueryExportRequest())
            ->setParent($formattedParent)
            ->setBigQueryExport($bigQueryExport)
            ->setBigQueryExportId($bigQueryExportId);
        try {
            $gapicClient->createBigQueryExport($request);
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
    public function createFindingTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $parent2 = 'parent21175163357';
        $resourceName = 'resourceName979421212';
        $category = 'category50511102';
        $externalUri = 'externalUri-1385596168';
        $canonicalName = 'canonicalName1385400054';
        $muteInitiator = 'muteInitiator7603081';
        $parentDisplayName = 'parentDisplayName934119773';
        $description = 'description-1724546052';
        $nextSteps = 'nextSteps-921338149';
        $moduleName = 'moduleName-1195003778';
        $expectedResponse = new Finding();
        $expectedResponse->setName($name);
        $expectedResponse->setParent($parent2);
        $expectedResponse->setResourceName($resourceName);
        $expectedResponse->setCategory($category);
        $expectedResponse->setExternalUri($externalUri);
        $expectedResponse->setCanonicalName($canonicalName);
        $expectedResponse->setMuteInitiator($muteInitiator);
        $expectedResponse->setParentDisplayName($parentDisplayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setNextSteps($nextSteps);
        $expectedResponse->setModuleName($moduleName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->sourceName('[ORGANIZATION]', '[SOURCE]');
        $findingId = 'findingId728776081';
        $finding = new Finding();
        $request = (new CreateFindingRequest())
            ->setParent($formattedParent)
            ->setFindingId($findingId)
            ->setFinding($finding);
        $response = $gapicClient->createFinding($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/CreateFinding', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getFindingId();
        $this->assertProtobufEquals($findingId, $actualValue);
        $actualValue = $actualRequestObject->getFinding();
        $this->assertProtobufEquals($finding, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createFindingExceptionTest()
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
        $formattedParent = $gapicClient->sourceName('[ORGANIZATION]', '[SOURCE]');
        $findingId = 'findingId728776081';
        $finding = new Finding();
        $request = (new CreateFindingRequest())
            ->setParent($formattedParent)
            ->setFindingId($findingId)
            ->setFinding($finding);
        try {
            $gapicClient->createFinding($request);
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
    public function createMuteConfigTest()
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
        $filter = 'filter-1274492040';
        $mostRecentEditor = 'mostRecentEditor-657770475';
        $expectedResponse = new MuteConfig();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setFilter($filter);
        $expectedResponse->setMostRecentEditor($mostRecentEditor);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $muteConfig = new MuteConfig();
        $muteConfigFilter = 'muteConfigFilter-1921414637';
        $muteConfig->setFilter($muteConfigFilter);
        $muteConfigId = 'muteConfigId-547860334';
        $request = (new CreateMuteConfigRequest())
            ->setParent($formattedParent)
            ->setMuteConfig($muteConfig)
            ->setMuteConfigId($muteConfigId);
        $response = $gapicClient->createMuteConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/CreateMuteConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getMuteConfig();
        $this->assertProtobufEquals($muteConfig, $actualValue);
        $actualValue = $actualRequestObject->getMuteConfigId();
        $this->assertProtobufEquals($muteConfigId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createMuteConfigExceptionTest()
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
        $muteConfig = new MuteConfig();
        $muteConfigFilter = 'muteConfigFilter-1921414637';
        $muteConfig->setFilter($muteConfigFilter);
        $muteConfigId = 'muteConfigId-547860334';
        $request = (new CreateMuteConfigRequest())
            ->setParent($formattedParent)
            ->setMuteConfig($muteConfig)
            ->setMuteConfigId($muteConfigId);
        try {
            $gapicClient->createMuteConfig($request);
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
    public function createNotificationConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $description = 'description-1724546052';
        $pubsubTopic = 'pubsubTopic-338126829';
        $serviceAccount = 'serviceAccount-1948028253';
        $expectedResponse = new NotificationConfig();
        $expectedResponse->setName($name);
        $expectedResponse->setDescription($description);
        $expectedResponse->setPubsubTopic($pubsubTopic);
        $expectedResponse->setServiceAccount($serviceAccount);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $configId = 'configId-804450504';
        $notificationConfig = new NotificationConfig();
        $request = (new CreateNotificationConfigRequest())
            ->setParent($formattedParent)
            ->setConfigId($configId)
            ->setNotificationConfig($notificationConfig);
        $response = $gapicClient->createNotificationConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/CreateNotificationConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getConfigId();
        $this->assertProtobufEquals($configId, $actualValue);
        $actualValue = $actualRequestObject->getNotificationConfig();
        $this->assertProtobufEquals($notificationConfig, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createNotificationConfigExceptionTest()
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
        $configId = 'configId-804450504';
        $notificationConfig = new NotificationConfig();
        $request = (new CreateNotificationConfigRequest())
            ->setParent($formattedParent)
            ->setConfigId($configId)
            ->setNotificationConfig($notificationConfig);
        try {
            $gapicClient->createNotificationConfig($request);
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
    public function createSecurityHealthAnalyticsCustomModuleTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $lastEditor = 'lastEditor1620154166';
        $ancestorModule = 'ancestorModule-521996712';
        $expectedResponse = new SecurityHealthAnalyticsCustomModule();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setLastEditor($lastEditor);
        $expectedResponse->setAncestorModule($ancestorModule);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->securityHealthAnalyticsSettingsName('[ORGANIZATION]');
        $securityHealthAnalyticsCustomModule = new SecurityHealthAnalyticsCustomModule();
        $request = (new CreateSecurityHealthAnalyticsCustomModuleRequest())
            ->setParent($formattedParent)
            ->setSecurityHealthAnalyticsCustomModule($securityHealthAnalyticsCustomModule);
        $response = $gapicClient->createSecurityHealthAnalyticsCustomModule($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/CreateSecurityHealthAnalyticsCustomModule', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getSecurityHealthAnalyticsCustomModule();
        $this->assertProtobufEquals($securityHealthAnalyticsCustomModule, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createSecurityHealthAnalyticsCustomModuleExceptionTest()
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
        $formattedParent = $gapicClient->securityHealthAnalyticsSettingsName('[ORGANIZATION]');
        $securityHealthAnalyticsCustomModule = new SecurityHealthAnalyticsCustomModule();
        $request = (new CreateSecurityHealthAnalyticsCustomModuleRequest())
            ->setParent($formattedParent)
            ->setSecurityHealthAnalyticsCustomModule($securityHealthAnalyticsCustomModule);
        try {
            $gapicClient->createSecurityHealthAnalyticsCustomModule($request);
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
    public function createSourceTest()
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
        $canonicalName = 'canonicalName1385400054';
        $expectedResponse = new Source();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setCanonicalName($canonicalName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->organizationName('[ORGANIZATION]');
        $source = new Source();
        $request = (new CreateSourceRequest())
            ->setParent($formattedParent)
            ->setSource($source);
        $response = $gapicClient->createSource($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/CreateSource', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getSource();
        $this->assertProtobufEquals($source, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createSourceExceptionTest()
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
        $formattedParent = $gapicClient->organizationName('[ORGANIZATION]');
        $source = new Source();
        $request = (new CreateSourceRequest())
            ->setParent($formattedParent)
            ->setSource($source);
        try {
            $gapicClient->createSource($request);
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
    public function deleteBigQueryExportTest()
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
        $formattedName = $gapicClient->bigQueryExportName('[ORGANIZATION]', '[EXPORT]');
        $request = (new DeleteBigQueryExportRequest())
            ->setName($formattedName);
        $gapicClient->deleteBigQueryExport($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/DeleteBigQueryExport', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteBigQueryExportExceptionTest()
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
        $formattedName = $gapicClient->bigQueryExportName('[ORGANIZATION]', '[EXPORT]');
        $request = (new DeleteBigQueryExportRequest())
            ->setName($formattedName);
        try {
            $gapicClient->deleteBigQueryExport($request);
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
    public function deleteMuteConfigTest()
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
        $formattedName = $gapicClient->muteConfigName('[ORGANIZATION]', '[MUTE_CONFIG]');
        $request = (new DeleteMuteConfigRequest())
            ->setName($formattedName);
        $gapicClient->deleteMuteConfig($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/DeleteMuteConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteMuteConfigExceptionTest()
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
        $formattedName = $gapicClient->muteConfigName('[ORGANIZATION]', '[MUTE_CONFIG]');
        $request = (new DeleteMuteConfigRequest())
            ->setName($formattedName);
        try {
            $gapicClient->deleteMuteConfig($request);
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
    public function deleteNotificationConfigTest()
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
        $formattedName = $gapicClient->notificationConfigName('[ORGANIZATION]', '[NOTIFICATION_CONFIG]');
        $request = (new DeleteNotificationConfigRequest())
            ->setName($formattedName);
        $gapicClient->deleteNotificationConfig($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/DeleteNotificationConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteNotificationConfigExceptionTest()
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
        $formattedName = $gapicClient->notificationConfigName('[ORGANIZATION]', '[NOTIFICATION_CONFIG]');
        $request = (new DeleteNotificationConfigRequest())
            ->setName($formattedName);
        try {
            $gapicClient->deleteNotificationConfig($request);
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
    public function deleteSecurityHealthAnalyticsCustomModuleTest()
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
        $formattedName = $gapicClient->securityHealthAnalyticsCustomModuleName('[ORGANIZATION]', '[CUSTOM_MODULE]');
        $request = (new DeleteSecurityHealthAnalyticsCustomModuleRequest())
            ->setName($formattedName);
        $gapicClient->deleteSecurityHealthAnalyticsCustomModule($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/DeleteSecurityHealthAnalyticsCustomModule', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteSecurityHealthAnalyticsCustomModuleExceptionTest()
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
        $formattedName = $gapicClient->securityHealthAnalyticsCustomModuleName('[ORGANIZATION]', '[CUSTOM_MODULE]');
        $request = (new DeleteSecurityHealthAnalyticsCustomModuleRequest())
            ->setName($formattedName);
        try {
            $gapicClient->deleteSecurityHealthAnalyticsCustomModule($request);
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
    public function getBigQueryExportTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $description = 'description-1724546052';
        $filter = 'filter-1274492040';
        $dataset = 'dataset1443214456';
        $mostRecentEditor = 'mostRecentEditor-657770475';
        $principal = 'principal-1812041682';
        $expectedResponse = new BigQueryExport();
        $expectedResponse->setName($name2);
        $expectedResponse->setDescription($description);
        $expectedResponse->setFilter($filter);
        $expectedResponse->setDataset($dataset);
        $expectedResponse->setMostRecentEditor($mostRecentEditor);
        $expectedResponse->setPrincipal($principal);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->bigQueryExportName('[ORGANIZATION]', '[EXPORT]');
        $request = (new GetBigQueryExportRequest())
            ->setName($formattedName);
        $response = $gapicClient->getBigQueryExport($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/GetBigQueryExport', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getBigQueryExportExceptionTest()
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
        $formattedName = $gapicClient->bigQueryExportName('[ORGANIZATION]', '[EXPORT]');
        $request = (new GetBigQueryExportRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getBigQueryExport($request);
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
    public function getEffectiveSecurityHealthAnalyticsCustomModuleTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $expectedResponse = new EffectiveSecurityHealthAnalyticsCustomModule();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->effectiveSecurityHealthAnalyticsCustomModuleName('[ORGANIZATION]', '[EFFECTIVE_CUSTOM_MODULE]');
        $request = (new GetEffectiveSecurityHealthAnalyticsCustomModuleRequest())
            ->setName($formattedName);
        $response = $gapicClient->getEffectiveSecurityHealthAnalyticsCustomModule($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/GetEffectiveSecurityHealthAnalyticsCustomModule', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getEffectiveSecurityHealthAnalyticsCustomModuleExceptionTest()
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
        $formattedName = $gapicClient->effectiveSecurityHealthAnalyticsCustomModuleName('[ORGANIZATION]', '[EFFECTIVE_CUSTOM_MODULE]');
        $request = (new GetEffectiveSecurityHealthAnalyticsCustomModuleRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getEffectiveSecurityHealthAnalyticsCustomModule($request);
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
        $request = (new GetIamPolicyRequest())
            ->setResource($resource);
        $response = $gapicClient->getIamPolicy($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/GetIamPolicy', $actualFuncCall);
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
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $resource = 'resource-341064690';
        $request = (new GetIamPolicyRequest())
            ->setResource($resource);
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
    public function getMuteConfigTest()
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
        $filter = 'filter-1274492040';
        $mostRecentEditor = 'mostRecentEditor-657770475';
        $expectedResponse = new MuteConfig();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setFilter($filter);
        $expectedResponse->setMostRecentEditor($mostRecentEditor);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->muteConfigName('[ORGANIZATION]', '[MUTE_CONFIG]');
        $request = (new GetMuteConfigRequest())
            ->setName($formattedName);
        $response = $gapicClient->getMuteConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/GetMuteConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getMuteConfigExceptionTest()
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
        $formattedName = $gapicClient->muteConfigName('[ORGANIZATION]', '[MUTE_CONFIG]');
        $request = (new GetMuteConfigRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getMuteConfig($request);
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
    public function getNotificationConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $description = 'description-1724546052';
        $pubsubTopic = 'pubsubTopic-338126829';
        $serviceAccount = 'serviceAccount-1948028253';
        $expectedResponse = new NotificationConfig();
        $expectedResponse->setName($name2);
        $expectedResponse->setDescription($description);
        $expectedResponse->setPubsubTopic($pubsubTopic);
        $expectedResponse->setServiceAccount($serviceAccount);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->notificationConfigName('[ORGANIZATION]', '[NOTIFICATION_CONFIG]');
        $request = (new GetNotificationConfigRequest())
            ->setName($formattedName);
        $response = $gapicClient->getNotificationConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/GetNotificationConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getNotificationConfigExceptionTest()
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
        $formattedName = $gapicClient->notificationConfigName('[ORGANIZATION]', '[NOTIFICATION_CONFIG]');
        $request = (new GetNotificationConfigRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getNotificationConfig($request);
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
    public function getOrganizationSettingsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $enableAssetDiscovery = false;
        $expectedResponse = new OrganizationSettings();
        $expectedResponse->setName($name2);
        $expectedResponse->setEnableAssetDiscovery($enableAssetDiscovery);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->organizationSettingsName('[ORGANIZATION]');
        $request = (new GetOrganizationSettingsRequest())
            ->setName($formattedName);
        $response = $gapicClient->getOrganizationSettings($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/GetOrganizationSettings', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getOrganizationSettingsExceptionTest()
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
        $formattedName = $gapicClient->organizationSettingsName('[ORGANIZATION]');
        $request = (new GetOrganizationSettingsRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getOrganizationSettings($request);
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
    public function getSecurityHealthAnalyticsCustomModuleTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $lastEditor = 'lastEditor1620154166';
        $ancestorModule = 'ancestorModule-521996712';
        $expectedResponse = new SecurityHealthAnalyticsCustomModule();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setLastEditor($lastEditor);
        $expectedResponse->setAncestorModule($ancestorModule);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->securityHealthAnalyticsCustomModuleName('[ORGANIZATION]', '[CUSTOM_MODULE]');
        $request = (new GetSecurityHealthAnalyticsCustomModuleRequest())
            ->setName($formattedName);
        $response = $gapicClient->getSecurityHealthAnalyticsCustomModule($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/GetSecurityHealthAnalyticsCustomModule', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getSecurityHealthAnalyticsCustomModuleExceptionTest()
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
        $formattedName = $gapicClient->securityHealthAnalyticsCustomModuleName('[ORGANIZATION]', '[CUSTOM_MODULE]');
        $request = (new GetSecurityHealthAnalyticsCustomModuleRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getSecurityHealthAnalyticsCustomModule($request);
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
    public function getSourceTest()
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
        $canonicalName = 'canonicalName1385400054';
        $expectedResponse = new Source();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setCanonicalName($canonicalName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->sourceName('[ORGANIZATION]', '[SOURCE]');
        $request = (new GetSourceRequest())
            ->setName($formattedName);
        $response = $gapicClient->getSource($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/GetSource', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getSourceExceptionTest()
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
        $formattedName = $gapicClient->sourceName('[ORGANIZATION]', '[SOURCE]');
        $request = (new GetSourceRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getSource($request);
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
    public function groupAssetsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $totalSize = 705419236;
        $groupByResultsElement = new GroupResult();
        $groupByResults = [
            $groupByResultsElement,
        ];
        $expectedResponse = new GroupAssetsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setGroupByResults($groupByResults);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $groupBy = 'groupBy506361367';
        $request = (new GroupAssetsRequest())
            ->setParent($formattedParent)
            ->setGroupBy($groupBy);
        $response = $gapicClient->groupAssets($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getGroupByResults()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/GroupAssets', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getGroupBy();
        $this->assertProtobufEquals($groupBy, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function groupAssetsExceptionTest()
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
        $groupBy = 'groupBy506361367';
        $request = (new GroupAssetsRequest())
            ->setParent($formattedParent)
            ->setGroupBy($groupBy);
        try {
            $gapicClient->groupAssets($request);
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
    public function groupFindingsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $totalSize = 705419236;
        $groupByResultsElement = new GroupResult();
        $groupByResults = [
            $groupByResultsElement,
        ];
        $expectedResponse = new GroupFindingsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setGroupByResults($groupByResults);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->sourceName('[ORGANIZATION]', '[SOURCE]');
        $groupBy = 'groupBy506361367';
        $request = (new GroupFindingsRequest())
            ->setParent($formattedParent)
            ->setGroupBy($groupBy);
        $response = $gapicClient->groupFindings($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getGroupByResults()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/GroupFindings', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getGroupBy();
        $this->assertProtobufEquals($groupBy, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function groupFindingsExceptionTest()
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
        $formattedParent = $gapicClient->sourceName('[ORGANIZATION]', '[SOURCE]');
        $groupBy = 'groupBy506361367';
        $request = (new GroupFindingsRequest())
            ->setParent($formattedParent)
            ->setGroupBy($groupBy);
        try {
            $gapicClient->groupFindings($request);
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
    public function listAssetsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $totalSize = 705419236;
        $listAssetsResultsElement = new ListAssetsResult();
        $listAssetsResults = [
            $listAssetsResultsElement,
        ];
        $expectedResponse = new ListAssetsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setListAssetsResults($listAssetsResults);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $request = (new ListAssetsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listAssets($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getListAssetsResults()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/ListAssets', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listAssetsExceptionTest()
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
        $request = (new ListAssetsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listAssets($request);
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
    public function listBigQueryExportsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $bigQueryExportsElement = new BigQueryExport();
        $bigQueryExports = [
            $bigQueryExportsElement,
        ];
        $expectedResponse = new ListBigQueryExportsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setBigQueryExports($bigQueryExports);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $request = (new ListBigQueryExportsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listBigQueryExports($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getBigQueryExports()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/ListBigQueryExports', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listBigQueryExportsExceptionTest()
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
        $request = (new ListBigQueryExportsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listBigQueryExports($request);
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
    public function listDescendantSecurityHealthAnalyticsCustomModulesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $securityHealthAnalyticsCustomModulesElement = new SecurityHealthAnalyticsCustomModule();
        $securityHealthAnalyticsCustomModules = [
            $securityHealthAnalyticsCustomModulesElement,
        ];
        $expectedResponse = new ListDescendantSecurityHealthAnalyticsCustomModulesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setSecurityHealthAnalyticsCustomModules($securityHealthAnalyticsCustomModules);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->securityHealthAnalyticsSettingsName('[ORGANIZATION]');
        $request = (new ListDescendantSecurityHealthAnalyticsCustomModulesRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listDescendantSecurityHealthAnalyticsCustomModules($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getSecurityHealthAnalyticsCustomModules()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/ListDescendantSecurityHealthAnalyticsCustomModules', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listDescendantSecurityHealthAnalyticsCustomModulesExceptionTest()
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
        $formattedParent = $gapicClient->securityHealthAnalyticsSettingsName('[ORGANIZATION]');
        $request = (new ListDescendantSecurityHealthAnalyticsCustomModulesRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listDescendantSecurityHealthAnalyticsCustomModules($request);
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
    public function listEffectiveSecurityHealthAnalyticsCustomModulesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $effectiveSecurityHealthAnalyticsCustomModulesElement = new EffectiveSecurityHealthAnalyticsCustomModule();
        $effectiveSecurityHealthAnalyticsCustomModules = [
            $effectiveSecurityHealthAnalyticsCustomModulesElement,
        ];
        $expectedResponse = new ListEffectiveSecurityHealthAnalyticsCustomModulesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setEffectiveSecurityHealthAnalyticsCustomModules($effectiveSecurityHealthAnalyticsCustomModules);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->securityHealthAnalyticsSettingsName('[ORGANIZATION]');
        $request = (new ListEffectiveSecurityHealthAnalyticsCustomModulesRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listEffectiveSecurityHealthAnalyticsCustomModules($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getEffectiveSecurityHealthAnalyticsCustomModules()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/ListEffectiveSecurityHealthAnalyticsCustomModules', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listEffectiveSecurityHealthAnalyticsCustomModulesExceptionTest()
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
        $formattedParent = $gapicClient->securityHealthAnalyticsSettingsName('[ORGANIZATION]');
        $request = (new ListEffectiveSecurityHealthAnalyticsCustomModulesRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listEffectiveSecurityHealthAnalyticsCustomModules($request);
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
    public function listFindingsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $totalSize = 705419236;
        $listFindingsResultsElement = new ListFindingsResult();
        $listFindingsResults = [
            $listFindingsResultsElement,
        ];
        $expectedResponse = new ListFindingsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setListFindingsResults($listFindingsResults);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->sourceName('[ORGANIZATION]', '[SOURCE]');
        $request = (new ListFindingsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listFindings($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getListFindingsResults()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/ListFindings', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listFindingsExceptionTest()
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
        $formattedParent = $gapicClient->sourceName('[ORGANIZATION]', '[SOURCE]');
        $request = (new ListFindingsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listFindings($request);
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
    public function listMuteConfigsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $muteConfigsElement = new MuteConfig();
        $muteConfigs = [
            $muteConfigsElement,
        ];
        $expectedResponse = new ListMuteConfigsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setMuteConfigs($muteConfigs);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $request = (new ListMuteConfigsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listMuteConfigs($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getMuteConfigs()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/ListMuteConfigs', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listMuteConfigsExceptionTest()
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
        $request = (new ListMuteConfigsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listMuteConfigs($request);
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
    public function listNotificationConfigsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $notificationConfigsElement = new NotificationConfig();
        $notificationConfigs = [
            $notificationConfigsElement,
        ];
        $expectedResponse = new ListNotificationConfigsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setNotificationConfigs($notificationConfigs);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $request = (new ListNotificationConfigsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listNotificationConfigs($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getNotificationConfigs()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/ListNotificationConfigs', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listNotificationConfigsExceptionTest()
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
        $request = (new ListNotificationConfigsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listNotificationConfigs($request);
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
    public function listSecurityHealthAnalyticsCustomModulesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $securityHealthAnalyticsCustomModulesElement = new SecurityHealthAnalyticsCustomModule();
        $securityHealthAnalyticsCustomModules = [
            $securityHealthAnalyticsCustomModulesElement,
        ];
        $expectedResponse = new ListSecurityHealthAnalyticsCustomModulesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setSecurityHealthAnalyticsCustomModules($securityHealthAnalyticsCustomModules);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->securityHealthAnalyticsSettingsName('[ORGANIZATION]');
        $request = (new ListSecurityHealthAnalyticsCustomModulesRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listSecurityHealthAnalyticsCustomModules($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getSecurityHealthAnalyticsCustomModules()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/ListSecurityHealthAnalyticsCustomModules', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listSecurityHealthAnalyticsCustomModulesExceptionTest()
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
        $formattedParent = $gapicClient->securityHealthAnalyticsSettingsName('[ORGANIZATION]');
        $request = (new ListSecurityHealthAnalyticsCustomModulesRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listSecurityHealthAnalyticsCustomModules($request);
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
    public function listSourcesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $sourcesElement = new Source();
        $sources = [
            $sourcesElement,
        ];
        $expectedResponse = new ListSourcesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setSources($sources);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->projectName('[PROJECT]');
        $request = (new ListSourcesRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listSources($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getSources()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/ListSources', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listSourcesExceptionTest()
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
        $request = (new ListSourcesRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listSources($request);
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
    public function runAssetDiscoveryTest()
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
        $incompleteOperation->setName('operations/runAssetDiscoveryTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new RunAssetDiscoveryResponse();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/runAssetDiscoveryTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $gapicClient->organizationName('[ORGANIZATION]');
        $request = (new RunAssetDiscoveryRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->runAssetDiscovery($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/RunAssetDiscovery', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/runAssetDiscoveryTest');
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
    public function runAssetDiscoveryExceptionTest()
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
        $incompleteOperation->setName('operations/runAssetDiscoveryTest');
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
        $formattedParent = $gapicClient->organizationName('[ORGANIZATION]');
        $request = (new RunAssetDiscoveryRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->runAssetDiscovery($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/runAssetDiscoveryTest');
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
    public function setFindingStateTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $parent = 'parent-995424086';
        $resourceName = 'resourceName979421212';
        $category = 'category50511102';
        $externalUri = 'externalUri-1385596168';
        $canonicalName = 'canonicalName1385400054';
        $muteInitiator = 'muteInitiator7603081';
        $parentDisplayName = 'parentDisplayName934119773';
        $description = 'description-1724546052';
        $nextSteps = 'nextSteps-921338149';
        $moduleName = 'moduleName-1195003778';
        $expectedResponse = new Finding();
        $expectedResponse->setName($name2);
        $expectedResponse->setParent($parent);
        $expectedResponse->setResourceName($resourceName);
        $expectedResponse->setCategory($category);
        $expectedResponse->setExternalUri($externalUri);
        $expectedResponse->setCanonicalName($canonicalName);
        $expectedResponse->setMuteInitiator($muteInitiator);
        $expectedResponse->setParentDisplayName($parentDisplayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setNextSteps($nextSteps);
        $expectedResponse->setModuleName($moduleName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->findingName('[ORGANIZATION]', '[SOURCE]', '[FINDING]');
        $state = State::STATE_UNSPECIFIED;
        $startTime = new Timestamp();
        $request = (new SetFindingStateRequest())
            ->setName($formattedName)
            ->setState($state)
            ->setStartTime($startTime);
        $response = $gapicClient->setFindingState($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/SetFindingState', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getState();
        $this->assertProtobufEquals($state, $actualValue);
        $actualValue = $actualRequestObject->getStartTime();
        $this->assertProtobufEquals($startTime, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function setFindingStateExceptionTest()
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
        $formattedName = $gapicClient->findingName('[ORGANIZATION]', '[SOURCE]', '[FINDING]');
        $state = State::STATE_UNSPECIFIED;
        $startTime = new Timestamp();
        $request = (new SetFindingStateRequest())
            ->setName($formattedName)
            ->setState($state)
            ->setStartTime($startTime);
        try {
            $gapicClient->setFindingState($request);
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
        $request = (new SetIamPolicyRequest())
            ->setResource($resource)
            ->setPolicy($policy);
        $response = $gapicClient->setIamPolicy($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/SetIamPolicy', $actualFuncCall);
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
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $resource = 'resource-341064690';
        $policy = new Policy();
        $request = (new SetIamPolicyRequest())
            ->setResource($resource)
            ->setPolicy($policy);
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
    public function setMuteTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $parent = 'parent-995424086';
        $resourceName = 'resourceName979421212';
        $category = 'category50511102';
        $externalUri = 'externalUri-1385596168';
        $canonicalName = 'canonicalName1385400054';
        $muteInitiator = 'muteInitiator7603081';
        $parentDisplayName = 'parentDisplayName934119773';
        $description = 'description-1724546052';
        $nextSteps = 'nextSteps-921338149';
        $moduleName = 'moduleName-1195003778';
        $expectedResponse = new Finding();
        $expectedResponse->setName($name2);
        $expectedResponse->setParent($parent);
        $expectedResponse->setResourceName($resourceName);
        $expectedResponse->setCategory($category);
        $expectedResponse->setExternalUri($externalUri);
        $expectedResponse->setCanonicalName($canonicalName);
        $expectedResponse->setMuteInitiator($muteInitiator);
        $expectedResponse->setParentDisplayName($parentDisplayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setNextSteps($nextSteps);
        $expectedResponse->setModuleName($moduleName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->findingName('[ORGANIZATION]', '[SOURCE]', '[FINDING]');
        $mute = Mute::MUTE_UNSPECIFIED;
        $request = (new SetMuteRequest())
            ->setName($formattedName)
            ->setMute($mute);
        $response = $gapicClient->setMute($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/SetMute', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getMute();
        $this->assertProtobufEquals($mute, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function setMuteExceptionTest()
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
        $formattedName = $gapicClient->findingName('[ORGANIZATION]', '[SOURCE]', '[FINDING]');
        $mute = Mute::MUTE_UNSPECIFIED;
        $request = (new SetMuteRequest())
            ->setName($formattedName)
            ->setMute($mute);
        try {
            $gapicClient->setMute($request);
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
    public function simulateSecurityHealthAnalyticsCustomModuleTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new SimulateSecurityHealthAnalyticsCustomModuleResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $parent = 'parent-995424086';
        $customConfig = new CustomConfig();
        $resource = new SimulatedResource();
        $resourceResourceType = 'resourceResourceType305300374';
        $resource->setResourceType($resourceResourceType);
        $request = (new SimulateSecurityHealthAnalyticsCustomModuleRequest())
            ->setParent($parent)
            ->setCustomConfig($customConfig)
            ->setResource($resource);
        $response = $gapicClient->simulateSecurityHealthAnalyticsCustomModule($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/SimulateSecurityHealthAnalyticsCustomModule', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $actualValue = $actualRequestObject->getCustomConfig();
        $this->assertProtobufEquals($customConfig, $actualValue);
        $actualValue = $actualRequestObject->getResource();
        $this->assertProtobufEquals($resource, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function simulateSecurityHealthAnalyticsCustomModuleExceptionTest()
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
        $parent = 'parent-995424086';
        $customConfig = new CustomConfig();
        $resource = new SimulatedResource();
        $resourceResourceType = 'resourceResourceType305300374';
        $resource->setResourceType($resourceResourceType);
        $request = (new SimulateSecurityHealthAnalyticsCustomModuleRequest())
            ->setParent($parent)
            ->setCustomConfig($customConfig)
            ->setResource($resource);
        try {
            $gapicClient->simulateSecurityHealthAnalyticsCustomModule($request);
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
        $request = (new TestIamPermissionsRequest())
            ->setResource($resource)
            ->setPermissions($permissions);
        $response = $gapicClient->testIamPermissions($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/TestIamPermissions', $actualFuncCall);
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
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
        $transport->addResponse(null, $status);
        // Mock request
        $resource = 'resource-341064690';
        $permissions = [];
        $request = (new TestIamPermissionsRequest())
            ->setResource($resource)
            ->setPermissions($permissions);
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
    public function updateBigQueryExportTest()
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
        $dataset = 'dataset1443214456';
        $mostRecentEditor = 'mostRecentEditor-657770475';
        $principal = 'principal-1812041682';
        $expectedResponse = new BigQueryExport();
        $expectedResponse->setName($name);
        $expectedResponse->setDescription($description);
        $expectedResponse->setFilter($filter);
        $expectedResponse->setDataset($dataset);
        $expectedResponse->setMostRecentEditor($mostRecentEditor);
        $expectedResponse->setPrincipal($principal);
        $transport->addResponse($expectedResponse);
        // Mock request
        $bigQueryExport = new BigQueryExport();
        $request = (new UpdateBigQueryExportRequest())
            ->setBigQueryExport($bigQueryExport);
        $response = $gapicClient->updateBigQueryExport($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/UpdateBigQueryExport', $actualFuncCall);
        $actualValue = $actualRequestObject->getBigQueryExport();
        $this->assertProtobufEquals($bigQueryExport, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateBigQueryExportExceptionTest()
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
        $bigQueryExport = new BigQueryExport();
        $request = (new UpdateBigQueryExportRequest())
            ->setBigQueryExport($bigQueryExport);
        try {
            $gapicClient->updateBigQueryExport($request);
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
    public function updateExternalSystemTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $externalUid = 'externalUid-1385596452';
        $status = 'status-892481550';
        $expectedResponse = new ExternalSystem();
        $expectedResponse->setName($name);
        $expectedResponse->setExternalUid($externalUid);
        $expectedResponse->setStatus($status);
        $transport->addResponse($expectedResponse);
        // Mock request
        $externalSystem = new ExternalSystem();
        $request = (new UpdateExternalSystemRequest())
            ->setExternalSystem($externalSystem);
        $response = $gapicClient->updateExternalSystem($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/UpdateExternalSystem', $actualFuncCall);
        $actualValue = $actualRequestObject->getExternalSystem();
        $this->assertProtobufEquals($externalSystem, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateExternalSystemExceptionTest()
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
        $externalSystem = new ExternalSystem();
        $request = (new UpdateExternalSystemRequest())
            ->setExternalSystem($externalSystem);
        try {
            $gapicClient->updateExternalSystem($request);
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
    public function updateFindingTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $parent = 'parent-995424086';
        $resourceName = 'resourceName979421212';
        $category = 'category50511102';
        $externalUri = 'externalUri-1385596168';
        $canonicalName = 'canonicalName1385400054';
        $muteInitiator = 'muteInitiator7603081';
        $parentDisplayName = 'parentDisplayName934119773';
        $description = 'description-1724546052';
        $nextSteps = 'nextSteps-921338149';
        $moduleName = 'moduleName-1195003778';
        $expectedResponse = new Finding();
        $expectedResponse->setName($name);
        $expectedResponse->setParent($parent);
        $expectedResponse->setResourceName($resourceName);
        $expectedResponse->setCategory($category);
        $expectedResponse->setExternalUri($externalUri);
        $expectedResponse->setCanonicalName($canonicalName);
        $expectedResponse->setMuteInitiator($muteInitiator);
        $expectedResponse->setParentDisplayName($parentDisplayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setNextSteps($nextSteps);
        $expectedResponse->setModuleName($moduleName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $finding = new Finding();
        $request = (new UpdateFindingRequest())
            ->setFinding($finding);
        $response = $gapicClient->updateFinding($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/UpdateFinding', $actualFuncCall);
        $actualValue = $actualRequestObject->getFinding();
        $this->assertProtobufEquals($finding, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateFindingExceptionTest()
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
        $finding = new Finding();
        $request = (new UpdateFindingRequest())
            ->setFinding($finding);
        try {
            $gapicClient->updateFinding($request);
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
    public function updateMuteConfigTest()
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
        $filter = 'filter-1274492040';
        $mostRecentEditor = 'mostRecentEditor-657770475';
        $expectedResponse = new MuteConfig();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setFilter($filter);
        $expectedResponse->setMostRecentEditor($mostRecentEditor);
        $transport->addResponse($expectedResponse);
        // Mock request
        $muteConfig = new MuteConfig();
        $muteConfigFilter = 'muteConfigFilter-1921414637';
        $muteConfig->setFilter($muteConfigFilter);
        $request = (new UpdateMuteConfigRequest())
            ->setMuteConfig($muteConfig);
        $response = $gapicClient->updateMuteConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/UpdateMuteConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getMuteConfig();
        $this->assertProtobufEquals($muteConfig, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateMuteConfigExceptionTest()
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
        $muteConfig = new MuteConfig();
        $muteConfigFilter = 'muteConfigFilter-1921414637';
        $muteConfig->setFilter($muteConfigFilter);
        $request = (new UpdateMuteConfigRequest())
            ->setMuteConfig($muteConfig);
        try {
            $gapicClient->updateMuteConfig($request);
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
    public function updateNotificationConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $description = 'description-1724546052';
        $pubsubTopic = 'pubsubTopic-338126829';
        $serviceAccount = 'serviceAccount-1948028253';
        $expectedResponse = new NotificationConfig();
        $expectedResponse->setName($name);
        $expectedResponse->setDescription($description);
        $expectedResponse->setPubsubTopic($pubsubTopic);
        $expectedResponse->setServiceAccount($serviceAccount);
        $transport->addResponse($expectedResponse);
        // Mock request
        $notificationConfig = new NotificationConfig();
        $request = (new UpdateNotificationConfigRequest())
            ->setNotificationConfig($notificationConfig);
        $response = $gapicClient->updateNotificationConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/UpdateNotificationConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getNotificationConfig();
        $this->assertProtobufEquals($notificationConfig, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateNotificationConfigExceptionTest()
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
        $notificationConfig = new NotificationConfig();
        $request = (new UpdateNotificationConfigRequest())
            ->setNotificationConfig($notificationConfig);
        try {
            $gapicClient->updateNotificationConfig($request);
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
    public function updateOrganizationSettingsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $enableAssetDiscovery = false;
        $expectedResponse = new OrganizationSettings();
        $expectedResponse->setName($name);
        $expectedResponse->setEnableAssetDiscovery($enableAssetDiscovery);
        $transport->addResponse($expectedResponse);
        // Mock request
        $organizationSettings = new OrganizationSettings();
        $request = (new UpdateOrganizationSettingsRequest())
            ->setOrganizationSettings($organizationSettings);
        $response = $gapicClient->updateOrganizationSettings($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/UpdateOrganizationSettings', $actualFuncCall);
        $actualValue = $actualRequestObject->getOrganizationSettings();
        $this->assertProtobufEquals($organizationSettings, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateOrganizationSettingsExceptionTest()
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
        $organizationSettings = new OrganizationSettings();
        $request = (new UpdateOrganizationSettingsRequest())
            ->setOrganizationSettings($organizationSettings);
        try {
            $gapicClient->updateOrganizationSettings($request);
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
    public function updateSecurityHealthAnalyticsCustomModuleTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $lastEditor = 'lastEditor1620154166';
        $ancestorModule = 'ancestorModule-521996712';
        $expectedResponse = new SecurityHealthAnalyticsCustomModule();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setLastEditor($lastEditor);
        $expectedResponse->setAncestorModule($ancestorModule);
        $transport->addResponse($expectedResponse);
        // Mock request
        $securityHealthAnalyticsCustomModule = new SecurityHealthAnalyticsCustomModule();
        $request = (new UpdateSecurityHealthAnalyticsCustomModuleRequest())
            ->setSecurityHealthAnalyticsCustomModule($securityHealthAnalyticsCustomModule);
        $response = $gapicClient->updateSecurityHealthAnalyticsCustomModule($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/UpdateSecurityHealthAnalyticsCustomModule', $actualFuncCall);
        $actualValue = $actualRequestObject->getSecurityHealthAnalyticsCustomModule();
        $this->assertProtobufEquals($securityHealthAnalyticsCustomModule, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateSecurityHealthAnalyticsCustomModuleExceptionTest()
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
        $securityHealthAnalyticsCustomModule = new SecurityHealthAnalyticsCustomModule();
        $request = (new UpdateSecurityHealthAnalyticsCustomModuleRequest())
            ->setSecurityHealthAnalyticsCustomModule($securityHealthAnalyticsCustomModule);
        try {
            $gapicClient->updateSecurityHealthAnalyticsCustomModule($request);
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
    public function updateSecurityMarksTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $canonicalName = 'canonicalName1385400054';
        $expectedResponse = new SecurityMarks();
        $expectedResponse->setName($name);
        $expectedResponse->setCanonicalName($canonicalName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $securityMarks = new SecurityMarks();
        $request = (new UpdateSecurityMarksRequest())
            ->setSecurityMarks($securityMarks);
        $response = $gapicClient->updateSecurityMarks($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/UpdateSecurityMarks', $actualFuncCall);
        $actualValue = $actualRequestObject->getSecurityMarks();
        $this->assertProtobufEquals($securityMarks, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateSecurityMarksExceptionTest()
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
        $securityMarks = new SecurityMarks();
        $request = (new UpdateSecurityMarksRequest())
            ->setSecurityMarks($securityMarks);
        try {
            $gapicClient->updateSecurityMarks($request);
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
    public function updateSourceTest()
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
        $canonicalName = 'canonicalName1385400054';
        $expectedResponse = new Source();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $expectedResponse->setCanonicalName($canonicalName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $source = new Source();
        $request = (new UpdateSourceRequest())
            ->setSource($source);
        $response = $gapicClient->updateSource($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/UpdateSource', $actualFuncCall);
        $actualValue = $actualRequestObject->getSource();
        $this->assertProtobufEquals($source, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateSourceExceptionTest()
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
        $source = new Source();
        $request = (new UpdateSourceRequest())
            ->setSource($source);
        try {
            $gapicClient->updateSource($request);
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
    public function bulkMuteFindingsAsyncTest()
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
        $incompleteOperation->setName('operations/bulkMuteFindingsTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new BulkMuteFindingsResponse();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/bulkMuteFindingsTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $parent = 'parent-995424086';
        $request = (new BulkMuteFindingsRequest())
            ->setParent($parent);
        $response = $gapicClient->bulkMuteFindingsAsync($request)->wait();
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.securitycenter.v1.SecurityCenter/BulkMuteFindings', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($parent, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/bulkMuteFindingsTest');
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
}
