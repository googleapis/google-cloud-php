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

namespace Google\Cloud\Sql\Tests\Unit\V1beta4;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Sql\V1beta4\DatabaseInstance;
use Google\Cloud\Sql\V1beta4\InstancesListResponse;
use Google\Cloud\Sql\V1beta4\InstancesListServerCasResponse;
use Google\Cloud\Sql\V1beta4\Operation;
use Google\Cloud\Sql\V1beta4\SqlInstancesGetDiskShrinkConfigResponse;
use Google\Cloud\Sql\V1beta4\SqlInstancesGetLatestRecoveryTimeResponse;
use Google\Cloud\Sql\V1beta4\SqlInstancesServiceClient;
use Google\Cloud\Sql\V1beta4\SqlInstancesVerifyExternalSyncSettingsResponse;
use Google\Cloud\Sql\V1beta4\SslCert;
use Google\Rpc\Code;
use stdClass;

/**
 * @group sql
 *
 * @group gapic
 */
class SqlInstancesServiceClientTest extends GeneratedTest
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

    /** @return SqlInstancesServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new SqlInstancesServiceClient($options);
    }

    /** @test */
    public function addServerCaTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $targetLink = 'targetLink-2084812312';
        $user = 'user3599307';
        $name = 'name3373707';
        $targetId = 'targetId-815576439';
        $selfLink = 'selfLink-1691268851';
        $targetProject = 'targetProject392184427';
        $expectedResponse = new Operation();
        $expectedResponse->setKind($kind);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setName($name);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetProject($targetProject);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->addServerCa();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1beta4.SqlInstancesService/AddServerCa', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function addServerCaExceptionTest()
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
        try {
            $gapicClient->addServerCa();
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
    public function cloneTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $targetLink = 'targetLink-2084812312';
        $user = 'user3599307';
        $name = 'name3373707';
        $targetId = 'targetId-815576439';
        $selfLink = 'selfLink-1691268851';
        $targetProject = 'targetProject392184427';
        $expectedResponse = new Operation();
        $expectedResponse->setKind($kind);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setName($name);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetProject($targetProject);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->clone();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1beta4.SqlInstancesService/Clone', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function cloneExceptionTest()
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
        try {
            $gapicClient->clone();
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
    public function createEphemeralTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $certSerialNumber = 'certSerialNumber-440611559';
        $cert = 'cert3050020';
        $commonName = 'commonName-1924955041';
        $sha1Fingerprint = 'sha1Fingerprint-1699692374';
        $instance2 = 'instance2902024968';
        $selfLink = 'selfLink-1691268851';
        $expectedResponse = new SslCert();
        $expectedResponse->setKind($kind);
        $expectedResponse->setCertSerialNumber($certSerialNumber);
        $expectedResponse->setCert($cert);
        $expectedResponse->setCommonName($commonName);
        $expectedResponse->setSha1Fingerprint($sha1Fingerprint);
        $expectedResponse->setInstance($instance2);
        $expectedResponse->setSelfLink($selfLink);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->createEphemeral();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1beta4.SqlInstancesService/CreateEphemeral', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createEphemeralExceptionTest()
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
        try {
            $gapicClient->createEphemeral();
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
    public function deleteTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $targetLink = 'targetLink-2084812312';
        $user = 'user3599307';
        $name = 'name3373707';
        $targetId = 'targetId-815576439';
        $selfLink = 'selfLink-1691268851';
        $targetProject = 'targetProject392184427';
        $expectedResponse = new Operation();
        $expectedResponse->setKind($kind);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setName($name);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetProject($targetProject);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->delete();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1beta4.SqlInstancesService/Delete', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteExceptionTest()
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
        try {
            $gapicClient->delete();
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
    public function demoteMasterTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $targetLink = 'targetLink-2084812312';
        $user = 'user3599307';
        $name = 'name3373707';
        $targetId = 'targetId-815576439';
        $selfLink = 'selfLink-1691268851';
        $targetProject = 'targetProject392184427';
        $expectedResponse = new Operation();
        $expectedResponse->setKind($kind);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setName($name);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetProject($targetProject);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->demoteMaster();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1beta4.SqlInstancesService/DemoteMaster', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function demoteMasterExceptionTest()
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
        try {
            $gapicClient->demoteMaster();
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
    public function exportTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $targetLink = 'targetLink-2084812312';
        $user = 'user3599307';
        $name = 'name3373707';
        $targetId = 'targetId-815576439';
        $selfLink = 'selfLink-1691268851';
        $targetProject = 'targetProject392184427';
        $expectedResponse = new Operation();
        $expectedResponse->setKind($kind);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setName($name);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetProject($targetProject);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->export();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1beta4.SqlInstancesService/Export', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function exportExceptionTest()
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
        try {
            $gapicClient->export();
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
    public function failoverTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $targetLink = 'targetLink-2084812312';
        $user = 'user3599307';
        $name = 'name3373707';
        $targetId = 'targetId-815576439';
        $selfLink = 'selfLink-1691268851';
        $targetProject = 'targetProject392184427';
        $expectedResponse = new Operation();
        $expectedResponse->setKind($kind);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setName($name);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetProject($targetProject);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->failover();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1beta4.SqlInstancesService/Failover', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function failoverExceptionTest()
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
        try {
            $gapicClient->failover();
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
    public function getTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $etag = 'etag3123477';
        $masterInstanceName = 'masterInstanceName-383886120';
        $project2 = 'project2-894831476';
        $ipv6Address = 'ipv6Address1952176540';
        $serviceAccountEmailAddress = 'serviceAccountEmailAddress303603125';
        $selfLink = 'selfLink-1691268851';
        $connectionName = 'connectionName731664204';
        $name = 'name3373707';
        $region = 'region-934795532';
        $gceZone = 'gceZone-227587294';
        $secondaryGceZone = 'secondaryGceZone826699149';
        $rootPassword = 'rootPassword448743768';
        $databaseInstalledVersion = 'databaseInstalledVersion-1701014705';
        $maintenanceVersion = 'maintenanceVersion-588975188';
        $pscServiceAttachmentLink = 'pscServiceAttachmentLink309057421';
        $dnsName = 'dnsName411992033';
        $primaryDnsName = 'primaryDnsName-1306966658';
        $writeEndpoint = 'writeEndpoint-1575656971';
        $expectedResponse = new DatabaseInstance();
        $expectedResponse->setKind($kind);
        $expectedResponse->setEtag($etag);
        $expectedResponse->setMasterInstanceName($masterInstanceName);
        $expectedResponse->setProject($project2);
        $expectedResponse->setIpv6Address($ipv6Address);
        $expectedResponse->setServiceAccountEmailAddress($serviceAccountEmailAddress);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setConnectionName($connectionName);
        $expectedResponse->setName($name);
        $expectedResponse->setRegion($region);
        $expectedResponse->setGceZone($gceZone);
        $expectedResponse->setSecondaryGceZone($secondaryGceZone);
        $expectedResponse->setRootPassword($rootPassword);
        $expectedResponse->setDatabaseInstalledVersion($databaseInstalledVersion);
        $expectedResponse->setMaintenanceVersion($maintenanceVersion);
        $expectedResponse->setPscServiceAttachmentLink($pscServiceAttachmentLink);
        $expectedResponse->setDnsName($dnsName);
        $expectedResponse->setPrimaryDnsName($primaryDnsName);
        $expectedResponse->setWriteEndpoint($writeEndpoint);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->get();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1beta4.SqlInstancesService/Get', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getExceptionTest()
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
        try {
            $gapicClient->get();
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
    public function getDiskShrinkConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $minimalTargetSizeGb = 1076246647;
        $message = 'message954925063';
        $expectedResponse = new SqlInstancesGetDiskShrinkConfigResponse();
        $expectedResponse->setKind($kind);
        $expectedResponse->setMinimalTargetSizeGb($minimalTargetSizeGb);
        $expectedResponse->setMessage($message);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->getDiskShrinkConfig();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1beta4.SqlInstancesService/GetDiskShrinkConfig', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getDiskShrinkConfigExceptionTest()
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
        try {
            $gapicClient->getDiskShrinkConfig();
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
    public function getLatestRecoveryTimeTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $expectedResponse = new SqlInstancesGetLatestRecoveryTimeResponse();
        $expectedResponse->setKind($kind);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->getLatestRecoveryTime();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1beta4.SqlInstancesService/GetLatestRecoveryTime', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getLatestRecoveryTimeExceptionTest()
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
        try {
            $gapicClient->getLatestRecoveryTime();
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
    public function importTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $targetLink = 'targetLink-2084812312';
        $user = 'user3599307';
        $name = 'name3373707';
        $targetId = 'targetId-815576439';
        $selfLink = 'selfLink-1691268851';
        $targetProject = 'targetProject392184427';
        $expectedResponse = new Operation();
        $expectedResponse->setKind($kind);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setName($name);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetProject($targetProject);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->import();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1beta4.SqlInstancesService/Import', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function importExceptionTest()
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
        try {
            $gapicClient->import();
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
    public function insertTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $targetLink = 'targetLink-2084812312';
        $user = 'user3599307';
        $name = 'name3373707';
        $targetId = 'targetId-815576439';
        $selfLink = 'selfLink-1691268851';
        $targetProject = 'targetProject392184427';
        $expectedResponse = new Operation();
        $expectedResponse->setKind($kind);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setName($name);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetProject($targetProject);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->insert();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1beta4.SqlInstancesService/Insert', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function insertExceptionTest()
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
        try {
            $gapicClient->insert();
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
    public function listTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $nextPageToken = 'nextPageToken-1530815211';
        $expectedResponse = new InstancesListResponse();
        $expectedResponse->setKind($kind);
        $expectedResponse->setNextPageToken($nextPageToken);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->list();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1beta4.SqlInstancesService/List', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listExceptionTest()
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
        try {
            $gapicClient->list();
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
    public function listServerCasTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $activeVersion = 'activeVersion442490015';
        $kind = 'kind3292052';
        $expectedResponse = new InstancesListServerCasResponse();
        $expectedResponse->setActiveVersion($activeVersion);
        $expectedResponse->setKind($kind);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->listServerCas();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1beta4.SqlInstancesService/ListServerCas', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listServerCasExceptionTest()
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
        try {
            $gapicClient->listServerCas();
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
    public function patchTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $targetLink = 'targetLink-2084812312';
        $user = 'user3599307';
        $name = 'name3373707';
        $targetId = 'targetId-815576439';
        $selfLink = 'selfLink-1691268851';
        $targetProject = 'targetProject392184427';
        $expectedResponse = new Operation();
        $expectedResponse->setKind($kind);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setName($name);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetProject($targetProject);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->patch();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1beta4.SqlInstancesService/Patch', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function patchExceptionTest()
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
        try {
            $gapicClient->patch();
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
    public function performDiskShrinkTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $targetLink = 'targetLink-2084812312';
        $user = 'user3599307';
        $name = 'name3373707';
        $targetId = 'targetId-815576439';
        $selfLink = 'selfLink-1691268851';
        $targetProject = 'targetProject392184427';
        $expectedResponse = new Operation();
        $expectedResponse->setKind($kind);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setName($name);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetProject($targetProject);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->performDiskShrink();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1beta4.SqlInstancesService/PerformDiskShrink', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function performDiskShrinkExceptionTest()
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
        try {
            $gapicClient->performDiskShrink();
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
    public function promoteReplicaTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $targetLink = 'targetLink-2084812312';
        $user = 'user3599307';
        $name = 'name3373707';
        $targetId = 'targetId-815576439';
        $selfLink = 'selfLink-1691268851';
        $targetProject = 'targetProject392184427';
        $expectedResponse = new Operation();
        $expectedResponse->setKind($kind);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setName($name);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetProject($targetProject);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->promoteReplica();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1beta4.SqlInstancesService/PromoteReplica', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function promoteReplicaExceptionTest()
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
        try {
            $gapicClient->promoteReplica();
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
    public function reencryptTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $targetLink = 'targetLink-2084812312';
        $user = 'user3599307';
        $name = 'name3373707';
        $targetId = 'targetId-815576439';
        $selfLink = 'selfLink-1691268851';
        $targetProject = 'targetProject392184427';
        $expectedResponse = new Operation();
        $expectedResponse->setKind($kind);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setName($name);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetProject($targetProject);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->reencrypt();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1beta4.SqlInstancesService/Reencrypt', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function reencryptExceptionTest()
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
        try {
            $gapicClient->reencrypt();
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
    public function rescheduleMaintenanceTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $targetLink = 'targetLink-2084812312';
        $user = 'user3599307';
        $name = 'name3373707';
        $targetId = 'targetId-815576439';
        $selfLink = 'selfLink-1691268851';
        $targetProject = 'targetProject392184427';
        $expectedResponse = new Operation();
        $expectedResponse->setKind($kind);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setName($name);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetProject($targetProject);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->rescheduleMaintenance();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1beta4.SqlInstancesService/RescheduleMaintenance', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function rescheduleMaintenanceExceptionTest()
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
        try {
            $gapicClient->rescheduleMaintenance();
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
    public function resetReplicaSizeTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $targetLink = 'targetLink-2084812312';
        $user = 'user3599307';
        $name = 'name3373707';
        $targetId = 'targetId-815576439';
        $selfLink = 'selfLink-1691268851';
        $targetProject = 'targetProject392184427';
        $expectedResponse = new Operation();
        $expectedResponse->setKind($kind);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setName($name);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetProject($targetProject);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->resetReplicaSize();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1beta4.SqlInstancesService/ResetReplicaSize', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function resetReplicaSizeExceptionTest()
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
        try {
            $gapicClient->resetReplicaSize();
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
    public function resetSslConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $targetLink = 'targetLink-2084812312';
        $user = 'user3599307';
        $name = 'name3373707';
        $targetId = 'targetId-815576439';
        $selfLink = 'selfLink-1691268851';
        $targetProject = 'targetProject392184427';
        $expectedResponse = new Operation();
        $expectedResponse->setKind($kind);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setName($name);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetProject($targetProject);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->resetSslConfig();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1beta4.SqlInstancesService/ResetSslConfig', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function resetSslConfigExceptionTest()
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
        try {
            $gapicClient->resetSslConfig();
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
    public function restartTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $targetLink = 'targetLink-2084812312';
        $user = 'user3599307';
        $name = 'name3373707';
        $targetId = 'targetId-815576439';
        $selfLink = 'selfLink-1691268851';
        $targetProject = 'targetProject392184427';
        $expectedResponse = new Operation();
        $expectedResponse->setKind($kind);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setName($name);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetProject($targetProject);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->restart();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1beta4.SqlInstancesService/Restart', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function restartExceptionTest()
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
        try {
            $gapicClient->restart();
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
    public function restoreBackupTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $targetLink = 'targetLink-2084812312';
        $user = 'user3599307';
        $name = 'name3373707';
        $targetId = 'targetId-815576439';
        $selfLink = 'selfLink-1691268851';
        $targetProject = 'targetProject392184427';
        $expectedResponse = new Operation();
        $expectedResponse->setKind($kind);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setName($name);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetProject($targetProject);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->restoreBackup();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1beta4.SqlInstancesService/RestoreBackup', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function restoreBackupExceptionTest()
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
        try {
            $gapicClient->restoreBackup();
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
    public function rotateServerCaTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $targetLink = 'targetLink-2084812312';
        $user = 'user3599307';
        $name = 'name3373707';
        $targetId = 'targetId-815576439';
        $selfLink = 'selfLink-1691268851';
        $targetProject = 'targetProject392184427';
        $expectedResponse = new Operation();
        $expectedResponse->setKind($kind);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setName($name);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetProject($targetProject);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->rotateServerCa();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1beta4.SqlInstancesService/RotateServerCa', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function rotateServerCaExceptionTest()
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
        try {
            $gapicClient->rotateServerCa();
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
    public function startExternalSyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $targetLink = 'targetLink-2084812312';
        $user = 'user3599307';
        $name = 'name3373707';
        $targetId = 'targetId-815576439';
        $selfLink = 'selfLink-1691268851';
        $targetProject = 'targetProject392184427';
        $expectedResponse = new Operation();
        $expectedResponse->setKind($kind);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setName($name);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetProject($targetProject);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->startExternalSync();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1beta4.SqlInstancesService/StartExternalSync', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function startExternalSyncExceptionTest()
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
        try {
            $gapicClient->startExternalSync();
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
    public function startReplicaTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $targetLink = 'targetLink-2084812312';
        $user = 'user3599307';
        $name = 'name3373707';
        $targetId = 'targetId-815576439';
        $selfLink = 'selfLink-1691268851';
        $targetProject = 'targetProject392184427';
        $expectedResponse = new Operation();
        $expectedResponse->setKind($kind);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setName($name);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetProject($targetProject);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->startReplica();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1beta4.SqlInstancesService/StartReplica', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function startReplicaExceptionTest()
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
        try {
            $gapicClient->startReplica();
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
    public function stopReplicaTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $targetLink = 'targetLink-2084812312';
        $user = 'user3599307';
        $name = 'name3373707';
        $targetId = 'targetId-815576439';
        $selfLink = 'selfLink-1691268851';
        $targetProject = 'targetProject392184427';
        $expectedResponse = new Operation();
        $expectedResponse->setKind($kind);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setName($name);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetProject($targetProject);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->stopReplica();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1beta4.SqlInstancesService/StopReplica', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function stopReplicaExceptionTest()
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
        try {
            $gapicClient->stopReplica();
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
    public function switchoverTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $targetLink = 'targetLink-2084812312';
        $user = 'user3599307';
        $name = 'name3373707';
        $targetId = 'targetId-815576439';
        $selfLink = 'selfLink-1691268851';
        $targetProject = 'targetProject392184427';
        $expectedResponse = new Operation();
        $expectedResponse->setKind($kind);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setName($name);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetProject($targetProject);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->switchover();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1beta4.SqlInstancesService/Switchover', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function switchoverExceptionTest()
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
        try {
            $gapicClient->switchover();
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
    public function truncateLogTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $targetLink = 'targetLink-2084812312';
        $user = 'user3599307';
        $name = 'name3373707';
        $targetId = 'targetId-815576439';
        $selfLink = 'selfLink-1691268851';
        $targetProject = 'targetProject392184427';
        $expectedResponse = new Operation();
        $expectedResponse->setKind($kind);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setName($name);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetProject($targetProject);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->truncateLog();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1beta4.SqlInstancesService/TruncateLog', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function truncateLogExceptionTest()
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
        try {
            $gapicClient->truncateLog();
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
    public function updateTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $targetLink = 'targetLink-2084812312';
        $user = 'user3599307';
        $name = 'name3373707';
        $targetId = 'targetId-815576439';
        $selfLink = 'selfLink-1691268851';
        $targetProject = 'targetProject392184427';
        $expectedResponse = new Operation();
        $expectedResponse->setKind($kind);
        $expectedResponse->setTargetLink($targetLink);
        $expectedResponse->setUser($user);
        $expectedResponse->setName($name);
        $expectedResponse->setTargetId($targetId);
        $expectedResponse->setSelfLink($selfLink);
        $expectedResponse->setTargetProject($targetProject);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->update();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1beta4.SqlInstancesService/Update', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateExceptionTest()
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
        try {
            $gapicClient->update();
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
    public function verifyExternalSyncSettingsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $kind = 'kind3292052';
        $expectedResponse = new SqlInstancesVerifyExternalSyncSettingsResponse();
        $expectedResponse->setKind($kind);
        $transport->addResponse($expectedResponse);
        $response = $gapicClient->verifyExternalSyncSettings();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.sql.v1beta4.SqlInstancesService/VerifyExternalSyncSettings', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function verifyExternalSyncSettingsExceptionTest()
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
        try {
            $gapicClient->verifyExternalSyncSettings();
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
}
