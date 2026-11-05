<?php
/*
 * Copyright 2026 Google LLC
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

namespace Google\Cloud\DiscoveryEngine\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\DiscoveryEngine\V1\Client\DataConnectorServiceClient;
use Google\Cloud\DiscoveryEngine\V1\DataConnector;
use Google\Cloud\DiscoveryEngine\V1\GetDataConnectorRequest;
use Google\Cloud\DiscoveryEngine\V1\SetUpDataConnectorRequest;
use Google\Cloud\DiscoveryEngine\V1\UpdateDataConnectorRequest;
use Google\LongRunning\Client\OperationsClient;
use Google\LongRunning\GetOperationRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\Any;
use Google\Protobuf\Duration;
use Google\Rpc\Code;
use stdClass;

/**
 * @group discoveryengine
 *
 * @group gapic
 */
class DataConnectorServiceClientTest extends GeneratedTest
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

    /** @return DataConnectorServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new DataConnectorServiceClient($options);
    }

    /** @test */
    public function getDataConnectorTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $jsonParams = 'jsonParams-1237830467';
        $name2 = 'name2-1052831874';
        $dataSource = 'dataSource-1333894576';
        $kmsKeyName = 'kmsKeyName2094986649';
        $staticIpEnabled = true;
        $privateConnectivityProjectId = 'privateConnectivityProjectId1617869005';
        $aclEnabled = true;
        $createEuaSaas = false;
        $autoRunDisabled = true;
        $incrementalSyncDisabled = false;
        $hybridIngestionDisabled = true;
        $vpcscEnabled = false;
        $connectorSourceId = 'connectorSourceId526910029';
        $tag = 'tag114586';
        $expectedResponse = new DataConnector();
        $expectedResponse->setJsonParams($jsonParams);
        $expectedResponse->setName($name2);
        $expectedResponse->setDataSource($dataSource);
        $expectedResponse->setKmsKeyName($kmsKeyName);
        $expectedResponse->setStaticIpEnabled($staticIpEnabled);
        $expectedResponse->setPrivateConnectivityProjectId($privateConnectivityProjectId);
        $expectedResponse->setAclEnabled($aclEnabled);
        $expectedResponse->setCreateEuaSaas($createEuaSaas);
        $expectedResponse->setAutoRunDisabled($autoRunDisabled);
        $expectedResponse->setIncrementalSyncDisabled($incrementalSyncDisabled);
        $expectedResponse->setHybridIngestionDisabled($hybridIngestionDisabled);
        $expectedResponse->setVpcscEnabled($vpcscEnabled);
        $expectedResponse->setConnectorSourceId($connectorSourceId);
        $expectedResponse->setTag($tag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->dataConnectorName('[PROJECT]', '[LOCATION]', '[COLLECTION]');
        $request = (new GetDataConnectorRequest())->setName($formattedName);
        $response = $gapicClient->getDataConnector($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.discoveryengine.v1.DataConnectorService/GetDataConnector', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getDataConnectorExceptionTest()
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
        $formattedName = $gapicClient->dataConnectorName('[PROJECT]', '[LOCATION]', '[COLLECTION]');
        $request = (new GetDataConnectorRequest())->setName($formattedName);
        try {
            $gapicClient->getDataConnector($request);
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
    public function setUpDataConnectorTest()
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
        $incompleteOperation->setName('operations/setUpDataConnectorTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $jsonParams = 'jsonParams-1237830467';
        $name = 'name3373707';
        $dataSource = 'dataSource-1333894576';
        $kmsKeyName = 'kmsKeyName2094986649';
        $staticIpEnabled = true;
        $privateConnectivityProjectId = 'privateConnectivityProjectId1617869005';
        $aclEnabled = true;
        $createEuaSaas = false;
        $autoRunDisabled = true;
        $incrementalSyncDisabled = false;
        $hybridIngestionDisabled = true;
        $vpcscEnabled = false;
        $connectorSourceId = 'connectorSourceId526910029';
        $tag = 'tag114586';
        $expectedResponse = new DataConnector();
        $expectedResponse->setJsonParams($jsonParams);
        $expectedResponse->setName($name);
        $expectedResponse->setDataSource($dataSource);
        $expectedResponse->setKmsKeyName($kmsKeyName);
        $expectedResponse->setStaticIpEnabled($staticIpEnabled);
        $expectedResponse->setPrivateConnectivityProjectId($privateConnectivityProjectId);
        $expectedResponse->setAclEnabled($aclEnabled);
        $expectedResponse->setCreateEuaSaas($createEuaSaas);
        $expectedResponse->setAutoRunDisabled($autoRunDisabled);
        $expectedResponse->setIncrementalSyncDisabled($incrementalSyncDisabled);
        $expectedResponse->setHybridIngestionDisabled($hybridIngestionDisabled);
        $expectedResponse->setVpcscEnabled($vpcscEnabled);
        $expectedResponse->setConnectorSourceId($connectorSourceId);
        $expectedResponse->setTag($tag);
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/setUpDataConnectorTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $collectionId = 'collectionId-821242276';
        $collectionDisplayName = 'collectionDisplayName784019433';
        $dataConnector = new DataConnector();
        $dataConnectorDataSource = 'dataConnectorDataSource1483588744';
        $dataConnector->setDataSource($dataConnectorDataSource);
        $dataConnectorRefreshInterval = new Duration();
        $dataConnector->setRefreshInterval($dataConnectorRefreshInterval);
        $request = (new SetUpDataConnectorRequest())
            ->setParent($formattedParent)
            ->setCollectionId($collectionId)
            ->setCollectionDisplayName($collectionDisplayName)
            ->setDataConnector($dataConnector);
        $response = $gapicClient->setUpDataConnector($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.discoveryengine.v1.DataConnectorService/SetUpDataConnector',
            $actualApiFuncCall
        );
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getCollectionId();
        $this->assertProtobufEquals($collectionId, $actualValue);
        $actualValue = $actualApiRequestObject->getCollectionDisplayName();
        $this->assertProtobufEquals($collectionDisplayName, $actualValue);
        $actualValue = $actualApiRequestObject->getDataConnector();
        $this->assertProtobufEquals($dataConnector, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/setUpDataConnectorTest');
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
    public function setUpDataConnectorExceptionTest()
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
        $incompleteOperation->setName('operations/setUpDataConnectorTest');
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
        $collectionId = 'collectionId-821242276';
        $collectionDisplayName = 'collectionDisplayName784019433';
        $dataConnector = new DataConnector();
        $dataConnectorDataSource = 'dataConnectorDataSource1483588744';
        $dataConnector->setDataSource($dataConnectorDataSource);
        $dataConnectorRefreshInterval = new Duration();
        $dataConnector->setRefreshInterval($dataConnectorRefreshInterval);
        $request = (new SetUpDataConnectorRequest())
            ->setParent($formattedParent)
            ->setCollectionId($collectionId)
            ->setCollectionDisplayName($collectionDisplayName)
            ->setDataConnector($dataConnector);
        $response = $gapicClient->setUpDataConnector($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/setUpDataConnectorTest');
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
    public function updateDataConnectorTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $jsonParams = 'jsonParams-1237830467';
        $name = 'name3373707';
        $dataSource = 'dataSource-1333894576';
        $kmsKeyName = 'kmsKeyName2094986649';
        $staticIpEnabled = true;
        $privateConnectivityProjectId = 'privateConnectivityProjectId1617869005';
        $aclEnabled = true;
        $createEuaSaas = false;
        $autoRunDisabled = true;
        $incrementalSyncDisabled = false;
        $hybridIngestionDisabled = true;
        $vpcscEnabled = false;
        $connectorSourceId = 'connectorSourceId526910029';
        $tag = 'tag114586';
        $expectedResponse = new DataConnector();
        $expectedResponse->setJsonParams($jsonParams);
        $expectedResponse->setName($name);
        $expectedResponse->setDataSource($dataSource);
        $expectedResponse->setKmsKeyName($kmsKeyName);
        $expectedResponse->setStaticIpEnabled($staticIpEnabled);
        $expectedResponse->setPrivateConnectivityProjectId($privateConnectivityProjectId);
        $expectedResponse->setAclEnabled($aclEnabled);
        $expectedResponse->setCreateEuaSaas($createEuaSaas);
        $expectedResponse->setAutoRunDisabled($autoRunDisabled);
        $expectedResponse->setIncrementalSyncDisabled($incrementalSyncDisabled);
        $expectedResponse->setHybridIngestionDisabled($hybridIngestionDisabled);
        $expectedResponse->setVpcscEnabled($vpcscEnabled);
        $expectedResponse->setConnectorSourceId($connectorSourceId);
        $expectedResponse->setTag($tag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $dataConnector = new DataConnector();
        $dataConnectorDataSource = 'dataConnectorDataSource1483588744';
        $dataConnector->setDataSource($dataConnectorDataSource);
        $dataConnectorRefreshInterval = new Duration();
        $dataConnector->setRefreshInterval($dataConnectorRefreshInterval);
        $request = (new UpdateDataConnectorRequest())->setDataConnector($dataConnector);
        $response = $gapicClient->updateDataConnector($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.discoveryengine.v1.DataConnectorService/UpdateDataConnector', $actualFuncCall);
        $actualValue = $actualRequestObject->getDataConnector();
        $this->assertProtobufEquals($dataConnector, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateDataConnectorExceptionTest()
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
        $dataConnector = new DataConnector();
        $dataConnectorDataSource = 'dataConnectorDataSource1483588744';
        $dataConnector->setDataSource($dataConnectorDataSource);
        $dataConnectorRefreshInterval = new Duration();
        $dataConnector->setRefreshInterval($dataConnectorRefreshInterval);
        $request = (new UpdateDataConnectorRequest())->setDataConnector($dataConnector);
        try {
            $gapicClient->updateDataConnector($request);
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
    public function getDataConnectorAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $jsonParams = 'jsonParams-1237830467';
        $name2 = 'name2-1052831874';
        $dataSource = 'dataSource-1333894576';
        $kmsKeyName = 'kmsKeyName2094986649';
        $staticIpEnabled = true;
        $privateConnectivityProjectId = 'privateConnectivityProjectId1617869005';
        $aclEnabled = true;
        $createEuaSaas = false;
        $autoRunDisabled = true;
        $incrementalSyncDisabled = false;
        $hybridIngestionDisabled = true;
        $vpcscEnabled = false;
        $connectorSourceId = 'connectorSourceId526910029';
        $tag = 'tag114586';
        $expectedResponse = new DataConnector();
        $expectedResponse->setJsonParams($jsonParams);
        $expectedResponse->setName($name2);
        $expectedResponse->setDataSource($dataSource);
        $expectedResponse->setKmsKeyName($kmsKeyName);
        $expectedResponse->setStaticIpEnabled($staticIpEnabled);
        $expectedResponse->setPrivateConnectivityProjectId($privateConnectivityProjectId);
        $expectedResponse->setAclEnabled($aclEnabled);
        $expectedResponse->setCreateEuaSaas($createEuaSaas);
        $expectedResponse->setAutoRunDisabled($autoRunDisabled);
        $expectedResponse->setIncrementalSyncDisabled($incrementalSyncDisabled);
        $expectedResponse->setHybridIngestionDisabled($hybridIngestionDisabled);
        $expectedResponse->setVpcscEnabled($vpcscEnabled);
        $expectedResponse->setConnectorSourceId($connectorSourceId);
        $expectedResponse->setTag($tag);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->dataConnectorName('[PROJECT]', '[LOCATION]', '[COLLECTION]');
        $request = (new GetDataConnectorRequest())->setName($formattedName);
        $response = $gapicClient->getDataConnectorAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.discoveryengine.v1.DataConnectorService/GetDataConnector', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
