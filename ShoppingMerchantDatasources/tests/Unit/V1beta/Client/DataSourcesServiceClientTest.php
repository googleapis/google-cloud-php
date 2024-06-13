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

namespace Google\Shopping\Merchant\Datasources\Tests\Unit\V1beta\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use Google\Shopping\Merchant\Datasources\V1beta\Client\DataSourcesServiceClient;
use Google\Shopping\Merchant\Datasources\V1beta\CreateDataSourceRequest;
use Google\Shopping\Merchant\Datasources\V1beta\DataSource;
use Google\Shopping\Merchant\Datasources\V1beta\DeleteDataSourceRequest;
use Google\Shopping\Merchant\Datasources\V1beta\FetchDataSourceRequest;
use Google\Shopping\Merchant\Datasources\V1beta\GetDataSourceRequest;
use Google\Shopping\Merchant\Datasources\V1beta\ListDataSourcesRequest;
use Google\Shopping\Merchant\Datasources\V1beta\ListDataSourcesResponse;
use Google\Shopping\Merchant\Datasources\V1beta\PrimaryProductDataSource;
use Google\Shopping\Merchant\Datasources\V1beta\PrimaryProductDataSource\Channel;
use Google\Shopping\Merchant\Datasources\V1beta\UpdateDataSourceRequest;
use stdClass;

/**
 * @group datasources
 *
 * @group gapic
 */
class DataSourcesServiceClientTest extends GeneratedTest
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

    /** @return DataSourcesServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new DataSourcesServiceClient($options);
    }

    /** @test */
    public function createDataSourceTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $dataSourceId = 1015796374;
        $displayName = 'displayName1615086568';
        $expectedResponse = new DataSource();
        $expectedResponse->setName($name);
        $expectedResponse->setDataSourceId($dataSourceId);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $dataSource = new DataSource();
        $dataSourceDisplayName = 'dataSourceDisplayName121757896';
        $dataSource->setDisplayName($dataSourceDisplayName);
        $dataSourcePrimaryProductDataSource = new PrimaryProductDataSource();
        $primaryProductDataSourceChannel = Channel::CHANNEL_UNSPECIFIED;
        $dataSourcePrimaryProductDataSource->setChannel($primaryProductDataSourceChannel);
        $dataSource->setPrimaryProductDataSource($dataSourcePrimaryProductDataSource);
        $request = (new CreateDataSourceRequest())->setParent($formattedParent)->setDataSource($dataSource);
        $response = $gapicClient->createDataSource($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.datasources.v1beta.DataSourcesService/CreateDataSource',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getDataSource();
        $this->assertProtobufEquals($dataSource, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createDataSourceExceptionTest()
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
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $dataSource = new DataSource();
        $dataSourceDisplayName = 'dataSourceDisplayName121757896';
        $dataSource->setDisplayName($dataSourceDisplayName);
        $dataSourcePrimaryProductDataSource = new PrimaryProductDataSource();
        $primaryProductDataSourceChannel = Channel::CHANNEL_UNSPECIFIED;
        $dataSourcePrimaryProductDataSource->setChannel($primaryProductDataSourceChannel);
        $dataSource->setPrimaryProductDataSource($dataSourcePrimaryProductDataSource);
        $request = (new CreateDataSourceRequest())->setParent($formattedParent)->setDataSource($dataSource);
        try {
            $gapicClient->createDataSource($request);
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
    public function deleteDataSourceTest()
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
        $formattedName = $gapicClient->dataSourceName('[ACCOUNT]', '[DATASOURCE]');
        $request = (new DeleteDataSourceRequest())->setName($formattedName);
        $gapicClient->deleteDataSource($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.datasources.v1beta.DataSourcesService/DeleteDataSource',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteDataSourceExceptionTest()
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
        $formattedName = $gapicClient->dataSourceName('[ACCOUNT]', '[DATASOURCE]');
        $request = (new DeleteDataSourceRequest())->setName($formattedName);
        try {
            $gapicClient->deleteDataSource($request);
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
    public function fetchDataSourceTest()
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
        $formattedName = $gapicClient->dataSourceName('[ACCOUNT]', '[DATASOURCE]');
        $request = (new FetchDataSourceRequest())->setName($formattedName);
        $gapicClient->fetchDataSource($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.datasources.v1beta.DataSourcesService/FetchDataSource',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function fetchDataSourceExceptionTest()
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
        $formattedName = $gapicClient->dataSourceName('[ACCOUNT]', '[DATASOURCE]');
        $request = (new FetchDataSourceRequest())->setName($formattedName);
        try {
            $gapicClient->fetchDataSource($request);
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
    public function getDataSourceTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $dataSourceId = 1015796374;
        $displayName = 'displayName1615086568';
        $expectedResponse = new DataSource();
        $expectedResponse->setName($name2);
        $expectedResponse->setDataSourceId($dataSourceId);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->dataSourceName('[ACCOUNT]', '[DATASOURCE]');
        $request = (new GetDataSourceRequest())->setName($formattedName);
        $response = $gapicClient->getDataSource($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.datasources.v1beta.DataSourcesService/GetDataSource',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getDataSourceExceptionTest()
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
        $formattedName = $gapicClient->dataSourceName('[ACCOUNT]', '[DATASOURCE]');
        $request = (new GetDataSourceRequest())->setName($formattedName);
        try {
            $gapicClient->getDataSource($request);
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
    public function listDataSourcesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $dataSourcesElement = new DataSource();
        $dataSources = [$dataSourcesElement];
        $expectedResponse = new ListDataSourcesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setDataSources($dataSources);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $request = (new ListDataSourcesRequest())->setParent($formattedParent);
        $response = $gapicClient->listDataSources($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getDataSources()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.datasources.v1beta.DataSourcesService/ListDataSources',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listDataSourcesExceptionTest()
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
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $request = (new ListDataSourcesRequest())->setParent($formattedParent);
        try {
            $gapicClient->listDataSources($request);
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
    public function updateDataSourceTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $dataSourceId = 1015796374;
        $displayName = 'displayName1615086568';
        $expectedResponse = new DataSource();
        $expectedResponse->setName($name);
        $expectedResponse->setDataSourceId($dataSourceId);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $dataSource = new DataSource();
        $dataSourceDisplayName = 'dataSourceDisplayName121757896';
        $dataSource->setDisplayName($dataSourceDisplayName);
        $dataSourcePrimaryProductDataSource = new PrimaryProductDataSource();
        $primaryProductDataSourceChannel = Channel::CHANNEL_UNSPECIFIED;
        $dataSourcePrimaryProductDataSource->setChannel($primaryProductDataSourceChannel);
        $dataSource->setPrimaryProductDataSource($dataSourcePrimaryProductDataSource);
        $updateMask = new FieldMask();
        $request = (new UpdateDataSourceRequest())->setDataSource($dataSource)->setUpdateMask($updateMask);
        $response = $gapicClient->updateDataSource($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.datasources.v1beta.DataSourcesService/UpdateDataSource',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getDataSource();
        $this->assertProtobufEquals($dataSource, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateDataSourceExceptionTest()
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
        $dataSource = new DataSource();
        $dataSourceDisplayName = 'dataSourceDisplayName121757896';
        $dataSource->setDisplayName($dataSourceDisplayName);
        $dataSourcePrimaryProductDataSource = new PrimaryProductDataSource();
        $primaryProductDataSourceChannel = Channel::CHANNEL_UNSPECIFIED;
        $dataSourcePrimaryProductDataSource->setChannel($primaryProductDataSourceChannel);
        $dataSource->setPrimaryProductDataSource($dataSourcePrimaryProductDataSource);
        $updateMask = new FieldMask();
        $request = (new UpdateDataSourceRequest())->setDataSource($dataSource)->setUpdateMask($updateMask);
        try {
            $gapicClient->updateDataSource($request);
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
    public function createDataSourceAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $dataSourceId = 1015796374;
        $displayName = 'displayName1615086568';
        $expectedResponse = new DataSource();
        $expectedResponse->setName($name);
        $expectedResponse->setDataSourceId($dataSourceId);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->accountName('[ACCOUNT]');
        $dataSource = new DataSource();
        $dataSourceDisplayName = 'dataSourceDisplayName121757896';
        $dataSource->setDisplayName($dataSourceDisplayName);
        $dataSourcePrimaryProductDataSource = new PrimaryProductDataSource();
        $primaryProductDataSourceChannel = Channel::CHANNEL_UNSPECIFIED;
        $dataSourcePrimaryProductDataSource->setChannel($primaryProductDataSourceChannel);
        $dataSource->setPrimaryProductDataSource($dataSourcePrimaryProductDataSource);
        $request = (new CreateDataSourceRequest())->setParent($formattedParent)->setDataSource($dataSource);
        $response = $gapicClient->createDataSourceAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.shopping.merchant.datasources.v1beta.DataSourcesService/CreateDataSource',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getDataSource();
        $this->assertProtobufEquals($dataSource, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
