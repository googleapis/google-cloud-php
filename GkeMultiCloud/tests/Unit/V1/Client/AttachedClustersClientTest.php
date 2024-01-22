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

namespace Google\Cloud\GkeMultiCloud\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\GkeMultiCloud\V1\AttachedCluster;
use Google\Cloud\GkeMultiCloud\V1\AttachedOidcConfig;
use Google\Cloud\GkeMultiCloud\V1\AttachedServerConfig;
use Google\Cloud\GkeMultiCloud\V1\Client\AttachedClustersClient;
use Google\Cloud\GkeMultiCloud\V1\CreateAttachedClusterRequest;
use Google\Cloud\GkeMultiCloud\V1\DeleteAttachedClusterRequest;
use Google\Cloud\GkeMultiCloud\V1\Fleet;
use Google\Cloud\GkeMultiCloud\V1\GenerateAttachedClusterAgentTokenRequest;
use Google\Cloud\GkeMultiCloud\V1\GenerateAttachedClusterAgentTokenResponse;
use Google\Cloud\GkeMultiCloud\V1\GenerateAttachedClusterInstallManifestRequest;
use Google\Cloud\GkeMultiCloud\V1\GenerateAttachedClusterInstallManifestResponse;
use Google\Cloud\GkeMultiCloud\V1\GetAttachedClusterRequest;
use Google\Cloud\GkeMultiCloud\V1\GetAttachedServerConfigRequest;
use Google\Cloud\GkeMultiCloud\V1\ImportAttachedClusterRequest;
use Google\Cloud\GkeMultiCloud\V1\ListAttachedClustersRequest;
use Google\Cloud\GkeMultiCloud\V1\ListAttachedClustersResponse;
use Google\Cloud\GkeMultiCloud\V1\UpdateAttachedClusterRequest;
use Google\LongRunning\GetOperationRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\Any;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group gkemulticloud
 *
 * @group gapic
 */
class AttachedClustersClientTest extends GeneratedTest
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

    /** @return AttachedClustersClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new AttachedClustersClient($options);
    }

    /** @test */
    public function createAttachedClusterTest()
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
        $incompleteOperation->setName('operations/createAttachedClusterTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $description = 'description-1724546052';
        $platformVersion = 'platformVersion1813514508';
        $distribution = 'distribution-1580708220';
        $clusterRegion = 'clusterRegion993903833';
        $uid = 'uid115792';
        $reconciling = false;
        $etag = 'etag3123477';
        $kubernetesVersion = 'kubernetesVersion50850015';
        $expectedResponse = new AttachedCluster();
        $expectedResponse->setName($name);
        $expectedResponse->setDescription($description);
        $expectedResponse->setPlatformVersion($platformVersion);
        $expectedResponse->setDistribution($distribution);
        $expectedResponse->setClusterRegion($clusterRegion);
        $expectedResponse->setUid($uid);
        $expectedResponse->setReconciling($reconciling);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setKubernetesVersion($kubernetesVersion);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/createAttachedClusterTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $attachedCluster = new AttachedCluster();
        $attachedClusterOidcConfig = new AttachedOidcConfig();
        $attachedCluster->setOidcConfig($attachedClusterOidcConfig);
        $attachedClusterPlatformVersion = 'attachedClusterPlatformVersion-208126385';
        $attachedCluster->setPlatformVersion($attachedClusterPlatformVersion);
        $attachedClusterDistribution = 'attachedClusterDistribution1692601690';
        $attachedCluster->setDistribution($attachedClusterDistribution);
        $attachedClusterFleet = new Fleet();
        $fleetProject = 'fleetProject604893675';
        $attachedClusterFleet->setProject($fleetProject);
        $attachedCluster->setFleet($attachedClusterFleet);
        $attachedClusterId = 'attachedClusterId-249426181';
        $request = (new CreateAttachedClusterRequest())
            ->setParent($formattedParent)
            ->setAttachedCluster($attachedCluster)
            ->setAttachedClusterId($attachedClusterId);
        $response = $gapicClient->createAttachedCluster($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AttachedClusters/CreateAttachedCluster', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getAttachedCluster();
        $this->assertProtobufEquals($attachedCluster, $actualValue);
        $actualValue = $actualApiRequestObject->getAttachedClusterId();
        $this->assertProtobufEquals($attachedClusterId, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createAttachedClusterTest');
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
    public function createAttachedClusterExceptionTest()
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
        $incompleteOperation->setName('operations/createAttachedClusterTest');
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $attachedCluster = new AttachedCluster();
        $attachedClusterOidcConfig = new AttachedOidcConfig();
        $attachedCluster->setOidcConfig($attachedClusterOidcConfig);
        $attachedClusterPlatformVersion = 'attachedClusterPlatformVersion-208126385';
        $attachedCluster->setPlatformVersion($attachedClusterPlatformVersion);
        $attachedClusterDistribution = 'attachedClusterDistribution1692601690';
        $attachedCluster->setDistribution($attachedClusterDistribution);
        $attachedClusterFleet = new Fleet();
        $fleetProject = 'fleetProject604893675';
        $attachedClusterFleet->setProject($fleetProject);
        $attachedCluster->setFleet($attachedClusterFleet);
        $attachedClusterId = 'attachedClusterId-249426181';
        $request = (new CreateAttachedClusterRequest())
            ->setParent($formattedParent)
            ->setAttachedCluster($attachedCluster)
            ->setAttachedClusterId($attachedClusterId);
        $response = $gapicClient->createAttachedCluster($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createAttachedClusterTest');
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
    public function deleteAttachedClusterTest()
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
        $incompleteOperation->setName('operations/deleteAttachedClusterTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new GPBEmpty();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/deleteAttachedClusterTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->attachedClusterName('[PROJECT]', '[LOCATION]', '[ATTACHED_CLUSTER]');
        $request = (new DeleteAttachedClusterRequest())
            ->setName($formattedName);
        $response = $gapicClient->deleteAttachedCluster($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AttachedClusters/DeleteAttachedCluster', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteAttachedClusterTest');
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
    public function deleteAttachedClusterExceptionTest()
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
        $incompleteOperation->setName('operations/deleteAttachedClusterTest');
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
        $formattedName = $gapicClient->attachedClusterName('[PROJECT]', '[LOCATION]', '[ATTACHED_CLUSTER]');
        $request = (new DeleteAttachedClusterRequest())
            ->setName($formattedName);
        $response = $gapicClient->deleteAttachedCluster($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteAttachedClusterTest');
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
    public function generateAttachedClusterAgentTokenTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $accessToken = 'accessToken-1938933922';
        $expiresIn = 833810928;
        $tokenType = 'tokenType101507520';
        $expectedResponse = new GenerateAttachedClusterAgentTokenResponse();
        $expectedResponse->setAccessToken($accessToken);
        $expectedResponse->setExpiresIn($expiresIn);
        $expectedResponse->setTokenType($tokenType);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedAttachedCluster = $gapicClient->attachedClusterName('[PROJECT]', '[LOCATION]', '[ATTACHED_CLUSTER]');
        $subjectToken = 'subjectToken454811942';
        $subjectTokenType = 'subjectTokenType-697160013';
        $version = 'version351608024';
        $request = (new GenerateAttachedClusterAgentTokenRequest())
            ->setAttachedCluster($formattedAttachedCluster)
            ->setSubjectToken($subjectToken)
            ->setSubjectTokenType($subjectTokenType)
            ->setVersion($version);
        $response = $gapicClient->generateAttachedClusterAgentToken($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AttachedClusters/GenerateAttachedClusterAgentToken', $actualFuncCall);
        $actualValue = $actualRequestObject->getAttachedCluster();
        $this->assertProtobufEquals($formattedAttachedCluster, $actualValue);
        $actualValue = $actualRequestObject->getSubjectToken();
        $this->assertProtobufEquals($subjectToken, $actualValue);
        $actualValue = $actualRequestObject->getSubjectTokenType();
        $this->assertProtobufEquals($subjectTokenType, $actualValue);
        $actualValue = $actualRequestObject->getVersion();
        $this->assertProtobufEquals($version, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function generateAttachedClusterAgentTokenExceptionTest()
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
        $formattedAttachedCluster = $gapicClient->attachedClusterName('[PROJECT]', '[LOCATION]', '[ATTACHED_CLUSTER]');
        $subjectToken = 'subjectToken454811942';
        $subjectTokenType = 'subjectTokenType-697160013';
        $version = 'version351608024';
        $request = (new GenerateAttachedClusterAgentTokenRequest())
            ->setAttachedCluster($formattedAttachedCluster)
            ->setSubjectToken($subjectToken)
            ->setSubjectTokenType($subjectTokenType)
            ->setVersion($version);
        try {
            $gapicClient->generateAttachedClusterAgentToken($request);
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
    public function generateAttachedClusterInstallManifestTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $manifest = 'manifest130625071';
        $expectedResponse = new GenerateAttachedClusterInstallManifestResponse();
        $expectedResponse->setManifest($manifest);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $attachedClusterId = 'attachedClusterId-249426181';
        $platformVersion = 'platformVersion1813514508';
        $request = (new GenerateAttachedClusterInstallManifestRequest())
            ->setParent($formattedParent)
            ->setAttachedClusterId($attachedClusterId)
            ->setPlatformVersion($platformVersion);
        $response = $gapicClient->generateAttachedClusterInstallManifest($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AttachedClusters/GenerateAttachedClusterInstallManifest', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getAttachedClusterId();
        $this->assertProtobufEquals($attachedClusterId, $actualValue);
        $actualValue = $actualRequestObject->getPlatformVersion();
        $this->assertProtobufEquals($platformVersion, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function generateAttachedClusterInstallManifestExceptionTest()
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $attachedClusterId = 'attachedClusterId-249426181';
        $platformVersion = 'platformVersion1813514508';
        $request = (new GenerateAttachedClusterInstallManifestRequest())
            ->setParent($formattedParent)
            ->setAttachedClusterId($attachedClusterId)
            ->setPlatformVersion($platformVersion);
        try {
            $gapicClient->generateAttachedClusterInstallManifest($request);
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
    public function getAttachedClusterTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $description = 'description-1724546052';
        $platformVersion = 'platformVersion1813514508';
        $distribution = 'distribution-1580708220';
        $clusterRegion = 'clusterRegion993903833';
        $uid = 'uid115792';
        $reconciling = false;
        $etag = 'etag3123477';
        $kubernetesVersion = 'kubernetesVersion50850015';
        $expectedResponse = new AttachedCluster();
        $expectedResponse->setName($name2);
        $expectedResponse->setDescription($description);
        $expectedResponse->setPlatformVersion($platformVersion);
        $expectedResponse->setDistribution($distribution);
        $expectedResponse->setClusterRegion($clusterRegion);
        $expectedResponse->setUid($uid);
        $expectedResponse->setReconciling($reconciling);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setKubernetesVersion($kubernetesVersion);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->attachedClusterName('[PROJECT]', '[LOCATION]', '[ATTACHED_CLUSTER]');
        $request = (new GetAttachedClusterRequest())
            ->setName($formattedName);
        $response = $gapicClient->getAttachedCluster($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AttachedClusters/GetAttachedCluster', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getAttachedClusterExceptionTest()
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
        $formattedName = $gapicClient->attachedClusterName('[PROJECT]', '[LOCATION]', '[ATTACHED_CLUSTER]');
        $request = (new GetAttachedClusterRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getAttachedCluster($request);
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
    public function getAttachedServerConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $expectedResponse = new AttachedServerConfig();
        $expectedResponse->setName($name2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->attachedServerConfigName('[PROJECT]', '[LOCATION]');
        $request = (new GetAttachedServerConfigRequest())
            ->setName($formattedName);
        $response = $gapicClient->getAttachedServerConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AttachedClusters/GetAttachedServerConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getAttachedServerConfigExceptionTest()
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
        $formattedName = $gapicClient->attachedServerConfigName('[PROJECT]', '[LOCATION]');
        $request = (new GetAttachedServerConfigRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getAttachedServerConfig($request);
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
    public function importAttachedClusterTest()
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
        $incompleteOperation->setName('operations/importAttachedClusterTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $description = 'description-1724546052';
        $platformVersion2 = 'platformVersion2-969276993';
        $distribution2 = 'distribution21357826359';
        $clusterRegion = 'clusterRegion993903833';
        $uid = 'uid115792';
        $reconciling = false;
        $etag = 'etag3123477';
        $kubernetesVersion = 'kubernetesVersion50850015';
        $expectedResponse = new AttachedCluster();
        $expectedResponse->setName($name);
        $expectedResponse->setDescription($description);
        $expectedResponse->setPlatformVersion($platformVersion2);
        $expectedResponse->setDistribution($distribution2);
        $expectedResponse->setClusterRegion($clusterRegion);
        $expectedResponse->setUid($uid);
        $expectedResponse->setReconciling($reconciling);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setKubernetesVersion($kubernetesVersion);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/importAttachedClusterTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $fleetMembership = 'fleetMembership1817977703';
        $platformVersion = 'platformVersion1813514508';
        $distribution = 'distribution-1580708220';
        $request = (new ImportAttachedClusterRequest())
            ->setParent($formattedParent)
            ->setFleetMembership($fleetMembership)
            ->setPlatformVersion($platformVersion)
            ->setDistribution($distribution);
        $response = $gapicClient->importAttachedCluster($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AttachedClusters/ImportAttachedCluster', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getFleetMembership();
        $this->assertProtobufEquals($fleetMembership, $actualValue);
        $actualValue = $actualApiRequestObject->getPlatformVersion();
        $this->assertProtobufEquals($platformVersion, $actualValue);
        $actualValue = $actualApiRequestObject->getDistribution();
        $this->assertProtobufEquals($distribution, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/importAttachedClusterTest');
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
    public function importAttachedClusterExceptionTest()
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
        $incompleteOperation->setName('operations/importAttachedClusterTest');
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $fleetMembership = 'fleetMembership1817977703';
        $platformVersion = 'platformVersion1813514508';
        $distribution = 'distribution-1580708220';
        $request = (new ImportAttachedClusterRequest())
            ->setParent($formattedParent)
            ->setFleetMembership($fleetMembership)
            ->setPlatformVersion($platformVersion)
            ->setDistribution($distribution);
        $response = $gapicClient->importAttachedCluster($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/importAttachedClusterTest');
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
    public function listAttachedClustersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $attachedClustersElement = new AttachedCluster();
        $attachedClusters = [
            $attachedClustersElement,
        ];
        $expectedResponse = new ListAttachedClustersResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setAttachedClusters($attachedClusters);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListAttachedClustersRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listAttachedClusters($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAttachedClusters()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AttachedClusters/ListAttachedClusters', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listAttachedClustersExceptionTest()
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListAttachedClustersRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listAttachedClusters($request);
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
    public function updateAttachedClusterTest()
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
        $incompleteOperation->setName('operations/updateAttachedClusterTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $description = 'description-1724546052';
        $platformVersion = 'platformVersion1813514508';
        $distribution = 'distribution-1580708220';
        $clusterRegion = 'clusterRegion993903833';
        $uid = 'uid115792';
        $reconciling = false;
        $etag = 'etag3123477';
        $kubernetesVersion = 'kubernetesVersion50850015';
        $expectedResponse = new AttachedCluster();
        $expectedResponse->setName($name);
        $expectedResponse->setDescription($description);
        $expectedResponse->setPlatformVersion($platformVersion);
        $expectedResponse->setDistribution($distribution);
        $expectedResponse->setClusterRegion($clusterRegion);
        $expectedResponse->setUid($uid);
        $expectedResponse->setReconciling($reconciling);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setKubernetesVersion($kubernetesVersion);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/updateAttachedClusterTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $attachedCluster = new AttachedCluster();
        $attachedClusterOidcConfig = new AttachedOidcConfig();
        $attachedCluster->setOidcConfig($attachedClusterOidcConfig);
        $attachedClusterPlatformVersion = 'attachedClusterPlatformVersion-208126385';
        $attachedCluster->setPlatformVersion($attachedClusterPlatformVersion);
        $attachedClusterDistribution = 'attachedClusterDistribution1692601690';
        $attachedCluster->setDistribution($attachedClusterDistribution);
        $attachedClusterFleet = new Fleet();
        $fleetProject = 'fleetProject604893675';
        $attachedClusterFleet->setProject($fleetProject);
        $attachedCluster->setFleet($attachedClusterFleet);
        $updateMask = new FieldMask();
        $request = (new UpdateAttachedClusterRequest())
            ->setAttachedCluster($attachedCluster)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateAttachedCluster($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AttachedClusters/UpdateAttachedCluster', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getAttachedCluster();
        $this->assertProtobufEquals($attachedCluster, $actualValue);
        $actualValue = $actualApiRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/updateAttachedClusterTest');
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
    public function updateAttachedClusterExceptionTest()
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
        $incompleteOperation->setName('operations/updateAttachedClusterTest');
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
        $attachedCluster = new AttachedCluster();
        $attachedClusterOidcConfig = new AttachedOidcConfig();
        $attachedCluster->setOidcConfig($attachedClusterOidcConfig);
        $attachedClusterPlatformVersion = 'attachedClusterPlatformVersion-208126385';
        $attachedCluster->setPlatformVersion($attachedClusterPlatformVersion);
        $attachedClusterDistribution = 'attachedClusterDistribution1692601690';
        $attachedCluster->setDistribution($attachedClusterDistribution);
        $attachedClusterFleet = new Fleet();
        $fleetProject = 'fleetProject604893675';
        $attachedClusterFleet->setProject($fleetProject);
        $attachedCluster->setFleet($attachedClusterFleet);
        $updateMask = new FieldMask();
        $request = (new UpdateAttachedClusterRequest())
            ->setAttachedCluster($attachedCluster)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateAttachedCluster($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/updateAttachedClusterTest');
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
    public function createAttachedClusterAsyncTest()
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
        $incompleteOperation->setName('operations/createAttachedClusterTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $description = 'description-1724546052';
        $platformVersion = 'platformVersion1813514508';
        $distribution = 'distribution-1580708220';
        $clusterRegion = 'clusterRegion993903833';
        $uid = 'uid115792';
        $reconciling = false;
        $etag = 'etag3123477';
        $kubernetesVersion = 'kubernetesVersion50850015';
        $expectedResponse = new AttachedCluster();
        $expectedResponse->setName($name);
        $expectedResponse->setDescription($description);
        $expectedResponse->setPlatformVersion($platformVersion);
        $expectedResponse->setDistribution($distribution);
        $expectedResponse->setClusterRegion($clusterRegion);
        $expectedResponse->setUid($uid);
        $expectedResponse->setReconciling($reconciling);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setKubernetesVersion($kubernetesVersion);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/createAttachedClusterTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $attachedCluster = new AttachedCluster();
        $attachedClusterOidcConfig = new AttachedOidcConfig();
        $attachedCluster->setOidcConfig($attachedClusterOidcConfig);
        $attachedClusterPlatformVersion = 'attachedClusterPlatformVersion-208126385';
        $attachedCluster->setPlatformVersion($attachedClusterPlatformVersion);
        $attachedClusterDistribution = 'attachedClusterDistribution1692601690';
        $attachedCluster->setDistribution($attachedClusterDistribution);
        $attachedClusterFleet = new Fleet();
        $fleetProject = 'fleetProject604893675';
        $attachedClusterFleet->setProject($fleetProject);
        $attachedCluster->setFleet($attachedClusterFleet);
        $attachedClusterId = 'attachedClusterId-249426181';
        $request = (new CreateAttachedClusterRequest())
            ->setParent($formattedParent)
            ->setAttachedCluster($attachedCluster)
            ->setAttachedClusterId($attachedClusterId);
        $response = $gapicClient->createAttachedClusterAsync($request)->wait();
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.gkemulticloud.v1.AttachedClusters/CreateAttachedCluster', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getAttachedCluster();
        $this->assertProtobufEquals($attachedCluster, $actualValue);
        $actualValue = $actualApiRequestObject->getAttachedClusterId();
        $this->assertProtobufEquals($attachedClusterId, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createAttachedClusterTest');
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
