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

namespace Google\Cloud\RecommendationEngine\Tests\Unit\V1beta1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\RecommendationEngine\V1beta1\CatalogItem;
use Google\Cloud\RecommendationEngine\V1beta1\Client\CatalogServiceClient;
use Google\Cloud\RecommendationEngine\V1beta1\CreateCatalogItemRequest;
use Google\Cloud\RecommendationEngine\V1beta1\DeleteCatalogItemRequest;
use Google\Cloud\RecommendationEngine\V1beta1\GetCatalogItemRequest;
use Google\Cloud\RecommendationEngine\V1beta1\ImportCatalogItemsRequest;
use Google\Cloud\RecommendationEngine\V1beta1\ImportCatalogItemsResponse;
use Google\Cloud\RecommendationEngine\V1beta1\InputConfig;
use Google\Cloud\RecommendationEngine\V1beta1\ListCatalogItemsRequest;
use Google\Cloud\RecommendationEngine\V1beta1\ListCatalogItemsResponse;
use Google\Cloud\RecommendationEngine\V1beta1\UpdateCatalogItemRequest;
use Google\LongRunning\Client\OperationsClient;
use Google\LongRunning\GetOperationRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\Any;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group recommendationengine
 *
 * @group gapic
 */
class CatalogServiceClientTest extends GeneratedTest
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

    /** @return CatalogServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new CatalogServiceClient($options);
    }

    /** @test */
    public function createCatalogItemTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $id = 'id3355';
        $title = 'title110371416';
        $description = 'description-1724546052';
        $languageCode = 'languageCode-412800396';
        $itemGroupId = 'itemGroupId894431879';
        $expectedResponse = new CatalogItem();
        $expectedResponse->setId($id);
        $expectedResponse->setTitle($title);
        $expectedResponse->setDescription($description);
        $expectedResponse->setLanguageCode($languageCode);
        $expectedResponse->setItemGroupId($itemGroupId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->catalogName('[PROJECT]', '[LOCATION]', '[CATALOG]');
        $catalogItem = new CatalogItem();
        $catalogItemId = 'catalogItemId-1850269433';
        $catalogItem->setId($catalogItemId);
        $catalogItemCategoryHierarchies = [];
        $catalogItem->setCategoryHierarchies($catalogItemCategoryHierarchies);
        $catalogItemTitle = 'catalogItemTitle244020972';
        $catalogItem->setTitle($catalogItemTitle);
        $request = (new CreateCatalogItemRequest())->setParent($formattedParent)->setCatalogItem($catalogItem);
        $response = $gapicClient->createCatalogItem($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.recommendationengine.v1beta1.CatalogService/CreateCatalogItem',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getCatalogItem();
        $this->assertProtobufEquals($catalogItem, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createCatalogItemExceptionTest()
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
        $formattedParent = $gapicClient->catalogName('[PROJECT]', '[LOCATION]', '[CATALOG]');
        $catalogItem = new CatalogItem();
        $catalogItemId = 'catalogItemId-1850269433';
        $catalogItem->setId($catalogItemId);
        $catalogItemCategoryHierarchies = [];
        $catalogItem->setCategoryHierarchies($catalogItemCategoryHierarchies);
        $catalogItemTitle = 'catalogItemTitle244020972';
        $catalogItem->setTitle($catalogItemTitle);
        $request = (new CreateCatalogItemRequest())->setParent($formattedParent)->setCatalogItem($catalogItem);
        try {
            $gapicClient->createCatalogItem($request);
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
    public function deleteCatalogItemTest()
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
        $formattedName = $gapicClient->catalogItemPathName(
            '[PROJECT]',
            '[LOCATION]',
            '[CATALOG]',
            '[CATALOG_ITEM_PATH]'
        );
        $request = (new DeleteCatalogItemRequest())->setName($formattedName);
        $gapicClient->deleteCatalogItem($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.recommendationengine.v1beta1.CatalogService/DeleteCatalogItem',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteCatalogItemExceptionTest()
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
        $formattedName = $gapicClient->catalogItemPathName(
            '[PROJECT]',
            '[LOCATION]',
            '[CATALOG]',
            '[CATALOG_ITEM_PATH]'
        );
        $request = (new DeleteCatalogItemRequest())->setName($formattedName);
        try {
            $gapicClient->deleteCatalogItem($request);
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
    public function getCatalogItemTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $id = 'id3355';
        $title = 'title110371416';
        $description = 'description-1724546052';
        $languageCode = 'languageCode-412800396';
        $itemGroupId = 'itemGroupId894431879';
        $expectedResponse = new CatalogItem();
        $expectedResponse->setId($id);
        $expectedResponse->setTitle($title);
        $expectedResponse->setDescription($description);
        $expectedResponse->setLanguageCode($languageCode);
        $expectedResponse->setItemGroupId($itemGroupId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->catalogItemPathName(
            '[PROJECT]',
            '[LOCATION]',
            '[CATALOG]',
            '[CATALOG_ITEM_PATH]'
        );
        $request = (new GetCatalogItemRequest())->setName($formattedName);
        $response = $gapicClient->getCatalogItem($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.recommendationengine.v1beta1.CatalogService/GetCatalogItem', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getCatalogItemExceptionTest()
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
        $formattedName = $gapicClient->catalogItemPathName(
            '[PROJECT]',
            '[LOCATION]',
            '[CATALOG]',
            '[CATALOG_ITEM_PATH]'
        );
        $request = (new GetCatalogItemRequest())->setName($formattedName);
        try {
            $gapicClient->getCatalogItem($request);
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
    public function importCatalogItemsTest()
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
        $incompleteOperation->setName('operations/importCatalogItemsTest');
        $incompleteOperation->setDone(false);
        $transport->addResponse($incompleteOperation);
        $expectedResponse = new ImportCatalogItemsResponse();
        $anyResponse = new Any();
        $anyResponse->setValue($expectedResponse->serializeToString());
        $completeOperation = new Operation();
        $completeOperation->setName('operations/importCatalogItemsTest');
        $completeOperation->setDone(true);
        $completeOperation->setResponse($anyResponse);
        $operationsTransport->addResponse($completeOperation);
        // Mock request
        $formattedParent = $gapicClient->catalogName('[PROJECT]', '[LOCATION]', '[CATALOG]');
        $inputConfig = new InputConfig();
        $request = (new ImportCatalogItemsRequest())->setParent($formattedParent)->setInputConfig($inputConfig);
        $response = $gapicClient->importCatalogItems($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $apiRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($apiRequests));
        $operationsRequestsEmpty = $operationsTransport->popReceivedCalls();
        $this->assertSame(0, count($operationsRequestsEmpty));
        $actualApiFuncCall = $apiRequests[0]->getFuncCall();
        $actualApiRequestObject = $apiRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.recommendationengine.v1beta1.CatalogService/ImportCatalogItems',
            $actualApiFuncCall
        );
        $actualValue = $actualApiRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualApiRequestObject->getInputConfig();
        $this->assertProtobufEquals($inputConfig, $actualValue);
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/importCatalogItemsTest');
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
    public function importCatalogItemsExceptionTest()
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
        $incompleteOperation->setName('operations/importCatalogItemsTest');
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
        $formattedParent = $gapicClient->catalogName('[PROJECT]', '[LOCATION]', '[CATALOG]');
        $inputConfig = new InputConfig();
        $request = (new ImportCatalogItemsRequest())->setParent($formattedParent)->setInputConfig($inputConfig);
        $response = $gapicClient->importCatalogItems($request);
        $this->assertFalse($response->isDone());
        $this->assertNull($response->getResult());
        $expectedOperationsRequestObject = new GetOperationRequest();
        $expectedOperationsRequestObject->setName('operations/importCatalogItemsTest');
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
    public function listCatalogItemsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $catalogItemsElement = new CatalogItem();
        $catalogItems = [$catalogItemsElement];
        $expectedResponse = new ListCatalogItemsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setCatalogItems($catalogItems);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->catalogName('[PROJECT]', '[LOCATION]', '[CATALOG]');
        $request = (new ListCatalogItemsRequest())->setParent($formattedParent);
        $response = $gapicClient->listCatalogItems($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCatalogItems()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.recommendationengine.v1beta1.CatalogService/ListCatalogItems',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listCatalogItemsExceptionTest()
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
        $formattedParent = $gapicClient->catalogName('[PROJECT]', '[LOCATION]', '[CATALOG]');
        $request = (new ListCatalogItemsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listCatalogItems($request);
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
    public function updateCatalogItemTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $id = 'id3355';
        $title = 'title110371416';
        $description = 'description-1724546052';
        $languageCode = 'languageCode-412800396';
        $itemGroupId = 'itemGroupId894431879';
        $expectedResponse = new CatalogItem();
        $expectedResponse->setId($id);
        $expectedResponse->setTitle($title);
        $expectedResponse->setDescription($description);
        $expectedResponse->setLanguageCode($languageCode);
        $expectedResponse->setItemGroupId($itemGroupId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->catalogItemPathName(
            '[PROJECT]',
            '[LOCATION]',
            '[CATALOG]',
            '[CATALOG_ITEM_PATH]'
        );
        $catalogItem = new CatalogItem();
        $catalogItemId = 'catalogItemId-1850269433';
        $catalogItem->setId($catalogItemId);
        $catalogItemCategoryHierarchies = [];
        $catalogItem->setCategoryHierarchies($catalogItemCategoryHierarchies);
        $catalogItemTitle = 'catalogItemTitle244020972';
        $catalogItem->setTitle($catalogItemTitle);
        $request = (new UpdateCatalogItemRequest())->setName($formattedName)->setCatalogItem($catalogItem);
        $response = $gapicClient->updateCatalogItem($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.recommendationengine.v1beta1.CatalogService/UpdateCatalogItem',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getCatalogItem();
        $this->assertProtobufEquals($catalogItem, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateCatalogItemExceptionTest()
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
        $formattedName = $gapicClient->catalogItemPathName(
            '[PROJECT]',
            '[LOCATION]',
            '[CATALOG]',
            '[CATALOG_ITEM_PATH]'
        );
        $catalogItem = new CatalogItem();
        $catalogItemId = 'catalogItemId-1850269433';
        $catalogItem->setId($catalogItemId);
        $catalogItemCategoryHierarchies = [];
        $catalogItem->setCategoryHierarchies($catalogItemCategoryHierarchies);
        $catalogItemTitle = 'catalogItemTitle244020972';
        $catalogItem->setTitle($catalogItemTitle);
        $request = (new UpdateCatalogItemRequest())->setName($formattedName)->setCatalogItem($catalogItem);
        try {
            $gapicClient->updateCatalogItem($request);
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
    public function createCatalogItemAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $id = 'id3355';
        $title = 'title110371416';
        $description = 'description-1724546052';
        $languageCode = 'languageCode-412800396';
        $itemGroupId = 'itemGroupId894431879';
        $expectedResponse = new CatalogItem();
        $expectedResponse->setId($id);
        $expectedResponse->setTitle($title);
        $expectedResponse->setDescription($description);
        $expectedResponse->setLanguageCode($languageCode);
        $expectedResponse->setItemGroupId($itemGroupId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->catalogName('[PROJECT]', '[LOCATION]', '[CATALOG]');
        $catalogItem = new CatalogItem();
        $catalogItemId = 'catalogItemId-1850269433';
        $catalogItem->setId($catalogItemId);
        $catalogItemCategoryHierarchies = [];
        $catalogItem->setCategoryHierarchies($catalogItemCategoryHierarchies);
        $catalogItemTitle = 'catalogItemTitle244020972';
        $catalogItem->setTitle($catalogItemTitle);
        $request = (new CreateCatalogItemRequest())->setParent($formattedParent)->setCatalogItem($catalogItem);
        $response = $gapicClient->createCatalogItemAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.recommendationengine.v1beta1.CatalogService/CreateCatalogItem',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getCatalogItem();
        $this->assertProtobufEquals($catalogItem, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
