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

namespace Google\Cloud\OracleDatabase\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Location\GetLocationRequest;
use Google\Cloud\Location\ListLocationsRequest;
use Google\Cloud\Location\ListLocationsResponse;
use Google\Cloud\Location\Location;
use Google\Cloud\OracleDatabase\V1\AutonomousDatabase;
use Google\Cloud\OracleDatabase\V1\AutonomousDatabaseBackup;
use Google\Cloud\OracleDatabase\V1\AutonomousDatabaseCharacterSet;
use Google\Cloud\OracleDatabase\V1\AutonomousDbVersion;
use Google\Cloud\OracleDatabase\V1\Client\OracleDatabaseClient;
use Google\Cloud\OracleDatabase\V1\CloudExadataInfrastructure;
use Google\Cloud\OracleDatabase\V1\CloudVmCluster;
use Google\Cloud\OracleDatabase\V1\CreateAutonomousDatabaseRequest;
use Google\Cloud\OracleDatabase\V1\CreateCloudExadataInfrastructureRequest;
use Google\Cloud\OracleDatabase\V1\CreateCloudVmClusterRequest;
use Google\Cloud\OracleDatabase\V1\CreateDbSystemRequest;
use Google\Cloud\OracleDatabase\V1\CreateExadbVmClusterRequest;
use Google\Cloud\OracleDatabase\V1\CreateExascaleDbStorageVaultRequest;
use Google\Cloud\OracleDatabase\V1\CreateOdbNetworkRequest;
use Google\Cloud\OracleDatabase\V1\CreateOdbSubnetRequest;
use Google\Cloud\OracleDatabase\V1\Database;
use Google\Cloud\OracleDatabase\V1\DatabaseCharacterSet;
use Google\Cloud\OracleDatabase\V1\DbNode;
use Google\Cloud\OracleDatabase\V1\DbServer;
use Google\Cloud\OracleDatabase\V1\DbSystem;
use Google\Cloud\OracleDatabase\V1\DbSystemInitialStorageSize;
use Google\Cloud\OracleDatabase\V1\DbSystemShape;
use Google\Cloud\OracleDatabase\V1\DbVersion;
use Google\Cloud\OracleDatabase\V1\DeleteAutonomousDatabaseRequest;
use Google\Cloud\OracleDatabase\V1\DeleteCloudExadataInfrastructureRequest;
use Google\Cloud\OracleDatabase\V1\DeleteCloudVmClusterRequest;
use Google\Cloud\OracleDatabase\V1\DeleteDbSystemRequest;
use Google\Cloud\OracleDatabase\V1\DeleteExadbVmClusterRequest;
use Google\Cloud\OracleDatabase\V1\DeleteExascaleDbStorageVaultRequest;
use Google\Cloud\OracleDatabase\V1\DeleteOdbNetworkRequest;
use Google\Cloud\OracleDatabase\V1\DeleteOdbSubnetRequest;
use Google\Cloud\OracleDatabase\V1\Entitlement;
use Google\Cloud\OracleDatabase\V1\ExadbVmCluster;
use Google\Cloud\OracleDatabase\V1\ExadbVmClusterProperties;
use Google\Cloud\OracleDatabase\V1\ExadbVmClusterProperties\ShapeAttribute;
use Google\Cloud\OracleDatabase\V1\ExadbVmClusterStorageDetails;
use Google\Cloud\OracleDatabase\V1\ExascaleDbStorageDetails;
use Google\Cloud\OracleDatabase\V1\ExascaleDbStorageVault;
use Google\Cloud\OracleDatabase\V1\ExascaleDbStorageVaultProperties;
use Google\Cloud\OracleDatabase\V1\FailoverAutonomousDatabaseRequest;
use Google\Cloud\OracleDatabase\V1\GenerateAutonomousDatabaseWalletRequest;
use Google\Cloud\OracleDatabase\V1\GenerateAutonomousDatabaseWalletResponse;
use Google\Cloud\OracleDatabase\V1\GetAutonomousDatabaseRequest;
use Google\Cloud\OracleDatabase\V1\GetCloudExadataInfrastructureRequest;
use Google\Cloud\OracleDatabase\V1\GetCloudVmClusterRequest;
use Google\Cloud\OracleDatabase\V1\GetDatabaseRequest;
use Google\Cloud\OracleDatabase\V1\GetDbSystemRequest;
use Google\Cloud\OracleDatabase\V1\GetExadbVmClusterRequest;
use Google\Cloud\OracleDatabase\V1\GetExascaleDbStorageVaultRequest;
use Google\Cloud\OracleDatabase\V1\GetOdbNetworkRequest;
use Google\Cloud\OracleDatabase\V1\GetOdbSubnetRequest;
use Google\Cloud\OracleDatabase\V1\GetPluggableDatabaseRequest;
use Google\Cloud\OracleDatabase\V1\GiVersion;
use Google\Cloud\OracleDatabase\V1\ListAutonomousDatabaseBackupsRequest;
use Google\Cloud\OracleDatabase\V1\ListAutonomousDatabaseBackupsResponse;
use Google\Cloud\OracleDatabase\V1\ListAutonomousDatabaseCharacterSetsRequest;
use Google\Cloud\OracleDatabase\V1\ListAutonomousDatabaseCharacterSetsResponse;
use Google\Cloud\OracleDatabase\V1\ListAutonomousDatabasesRequest;
use Google\Cloud\OracleDatabase\V1\ListAutonomousDatabasesResponse;
use Google\Cloud\OracleDatabase\V1\ListAutonomousDbVersionsRequest;
use Google\Cloud\OracleDatabase\V1\ListAutonomousDbVersionsResponse;
use Google\Cloud\OracleDatabase\V1\ListCloudExadataInfrastructuresRequest;
use Google\Cloud\OracleDatabase\V1\ListCloudExadataInfrastructuresResponse;
use Google\Cloud\OracleDatabase\V1\ListCloudVmClustersRequest;
use Google\Cloud\OracleDatabase\V1\ListCloudVmClustersResponse;
use Google\Cloud\OracleDatabase\V1\ListDatabaseCharacterSetsRequest;
use Google\Cloud\OracleDatabase\V1\ListDatabaseCharacterSetsResponse;
use Google\Cloud\OracleDatabase\V1\ListDatabasesRequest;
use Google\Cloud\OracleDatabase\V1\ListDatabasesResponse;
use Google\Cloud\OracleDatabase\V1\ListDbNodesRequest;
use Google\Cloud\OracleDatabase\V1\ListDbNodesResponse;
use Google\Cloud\OracleDatabase\V1\ListDbServersRequest;
use Google\Cloud\OracleDatabase\V1\ListDbServersResponse;
use Google\Cloud\OracleDatabase\V1\ListDbSystemInitialStorageSizesRequest;
use Google\Cloud\OracleDatabase\V1\ListDbSystemInitialStorageSizesResponse;
use Google\Cloud\OracleDatabase\V1\ListDbSystemShapesRequest;
use Google\Cloud\OracleDatabase\V1\ListDbSystemShapesResponse;
use Google\Cloud\OracleDatabase\V1\ListDbSystemsRequest;
use Google\Cloud\OracleDatabase\V1\ListDbSystemsResponse;
use Google\Cloud\OracleDatabase\V1\ListDbVersionsRequest;
use Google\Cloud\OracleDatabase\V1\ListDbVersionsResponse;
use Google\Cloud\OracleDatabase\V1\ListEntitlementsRequest;
use Google\Cloud\OracleDatabase\V1\ListEntitlementsResponse;
use Google\Cloud\OracleDatabase\V1\ListExadbVmClustersRequest;
use Google\Cloud\OracleDatabase\V1\ListExadbVmClustersResponse;
use Google\Cloud\OracleDatabase\V1\ListExascaleDbStorageVaultsRequest;
use Google\Cloud\OracleDatabase\V1\ListExascaleDbStorageVaultsResponse;
use Google\Cloud\OracleDatabase\V1\ListGiVersionsRequest;
use Google\Cloud\OracleDatabase\V1\ListGiVersionsResponse;
use Google\Cloud\OracleDatabase\V1\ListMinorVersionsRequest;
use Google\Cloud\OracleDatabase\V1\ListMinorVersionsResponse;
use Google\Cloud\OracleDatabase\V1\ListOdbNetworksRequest;
use Google\Cloud\OracleDatabase\V1\ListOdbNetworksResponse;
use Google\Cloud\OracleDatabase\V1\ListOdbSubnetsRequest;
use Google\Cloud\OracleDatabase\V1\ListOdbSubnetsResponse;
use Google\Cloud\OracleDatabase\V1\ListPluggableDatabasesRequest;
use Google\Cloud\OracleDatabase\V1\ListPluggableDatabasesResponse;
use Google\Cloud\OracleDatabase\V1\MinorVersion;
use Google\Cloud\OracleDatabase\V1\OdbNetwork;
use Google\Cloud\OracleDatabase\V1\OdbSubnet;
use Google\Cloud\OracleDatabase\V1\OdbSubnet\Purpose;
use Google\Cloud\OracleDatabase\V1\PluggableDatabase;
use Google\Cloud\OracleDatabase\V1\RemoveVirtualMachineExadbVmClusterRequest;
use Google\Cloud\OracleDatabase\V1\RestartAutonomousDatabaseRequest;
use Google\Cloud\OracleDatabase\V1\RestoreAutonomousDatabaseRequest;
use Google\Cloud\OracleDatabase\V1\StartAutonomousDatabaseRequest;
use Google\Cloud\OracleDatabase\V1\StopAutonomousDatabaseRequest;
use Google\Cloud\OracleDatabase\V1\SwitchoverAutonomousDatabaseRequest;
use Google\Cloud\OracleDatabase\V1\UpdateAutonomousDatabaseRequest;
use Google\Cloud\OracleDatabase\V1\UpdateExadbVmClusterRequest;
use Google\LongRunning\Client\OperationsClient;
use Google\LongRunning\GetOperationRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\Any;
use Google\Protobuf\GPBEmpty;
use Google\Protobuf\Timestamp;
use Google\Rpc\Code;
use stdClass;

/**
 * @group oracledatabase
 *
 * @group gapic
 */
class OracleDatabaseClientTest extends GeneratedTest
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

    /** @return OracleDatabaseClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new OracleDatabaseClient($options);
    }

    /** @test */
    public function createAutonomousDatabaseTest()
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
        $incompleteOperation->setName('operations/createAutonomousDatabaseTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $database = 'database1789464955';
        $displayName = 'displayName1615086568';
        $entitlementId = 'entitlementId-1715775123';
        $adminPassword = 'adminPassword1579561355';
        $network = 'network1843485230';
        $cidr = 'cidr3053428';
        $odbNetwork = 'odbNetwork-1199754980';
        $odbSubnet = 'odbSubnet118675119';
        $expectedResponse = new AutonomousDatabase();
        $expectedResponse->setName($name);
        $expectedResponse->setDatabase($database);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setEntitlementId($entitlementId);
        $expectedResponse->setAdminPassword($adminPassword);
        $expectedResponse->setNetwork($network);
        $expectedResponse->setCidr($cidr);
        $expectedResponse->setOdbNetwork($odbNetwork);
        $expectedResponse->setOdbSubnet($odbSubnet);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/createAutonomousDatabaseTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $autonomousDatabaseId = 'autonomousDatabaseId-1188134896';
        $autonomousDatabase = new AutonomousDatabase();
        $request = (new CreateAutonomousDatabaseRequest())
            ->setParent($formattedParent)
            ->setAutonomousDatabaseId($autonomousDatabaseId)
            ->setAutonomousDatabase($autonomousDatabase);
        $response = $gapicClient->createAutonomousDatabase($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.oracledatabase.v1.OracleDatabase/CreateAutonomousDatabase',
            $actualApiFuncCall
        );
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getAutonomousDatabaseId();
        $this->assertProtobufEquals($autonomousDatabaseId, $actualValue);
        $actualValue = $actualApiRequestObject->getAutonomousDatabase();
        $this->assertProtobufEquals($autonomousDatabase, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createAutonomousDatabaseTest');
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
    public function createAutonomousDatabaseExceptionTest()
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
        $incompleteOperation->setName('operations/createAutonomousDatabaseTest');
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $autonomousDatabaseId = 'autonomousDatabaseId-1188134896';
        $autonomousDatabase = new AutonomousDatabase();
        $request = (new CreateAutonomousDatabaseRequest())
            ->setParent($formattedParent)
            ->setAutonomousDatabaseId($autonomousDatabaseId)
            ->setAutonomousDatabase($autonomousDatabase);
        $response = $gapicClient->createAutonomousDatabase($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createAutonomousDatabaseTest');
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
    public function createCloudExadataInfrastructureTest()
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
        $incompleteOperation->setName('operations/createCloudExadataInfrastructureTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $gcpOracleZone = 'gcpOracleZone1763347746';
        $entitlementId = 'entitlementId-1715775123';
        $expectedResponse = new CloudExadataInfrastructure();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setGcpOracleZone($gcpOracleZone);
        $expectedResponse->setEntitlementId($entitlementId);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/createCloudExadataInfrastructureTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $cloudExadataInfrastructureId = 'cloudExadataInfrastructureId642023910';
        $cloudExadataInfrastructure = new CloudExadataInfrastructure();
        $request = (new CreateCloudExadataInfrastructureRequest())
            ->setParent($formattedParent)
            ->setCloudExadataInfrastructureId($cloudExadataInfrastructureId)
            ->setCloudExadataInfrastructure($cloudExadataInfrastructure);
        $response = $gapicClient->createCloudExadataInfrastructure($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.oracledatabase.v1.OracleDatabase/CreateCloudExadataInfrastructure',
            $actualApiFuncCall
        );
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getCloudExadataInfrastructureId();
        $this->assertProtobufEquals($cloudExadataInfrastructureId, $actualValue);
        $actualValue = $actualApiRequestObject->getCloudExadataInfrastructure();
        $this->assertProtobufEquals($cloudExadataInfrastructure, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createCloudExadataInfrastructureTest');
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
    public function createCloudExadataInfrastructureExceptionTest()
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
        $incompleteOperation->setName('operations/createCloudExadataInfrastructureTest');
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $cloudExadataInfrastructureId = 'cloudExadataInfrastructureId642023910';
        $cloudExadataInfrastructure = new CloudExadataInfrastructure();
        $request = (new CreateCloudExadataInfrastructureRequest())
            ->setParent($formattedParent)
            ->setCloudExadataInfrastructureId($cloudExadataInfrastructureId)
            ->setCloudExadataInfrastructure($cloudExadataInfrastructure);
        $response = $gapicClient->createCloudExadataInfrastructure($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createCloudExadataInfrastructureTest');
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
    public function createCloudVmClusterTest()
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
        $incompleteOperation->setName('operations/createCloudVmClusterTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $exadataInfrastructure = 'exadataInfrastructure94104074';
        $displayName = 'displayName1615086568';
        $cidr = 'cidr3053428';
        $backupSubnetCidr = 'backupSubnetCidr-1604198375';
        $network = 'network1843485230';
        $gcpOracleZone = 'gcpOracleZone1763347746';
        $odbNetwork = 'odbNetwork-1199754980';
        $odbSubnet = 'odbSubnet118675119';
        $backupOdbSubnet = 'backupOdbSubnet677701964';
        $expectedResponse = new CloudVmCluster();
        $expectedResponse->setName($name);
        $expectedResponse->setExadataInfrastructure($exadataInfrastructure);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setCidr($cidr);
        $expectedResponse->setBackupSubnetCidr($backupSubnetCidr);
        $expectedResponse->setNetwork($network);
        $expectedResponse->setGcpOracleZone($gcpOracleZone);
        $expectedResponse->setOdbNetwork($odbNetwork);
        $expectedResponse->setOdbSubnet($odbSubnet);
        $expectedResponse->setBackupOdbSubnet($backupOdbSubnet);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/createCloudVmClusterTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $cloudVmClusterId = 'cloudVmClusterId-117615746';
        $cloudVmCluster = new CloudVmCluster();
        $cloudVmClusterExadataInfrastructure = $gapicClient->cloudExadataInfrastructureName(
            '[PROJECT]',
            '[LOCATION]',
            '[CLOUD_EXADATA_INFRASTRUCTURE]'
        );
        $cloudVmCluster->setExadataInfrastructure($cloudVmClusterExadataInfrastructure);
        $request = (new CreateCloudVmClusterRequest())
            ->setParent($formattedParent)
            ->setCloudVmClusterId($cloudVmClusterId)
            ->setCloudVmCluster($cloudVmCluster);
        $response = $gapicClient->createCloudVmCluster($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/CreateCloudVmCluster', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getCloudVmClusterId();
        $this->assertProtobufEquals($cloudVmClusterId, $actualValue);
        $actualValue = $actualApiRequestObject->getCloudVmCluster();
        $this->assertProtobufEquals($cloudVmCluster, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createCloudVmClusterTest');
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
    public function createCloudVmClusterExceptionTest()
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
        $incompleteOperation->setName('operations/createCloudVmClusterTest');
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $cloudVmClusterId = 'cloudVmClusterId-117615746';
        $cloudVmCluster = new CloudVmCluster();
        $cloudVmClusterExadataInfrastructure = $gapicClient->cloudExadataInfrastructureName(
            '[PROJECT]',
            '[LOCATION]',
            '[CLOUD_EXADATA_INFRASTRUCTURE]'
        );
        $cloudVmCluster->setExadataInfrastructure($cloudVmClusterExadataInfrastructure);
        $request = (new CreateCloudVmClusterRequest())
            ->setParent($formattedParent)
            ->setCloudVmClusterId($cloudVmClusterId)
            ->setCloudVmCluster($cloudVmCluster);
        $response = $gapicClient->createCloudVmCluster($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createCloudVmClusterTest');
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
    public function createDbSystemTest()
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
        $incompleteOperation->setName('operations/createDbSystemTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $gcpOracleZone = 'gcpOracleZone1763347746';
        $odbNetwork = 'odbNetwork-1199754980';
        $odbSubnet = 'odbSubnet118675119';
        $entitlementId = 'entitlementId-1715775123';
        $displayName = 'displayName1615086568';
        $ociUrl = 'ociUrl-1632104635';
        $expectedResponse = new DbSystem();
        $expectedResponse->setName($name);
        $expectedResponse->setGcpOracleZone($gcpOracleZone);
        $expectedResponse->setOdbNetwork($odbNetwork);
        $expectedResponse->setOdbSubnet($odbSubnet);
        $expectedResponse->setEntitlementId($entitlementId);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setOciUrl($ociUrl);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/createDbSystemTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $dbSystemId = 'dbSystemId-343990614';
        $dbSystem = new DbSystem();
        $dbSystemOdbSubnet = $gapicClient->odbSubnetName('[PROJECT]', '[LOCATION]', '[ODB_NETWORK]', '[ODB_SUBNET]');
        $dbSystem->setOdbSubnet($dbSystemOdbSubnet);
        $dbSystemDisplayName = 'dbSystemDisplayName996550624';
        $dbSystem->setDisplayName($dbSystemDisplayName);
        $request = (new CreateDbSystemRequest())
            ->setParent($formattedParent)
            ->setDbSystemId($dbSystemId)
            ->setDbSystem($dbSystem);
        $response = $gapicClient->createDbSystem($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/CreateDbSystem', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getDbSystemId();
        $this->assertProtobufEquals($dbSystemId, $actualValue);
        $actualValue = $actualApiRequestObject->getDbSystem();
        $this->assertProtobufEquals($dbSystem, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createDbSystemTest');
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
    public function createDbSystemExceptionTest()
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
        $incompleteOperation->setName('operations/createDbSystemTest');
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $dbSystemId = 'dbSystemId-343990614';
        $dbSystem = new DbSystem();
        $dbSystemOdbSubnet = $gapicClient->odbSubnetName('[PROJECT]', '[LOCATION]', '[ODB_NETWORK]', '[ODB_SUBNET]');
        $dbSystem->setOdbSubnet($dbSystemOdbSubnet);
        $dbSystemDisplayName = 'dbSystemDisplayName996550624';
        $dbSystem->setDisplayName($dbSystemDisplayName);
        $request = (new CreateDbSystemRequest())
            ->setParent($formattedParent)
            ->setDbSystemId($dbSystemId)
            ->setDbSystem($dbSystem);
        $response = $gapicClient->createDbSystem($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createDbSystemTest');
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
    public function createExadbVmClusterTest()
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
        $incompleteOperation->setName('operations/createExadbVmClusterTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $gcpOracleZone = 'gcpOracleZone1763347746';
        $odbNetwork = 'odbNetwork-1199754980';
        $odbSubnet = 'odbSubnet118675119';
        $backupOdbSubnet = 'backupOdbSubnet677701964';
        $displayName = 'displayName1615086568';
        $entitlementId = 'entitlementId-1715775123';
        $expectedResponse = new ExadbVmCluster();
        $expectedResponse->setName($name);
        $expectedResponse->setGcpOracleZone($gcpOracleZone);
        $expectedResponse->setOdbNetwork($odbNetwork);
        $expectedResponse->setOdbSubnet($odbSubnet);
        $expectedResponse->setBackupOdbSubnet($backupOdbSubnet);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setEntitlementId($entitlementId);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/createExadbVmClusterTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $exadbVmClusterId = 'exadbVmClusterId-1283982315';
        $exadbVmCluster = new ExadbVmCluster();
        $exadbVmClusterProperties = new ExadbVmClusterProperties();
        $propertiesGridImageId = 'propertiesGridImageId1390651005';
        $exadbVmClusterProperties->setGridImageId($propertiesGridImageId);
        $propertiesNodeCount = 2104221754;
        $exadbVmClusterProperties->setNodeCount($propertiesNodeCount);
        $propertiesEnabledEcpuCountPerNode = 1552954913;
        $exadbVmClusterProperties->setEnabledEcpuCountPerNode($propertiesEnabledEcpuCountPerNode);
        $propertiesVmFileSystemStorage = new ExadbVmClusterStorageDetails();
        $vmFileSystemStorageSizeInGbsPerNode = 818206298;
        $propertiesVmFileSystemStorage->setSizeInGbsPerNode($vmFileSystemStorageSizeInGbsPerNode);
        $exadbVmClusterProperties->setVmFileSystemStorage($propertiesVmFileSystemStorage);
        $propertiesExascaleDbStorageVault = $gapicClient->exascaleDbStorageVaultName(
            '[PROJECT]',
            '[LOCATION]',
            '[EXASCALE_DB_STORAGE_VAULT]'
        );
        $exadbVmClusterProperties->setExascaleDbStorageVault($propertiesExascaleDbStorageVault);
        $propertiesHostnamePrefix = 'propertiesHostnamePrefix1242795192';
        $exadbVmClusterProperties->setHostnamePrefix($propertiesHostnamePrefix);
        $propertiesSshPublicKeys = [];
        $exadbVmClusterProperties->setSshPublicKeys($propertiesSshPublicKeys);
        $propertiesShapeAttribute = ShapeAttribute::SHAPE_ATTRIBUTE_UNSPECIFIED;
        $exadbVmClusterProperties->setShapeAttribute($propertiesShapeAttribute);
        $exadbVmCluster->setProperties($exadbVmClusterProperties);
        $exadbVmClusterOdbSubnet = $gapicClient->odbSubnetName(
            '[PROJECT]',
            '[LOCATION]',
            '[ODB_NETWORK]',
            '[ODB_SUBNET]'
        );
        $exadbVmCluster->setOdbSubnet($exadbVmClusterOdbSubnet);
        $exadbVmClusterBackupOdbSubnet = $gapicClient->odbSubnetName(
            '[PROJECT]',
            '[LOCATION]',
            '[ODB_NETWORK]',
            '[ODB_SUBNET]'
        );
        $exadbVmCluster->setBackupOdbSubnet($exadbVmClusterBackupOdbSubnet);
        $exadbVmClusterDisplayName = 'exadbVmClusterDisplayName-1120012202';
        $exadbVmCluster->setDisplayName($exadbVmClusterDisplayName);
        $request = (new CreateExadbVmClusterRequest())
            ->setParent($formattedParent)
            ->setExadbVmClusterId($exadbVmClusterId)
            ->setExadbVmCluster($exadbVmCluster);
        $response = $gapicClient->createExadbVmCluster($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/CreateExadbVmCluster', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getExadbVmClusterId();
        $this->assertProtobufEquals($exadbVmClusterId, $actualValue);
        $actualValue = $actualApiRequestObject->getExadbVmCluster();
        $this->assertProtobufEquals($exadbVmCluster, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createExadbVmClusterTest');
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
    public function createExadbVmClusterExceptionTest()
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
        $incompleteOperation->setName('operations/createExadbVmClusterTest');
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $exadbVmClusterId = 'exadbVmClusterId-1283982315';
        $exadbVmCluster = new ExadbVmCluster();
        $exadbVmClusterProperties = new ExadbVmClusterProperties();
        $propertiesGridImageId = 'propertiesGridImageId1390651005';
        $exadbVmClusterProperties->setGridImageId($propertiesGridImageId);
        $propertiesNodeCount = 2104221754;
        $exadbVmClusterProperties->setNodeCount($propertiesNodeCount);
        $propertiesEnabledEcpuCountPerNode = 1552954913;
        $exadbVmClusterProperties->setEnabledEcpuCountPerNode($propertiesEnabledEcpuCountPerNode);
        $propertiesVmFileSystemStorage = new ExadbVmClusterStorageDetails();
        $vmFileSystemStorageSizeInGbsPerNode = 818206298;
        $propertiesVmFileSystemStorage->setSizeInGbsPerNode($vmFileSystemStorageSizeInGbsPerNode);
        $exadbVmClusterProperties->setVmFileSystemStorage($propertiesVmFileSystemStorage);
        $propertiesExascaleDbStorageVault = $gapicClient->exascaleDbStorageVaultName(
            '[PROJECT]',
            '[LOCATION]',
            '[EXASCALE_DB_STORAGE_VAULT]'
        );
        $exadbVmClusterProperties->setExascaleDbStorageVault($propertiesExascaleDbStorageVault);
        $propertiesHostnamePrefix = 'propertiesHostnamePrefix1242795192';
        $exadbVmClusterProperties->setHostnamePrefix($propertiesHostnamePrefix);
        $propertiesSshPublicKeys = [];
        $exadbVmClusterProperties->setSshPublicKeys($propertiesSshPublicKeys);
        $propertiesShapeAttribute = ShapeAttribute::SHAPE_ATTRIBUTE_UNSPECIFIED;
        $exadbVmClusterProperties->setShapeAttribute($propertiesShapeAttribute);
        $exadbVmCluster->setProperties($exadbVmClusterProperties);
        $exadbVmClusterOdbSubnet = $gapicClient->odbSubnetName(
            '[PROJECT]',
            '[LOCATION]',
            '[ODB_NETWORK]',
            '[ODB_SUBNET]'
        );
        $exadbVmCluster->setOdbSubnet($exadbVmClusterOdbSubnet);
        $exadbVmClusterBackupOdbSubnet = $gapicClient->odbSubnetName(
            '[PROJECT]',
            '[LOCATION]',
            '[ODB_NETWORK]',
            '[ODB_SUBNET]'
        );
        $exadbVmCluster->setBackupOdbSubnet($exadbVmClusterBackupOdbSubnet);
        $exadbVmClusterDisplayName = 'exadbVmClusterDisplayName-1120012202';
        $exadbVmCluster->setDisplayName($exadbVmClusterDisplayName);
        $request = (new CreateExadbVmClusterRequest())
            ->setParent($formattedParent)
            ->setExadbVmClusterId($exadbVmClusterId)
            ->setExadbVmCluster($exadbVmCluster);
        $response = $gapicClient->createExadbVmCluster($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createExadbVmClusterTest');
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
    public function createExascaleDbStorageVaultTest()
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
        $incompleteOperation->setName('operations/createExascaleDbStorageVaultTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $gcpOracleZone = 'gcpOracleZone1763347746';
        $entitlementId = 'entitlementId-1715775123';
        $expectedResponse = new ExascaleDbStorageVault();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setGcpOracleZone($gcpOracleZone);
        $expectedResponse->setEntitlementId($entitlementId);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/createExascaleDbStorageVaultTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $exascaleDbStorageVaultId = 'exascaleDbStorageVaultId-550947734';
        $exascaleDbStorageVault = new ExascaleDbStorageVault();
        $exascaleDbStorageVaultDisplayName = 'exascaleDbStorageVaultDisplayName-685104516';
        $exascaleDbStorageVault->setDisplayName($exascaleDbStorageVaultDisplayName);
        $exascaleDbStorageVaultProperties = new ExascaleDbStorageVaultProperties();
        $propertiesExascaleDbStorageDetails = new ExascaleDbStorageDetails();
        $exascaleDbStorageDetailsTotalSizeGbs = 961293684;
        $propertiesExascaleDbStorageDetails->setTotalSizeGbs($exascaleDbStorageDetailsTotalSizeGbs);
        $exascaleDbStorageVaultProperties->setExascaleDbStorageDetails($propertiesExascaleDbStorageDetails);
        $exascaleDbStorageVault->setProperties($exascaleDbStorageVaultProperties);
        $request = (new CreateExascaleDbStorageVaultRequest())
            ->setParent($formattedParent)
            ->setExascaleDbStorageVaultId($exascaleDbStorageVaultId)
            ->setExascaleDbStorageVault($exascaleDbStorageVault);
        $response = $gapicClient->createExascaleDbStorageVault($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.oracledatabase.v1.OracleDatabase/CreateExascaleDbStorageVault',
            $actualApiFuncCall
        );
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getExascaleDbStorageVaultId();
        $this->assertProtobufEquals($exascaleDbStorageVaultId, $actualValue);
        $actualValue = $actualApiRequestObject->getExascaleDbStorageVault();
        $this->assertProtobufEquals($exascaleDbStorageVault, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createExascaleDbStorageVaultTest');
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
    public function createExascaleDbStorageVaultExceptionTest()
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
        $incompleteOperation->setName('operations/createExascaleDbStorageVaultTest');
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $exascaleDbStorageVaultId = 'exascaleDbStorageVaultId-550947734';
        $exascaleDbStorageVault = new ExascaleDbStorageVault();
        $exascaleDbStorageVaultDisplayName = 'exascaleDbStorageVaultDisplayName-685104516';
        $exascaleDbStorageVault->setDisplayName($exascaleDbStorageVaultDisplayName);
        $exascaleDbStorageVaultProperties = new ExascaleDbStorageVaultProperties();
        $propertiesExascaleDbStorageDetails = new ExascaleDbStorageDetails();
        $exascaleDbStorageDetailsTotalSizeGbs = 961293684;
        $propertiesExascaleDbStorageDetails->setTotalSizeGbs($exascaleDbStorageDetailsTotalSizeGbs);
        $exascaleDbStorageVaultProperties->setExascaleDbStorageDetails($propertiesExascaleDbStorageDetails);
        $exascaleDbStorageVault->setProperties($exascaleDbStorageVaultProperties);
        $request = (new CreateExascaleDbStorageVaultRequest())
            ->setParent($formattedParent)
            ->setExascaleDbStorageVaultId($exascaleDbStorageVaultId)
            ->setExascaleDbStorageVault($exascaleDbStorageVault);
        $response = $gapicClient->createExascaleDbStorageVault($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createExascaleDbStorageVaultTest');
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
    public function createOdbNetworkTest()
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
        $incompleteOperation->setName('operations/createOdbNetworkTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $network = 'network1843485230';
        $entitlementId = 'entitlementId-1715775123';
        $gcpOracleZone = 'gcpOracleZone1763347746';
        $expectedResponse = new OdbNetwork();
        $expectedResponse->setName($name);
        $expectedResponse->setNetwork($network);
        $expectedResponse->setEntitlementId($entitlementId);
        $expectedResponse->setGcpOracleZone($gcpOracleZone);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/createOdbNetworkTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $odbNetworkId = 'odbNetworkId817322782';
        $odbNetwork = new OdbNetwork();
        $odbNetworkNetwork = $gapicClient->networkName('[PROJECT]', '[NETWORK]');
        $odbNetwork->setNetwork($odbNetworkNetwork);
        $request = (new CreateOdbNetworkRequest())
            ->setParent($formattedParent)
            ->setOdbNetworkId($odbNetworkId)
            ->setOdbNetwork($odbNetwork);
        $response = $gapicClient->createOdbNetwork($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/CreateOdbNetwork', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getOdbNetworkId();
        $this->assertProtobufEquals($odbNetworkId, $actualValue);
        $actualValue = $actualApiRequestObject->getOdbNetwork();
        $this->assertProtobufEquals($odbNetwork, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createOdbNetworkTest');
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
    public function createOdbNetworkExceptionTest()
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
        $incompleteOperation->setName('operations/createOdbNetworkTest');
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $odbNetworkId = 'odbNetworkId817322782';
        $odbNetwork = new OdbNetwork();
        $odbNetworkNetwork = $gapicClient->networkName('[PROJECT]', '[NETWORK]');
        $odbNetwork->setNetwork($odbNetworkNetwork);
        $request = (new CreateOdbNetworkRequest())
            ->setParent($formattedParent)
            ->setOdbNetworkId($odbNetworkId)
            ->setOdbNetwork($odbNetwork);
        $response = $gapicClient->createOdbNetwork($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createOdbNetworkTest');
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
    public function createOdbSubnetTest()
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
        $incompleteOperation->setName('operations/createOdbSubnetTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $cidrRange = 'cidrRange327470258';
        $expectedResponse = new OdbSubnet();
        $expectedResponse->setName($name);
        $expectedResponse->setCidrRange($cidrRange);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/createOdbSubnetTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $gapicClient->odbNetworkName('[PROJECT]', '[LOCATION]', '[ODB_NETWORK]');
        $odbSubnetId = 'odbSubnetId692480171';
        $odbSubnet = new OdbSubnet();
        $odbSubnetCidrRange = 'odbSubnetCidrRange1516239455';
        $odbSubnet->setCidrRange($odbSubnetCidrRange);
        $odbSubnetPurpose = Purpose::PURPOSE_UNSPECIFIED;
        $odbSubnet->setPurpose($odbSubnetPurpose);
        $request = (new CreateOdbSubnetRequest())
            ->setParent($formattedParent)
            ->setOdbSubnetId($odbSubnetId)
            ->setOdbSubnet($odbSubnet);
        $response = $gapicClient->createOdbSubnet($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/CreateOdbSubnet', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getOdbSubnetId();
        $this->assertProtobufEquals($odbSubnetId, $actualValue);
        $actualValue = $actualApiRequestObject->getOdbSubnet();
        $this->assertProtobufEquals($odbSubnet, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createOdbSubnetTest');
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
    public function createOdbSubnetExceptionTest()
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
        $incompleteOperation->setName('operations/createOdbSubnetTest');
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
        $formattedParent = $gapicClient->odbNetworkName('[PROJECT]', '[LOCATION]', '[ODB_NETWORK]');
        $odbSubnetId = 'odbSubnetId692480171';
        $odbSubnet = new OdbSubnet();
        $odbSubnetCidrRange = 'odbSubnetCidrRange1516239455';
        $odbSubnet->setCidrRange($odbSubnetCidrRange);
        $odbSubnetPurpose = Purpose::PURPOSE_UNSPECIFIED;
        $odbSubnet->setPurpose($odbSubnetPurpose);
        $request = (new CreateOdbSubnetRequest())
            ->setParent($formattedParent)
            ->setOdbSubnetId($odbSubnetId)
            ->setOdbSubnet($odbSubnet);
        $response = $gapicClient->createOdbSubnet($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createOdbSubnetTest');
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
    public function deleteAutonomousDatabaseTest()
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
        $incompleteOperation->setName('operations/deleteAutonomousDatabaseTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new GPBEmpty();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/deleteAutonomousDatabaseTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->autonomousDatabaseName('[PROJECT]', '[LOCATION]', '[AUTONOMOUS_DATABASE]');
        $request = (new DeleteAutonomousDatabaseRequest())->setName($formattedName);
        $response = $gapicClient->deleteAutonomousDatabase($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.oracledatabase.v1.OracleDatabase/DeleteAutonomousDatabase',
            $actualApiFuncCall
        );
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteAutonomousDatabaseTest');
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
    public function deleteAutonomousDatabaseExceptionTest()
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
        $incompleteOperation->setName('operations/deleteAutonomousDatabaseTest');
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
        $formattedName = $gapicClient->autonomousDatabaseName('[PROJECT]', '[LOCATION]', '[AUTONOMOUS_DATABASE]');
        $request = (new DeleteAutonomousDatabaseRequest())->setName($formattedName);
        $response = $gapicClient->deleteAutonomousDatabase($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteAutonomousDatabaseTest');
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
    public function deleteCloudExadataInfrastructureTest()
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
        $incompleteOperation->setName('operations/deleteCloudExadataInfrastructureTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new GPBEmpty();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/deleteCloudExadataInfrastructureTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->cloudExadataInfrastructureName(
            '[PROJECT]',
            '[LOCATION]',
            '[CLOUD_EXADATA_INFRASTRUCTURE]'
        );
        $request = (new DeleteCloudExadataInfrastructureRequest())->setName($formattedName);
        $response = $gapicClient->deleteCloudExadataInfrastructure($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.oracledatabase.v1.OracleDatabase/DeleteCloudExadataInfrastructure',
            $actualApiFuncCall
        );
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteCloudExadataInfrastructureTest');
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
    public function deleteCloudExadataInfrastructureExceptionTest()
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
        $incompleteOperation->setName('operations/deleteCloudExadataInfrastructureTest');
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
        $formattedName = $gapicClient->cloudExadataInfrastructureName(
            '[PROJECT]',
            '[LOCATION]',
            '[CLOUD_EXADATA_INFRASTRUCTURE]'
        );
        $request = (new DeleteCloudExadataInfrastructureRequest())->setName($formattedName);
        $response = $gapicClient->deleteCloudExadataInfrastructure($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteCloudExadataInfrastructureTest');
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
    public function deleteCloudVmClusterTest()
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
        $incompleteOperation->setName('operations/deleteCloudVmClusterTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new GPBEmpty();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/deleteCloudVmClusterTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->cloudVmClusterName('[PROJECT]', '[LOCATION]', '[CLOUD_VM_CLUSTER]');
        $request = (new DeleteCloudVmClusterRequest())->setName($formattedName);
        $response = $gapicClient->deleteCloudVmCluster($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/DeleteCloudVmCluster', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteCloudVmClusterTest');
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
    public function deleteCloudVmClusterExceptionTest()
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
        $incompleteOperation->setName('operations/deleteCloudVmClusterTest');
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
        $formattedName = $gapicClient->cloudVmClusterName('[PROJECT]', '[LOCATION]', '[CLOUD_VM_CLUSTER]');
        $request = (new DeleteCloudVmClusterRequest())->setName($formattedName);
        $response = $gapicClient->deleteCloudVmCluster($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteCloudVmClusterTest');
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
    public function deleteDbSystemTest()
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
        $incompleteOperation->setName('operations/deleteDbSystemTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new GPBEmpty();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/deleteDbSystemTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->dbSystemName('[PROJECT]', '[LOCATION]', '[DB_SYSTEM]');
        $request = (new DeleteDbSystemRequest())->setName($formattedName);
        $response = $gapicClient->deleteDbSystem($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/DeleteDbSystem', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteDbSystemTest');
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
    public function deleteDbSystemExceptionTest()
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
        $incompleteOperation->setName('operations/deleteDbSystemTest');
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
        $formattedName = $gapicClient->dbSystemName('[PROJECT]', '[LOCATION]', '[DB_SYSTEM]');
        $request = (new DeleteDbSystemRequest())->setName($formattedName);
        $response = $gapicClient->deleteDbSystem($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteDbSystemTest');
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
    public function deleteExadbVmClusterTest()
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
        $incompleteOperation->setName('operations/deleteExadbVmClusterTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new GPBEmpty();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/deleteExadbVmClusterTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->exadbVmClusterName('[PROJECT]', '[LOCATION]', '[EXADB_VM_CLUSTER]');
        $request = (new DeleteExadbVmClusterRequest())->setName($formattedName);
        $response = $gapicClient->deleteExadbVmCluster($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/DeleteExadbVmCluster', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteExadbVmClusterTest');
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
    public function deleteExadbVmClusterExceptionTest()
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
        $incompleteOperation->setName('operations/deleteExadbVmClusterTest');
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
        $formattedName = $gapicClient->exadbVmClusterName('[PROJECT]', '[LOCATION]', '[EXADB_VM_CLUSTER]');
        $request = (new DeleteExadbVmClusterRequest())->setName($formattedName);
        $response = $gapicClient->deleteExadbVmCluster($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteExadbVmClusterTest');
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
    public function deleteExascaleDbStorageVaultTest()
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
        $incompleteOperation->setName('operations/deleteExascaleDbStorageVaultTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new GPBEmpty();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/deleteExascaleDbStorageVaultTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->exascaleDbStorageVaultName(
            '[PROJECT]',
            '[LOCATION]',
            '[EXASCALE_DB_STORAGE_VAULT]'
        );
        $request = (new DeleteExascaleDbStorageVaultRequest())->setName($formattedName);
        $response = $gapicClient->deleteExascaleDbStorageVault($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.oracledatabase.v1.OracleDatabase/DeleteExascaleDbStorageVault',
            $actualApiFuncCall
        );
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteExascaleDbStorageVaultTest');
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
    public function deleteExascaleDbStorageVaultExceptionTest()
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
        $incompleteOperation->setName('operations/deleteExascaleDbStorageVaultTest');
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
        $formattedName = $gapicClient->exascaleDbStorageVaultName(
            '[PROJECT]',
            '[LOCATION]',
            '[EXASCALE_DB_STORAGE_VAULT]'
        );
        $request = (new DeleteExascaleDbStorageVaultRequest())->setName($formattedName);
        $response = $gapicClient->deleteExascaleDbStorageVault($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteExascaleDbStorageVaultTest');
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
    public function deleteOdbNetworkTest()
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
        $incompleteOperation->setName('operations/deleteOdbNetworkTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new GPBEmpty();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/deleteOdbNetworkTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->odbNetworkName('[PROJECT]', '[LOCATION]', '[ODB_NETWORK]');
        $request = (new DeleteOdbNetworkRequest())->setName($formattedName);
        $response = $gapicClient->deleteOdbNetwork($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/DeleteOdbNetwork', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteOdbNetworkTest');
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
    public function deleteOdbNetworkExceptionTest()
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
        $incompleteOperation->setName('operations/deleteOdbNetworkTest');
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
        $formattedName = $gapicClient->odbNetworkName('[PROJECT]', '[LOCATION]', '[ODB_NETWORK]');
        $request = (new DeleteOdbNetworkRequest())->setName($formattedName);
        $response = $gapicClient->deleteOdbNetwork($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteOdbNetworkTest');
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
    public function deleteOdbSubnetTest()
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
        $incompleteOperation->setName('operations/deleteOdbSubnetTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new GPBEmpty();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/deleteOdbSubnetTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->odbSubnetName('[PROJECT]', '[LOCATION]', '[ODB_NETWORK]', '[ODB_SUBNET]');
        $request = (new DeleteOdbSubnetRequest())->setName($formattedName);
        $response = $gapicClient->deleteOdbSubnet($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/DeleteOdbSubnet', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteOdbSubnetTest');
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
    public function deleteOdbSubnetExceptionTest()
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
        $incompleteOperation->setName('operations/deleteOdbSubnetTest');
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
        $formattedName = $gapicClient->odbSubnetName('[PROJECT]', '[LOCATION]', '[ODB_NETWORK]', '[ODB_SUBNET]');
        $request = (new DeleteOdbSubnetRequest())->setName($formattedName);
        $response = $gapicClient->deleteOdbSubnet($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteOdbSubnetTest');
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
    public function failoverAutonomousDatabaseTest()
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
        $incompleteOperation->setName('operations/failoverAutonomousDatabaseTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name2 = 'name2-1052831874';
        $database = 'database1789464955';
        $displayName = 'displayName1615086568';
        $entitlementId = 'entitlementId-1715775123';
        $adminPassword = 'adminPassword1579561355';
        $network = 'network1843485230';
        $cidr = 'cidr3053428';
        $odbNetwork = 'odbNetwork-1199754980';
        $odbSubnet = 'odbSubnet118675119';
        $expectedResponse = new AutonomousDatabase();
        $expectedResponse->setName($name2);
        $expectedResponse->setDatabase($database);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setEntitlementId($entitlementId);
        $expectedResponse->setAdminPassword($adminPassword);
        $expectedResponse->setNetwork($network);
        $expectedResponse->setCidr($cidr);
        $expectedResponse->setOdbNetwork($odbNetwork);
        $expectedResponse->setOdbSubnet($odbSubnet);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/failoverAutonomousDatabaseTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->autonomousDatabaseName('[PROJECT]', '[LOCATION]', '[AUTONOMOUS_DATABASE]');
        $formattedPeerAutonomousDatabase = $gapicClient->autonomousDatabaseName(
            '[PROJECT]',
            '[LOCATION]',
            '[AUTONOMOUS_DATABASE]'
        );
        $request = (new FailoverAutonomousDatabaseRequest())
            ->setName($formattedName)
            ->setPeerAutonomousDatabase($formattedPeerAutonomousDatabase);
        $response = $gapicClient->failoverAutonomousDatabase($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.oracledatabase.v1.OracleDatabase/FailoverAutonomousDatabase',
            $actualApiFuncCall
        );
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualApiRequestObject->getPeerAutonomousDatabase();
        $this->assertProtobufEquals($formattedPeerAutonomousDatabase, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/failoverAutonomousDatabaseTest');
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
    public function failoverAutonomousDatabaseExceptionTest()
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
        $incompleteOperation->setName('operations/failoverAutonomousDatabaseTest');
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
        $formattedName = $gapicClient->autonomousDatabaseName('[PROJECT]', '[LOCATION]', '[AUTONOMOUS_DATABASE]');
        $formattedPeerAutonomousDatabase = $gapicClient->autonomousDatabaseName(
            '[PROJECT]',
            '[LOCATION]',
            '[AUTONOMOUS_DATABASE]'
        );
        $request = (new FailoverAutonomousDatabaseRequest())
            ->setName($formattedName)
            ->setPeerAutonomousDatabase($formattedPeerAutonomousDatabase);
        $response = $gapicClient->failoverAutonomousDatabase($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/failoverAutonomousDatabaseTest');
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
    public function generateAutonomousDatabaseWalletTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $archiveContent = '-4';
        $expectedResponse = new GenerateAutonomousDatabaseWalletResponse();
        $expectedResponse->setArchiveContent($archiveContent);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->autonomousDatabaseName('[PROJECT]', '[LOCATION]', '[AUTONOMOUS_DATABASE]');
        $password = 'password1216985755';
        $request = (new GenerateAutonomousDatabaseWalletRequest())->setName($formattedName)->setPassword($password);
        $response = $gapicClient->generateAutonomousDatabaseWallet($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.oracledatabase.v1.OracleDatabase/GenerateAutonomousDatabaseWallet',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getPassword();
        $this->assertProtobufEquals($password, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function generateAutonomousDatabaseWalletExceptionTest()
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
        $formattedName = $gapicClient->autonomousDatabaseName('[PROJECT]', '[LOCATION]', '[AUTONOMOUS_DATABASE]');
        $password = 'password1216985755';
        $request = (new GenerateAutonomousDatabaseWalletRequest())->setName($formattedName)->setPassword($password);
        try {
            $gapicClient->generateAutonomousDatabaseWallet($request);
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
    public function getAutonomousDatabaseTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $database = 'database1789464955';
        $displayName = 'displayName1615086568';
        $entitlementId = 'entitlementId-1715775123';
        $adminPassword = 'adminPassword1579561355';
        $network = 'network1843485230';
        $cidr = 'cidr3053428';
        $odbNetwork = 'odbNetwork-1199754980';
        $odbSubnet = 'odbSubnet118675119';
        $expectedResponse = new AutonomousDatabase();
        $expectedResponse->setName($name2);
        $expectedResponse->setDatabase($database);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setEntitlementId($entitlementId);
        $expectedResponse->setAdminPassword($adminPassword);
        $expectedResponse->setNetwork($network);
        $expectedResponse->setCidr($cidr);
        $expectedResponse->setOdbNetwork($odbNetwork);
        $expectedResponse->setOdbSubnet($odbSubnet);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->autonomousDatabaseName('[PROJECT]', '[LOCATION]', '[AUTONOMOUS_DATABASE]');
        $request = (new GetAutonomousDatabaseRequest())->setName($formattedName);
        $response = $gapicClient->getAutonomousDatabase($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/GetAutonomousDatabase', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getAutonomousDatabaseExceptionTest()
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
        $formattedName = $gapicClient->autonomousDatabaseName('[PROJECT]', '[LOCATION]', '[AUTONOMOUS_DATABASE]');
        $request = (new GetAutonomousDatabaseRequest())->setName($formattedName);
        try {
            $gapicClient->getAutonomousDatabase($request);
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
    public function getCloudExadataInfrastructureTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $gcpOracleZone = 'gcpOracleZone1763347746';
        $entitlementId = 'entitlementId-1715775123';
        $expectedResponse = new CloudExadataInfrastructure();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setGcpOracleZone($gcpOracleZone);
        $expectedResponse->setEntitlementId($entitlementId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->cloudExadataInfrastructureName(
            '[PROJECT]',
            '[LOCATION]',
            '[CLOUD_EXADATA_INFRASTRUCTURE]'
        );
        $request = (new GetCloudExadataInfrastructureRequest())->setName($formattedName);
        $response = $gapicClient->getCloudExadataInfrastructure($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.oracledatabase.v1.OracleDatabase/GetCloudExadataInfrastructure',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getCloudExadataInfrastructureExceptionTest()
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
        $formattedName = $gapicClient->cloudExadataInfrastructureName(
            '[PROJECT]',
            '[LOCATION]',
            '[CLOUD_EXADATA_INFRASTRUCTURE]'
        );
        $request = (new GetCloudExadataInfrastructureRequest())->setName($formattedName);
        try {
            $gapicClient->getCloudExadataInfrastructure($request);
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
    public function getCloudVmClusterTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $exadataInfrastructure = 'exadataInfrastructure94104074';
        $displayName = 'displayName1615086568';
        $cidr = 'cidr3053428';
        $backupSubnetCidr = 'backupSubnetCidr-1604198375';
        $network = 'network1843485230';
        $gcpOracleZone = 'gcpOracleZone1763347746';
        $odbNetwork = 'odbNetwork-1199754980';
        $odbSubnet = 'odbSubnet118675119';
        $backupOdbSubnet = 'backupOdbSubnet677701964';
        $expectedResponse = new CloudVmCluster();
        $expectedResponse->setName($name2);
        $expectedResponse->setExadataInfrastructure($exadataInfrastructure);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setCidr($cidr);
        $expectedResponse->setBackupSubnetCidr($backupSubnetCidr);
        $expectedResponse->setNetwork($network);
        $expectedResponse->setGcpOracleZone($gcpOracleZone);
        $expectedResponse->setOdbNetwork($odbNetwork);
        $expectedResponse->setOdbSubnet($odbSubnet);
        $expectedResponse->setBackupOdbSubnet($backupOdbSubnet);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->cloudVmClusterName('[PROJECT]', '[LOCATION]', '[CLOUD_VM_CLUSTER]');
        $request = (new GetCloudVmClusterRequest())->setName($formattedName);
        $response = $gapicClient->getCloudVmCluster($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/GetCloudVmCluster', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getCloudVmClusterExceptionTest()
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
        $formattedName = $gapicClient->cloudVmClusterName('[PROJECT]', '[LOCATION]', '[CLOUD_VM_CLUSTER]');
        $request = (new GetCloudVmClusterRequest())->setName($formattedName);
        try {
            $gapicClient->getCloudVmCluster($request);
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
    public function getDatabaseTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $dbName = 'dbName1452819884';
        $dbUniqueName = 'dbUniqueName-247267336';
        $adminPassword = 'adminPassword1579561355';
        $tdeWalletPassword = 'tdeWalletPassword2013760471';
        $characterSet = 'characterSet-1789597108';
        $ncharacterSet = 'ncharacterSet-1566471010';
        $ociUrl = 'ociUrl-1632104635';
        $databaseId = 'databaseId816491103';
        $dbHomeName = 'dbHomeName644903786';
        $gcpOracleZone = 'gcpOracleZone1763347746';
        $expectedResponse = new Database();
        $expectedResponse->setName($name2);
        $expectedResponse->setDbName($dbName);
        $expectedResponse->setDbUniqueName($dbUniqueName);
        $expectedResponse->setAdminPassword($adminPassword);
        $expectedResponse->setTdeWalletPassword($tdeWalletPassword);
        $expectedResponse->setCharacterSet($characterSet);
        $expectedResponse->setNcharacterSet($ncharacterSet);
        $expectedResponse->setOciUrl($ociUrl);
        $expectedResponse->setDatabaseId($databaseId);
        $expectedResponse->setDbHomeName($dbHomeName);
        $expectedResponse->setGcpOracleZone($gcpOracleZone);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->databaseName('[PROJECT]', '[LOCATION]', '[DATABASE]');
        $request = (new GetDatabaseRequest())->setName($formattedName);
        $response = $gapicClient->getDatabase($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/GetDatabase', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getDatabaseExceptionTest()
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
        $formattedName = $gapicClient->databaseName('[PROJECT]', '[LOCATION]', '[DATABASE]');
        $request = (new GetDatabaseRequest())->setName($formattedName);
        try {
            $gapicClient->getDatabase($request);
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
    public function getDbSystemTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $gcpOracleZone = 'gcpOracleZone1763347746';
        $odbNetwork = 'odbNetwork-1199754980';
        $odbSubnet = 'odbSubnet118675119';
        $entitlementId = 'entitlementId-1715775123';
        $displayName = 'displayName1615086568';
        $ociUrl = 'ociUrl-1632104635';
        $expectedResponse = new DbSystem();
        $expectedResponse->setName($name2);
        $expectedResponse->setGcpOracleZone($gcpOracleZone);
        $expectedResponse->setOdbNetwork($odbNetwork);
        $expectedResponse->setOdbSubnet($odbSubnet);
        $expectedResponse->setEntitlementId($entitlementId);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setOciUrl($ociUrl);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->dbSystemName('[PROJECT]', '[LOCATION]', '[DB_SYSTEM]');
        $request = (new GetDbSystemRequest())->setName($formattedName);
        $response = $gapicClient->getDbSystem($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/GetDbSystem', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getDbSystemExceptionTest()
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
        $formattedName = $gapicClient->dbSystemName('[PROJECT]', '[LOCATION]', '[DB_SYSTEM]');
        $request = (new GetDbSystemRequest())->setName($formattedName);
        try {
            $gapicClient->getDbSystem($request);
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
    public function getExadbVmClusterTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $gcpOracleZone = 'gcpOracleZone1763347746';
        $odbNetwork = 'odbNetwork-1199754980';
        $odbSubnet = 'odbSubnet118675119';
        $backupOdbSubnet = 'backupOdbSubnet677701964';
        $displayName = 'displayName1615086568';
        $entitlementId = 'entitlementId-1715775123';
        $expectedResponse = new ExadbVmCluster();
        $expectedResponse->setName($name2);
        $expectedResponse->setGcpOracleZone($gcpOracleZone);
        $expectedResponse->setOdbNetwork($odbNetwork);
        $expectedResponse->setOdbSubnet($odbSubnet);
        $expectedResponse->setBackupOdbSubnet($backupOdbSubnet);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setEntitlementId($entitlementId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->exadbVmClusterName('[PROJECT]', '[LOCATION]', '[EXADB_VM_CLUSTER]');
        $request = (new GetExadbVmClusterRequest())->setName($formattedName);
        $response = $gapicClient->getExadbVmCluster($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/GetExadbVmCluster', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getExadbVmClusterExceptionTest()
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
        $formattedName = $gapicClient->exadbVmClusterName('[PROJECT]', '[LOCATION]', '[EXADB_VM_CLUSTER]');
        $request = (new GetExadbVmClusterRequest())->setName($formattedName);
        try {
            $gapicClient->getExadbVmCluster($request);
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
    public function getExascaleDbStorageVaultTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $gcpOracleZone = 'gcpOracleZone1763347746';
        $entitlementId = 'entitlementId-1715775123';
        $expectedResponse = new ExascaleDbStorageVault();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setGcpOracleZone($gcpOracleZone);
        $expectedResponse->setEntitlementId($entitlementId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->exascaleDbStorageVaultName(
            '[PROJECT]',
            '[LOCATION]',
            '[EXASCALE_DB_STORAGE_VAULT]'
        );
        $request = (new GetExascaleDbStorageVaultRequest())->setName($formattedName);
        $response = $gapicClient->getExascaleDbStorageVault($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/GetExascaleDbStorageVault', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getExascaleDbStorageVaultExceptionTest()
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
        $formattedName = $gapicClient->exascaleDbStorageVaultName(
            '[PROJECT]',
            '[LOCATION]',
            '[EXASCALE_DB_STORAGE_VAULT]'
        );
        $request = (new GetExascaleDbStorageVaultRequest())->setName($formattedName);
        try {
            $gapicClient->getExascaleDbStorageVault($request);
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
    public function getOdbNetworkTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $network = 'network1843485230';
        $entitlementId = 'entitlementId-1715775123';
        $gcpOracleZone = 'gcpOracleZone1763347746';
        $expectedResponse = new OdbNetwork();
        $expectedResponse->setName($name2);
        $expectedResponse->setNetwork($network);
        $expectedResponse->setEntitlementId($entitlementId);
        $expectedResponse->setGcpOracleZone($gcpOracleZone);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->odbNetworkName('[PROJECT]', '[LOCATION]', '[ODB_NETWORK]');
        $request = (new GetOdbNetworkRequest())->setName($formattedName);
        $response = $gapicClient->getOdbNetwork($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/GetOdbNetwork', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getOdbNetworkExceptionTest()
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
        $formattedName = $gapicClient->odbNetworkName('[PROJECT]', '[LOCATION]', '[ODB_NETWORK]');
        $request = (new GetOdbNetworkRequest())->setName($formattedName);
        try {
            $gapicClient->getOdbNetwork($request);
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
    public function getOdbSubnetTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $cidrRange = 'cidrRange327470258';
        $expectedResponse = new OdbSubnet();
        $expectedResponse->setName($name2);
        $expectedResponse->setCidrRange($cidrRange);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->odbSubnetName('[PROJECT]', '[LOCATION]', '[ODB_NETWORK]', '[ODB_SUBNET]');
        $request = (new GetOdbSubnetRequest())->setName($formattedName);
        $response = $gapicClient->getOdbSubnet($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/GetOdbSubnet', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getOdbSubnetExceptionTest()
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
        $formattedName = $gapicClient->odbSubnetName('[PROJECT]', '[LOCATION]', '[ODB_NETWORK]', '[ODB_SUBNET]');
        $request = (new GetOdbSubnetRequest())->setName($formattedName);
        try {
            $gapicClient->getOdbSubnet($request);
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
    public function getPluggableDatabaseTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $ociUrl = 'ociUrl-1632104635';
        $expectedResponse = new PluggableDatabase();
        $expectedResponse->setName($name2);
        $expectedResponse->setOciUrl($ociUrl);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->pluggableDatabaseName('[PROJECT]', '[LOCATION]', '[PLUGGABLE_DATABASE]');
        $request = (new GetPluggableDatabaseRequest())->setName($formattedName);
        $response = $gapicClient->getPluggableDatabase($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/GetPluggableDatabase', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getPluggableDatabaseExceptionTest()
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
        $formattedName = $gapicClient->pluggableDatabaseName('[PROJECT]', '[LOCATION]', '[PLUGGABLE_DATABASE]');
        $request = (new GetPluggableDatabaseRequest())->setName($formattedName);
        try {
            $gapicClient->getPluggableDatabase($request);
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
    public function listAutonomousDatabaseBackupsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $autonomousDatabaseBackupsElement = new AutonomousDatabaseBackup();
        $autonomousDatabaseBackups = [$autonomousDatabaseBackupsElement];
        $expectedResponse = new ListAutonomousDatabaseBackupsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setAutonomousDatabaseBackups($autonomousDatabaseBackups);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListAutonomousDatabaseBackupsRequest())->setParent($formattedParent);
        $response = $gapicClient->listAutonomousDatabaseBackups($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAutonomousDatabaseBackups()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.oracledatabase.v1.OracleDatabase/ListAutonomousDatabaseBackups',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listAutonomousDatabaseBackupsExceptionTest()
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
        $request = (new ListAutonomousDatabaseBackupsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listAutonomousDatabaseBackups($request);
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
    public function listAutonomousDatabaseCharacterSetsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $autonomousDatabaseCharacterSetsElement = new AutonomousDatabaseCharacterSet();
        $autonomousDatabaseCharacterSets = [$autonomousDatabaseCharacterSetsElement];
        $expectedResponse = new ListAutonomousDatabaseCharacterSetsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setAutonomousDatabaseCharacterSets($autonomousDatabaseCharacterSets);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListAutonomousDatabaseCharacterSetsRequest())->setParent($formattedParent);
        $response = $gapicClient->listAutonomousDatabaseCharacterSets($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAutonomousDatabaseCharacterSets()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.oracledatabase.v1.OracleDatabase/ListAutonomousDatabaseCharacterSets',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listAutonomousDatabaseCharacterSetsExceptionTest()
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
        $request = (new ListAutonomousDatabaseCharacterSetsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listAutonomousDatabaseCharacterSets($request);
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
    public function listAutonomousDatabasesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $autonomousDatabasesElement = new AutonomousDatabase();
        $autonomousDatabases = [$autonomousDatabasesElement];
        $expectedResponse = new ListAutonomousDatabasesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setAutonomousDatabases($autonomousDatabases);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListAutonomousDatabasesRequest())->setParent($formattedParent);
        $response = $gapicClient->listAutonomousDatabases($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAutonomousDatabases()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/ListAutonomousDatabases', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listAutonomousDatabasesExceptionTest()
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
        $request = (new ListAutonomousDatabasesRequest())->setParent($formattedParent);
        try {
            $gapicClient->listAutonomousDatabases($request);
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
    public function listAutonomousDbVersionsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $autonomousDbVersionsElement = new AutonomousDbVersion();
        $autonomousDbVersions = [$autonomousDbVersionsElement];
        $expectedResponse = new ListAutonomousDbVersionsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setAutonomousDbVersions($autonomousDbVersions);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListAutonomousDbVersionsRequest())->setParent($formattedParent);
        $response = $gapicClient->listAutonomousDbVersions($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAutonomousDbVersions()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/ListAutonomousDbVersions', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listAutonomousDbVersionsExceptionTest()
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
        $request = (new ListAutonomousDbVersionsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listAutonomousDbVersions($request);
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
    public function listCloudExadataInfrastructuresTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $cloudExadataInfrastructuresElement = new CloudExadataInfrastructure();
        $cloudExadataInfrastructures = [$cloudExadataInfrastructuresElement];
        $expectedResponse = new ListCloudExadataInfrastructuresResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setCloudExadataInfrastructures($cloudExadataInfrastructures);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListCloudExadataInfrastructuresRequest())->setParent($formattedParent);
        $response = $gapicClient->listCloudExadataInfrastructures($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCloudExadataInfrastructures()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.oracledatabase.v1.OracleDatabase/ListCloudExadataInfrastructures',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listCloudExadataInfrastructuresExceptionTest()
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
        $request = (new ListCloudExadataInfrastructuresRequest())->setParent($formattedParent);
        try {
            $gapicClient->listCloudExadataInfrastructures($request);
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
    public function listCloudVmClustersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $cloudVmClustersElement = new CloudVmCluster();
        $cloudVmClusters = [$cloudVmClustersElement];
        $expectedResponse = new ListCloudVmClustersResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setCloudVmClusters($cloudVmClusters);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListCloudVmClustersRequest())->setParent($formattedParent);
        $response = $gapicClient->listCloudVmClusters($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCloudVmClusters()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/ListCloudVmClusters', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listCloudVmClustersExceptionTest()
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
        $request = (new ListCloudVmClustersRequest())->setParent($formattedParent);
        try {
            $gapicClient->listCloudVmClusters($request);
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
    public function listDatabaseCharacterSetsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $databaseCharacterSetsElement = new DatabaseCharacterSet();
        $databaseCharacterSets = [$databaseCharacterSetsElement];
        $expectedResponse = new ListDatabaseCharacterSetsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setDatabaseCharacterSets($databaseCharacterSets);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListDatabaseCharacterSetsRequest())->setParent($formattedParent);
        $response = $gapicClient->listDatabaseCharacterSets($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getDatabaseCharacterSets()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/ListDatabaseCharacterSets', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listDatabaseCharacterSetsExceptionTest()
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
        $request = (new ListDatabaseCharacterSetsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listDatabaseCharacterSets($request);
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
    public function listDatabasesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $databasesElement = new Database();
        $databases = [$databasesElement];
        $expectedResponse = new ListDatabasesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setDatabases($databases);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListDatabasesRequest())->setParent($formattedParent);
        $response = $gapicClient->listDatabases($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getDatabases()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/ListDatabases', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listDatabasesExceptionTest()
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
        $request = (new ListDatabasesRequest())->setParent($formattedParent);
        try {
            $gapicClient->listDatabases($request);
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
    public function listDbNodesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $dbNodesElement = new DbNode();
        $dbNodes = [$dbNodesElement];
        $expectedResponse = new ListDbNodesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setDbNodes($dbNodes);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->exadbVmClusterName('[PROJECT]', '[LOCATION]', '[EXADB_VM_CLUSTER]');
        $request = (new ListDbNodesRequest())->setParent($formattedParent);
        $response = $gapicClient->listDbNodes($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getDbNodes()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/ListDbNodes', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listDbNodesExceptionTest()
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
        $formattedParent = $gapicClient->exadbVmClusterName('[PROJECT]', '[LOCATION]', '[EXADB_VM_CLUSTER]');
        $request = (new ListDbNodesRequest())->setParent($formattedParent);
        try {
            $gapicClient->listDbNodes($request);
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
    public function listDbServersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $dbServersElement = new DbServer();
        $dbServers = [$dbServersElement];
        $expectedResponse = new ListDbServersResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setDbServers($dbServers);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->cloudExadataInfrastructureName(
            '[PROJECT]',
            '[LOCATION]',
            '[CLOUD_EXADATA_INFRASTRUCTURE]'
        );
        $request = (new ListDbServersRequest())->setParent($formattedParent);
        $response = $gapicClient->listDbServers($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getDbServers()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/ListDbServers', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listDbServersExceptionTest()
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
        $formattedParent = $gapicClient->cloudExadataInfrastructureName(
            '[PROJECT]',
            '[LOCATION]',
            '[CLOUD_EXADATA_INFRASTRUCTURE]'
        );
        $request = (new ListDbServersRequest())->setParent($formattedParent);
        try {
            $gapicClient->listDbServers($request);
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
    public function listDbSystemInitialStorageSizesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $dbSystemInitialStorageSizesElement = new DbSystemInitialStorageSize();
        $dbSystemInitialStorageSizes = [$dbSystemInitialStorageSizesElement];
        $expectedResponse = new ListDbSystemInitialStorageSizesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setDbSystemInitialStorageSizes($dbSystemInitialStorageSizes);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListDbSystemInitialStorageSizesRequest())->setParent($formattedParent);
        $response = $gapicClient->listDbSystemInitialStorageSizes($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getDbSystemInitialStorageSizes()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.oracledatabase.v1.OracleDatabase/ListDbSystemInitialStorageSizes',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listDbSystemInitialStorageSizesExceptionTest()
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
        $request = (new ListDbSystemInitialStorageSizesRequest())->setParent($formattedParent);
        try {
            $gapicClient->listDbSystemInitialStorageSizes($request);
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
    public function listDbSystemShapesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $dbSystemShapesElement = new DbSystemShape();
        $dbSystemShapes = [$dbSystemShapesElement];
        $expectedResponse = new ListDbSystemShapesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setDbSystemShapes($dbSystemShapes);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListDbSystemShapesRequest())->setParent($formattedParent);
        $response = $gapicClient->listDbSystemShapes($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getDbSystemShapes()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/ListDbSystemShapes', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listDbSystemShapesExceptionTest()
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
        $request = (new ListDbSystemShapesRequest())->setParent($formattedParent);
        try {
            $gapicClient->listDbSystemShapes($request);
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
    public function listDbSystemsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $dbSystemsElement = new DbSystem();
        $dbSystems = [$dbSystemsElement];
        $expectedResponse = new ListDbSystemsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setDbSystems($dbSystems);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListDbSystemsRequest())->setParent($formattedParent);
        $response = $gapicClient->listDbSystems($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getDbSystems()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/ListDbSystems', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listDbSystemsExceptionTest()
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
        $request = (new ListDbSystemsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listDbSystems($request);
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
    public function listDbVersionsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $dbVersionsElement = new DbVersion();
        $dbVersions = [$dbVersionsElement];
        $expectedResponse = new ListDbVersionsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setDbVersions($dbVersions);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListDbVersionsRequest())->setParent($formattedParent);
        $response = $gapicClient->listDbVersions($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getDbVersions()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/ListDbVersions', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listDbVersionsExceptionTest()
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
        $request = (new ListDbVersionsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listDbVersions($request);
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
    public function listEntitlementsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $entitlementsElement = new Entitlement();
        $entitlements = [$entitlementsElement];
        $expectedResponse = new ListEntitlementsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setEntitlements($entitlements);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListEntitlementsRequest())->setParent($formattedParent);
        $response = $gapicClient->listEntitlements($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getEntitlements()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/ListEntitlements', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listEntitlementsExceptionTest()
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
        $request = (new ListEntitlementsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listEntitlements($request);
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
    public function listExadbVmClustersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $exadbVmClustersElement = new ExadbVmCluster();
        $exadbVmClusters = [$exadbVmClustersElement];
        $expectedResponse = new ListExadbVmClustersResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setExadbVmClusters($exadbVmClusters);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListExadbVmClustersRequest())->setParent($formattedParent);
        $response = $gapicClient->listExadbVmClusters($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getExadbVmClusters()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/ListExadbVmClusters', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listExadbVmClustersExceptionTest()
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
        $request = (new ListExadbVmClustersRequest())->setParent($formattedParent);
        try {
            $gapicClient->listExadbVmClusters($request);
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
    public function listExascaleDbStorageVaultsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $exascaleDbStorageVaultsElement = new ExascaleDbStorageVault();
        $exascaleDbStorageVaults = [$exascaleDbStorageVaultsElement];
        $expectedResponse = new ListExascaleDbStorageVaultsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setExascaleDbStorageVaults($exascaleDbStorageVaults);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListExascaleDbStorageVaultsRequest())->setParent($formattedParent);
        $response = $gapicClient->listExascaleDbStorageVaults($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getExascaleDbStorageVaults()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.oracledatabase.v1.OracleDatabase/ListExascaleDbStorageVaults',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listExascaleDbStorageVaultsExceptionTest()
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
        $request = (new ListExascaleDbStorageVaultsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listExascaleDbStorageVaults($request);
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
    public function listGiVersionsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $giVersionsElement = new GiVersion();
        $giVersions = [$giVersionsElement];
        $expectedResponse = new ListGiVersionsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setGiVersions($giVersions);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListGiVersionsRequest())->setParent($formattedParent);
        $response = $gapicClient->listGiVersions($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getGiVersions()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/ListGiVersions', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listGiVersionsExceptionTest()
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
        $request = (new ListGiVersionsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listGiVersions($request);
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
    public function listMinorVersionsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $minorVersionsElement = new MinorVersion();
        $minorVersions = [$minorVersionsElement];
        $expectedResponse = new ListMinorVersionsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setMinorVersions($minorVersions);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->giVersionName('[PROJECT]', '[LOCATION]', '[GI_VERSION]');
        $request = (new ListMinorVersionsRequest())->setParent($formattedParent);
        $response = $gapicClient->listMinorVersions($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getMinorVersions()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/ListMinorVersions', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listMinorVersionsExceptionTest()
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
        $formattedParent = $gapicClient->giVersionName('[PROJECT]', '[LOCATION]', '[GI_VERSION]');
        $request = (new ListMinorVersionsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listMinorVersions($request);
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
    public function listOdbNetworksTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $odbNetworksElement = new OdbNetwork();
        $odbNetworks = [$odbNetworksElement];
        $expectedResponse = new ListOdbNetworksResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setOdbNetworks($odbNetworks);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListOdbNetworksRequest())->setParent($formattedParent);
        $response = $gapicClient->listOdbNetworks($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getOdbNetworks()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/ListOdbNetworks', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listOdbNetworksExceptionTest()
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
        $request = (new ListOdbNetworksRequest())->setParent($formattedParent);
        try {
            $gapicClient->listOdbNetworks($request);
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
    public function listOdbSubnetsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $odbSubnetsElement = new OdbSubnet();
        $odbSubnets = [$odbSubnetsElement];
        $expectedResponse = new ListOdbSubnetsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setOdbSubnets($odbSubnets);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->odbNetworkName('[PROJECT]', '[LOCATION]', '[ODB_NETWORK]');
        $request = (new ListOdbSubnetsRequest())->setParent($formattedParent);
        $response = $gapicClient->listOdbSubnets($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getOdbSubnets()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/ListOdbSubnets', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listOdbSubnetsExceptionTest()
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
        $formattedParent = $gapicClient->odbNetworkName('[PROJECT]', '[LOCATION]', '[ODB_NETWORK]');
        $request = (new ListOdbSubnetsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listOdbSubnets($request);
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
    public function listPluggableDatabasesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $pluggableDatabasesElement = new PluggableDatabase();
        $pluggableDatabases = [$pluggableDatabasesElement];
        $expectedResponse = new ListPluggableDatabasesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setPluggableDatabases($pluggableDatabases);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListPluggableDatabasesRequest())->setParent($formattedParent);
        $response = $gapicClient->listPluggableDatabases($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getPluggableDatabases()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/ListPluggableDatabases', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listPluggableDatabasesExceptionTest()
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
        $request = (new ListPluggableDatabasesRequest())->setParent($formattedParent);
        try {
            $gapicClient->listPluggableDatabases($request);
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
    public function removeVirtualMachineExadbVmClusterTest()
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
        $incompleteOperation->setName('operations/removeVirtualMachineExadbVmClusterTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name2 = 'name2-1052831874';
        $gcpOracleZone = 'gcpOracleZone1763347746';
        $odbNetwork = 'odbNetwork-1199754980';
        $odbSubnet = 'odbSubnet118675119';
        $backupOdbSubnet = 'backupOdbSubnet677701964';
        $displayName = 'displayName1615086568';
        $entitlementId = 'entitlementId-1715775123';
        $expectedResponse = new ExadbVmCluster();
        $expectedResponse->setName($name2);
        $expectedResponse->setGcpOracleZone($gcpOracleZone);
        $expectedResponse->setOdbNetwork($odbNetwork);
        $expectedResponse->setOdbSubnet($odbSubnet);
        $expectedResponse->setBackupOdbSubnet($backupOdbSubnet);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setEntitlementId($entitlementId);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/removeVirtualMachineExadbVmClusterTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->exadbVmClusterName('[PROJECT]', '[LOCATION]', '[EXADB_VM_CLUSTER]');
        $hostnames = [];
        $request = (new RemoveVirtualMachineExadbVmClusterRequest())->setName($formattedName)->setHostnames($hostnames);
        $response = $gapicClient->removeVirtualMachineExadbVmCluster($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.oracledatabase.v1.OracleDatabase/RemoveVirtualMachineExadbVmCluster',
            $actualApiFuncCall
        );
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualApiRequestObject->getHostnames();
        $this->assertProtobufEquals($hostnames, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/removeVirtualMachineExadbVmClusterTest');
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
    public function removeVirtualMachineExadbVmClusterExceptionTest()
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
        $incompleteOperation->setName('operations/removeVirtualMachineExadbVmClusterTest');
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
        $formattedName = $gapicClient->exadbVmClusterName('[PROJECT]', '[LOCATION]', '[EXADB_VM_CLUSTER]');
        $hostnames = [];
        $request = (new RemoveVirtualMachineExadbVmClusterRequest())->setName($formattedName)->setHostnames($hostnames);
        $response = $gapicClient->removeVirtualMachineExadbVmCluster($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/removeVirtualMachineExadbVmClusterTest');
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
    public function restartAutonomousDatabaseTest()
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
        $incompleteOperation->setName('operations/restartAutonomousDatabaseTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name2 = 'name2-1052831874';
        $database = 'database1789464955';
        $displayName = 'displayName1615086568';
        $entitlementId = 'entitlementId-1715775123';
        $adminPassword = 'adminPassword1579561355';
        $network = 'network1843485230';
        $cidr = 'cidr3053428';
        $odbNetwork = 'odbNetwork-1199754980';
        $odbSubnet = 'odbSubnet118675119';
        $expectedResponse = new AutonomousDatabase();
        $expectedResponse->setName($name2);
        $expectedResponse->setDatabase($database);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setEntitlementId($entitlementId);
        $expectedResponse->setAdminPassword($adminPassword);
        $expectedResponse->setNetwork($network);
        $expectedResponse->setCidr($cidr);
        $expectedResponse->setOdbNetwork($odbNetwork);
        $expectedResponse->setOdbSubnet($odbSubnet);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/restartAutonomousDatabaseTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->autonomousDatabaseName('[PROJECT]', '[LOCATION]', '[AUTONOMOUS_DATABASE]');
        $request = (new RestartAutonomousDatabaseRequest())->setName($formattedName);
        $response = $gapicClient->restartAutonomousDatabase($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.oracledatabase.v1.OracleDatabase/RestartAutonomousDatabase',
            $actualApiFuncCall
        );
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/restartAutonomousDatabaseTest');
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
    public function restartAutonomousDatabaseExceptionTest()
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
        $incompleteOperation->setName('operations/restartAutonomousDatabaseTest');
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
        $formattedName = $gapicClient->autonomousDatabaseName('[PROJECT]', '[LOCATION]', '[AUTONOMOUS_DATABASE]');
        $request = (new RestartAutonomousDatabaseRequest())->setName($formattedName);
        $response = $gapicClient->restartAutonomousDatabase($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/restartAutonomousDatabaseTest');
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
    public function restoreAutonomousDatabaseTest()
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
        $incompleteOperation->setName('operations/restoreAutonomousDatabaseTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name2 = 'name2-1052831874';
        $database = 'database1789464955';
        $displayName = 'displayName1615086568';
        $entitlementId = 'entitlementId-1715775123';
        $adminPassword = 'adminPassword1579561355';
        $network = 'network1843485230';
        $cidr = 'cidr3053428';
        $odbNetwork = 'odbNetwork-1199754980';
        $odbSubnet = 'odbSubnet118675119';
        $expectedResponse = new AutonomousDatabase();
        $expectedResponse->setName($name2);
        $expectedResponse->setDatabase($database);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setEntitlementId($entitlementId);
        $expectedResponse->setAdminPassword($adminPassword);
        $expectedResponse->setNetwork($network);
        $expectedResponse->setCidr($cidr);
        $expectedResponse->setOdbNetwork($odbNetwork);
        $expectedResponse->setOdbSubnet($odbSubnet);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/restoreAutonomousDatabaseTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->autonomousDatabaseName('[PROJECT]', '[LOCATION]', '[AUTONOMOUS_DATABASE]');
        $restoreTime = new Timestamp();
        $request = (new RestoreAutonomousDatabaseRequest())->setName($formattedName)->setRestoreTime($restoreTime);
        $response = $gapicClient->restoreAutonomousDatabase($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.oracledatabase.v1.OracleDatabase/RestoreAutonomousDatabase',
            $actualApiFuncCall
        );
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualApiRequestObject->getRestoreTime();
        $this->assertProtobufEquals($restoreTime, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/restoreAutonomousDatabaseTest');
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
    public function restoreAutonomousDatabaseExceptionTest()
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
        $incompleteOperation->setName('operations/restoreAutonomousDatabaseTest');
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
        $formattedName = $gapicClient->autonomousDatabaseName('[PROJECT]', '[LOCATION]', '[AUTONOMOUS_DATABASE]');
        $restoreTime = new Timestamp();
        $request = (new RestoreAutonomousDatabaseRequest())->setName($formattedName)->setRestoreTime($restoreTime);
        $response = $gapicClient->restoreAutonomousDatabase($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/restoreAutonomousDatabaseTest');
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
    public function startAutonomousDatabaseTest()
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
        $incompleteOperation->setName('operations/startAutonomousDatabaseTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name2 = 'name2-1052831874';
        $database = 'database1789464955';
        $displayName = 'displayName1615086568';
        $entitlementId = 'entitlementId-1715775123';
        $adminPassword = 'adminPassword1579561355';
        $network = 'network1843485230';
        $cidr = 'cidr3053428';
        $odbNetwork = 'odbNetwork-1199754980';
        $odbSubnet = 'odbSubnet118675119';
        $expectedResponse = new AutonomousDatabase();
        $expectedResponse->setName($name2);
        $expectedResponse->setDatabase($database);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setEntitlementId($entitlementId);
        $expectedResponse->setAdminPassword($adminPassword);
        $expectedResponse->setNetwork($network);
        $expectedResponse->setCidr($cidr);
        $expectedResponse->setOdbNetwork($odbNetwork);
        $expectedResponse->setOdbSubnet($odbSubnet);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/startAutonomousDatabaseTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->autonomousDatabaseName('[PROJECT]', '[LOCATION]', '[AUTONOMOUS_DATABASE]');
        $request = (new StartAutonomousDatabaseRequest())->setName($formattedName);
        $response = $gapicClient->startAutonomousDatabase($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/StartAutonomousDatabase', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/startAutonomousDatabaseTest');
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
    public function startAutonomousDatabaseExceptionTest()
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
        $incompleteOperation->setName('operations/startAutonomousDatabaseTest');
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
        $formattedName = $gapicClient->autonomousDatabaseName('[PROJECT]', '[LOCATION]', '[AUTONOMOUS_DATABASE]');
        $request = (new StartAutonomousDatabaseRequest())->setName($formattedName);
        $response = $gapicClient->startAutonomousDatabase($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/startAutonomousDatabaseTest');
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
    public function stopAutonomousDatabaseTest()
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
        $incompleteOperation->setName('operations/stopAutonomousDatabaseTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name2 = 'name2-1052831874';
        $database = 'database1789464955';
        $displayName = 'displayName1615086568';
        $entitlementId = 'entitlementId-1715775123';
        $adminPassword = 'adminPassword1579561355';
        $network = 'network1843485230';
        $cidr = 'cidr3053428';
        $odbNetwork = 'odbNetwork-1199754980';
        $odbSubnet = 'odbSubnet118675119';
        $expectedResponse = new AutonomousDatabase();
        $expectedResponse->setName($name2);
        $expectedResponse->setDatabase($database);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setEntitlementId($entitlementId);
        $expectedResponse->setAdminPassword($adminPassword);
        $expectedResponse->setNetwork($network);
        $expectedResponse->setCidr($cidr);
        $expectedResponse->setOdbNetwork($odbNetwork);
        $expectedResponse->setOdbSubnet($odbSubnet);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/stopAutonomousDatabaseTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->autonomousDatabaseName('[PROJECT]', '[LOCATION]', '[AUTONOMOUS_DATABASE]');
        $request = (new StopAutonomousDatabaseRequest())->setName($formattedName);
        $response = $gapicClient->stopAutonomousDatabase($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/StopAutonomousDatabase', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/stopAutonomousDatabaseTest');
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
    public function stopAutonomousDatabaseExceptionTest()
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
        $incompleteOperation->setName('operations/stopAutonomousDatabaseTest');
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
        $formattedName = $gapicClient->autonomousDatabaseName('[PROJECT]', '[LOCATION]', '[AUTONOMOUS_DATABASE]');
        $request = (new StopAutonomousDatabaseRequest())->setName($formattedName);
        $response = $gapicClient->stopAutonomousDatabase($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/stopAutonomousDatabaseTest');
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
    public function switchoverAutonomousDatabaseTest()
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
        $incompleteOperation->setName('operations/switchoverAutonomousDatabaseTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name2 = 'name2-1052831874';
        $database = 'database1789464955';
        $displayName = 'displayName1615086568';
        $entitlementId = 'entitlementId-1715775123';
        $adminPassword = 'adminPassword1579561355';
        $network = 'network1843485230';
        $cidr = 'cidr3053428';
        $odbNetwork = 'odbNetwork-1199754980';
        $odbSubnet = 'odbSubnet118675119';
        $expectedResponse = new AutonomousDatabase();
        $expectedResponse->setName($name2);
        $expectedResponse->setDatabase($database);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setEntitlementId($entitlementId);
        $expectedResponse->setAdminPassword($adminPassword);
        $expectedResponse->setNetwork($network);
        $expectedResponse->setCidr($cidr);
        $expectedResponse->setOdbNetwork($odbNetwork);
        $expectedResponse->setOdbSubnet($odbSubnet);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/switchoverAutonomousDatabaseTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->autonomousDatabaseName('[PROJECT]', '[LOCATION]', '[AUTONOMOUS_DATABASE]');
        $formattedPeerAutonomousDatabase = $gapicClient->autonomousDatabaseName(
            '[PROJECT]',
            '[LOCATION]',
            '[AUTONOMOUS_DATABASE]'
        );
        $request = (new SwitchoverAutonomousDatabaseRequest())
            ->setName($formattedName)
            ->setPeerAutonomousDatabase($formattedPeerAutonomousDatabase);
        $response = $gapicClient->switchoverAutonomousDatabase($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.oracledatabase.v1.OracleDatabase/SwitchoverAutonomousDatabase',
            $actualApiFuncCall
        );
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualApiRequestObject->getPeerAutonomousDatabase();
        $this->assertProtobufEquals($formattedPeerAutonomousDatabase, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/switchoverAutonomousDatabaseTest');
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
    public function switchoverAutonomousDatabaseExceptionTest()
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
        $incompleteOperation->setName('operations/switchoverAutonomousDatabaseTest');
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
        $formattedName = $gapicClient->autonomousDatabaseName('[PROJECT]', '[LOCATION]', '[AUTONOMOUS_DATABASE]');
        $formattedPeerAutonomousDatabase = $gapicClient->autonomousDatabaseName(
            '[PROJECT]',
            '[LOCATION]',
            '[AUTONOMOUS_DATABASE]'
        );
        $request = (new SwitchoverAutonomousDatabaseRequest())
            ->setName($formattedName)
            ->setPeerAutonomousDatabase($formattedPeerAutonomousDatabase);
        $response = $gapicClient->switchoverAutonomousDatabase($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/switchoverAutonomousDatabaseTest');
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
    public function updateAutonomousDatabaseTest()
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
        $incompleteOperation->setName('operations/updateAutonomousDatabaseTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $database = 'database1789464955';
        $displayName = 'displayName1615086568';
        $entitlementId = 'entitlementId-1715775123';
        $adminPassword = 'adminPassword1579561355';
        $network = 'network1843485230';
        $cidr = 'cidr3053428';
        $odbNetwork = 'odbNetwork-1199754980';
        $odbSubnet = 'odbSubnet118675119';
        $expectedResponse = new AutonomousDatabase();
        $expectedResponse->setName($name);
        $expectedResponse->setDatabase($database);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setEntitlementId($entitlementId);
        $expectedResponse->setAdminPassword($adminPassword);
        $expectedResponse->setNetwork($network);
        $expectedResponse->setCidr($cidr);
        $expectedResponse->setOdbNetwork($odbNetwork);
        $expectedResponse->setOdbSubnet($odbSubnet);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/updateAutonomousDatabaseTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $autonomousDatabase = new AutonomousDatabase();
        $request = (new UpdateAutonomousDatabaseRequest())->setAutonomousDatabase($autonomousDatabase);
        $response = $gapicClient->updateAutonomousDatabase($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.oracledatabase.v1.OracleDatabase/UpdateAutonomousDatabase',
            $actualApiFuncCall
        );
        $actualValue = $actualApiRequestObject->getAutonomousDatabase();
        $this->assertProtobufEquals($autonomousDatabase, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/updateAutonomousDatabaseTest');
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
    public function updateAutonomousDatabaseExceptionTest()
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
        $incompleteOperation->setName('operations/updateAutonomousDatabaseTest');
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
        $autonomousDatabase = new AutonomousDatabase();
        $request = (new UpdateAutonomousDatabaseRequest())->setAutonomousDatabase($autonomousDatabase);
        $response = $gapicClient->updateAutonomousDatabase($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/updateAutonomousDatabaseTest');
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
    public function updateExadbVmClusterTest()
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
        $incompleteOperation->setName('operations/updateExadbVmClusterTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $gcpOracleZone = 'gcpOracleZone1763347746';
        $odbNetwork = 'odbNetwork-1199754980';
        $odbSubnet = 'odbSubnet118675119';
        $backupOdbSubnet = 'backupOdbSubnet677701964';
        $displayName = 'displayName1615086568';
        $entitlementId = 'entitlementId-1715775123';
        $expectedResponse = new ExadbVmCluster();
        $expectedResponse->setName($name);
        $expectedResponse->setGcpOracleZone($gcpOracleZone);
        $expectedResponse->setOdbNetwork($odbNetwork);
        $expectedResponse->setOdbSubnet($odbSubnet);
        $expectedResponse->setBackupOdbSubnet($backupOdbSubnet);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setEntitlementId($entitlementId);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/updateExadbVmClusterTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $exadbVmCluster = new ExadbVmCluster();
        $exadbVmClusterProperties = new ExadbVmClusterProperties();
        $propertiesGridImageId = 'propertiesGridImageId1390651005';
        $exadbVmClusterProperties->setGridImageId($propertiesGridImageId);
        $propertiesNodeCount = 2104221754;
        $exadbVmClusterProperties->setNodeCount($propertiesNodeCount);
        $propertiesEnabledEcpuCountPerNode = 1552954913;
        $exadbVmClusterProperties->setEnabledEcpuCountPerNode($propertiesEnabledEcpuCountPerNode);
        $propertiesVmFileSystemStorage = new ExadbVmClusterStorageDetails();
        $vmFileSystemStorageSizeInGbsPerNode = 818206298;
        $propertiesVmFileSystemStorage->setSizeInGbsPerNode($vmFileSystemStorageSizeInGbsPerNode);
        $exadbVmClusterProperties->setVmFileSystemStorage($propertiesVmFileSystemStorage);
        $propertiesExascaleDbStorageVault = $gapicClient->exascaleDbStorageVaultName(
            '[PROJECT]',
            '[LOCATION]',
            '[EXASCALE_DB_STORAGE_VAULT]'
        );
        $exadbVmClusterProperties->setExascaleDbStorageVault($propertiesExascaleDbStorageVault);
        $propertiesHostnamePrefix = 'propertiesHostnamePrefix1242795192';
        $exadbVmClusterProperties->setHostnamePrefix($propertiesHostnamePrefix);
        $propertiesSshPublicKeys = [];
        $exadbVmClusterProperties->setSshPublicKeys($propertiesSshPublicKeys);
        $propertiesShapeAttribute = ShapeAttribute::SHAPE_ATTRIBUTE_UNSPECIFIED;
        $exadbVmClusterProperties->setShapeAttribute($propertiesShapeAttribute);
        $exadbVmCluster->setProperties($exadbVmClusterProperties);
        $exadbVmClusterOdbSubnet = $gapicClient->odbSubnetName(
            '[PROJECT]',
            '[LOCATION]',
            '[ODB_NETWORK]',
            '[ODB_SUBNET]'
        );
        $exadbVmCluster->setOdbSubnet($exadbVmClusterOdbSubnet);
        $exadbVmClusterBackupOdbSubnet = $gapicClient->odbSubnetName(
            '[PROJECT]',
            '[LOCATION]',
            '[ODB_NETWORK]',
            '[ODB_SUBNET]'
        );
        $exadbVmCluster->setBackupOdbSubnet($exadbVmClusterBackupOdbSubnet);
        $exadbVmClusterDisplayName = 'exadbVmClusterDisplayName-1120012202';
        $exadbVmCluster->setDisplayName($exadbVmClusterDisplayName);
        $request = (new UpdateExadbVmClusterRequest())->setExadbVmCluster($exadbVmCluster);
        $response = $gapicClient->updateExadbVmCluster($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.oracledatabase.v1.OracleDatabase/UpdateExadbVmCluster', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getExadbVmCluster();
        $this->assertProtobufEquals($exadbVmCluster, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/updateExadbVmClusterTest');
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
    public function updateExadbVmClusterExceptionTest()
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
        $incompleteOperation->setName('operations/updateExadbVmClusterTest');
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
        $exadbVmCluster = new ExadbVmCluster();
        $exadbVmClusterProperties = new ExadbVmClusterProperties();
        $propertiesGridImageId = 'propertiesGridImageId1390651005';
        $exadbVmClusterProperties->setGridImageId($propertiesGridImageId);
        $propertiesNodeCount = 2104221754;
        $exadbVmClusterProperties->setNodeCount($propertiesNodeCount);
        $propertiesEnabledEcpuCountPerNode = 1552954913;
        $exadbVmClusterProperties->setEnabledEcpuCountPerNode($propertiesEnabledEcpuCountPerNode);
        $propertiesVmFileSystemStorage = new ExadbVmClusterStorageDetails();
        $vmFileSystemStorageSizeInGbsPerNode = 818206298;
        $propertiesVmFileSystemStorage->setSizeInGbsPerNode($vmFileSystemStorageSizeInGbsPerNode);
        $exadbVmClusterProperties->setVmFileSystemStorage($propertiesVmFileSystemStorage);
        $propertiesExascaleDbStorageVault = $gapicClient->exascaleDbStorageVaultName(
            '[PROJECT]',
            '[LOCATION]',
            '[EXASCALE_DB_STORAGE_VAULT]'
        );
        $exadbVmClusterProperties->setExascaleDbStorageVault($propertiesExascaleDbStorageVault);
        $propertiesHostnamePrefix = 'propertiesHostnamePrefix1242795192';
        $exadbVmClusterProperties->setHostnamePrefix($propertiesHostnamePrefix);
        $propertiesSshPublicKeys = [];
        $exadbVmClusterProperties->setSshPublicKeys($propertiesSshPublicKeys);
        $propertiesShapeAttribute = ShapeAttribute::SHAPE_ATTRIBUTE_UNSPECIFIED;
        $exadbVmClusterProperties->setShapeAttribute($propertiesShapeAttribute);
        $exadbVmCluster->setProperties($exadbVmClusterProperties);
        $exadbVmClusterOdbSubnet = $gapicClient->odbSubnetName(
            '[PROJECT]',
            '[LOCATION]',
            '[ODB_NETWORK]',
            '[ODB_SUBNET]'
        );
        $exadbVmCluster->setOdbSubnet($exadbVmClusterOdbSubnet);
        $exadbVmClusterBackupOdbSubnet = $gapicClient->odbSubnetName(
            '[PROJECT]',
            '[LOCATION]',
            '[ODB_NETWORK]',
            '[ODB_SUBNET]'
        );
        $exadbVmCluster->setBackupOdbSubnet($exadbVmClusterBackupOdbSubnet);
        $exadbVmClusterDisplayName = 'exadbVmClusterDisplayName-1120012202';
        $exadbVmCluster->setDisplayName($exadbVmClusterDisplayName);
        $request = (new UpdateExadbVmClusterRequest())->setExadbVmCluster($exadbVmCluster);
        $response = $gapicClient->updateExadbVmCluster($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/updateExadbVmClusterTest');
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
    public function createAutonomousDatabaseAsyncTest()
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
        $incompleteOperation->setName('operations/createAutonomousDatabaseTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $database = 'database1789464955';
        $displayName = 'displayName1615086568';
        $entitlementId = 'entitlementId-1715775123';
        $adminPassword = 'adminPassword1579561355';
        $network = 'network1843485230';
        $cidr = 'cidr3053428';
        $odbNetwork = 'odbNetwork-1199754980';
        $odbSubnet = 'odbSubnet118675119';
        $expectedResponse = new AutonomousDatabase();
        $expectedResponse->setName($name);
        $expectedResponse->setDatabase($database);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setEntitlementId($entitlementId);
        $expectedResponse->setAdminPassword($adminPassword);
        $expectedResponse->setNetwork($network);
        $expectedResponse->setCidr($cidr);
        $expectedResponse->setOdbNetwork($odbNetwork);
        $expectedResponse->setOdbSubnet($odbSubnet);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/createAutonomousDatabaseTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $autonomousDatabaseId = 'autonomousDatabaseId-1188134896';
        $autonomousDatabase = new AutonomousDatabase();
        $request = (new CreateAutonomousDatabaseRequest())
            ->setParent($formattedParent)
            ->setAutonomousDatabaseId($autonomousDatabaseId)
            ->setAutonomousDatabase($autonomousDatabase);
        $response = $gapicClient->createAutonomousDatabaseAsync($request)->wait();
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.oracledatabase.v1.OracleDatabase/CreateAutonomousDatabase',
            $actualApiFuncCall
        );
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getAutonomousDatabaseId();
        $this->assertProtobufEquals($autonomousDatabaseId, $actualValue);
        $actualValue = $actualApiRequestObject->getAutonomousDatabase();
        $this->assertProtobufEquals($autonomousDatabase, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createAutonomousDatabaseTest');
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
