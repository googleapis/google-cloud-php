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

namespace Google\Cloud\Redis\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Location\GetLocationRequest;
use Google\Cloud\Location\ListLocationsRequest;
use Google\Cloud\Location\ListLocationsResponse;
use Google\Cloud\Location\Location;
use Google\Cloud\Redis\V1\Client\CloudRedisClient;
use Google\Cloud\Redis\V1\CreateInstanceRequest;
use Google\Cloud\Redis\V1\DeleteInstanceRequest;
use Google\Cloud\Redis\V1\ExportInstanceRequest;
use Google\Cloud\Redis\V1\FailoverInstanceRequest;
use Google\Cloud\Redis\V1\GetInstanceAuthStringRequest;
use Google\Cloud\Redis\V1\GetInstanceRequest;
use Google\Cloud\Redis\V1\ImportInstanceRequest;
use Google\Cloud\Redis\V1\InputConfig;
use Google\Cloud\Redis\V1\Instance;
use Google\Cloud\Redis\V1\InstanceAuthString;
use Google\Cloud\Redis\V1\Instance\Tier;
use Google\Cloud\Redis\V1\ListInstancesRequest;
use Google\Cloud\Redis\V1\ListInstancesResponse;
use Google\Cloud\Redis\V1\OutputConfig;
use Google\Cloud\Redis\V1\RescheduleMaintenanceRequest;
use Google\Cloud\Redis\V1\RescheduleMaintenanceRequest\RescheduleType;
use Google\Cloud\Redis\V1\UpdateInstanceRequest;
use Google\Cloud\Redis\V1\UpgradeInstanceRequest;
use Google\LongRunning\GetOperationRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\Any;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group redis
 *
 * @group gapic
 */
class CloudRedisClientTest extends GeneratedTest
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

    /** @return CloudRedisClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new CloudRedisClient($options);
    }

    /** @test */
    public function createInstanceTest()
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
        $incompleteOperation->setName('operations/createInstanceTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $locationId = 'locationId552319461';
        $alternativeLocationId = 'alternativeLocationId-718920621';
        $redisVersion = 'redisVersion-685310444';
        $reservedIpRange = 'reservedIpRange-1082940580';
        $secondaryIpRange = 'secondaryIpRange-1484975472';
        $host = 'host3208616';
        $port = 3446913;
        $currentLocationId = 'currentLocationId1312712735';
        $statusMessage = 'statusMessage-239442758';
        $memorySizeGb = 34199707;
        $authorizedNetwork = 'authorizedNetwork-1733809270';
        $persistenceIamIdentity = 'persistenceIamIdentity1061944584';
        $authEnabled = true;
        $replicaCount = 564075208;
        $readEndpoint = 'readEndpoint-2081202658';
        $readEndpointPort = 1676143102;
        $customerManagedKey = 'customerManagedKey-1392642338';
        $maintenanceVersion = 'maintenanceVersion-588975188';
        $expectedResponse = new Instance();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setLocationId($locationId);
        $expectedResponse->setAlternativeLocationId($alternativeLocationId);
        $expectedResponse->setRedisVersion($redisVersion);
        $expectedResponse->setReservedIpRange($reservedIpRange);
        $expectedResponse->setSecondaryIpRange($secondaryIpRange);
        $expectedResponse->setHost($host);
        $expectedResponse->setPort($port);
        $expectedResponse->setCurrentLocationId($currentLocationId);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setMemorySizeGb($memorySizeGb);
        $expectedResponse->setAuthorizedNetwork($authorizedNetwork);
        $expectedResponse->setPersistenceIamIdentity($persistenceIamIdentity);
        $expectedResponse->setAuthEnabled($authEnabled);
        $expectedResponse->setReplicaCount($replicaCount);
        $expectedResponse->setReadEndpoint($readEndpoint);
        $expectedResponse->setReadEndpointPort($readEndpointPort);
        $expectedResponse->setCustomerManagedKey($customerManagedKey);
        $expectedResponse->setMaintenanceVersion($maintenanceVersion);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/createInstanceTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $instanceId = 'instanceId-2101995259';
        $instance = new Instance();
        $instanceName = 'instanceName-737857344';
        $instance->setName($instanceName);
        $instanceTier = Tier::TIER_UNSPECIFIED;
        $instance->setTier($instanceTier);
        $instanceMemorySizeGb = 193936814;
        $instance->setMemorySizeGb($instanceMemorySizeGb);
        $request = (new CreateInstanceRequest())
            ->setParent($formattedParent)
            ->setInstanceId($instanceId)
            ->setInstance($instance);
        $response = $gapicClient->createInstance($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.redis.v1.CloudRedis/CreateInstance', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getInstanceId();
        $this->assertProtobufEquals($instanceId, $actualValue);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createInstanceTest');
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
    public function createInstanceExceptionTest()
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
        $incompleteOperation->setName('operations/createInstanceTest');
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
        $instanceId = 'instanceId-2101995259';
        $instance = new Instance();
        $instanceName = 'instanceName-737857344';
        $instance->setName($instanceName);
        $instanceTier = Tier::TIER_UNSPECIFIED;
        $instance->setTier($instanceTier);
        $instanceMemorySizeGb = 193936814;
        $instance->setMemorySizeGb($instanceMemorySizeGb);
        $request = (new CreateInstanceRequest())
            ->setParent($formattedParent)
            ->setInstanceId($instanceId)
            ->setInstance($instance);
        $response = $gapicClient->createInstance($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createInstanceTest');
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
    public function deleteInstanceTest()
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
        $incompleteOperation->setName('operations/deleteInstanceTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new GPBEmpty();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/deleteInstanceTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $request = (new DeleteInstanceRequest())
            ->setName($formattedName);
        $response = $gapicClient->deleteInstance($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.redis.v1.CloudRedis/DeleteInstance', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteInstanceTest');
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
    public function deleteInstanceExceptionTest()
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
        $incompleteOperation->setName('operations/deleteInstanceTest');
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
        $formattedName = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $request = (new DeleteInstanceRequest())
            ->setName($formattedName);
        $response = $gapicClient->deleteInstance($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/deleteInstanceTest');
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
    public function exportInstanceTest()
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
        $incompleteOperation->setName('operations/exportInstanceTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $locationId = 'locationId552319461';
        $alternativeLocationId = 'alternativeLocationId-718920621';
        $redisVersion = 'redisVersion-685310444';
        $reservedIpRange = 'reservedIpRange-1082940580';
        $secondaryIpRange = 'secondaryIpRange-1484975472';
        $host = 'host3208616';
        $port = 3446913;
        $currentLocationId = 'currentLocationId1312712735';
        $statusMessage = 'statusMessage-239442758';
        $memorySizeGb = 34199707;
        $authorizedNetwork = 'authorizedNetwork-1733809270';
        $persistenceIamIdentity = 'persistenceIamIdentity1061944584';
        $authEnabled = true;
        $replicaCount = 564075208;
        $readEndpoint = 'readEndpoint-2081202658';
        $readEndpointPort = 1676143102;
        $customerManagedKey = 'customerManagedKey-1392642338';
        $maintenanceVersion = 'maintenanceVersion-588975188';
        $expectedResponse = new Instance();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setLocationId($locationId);
        $expectedResponse->setAlternativeLocationId($alternativeLocationId);
        $expectedResponse->setRedisVersion($redisVersion);
        $expectedResponse->setReservedIpRange($reservedIpRange);
        $expectedResponse->setSecondaryIpRange($secondaryIpRange);
        $expectedResponse->setHost($host);
        $expectedResponse->setPort($port);
        $expectedResponse->setCurrentLocationId($currentLocationId);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setMemorySizeGb($memorySizeGb);
        $expectedResponse->setAuthorizedNetwork($authorizedNetwork);
        $expectedResponse->setPersistenceIamIdentity($persistenceIamIdentity);
        $expectedResponse->setAuthEnabled($authEnabled);
        $expectedResponse->setReplicaCount($replicaCount);
        $expectedResponse->setReadEndpoint($readEndpoint);
        $expectedResponse->setReadEndpointPort($readEndpointPort);
        $expectedResponse->setCustomerManagedKey($customerManagedKey);
        $expectedResponse->setMaintenanceVersion($maintenanceVersion);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/exportInstanceTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $name = 'name3373707';
        $outputConfig = new OutputConfig();
        $request = (new ExportInstanceRequest())
            ->setName($name)
            ->setOutputConfig($outputConfig);
        $response = $gapicClient->exportInstance($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.redis.v1.CloudRedis/ExportInstance', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($name, $actualValue);
        $actualValue = $actualApiRequestObject->getOutputConfig();
        $this->assertProtobufEquals($outputConfig, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/exportInstanceTest');
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
    public function exportInstanceExceptionTest()
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
        $incompleteOperation->setName('operations/exportInstanceTest');
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
        $name = 'name3373707';
        $outputConfig = new OutputConfig();
        $request = (new ExportInstanceRequest())
            ->setName($name)
            ->setOutputConfig($outputConfig);
        $response = $gapicClient->exportInstance($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/exportInstanceTest');
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
    public function failoverInstanceTest()
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
        $incompleteOperation->setName('operations/failoverInstanceTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $locationId = 'locationId552319461';
        $alternativeLocationId = 'alternativeLocationId-718920621';
        $redisVersion = 'redisVersion-685310444';
        $reservedIpRange = 'reservedIpRange-1082940580';
        $secondaryIpRange = 'secondaryIpRange-1484975472';
        $host = 'host3208616';
        $port = 3446913;
        $currentLocationId = 'currentLocationId1312712735';
        $statusMessage = 'statusMessage-239442758';
        $memorySizeGb = 34199707;
        $authorizedNetwork = 'authorizedNetwork-1733809270';
        $persistenceIamIdentity = 'persistenceIamIdentity1061944584';
        $authEnabled = true;
        $replicaCount = 564075208;
        $readEndpoint = 'readEndpoint-2081202658';
        $readEndpointPort = 1676143102;
        $customerManagedKey = 'customerManagedKey-1392642338';
        $maintenanceVersion = 'maintenanceVersion-588975188';
        $expectedResponse = new Instance();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setLocationId($locationId);
        $expectedResponse->setAlternativeLocationId($alternativeLocationId);
        $expectedResponse->setRedisVersion($redisVersion);
        $expectedResponse->setReservedIpRange($reservedIpRange);
        $expectedResponse->setSecondaryIpRange($secondaryIpRange);
        $expectedResponse->setHost($host);
        $expectedResponse->setPort($port);
        $expectedResponse->setCurrentLocationId($currentLocationId);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setMemorySizeGb($memorySizeGb);
        $expectedResponse->setAuthorizedNetwork($authorizedNetwork);
        $expectedResponse->setPersistenceIamIdentity($persistenceIamIdentity);
        $expectedResponse->setAuthEnabled($authEnabled);
        $expectedResponse->setReplicaCount($replicaCount);
        $expectedResponse->setReadEndpoint($readEndpoint);
        $expectedResponse->setReadEndpointPort($readEndpointPort);
        $expectedResponse->setCustomerManagedKey($customerManagedKey);
        $expectedResponse->setMaintenanceVersion($maintenanceVersion);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/failoverInstanceTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $request = (new FailoverInstanceRequest())
            ->setName($formattedName);
        $response = $gapicClient->failoverInstance($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.redis.v1.CloudRedis/FailoverInstance', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/failoverInstanceTest');
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
    public function failoverInstanceExceptionTest()
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
        $incompleteOperation->setName('operations/failoverInstanceTest');
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
        $formattedName = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $request = (new FailoverInstanceRequest())
            ->setName($formattedName);
        $response = $gapicClient->failoverInstance($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/failoverInstanceTest');
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
    public function getInstanceTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $locationId = 'locationId552319461';
        $alternativeLocationId = 'alternativeLocationId-718920621';
        $redisVersion = 'redisVersion-685310444';
        $reservedIpRange = 'reservedIpRange-1082940580';
        $secondaryIpRange = 'secondaryIpRange-1484975472';
        $host = 'host3208616';
        $port = 3446913;
        $currentLocationId = 'currentLocationId1312712735';
        $statusMessage = 'statusMessage-239442758';
        $memorySizeGb = 34199707;
        $authorizedNetwork = 'authorizedNetwork-1733809270';
        $persistenceIamIdentity = 'persistenceIamIdentity1061944584';
        $authEnabled = true;
        $replicaCount = 564075208;
        $readEndpoint = 'readEndpoint-2081202658';
        $readEndpointPort = 1676143102;
        $customerManagedKey = 'customerManagedKey-1392642338';
        $maintenanceVersion = 'maintenanceVersion-588975188';
        $expectedResponse = new Instance();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setLocationId($locationId);
        $expectedResponse->setAlternativeLocationId($alternativeLocationId);
        $expectedResponse->setRedisVersion($redisVersion);
        $expectedResponse->setReservedIpRange($reservedIpRange);
        $expectedResponse->setSecondaryIpRange($secondaryIpRange);
        $expectedResponse->setHost($host);
        $expectedResponse->setPort($port);
        $expectedResponse->setCurrentLocationId($currentLocationId);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setMemorySizeGb($memorySizeGb);
        $expectedResponse->setAuthorizedNetwork($authorizedNetwork);
        $expectedResponse->setPersistenceIamIdentity($persistenceIamIdentity);
        $expectedResponse->setAuthEnabled($authEnabled);
        $expectedResponse->setReplicaCount($replicaCount);
        $expectedResponse->setReadEndpoint($readEndpoint);
        $expectedResponse->setReadEndpointPort($readEndpointPort);
        $expectedResponse->setCustomerManagedKey($customerManagedKey);
        $expectedResponse->setMaintenanceVersion($maintenanceVersion);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $request = (new GetInstanceRequest())
            ->setName($formattedName);
        $response = $gapicClient->getInstance($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.redis.v1.CloudRedis/GetInstance', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getInstanceExceptionTest()
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
        $formattedName = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $request = (new GetInstanceRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getInstance($request);
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
    public function getInstanceAuthStringTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $authString = 'authString-554020216';
        $expectedResponse = new InstanceAuthString();
        $expectedResponse->setAuthString($authString);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $request = (new GetInstanceAuthStringRequest())
            ->setName($formattedName);
        $response = $gapicClient->getInstanceAuthString($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.redis.v1.CloudRedis/GetInstanceAuthString', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getInstanceAuthStringExceptionTest()
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
        $formattedName = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $request = (new GetInstanceAuthStringRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getInstanceAuthString($request);
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
    public function importInstanceTest()
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
        $incompleteOperation->setName('operations/importInstanceTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $locationId = 'locationId552319461';
        $alternativeLocationId = 'alternativeLocationId-718920621';
        $redisVersion = 'redisVersion-685310444';
        $reservedIpRange = 'reservedIpRange-1082940580';
        $secondaryIpRange = 'secondaryIpRange-1484975472';
        $host = 'host3208616';
        $port = 3446913;
        $currentLocationId = 'currentLocationId1312712735';
        $statusMessage = 'statusMessage-239442758';
        $memorySizeGb = 34199707;
        $authorizedNetwork = 'authorizedNetwork-1733809270';
        $persistenceIamIdentity = 'persistenceIamIdentity1061944584';
        $authEnabled = true;
        $replicaCount = 564075208;
        $readEndpoint = 'readEndpoint-2081202658';
        $readEndpointPort = 1676143102;
        $customerManagedKey = 'customerManagedKey-1392642338';
        $maintenanceVersion = 'maintenanceVersion-588975188';
        $expectedResponse = new Instance();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setLocationId($locationId);
        $expectedResponse->setAlternativeLocationId($alternativeLocationId);
        $expectedResponse->setRedisVersion($redisVersion);
        $expectedResponse->setReservedIpRange($reservedIpRange);
        $expectedResponse->setSecondaryIpRange($secondaryIpRange);
        $expectedResponse->setHost($host);
        $expectedResponse->setPort($port);
        $expectedResponse->setCurrentLocationId($currentLocationId);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setMemorySizeGb($memorySizeGb);
        $expectedResponse->setAuthorizedNetwork($authorizedNetwork);
        $expectedResponse->setPersistenceIamIdentity($persistenceIamIdentity);
        $expectedResponse->setAuthEnabled($authEnabled);
        $expectedResponse->setReplicaCount($replicaCount);
        $expectedResponse->setReadEndpoint($readEndpoint);
        $expectedResponse->setReadEndpointPort($readEndpointPort);
        $expectedResponse->setCustomerManagedKey($customerManagedKey);
        $expectedResponse->setMaintenanceVersion($maintenanceVersion);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/importInstanceTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $name = 'name3373707';
        $inputConfig = new InputConfig();
        $request = (new ImportInstanceRequest())
            ->setName($name)
            ->setInputConfig($inputConfig);
        $response = $gapicClient->importInstance($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.redis.v1.CloudRedis/ImportInstance', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($name, $actualValue);
        $actualValue = $actualApiRequestObject->getInputConfig();
        $this->assertProtobufEquals($inputConfig, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/importInstanceTest');
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
    public function importInstanceExceptionTest()
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
        $incompleteOperation->setName('operations/importInstanceTest');
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
        $name = 'name3373707';
        $inputConfig = new InputConfig();
        $request = (new ImportInstanceRequest())
            ->setName($name)
            ->setInputConfig($inputConfig);
        $response = $gapicClient->importInstance($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/importInstanceTest');
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
    public function listInstancesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $instancesElement = new Instance();
        $instances = [
            $instancesElement,
        ];
        $expectedResponse = new ListInstancesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setInstances($instances);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListInstancesRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listInstances($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getInstances()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.redis.v1.CloudRedis/ListInstances', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listInstancesExceptionTest()
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
        $request = (new ListInstancesRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listInstances($request);
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
        $incompleteOperation->setName('operations/rescheduleMaintenanceTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $locationId = 'locationId552319461';
        $alternativeLocationId = 'alternativeLocationId-718920621';
        $redisVersion = 'redisVersion-685310444';
        $reservedIpRange = 'reservedIpRange-1082940580';
        $secondaryIpRange = 'secondaryIpRange-1484975472';
        $host = 'host3208616';
        $port = 3446913;
        $currentLocationId = 'currentLocationId1312712735';
        $statusMessage = 'statusMessage-239442758';
        $memorySizeGb = 34199707;
        $authorizedNetwork = 'authorizedNetwork-1733809270';
        $persistenceIamIdentity = 'persistenceIamIdentity1061944584';
        $authEnabled = true;
        $replicaCount = 564075208;
        $readEndpoint = 'readEndpoint-2081202658';
        $readEndpointPort = 1676143102;
        $customerManagedKey = 'customerManagedKey-1392642338';
        $maintenanceVersion = 'maintenanceVersion-588975188';
        $expectedResponse = new Instance();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setLocationId($locationId);
        $expectedResponse->setAlternativeLocationId($alternativeLocationId);
        $expectedResponse->setRedisVersion($redisVersion);
        $expectedResponse->setReservedIpRange($reservedIpRange);
        $expectedResponse->setSecondaryIpRange($secondaryIpRange);
        $expectedResponse->setHost($host);
        $expectedResponse->setPort($port);
        $expectedResponse->setCurrentLocationId($currentLocationId);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setMemorySizeGb($memorySizeGb);
        $expectedResponse->setAuthorizedNetwork($authorizedNetwork);
        $expectedResponse->setPersistenceIamIdentity($persistenceIamIdentity);
        $expectedResponse->setAuthEnabled($authEnabled);
        $expectedResponse->setReplicaCount($replicaCount);
        $expectedResponse->setReadEndpoint($readEndpoint);
        $expectedResponse->setReadEndpointPort($readEndpointPort);
        $expectedResponse->setCustomerManagedKey($customerManagedKey);
        $expectedResponse->setMaintenanceVersion($maintenanceVersion);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/rescheduleMaintenanceTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $rescheduleType = RescheduleType::RESCHEDULE_TYPE_UNSPECIFIED;
        $request = (new RescheduleMaintenanceRequest())
            ->setName($formattedName)
            ->setRescheduleType($rescheduleType);
        $response = $gapicClient->rescheduleMaintenance($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.redis.v1.CloudRedis/RescheduleMaintenance', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualApiRequestObject->getRescheduleType();
        $this->assertProtobufEquals($rescheduleType, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/rescheduleMaintenanceTest');
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
    public function rescheduleMaintenanceExceptionTest()
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
        $incompleteOperation->setName('operations/rescheduleMaintenanceTest');
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
        $formattedName = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $rescheduleType = RescheduleType::RESCHEDULE_TYPE_UNSPECIFIED;
        $request = (new RescheduleMaintenanceRequest())
            ->setName($formattedName)
            ->setRescheduleType($rescheduleType);
        $response = $gapicClient->rescheduleMaintenance($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/rescheduleMaintenanceTest');
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
    public function updateInstanceTest()
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
        $incompleteOperation->setName('operations/updateInstanceTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $locationId = 'locationId552319461';
        $alternativeLocationId = 'alternativeLocationId-718920621';
        $redisVersion = 'redisVersion-685310444';
        $reservedIpRange = 'reservedIpRange-1082940580';
        $secondaryIpRange = 'secondaryIpRange-1484975472';
        $host = 'host3208616';
        $port = 3446913;
        $currentLocationId = 'currentLocationId1312712735';
        $statusMessage = 'statusMessage-239442758';
        $memorySizeGb = 34199707;
        $authorizedNetwork = 'authorizedNetwork-1733809270';
        $persistenceIamIdentity = 'persistenceIamIdentity1061944584';
        $authEnabled = true;
        $replicaCount = 564075208;
        $readEndpoint = 'readEndpoint-2081202658';
        $readEndpointPort = 1676143102;
        $customerManagedKey = 'customerManagedKey-1392642338';
        $maintenanceVersion = 'maintenanceVersion-588975188';
        $expectedResponse = new Instance();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setLocationId($locationId);
        $expectedResponse->setAlternativeLocationId($alternativeLocationId);
        $expectedResponse->setRedisVersion($redisVersion);
        $expectedResponse->setReservedIpRange($reservedIpRange);
        $expectedResponse->setSecondaryIpRange($secondaryIpRange);
        $expectedResponse->setHost($host);
        $expectedResponse->setPort($port);
        $expectedResponse->setCurrentLocationId($currentLocationId);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setMemorySizeGb($memorySizeGb);
        $expectedResponse->setAuthorizedNetwork($authorizedNetwork);
        $expectedResponse->setPersistenceIamIdentity($persistenceIamIdentity);
        $expectedResponse->setAuthEnabled($authEnabled);
        $expectedResponse->setReplicaCount($replicaCount);
        $expectedResponse->setReadEndpoint($readEndpoint);
        $expectedResponse->setReadEndpointPort($readEndpointPort);
        $expectedResponse->setCustomerManagedKey($customerManagedKey);
        $expectedResponse->setMaintenanceVersion($maintenanceVersion);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/updateInstanceTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $updateMask = new FieldMask();
        $instance = new Instance();
        $instanceName = 'instanceName-737857344';
        $instance->setName($instanceName);
        $instanceTier = Tier::TIER_UNSPECIFIED;
        $instance->setTier($instanceTier);
        $instanceMemorySizeGb = 193936814;
        $instance->setMemorySizeGb($instanceMemorySizeGb);
        $request = (new UpdateInstanceRequest())
            ->setUpdateMask($updateMask)
            ->setInstance($instance);
        $response = $gapicClient->updateInstance($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.redis.v1.CloudRedis/UpdateInstance', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/updateInstanceTest');
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
    public function updateInstanceExceptionTest()
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
        $incompleteOperation->setName('operations/updateInstanceTest');
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
        $updateMask = new FieldMask();
        $instance = new Instance();
        $instanceName = 'instanceName-737857344';
        $instance->setName($instanceName);
        $instanceTier = Tier::TIER_UNSPECIFIED;
        $instance->setTier($instanceTier);
        $instanceMemorySizeGb = 193936814;
        $instance->setMemorySizeGb($instanceMemorySizeGb);
        $request = (new UpdateInstanceRequest())
            ->setUpdateMask($updateMask)
            ->setInstance($instance);
        $response = $gapicClient->updateInstance($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/updateInstanceTest');
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
    public function upgradeInstanceTest()
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
        $incompleteOperation->setName('operations/upgradeInstanceTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $locationId = 'locationId552319461';
        $alternativeLocationId = 'alternativeLocationId-718920621';
        $redisVersion2 = 'redisVersion2-1453337401';
        $reservedIpRange = 'reservedIpRange-1082940580';
        $secondaryIpRange = 'secondaryIpRange-1484975472';
        $host = 'host3208616';
        $port = 3446913;
        $currentLocationId = 'currentLocationId1312712735';
        $statusMessage = 'statusMessage-239442758';
        $memorySizeGb = 34199707;
        $authorizedNetwork = 'authorizedNetwork-1733809270';
        $persistenceIamIdentity = 'persistenceIamIdentity1061944584';
        $authEnabled = true;
        $replicaCount = 564075208;
        $readEndpoint = 'readEndpoint-2081202658';
        $readEndpointPort = 1676143102;
        $customerManagedKey = 'customerManagedKey-1392642338';
        $maintenanceVersion = 'maintenanceVersion-588975188';
        $expectedResponse = new Instance();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setLocationId($locationId);
        $expectedResponse->setAlternativeLocationId($alternativeLocationId);
        $expectedResponse->setRedisVersion($redisVersion2);
        $expectedResponse->setReservedIpRange($reservedIpRange);
        $expectedResponse->setSecondaryIpRange($secondaryIpRange);
        $expectedResponse->setHost($host);
        $expectedResponse->setPort($port);
        $expectedResponse->setCurrentLocationId($currentLocationId);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setMemorySizeGb($memorySizeGb);
        $expectedResponse->setAuthorizedNetwork($authorizedNetwork);
        $expectedResponse->setPersistenceIamIdentity($persistenceIamIdentity);
        $expectedResponse->setAuthEnabled($authEnabled);
        $expectedResponse->setReplicaCount($replicaCount);
        $expectedResponse->setReadEndpoint($readEndpoint);
        $expectedResponse->setReadEndpointPort($readEndpointPort);
        $expectedResponse->setCustomerManagedKey($customerManagedKey);
        $expectedResponse->setMaintenanceVersion($maintenanceVersion);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/upgradeInstanceTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedName = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $redisVersion = 'redisVersion-685310444';
        $request = (new UpgradeInstanceRequest())
            ->setName($formattedName)
            ->setRedisVersion($redisVersion);
        $response = $gapicClient->upgradeInstance($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.redis.v1.CloudRedis/UpgradeInstance', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualApiRequestObject->getRedisVersion();
        $this->assertProtobufEquals($redisVersion, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/upgradeInstanceTest');
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
    public function upgradeInstanceExceptionTest()
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
        $incompleteOperation->setName('operations/upgradeInstanceTest');
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
        $formattedName = $gapicClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
        $redisVersion = 'redisVersion-685310444';
        $request = (new UpgradeInstanceRequest())
            ->setName($formattedName)
            ->setRedisVersion($redisVersion);
        $response = $gapicClient->upgradeInstance($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/upgradeInstanceTest');
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
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
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
        $locations = [
            $locationsElement,
        ];
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
        $expectedExceptionMessage  = json_encode([
            'message' => 'internal error',
            'code' => Code::DATA_LOSS,
            'status' => 'DATA_LOSS',
            'details' => [],
        ], JSON_PRETTY_PRINT);
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
    public function createInstanceAsyncTest()
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
        $incompleteOperation->setName('operations/createInstanceTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $locationId = 'locationId552319461';
        $alternativeLocationId = 'alternativeLocationId-718920621';
        $redisVersion = 'redisVersion-685310444';
        $reservedIpRange = 'reservedIpRange-1082940580';
        $secondaryIpRange = 'secondaryIpRange-1484975472';
        $host = 'host3208616';
        $port = 3446913;
        $currentLocationId = 'currentLocationId1312712735';
        $statusMessage = 'statusMessage-239442758';
        $memorySizeGb = 34199707;
        $authorizedNetwork = 'authorizedNetwork-1733809270';
        $persistenceIamIdentity = 'persistenceIamIdentity1061944584';
        $authEnabled = true;
        $replicaCount = 564075208;
        $readEndpoint = 'readEndpoint-2081202658';
        $readEndpointPort = 1676143102;
        $customerManagedKey = 'customerManagedKey-1392642338';
        $maintenanceVersion = 'maintenanceVersion-588975188';
        $expectedResponse = new Instance();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setLocationId($locationId);
        $expectedResponse->setAlternativeLocationId($alternativeLocationId);
        $expectedResponse->setRedisVersion($redisVersion);
        $expectedResponse->setReservedIpRange($reservedIpRange);
        $expectedResponse->setSecondaryIpRange($secondaryIpRange);
        $expectedResponse->setHost($host);
        $expectedResponse->setPort($port);
        $expectedResponse->setCurrentLocationId($currentLocationId);
        $expectedResponse->setStatusMessage($statusMessage);
        $expectedResponse->setMemorySizeGb($memorySizeGb);
        $expectedResponse->setAuthorizedNetwork($authorizedNetwork);
        $expectedResponse->setPersistenceIamIdentity($persistenceIamIdentity);
        $expectedResponse->setAuthEnabled($authEnabled);
        $expectedResponse->setReplicaCount($replicaCount);
        $expectedResponse->setReadEndpoint($readEndpoint);
        $expectedResponse->setReadEndpointPort($readEndpointPort);
        $expectedResponse->setCustomerManagedKey($customerManagedKey);
        $expectedResponse->setMaintenanceVersion($maintenanceVersion);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/createInstanceTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $instanceId = 'instanceId-2101995259';
        $instance = new Instance();
        $instanceName = 'instanceName-737857344';
        $instance->setName($instanceName);
        $instanceTier = Tier::TIER_UNSPECIFIED;
        $instance->setTier($instanceTier);
        $instanceMemorySizeGb = 193936814;
        $instance->setMemorySizeGb($instanceMemorySizeGb);
        $request = (new CreateInstanceRequest())
            ->setParent($formattedParent)
            ->setInstanceId($instanceId)
            ->setInstance($instance);
        $response = $gapicClient->createInstanceAsync($request)->wait();
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.redis.v1.CloudRedis/CreateInstance', $actualApiFuncCall);
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getInstanceId();
        $this->assertProtobufEquals($instanceId, $actualValue);
        $actualValue = $actualApiRequestObject->getInstance();
        $this->assertProtobufEquals($instance, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/createInstanceTest');
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
