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

namespace Google\Cloud\Retail\Tests\Unit\V2\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Retail\V2\AddCatalogAttributeRequest;
use Google\Cloud\Retail\V2\AttributesConfig;
use Google\Cloud\Retail\V2\Catalog;
use Google\Cloud\Retail\V2\CatalogAttribute;
use Google\Cloud\Retail\V2\Client\CatalogServiceClient;
use Google\Cloud\Retail\V2\CompletionConfig;
use Google\Cloud\Retail\V2\GetAttributesConfigRequest;
use Google\Cloud\Retail\V2\GetCompletionConfigRequest;
use Google\Cloud\Retail\V2\GetDefaultBranchRequest;
use Google\Cloud\Retail\V2\GetDefaultBranchResponse;
use Google\Cloud\Retail\V2\ListCatalogsRequest;
use Google\Cloud\Retail\V2\ListCatalogsResponse;
use Google\Cloud\Retail\V2\ProductLevelConfig;
use Google\Cloud\Retail\V2\RemoveCatalogAttributeRequest;
use Google\Cloud\Retail\V2\ReplaceCatalogAttributeRequest;
use Google\Cloud\Retail\V2\SetDefaultBranchRequest;
use Google\Cloud\Retail\V2\UpdateAttributesConfigRequest;
use Google\Cloud\Retail\V2\UpdateCatalogRequest;
use Google\Cloud\Retail\V2\UpdateCompletionConfigRequest;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group retail
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
        return $this->getMockBuilder(CredentialsWrapper::class)->disableOriginalConstructor()->getMock();
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
    public function addCatalogAttributeTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $expectedResponse = new AttributesConfig();
        $expectedResponse->setName($name);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedAttributesConfig = $gapicClient->attributesConfigName('[PROJECT]', '[LOCATION]', '[CATALOG]');
        $catalogAttribute = new CatalogAttribute();
        $catalogAttributeKey = 'catalogAttributeKey-1525777188';
        $catalogAttribute->setKey($catalogAttributeKey);
        $request = (new AddCatalogAttributeRequest())
            ->setAttributesConfig($formattedAttributesConfig)
            ->setCatalogAttribute($catalogAttribute);
        $response = $gapicClient->addCatalogAttribute($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.retail.v2.CatalogService/AddCatalogAttribute', $actualFuncCall);
        $actualValue = $actualRequestObject->getAttributesConfig();
        $this->assertProtobufEquals($formattedAttributesConfig, $actualValue);
        $actualValue = $actualRequestObject->getCatalogAttribute();
        $this->assertProtobufEquals($catalogAttribute, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function addCatalogAttributeExceptionTest()
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
        $formattedAttributesConfig = $gapicClient->attributesConfigName('[PROJECT]', '[LOCATION]', '[CATALOG]');
        $catalogAttribute = new CatalogAttribute();
        $catalogAttributeKey = 'catalogAttributeKey-1525777188';
        $catalogAttribute->setKey($catalogAttributeKey);
        $request = (new AddCatalogAttributeRequest())
            ->setAttributesConfig($formattedAttributesConfig)
            ->setCatalogAttribute($catalogAttribute);
        try {
            $gapicClient->addCatalogAttribute($request);
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
    public function getAttributesConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $expectedResponse = new AttributesConfig();
        $expectedResponse->setName($name2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->attributesConfigName('[PROJECT]', '[LOCATION]', '[CATALOG]');
        $request = (new GetAttributesConfigRequest())
            ->setName($formattedName);
        $response = $gapicClient->getAttributesConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.retail.v2.CatalogService/GetAttributesConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getAttributesConfigExceptionTest()
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
        $formattedName = $gapicClient->attributesConfigName('[PROJECT]', '[LOCATION]', '[CATALOG]');
        $request = (new GetAttributesConfigRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getAttributesConfig($request);
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
    public function getCompletionConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $matchingOrder = 'matchingOrder1035789452';
        $maxSuggestions = 618824852;
        $minPrefixLength = 96853510;
        $autoLearning = true;
        $lastSuggestionsImportOperation = 'lastSuggestionsImportOperation-470644314';
        $lastDenylistImportOperation = 'lastDenylistImportOperation-181585959';
        $lastAllowlistImportOperation = 'lastAllowlistImportOperation723854958';
        $expectedResponse = new CompletionConfig();
        $expectedResponse->setName($name2);
        $expectedResponse->setMatchingOrder($matchingOrder);
        $expectedResponse->setMaxSuggestions($maxSuggestions);
        $expectedResponse->setMinPrefixLength($minPrefixLength);
        $expectedResponse->setAutoLearning($autoLearning);
        $expectedResponse->setLastSuggestionsImportOperation($lastSuggestionsImportOperation);
        $expectedResponse->setLastDenylistImportOperation($lastDenylistImportOperation);
        $expectedResponse->setLastAllowlistImportOperation($lastAllowlistImportOperation);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->completionConfigName('[PROJECT]', '[LOCATION]', '[CATALOG]');
        $request = (new GetCompletionConfigRequest())
            ->setName($formattedName);
        $response = $gapicClient->getCompletionConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.retail.v2.CatalogService/GetCompletionConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getCompletionConfigExceptionTest()
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
        $formattedName = $gapicClient->completionConfigName('[PROJECT]', '[LOCATION]', '[CATALOG]');
        $request = (new GetCompletionConfigRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getCompletionConfig($request);
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
    public function getDefaultBranchTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $branch = 'branch-1381030494';
        $note = 'note3387378';
        $expectedResponse = new GetDefaultBranchResponse();
        $expectedResponse->setBranch($branch);
        $expectedResponse->setNote($note);
        $transport->addResponse($expectedResponse);
        $request = new GetDefaultBranchRequest();
        $response = $gapicClient->getDefaultBranch($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.retail.v2.CatalogService/GetDefaultBranch', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getDefaultBranchExceptionTest()
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
        $request = new GetDefaultBranchRequest();
        try {
            $gapicClient->getDefaultBranch($request);
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
    public function listCatalogsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $catalogsElement = new Catalog();
        $catalogs = [
            $catalogsElement,
        ];
        $expectedResponse = new ListCatalogsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setCatalogs($catalogs);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListCatalogsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listCatalogs($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCatalogs()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.retail.v2.CatalogService/ListCatalogs', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listCatalogsExceptionTest()
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
        $request = (new ListCatalogsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listCatalogs($request);
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
    public function removeCatalogAttributeTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $expectedResponse = new AttributesConfig();
        $expectedResponse->setName($name);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedAttributesConfig = $gapicClient->attributesConfigName('[PROJECT]', '[LOCATION]', '[CATALOG]');
        $key = 'key106079';
        $request = (new RemoveCatalogAttributeRequest())
            ->setAttributesConfig($formattedAttributesConfig)
            ->setKey($key);
        $response = $gapicClient->removeCatalogAttribute($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.retail.v2.CatalogService/RemoveCatalogAttribute', $actualFuncCall);
        $actualValue = $actualRequestObject->getAttributesConfig();
        $this->assertProtobufEquals($formattedAttributesConfig, $actualValue);
        $actualValue = $actualRequestObject->getKey();
        $this->assertProtobufEquals($key, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function removeCatalogAttributeExceptionTest()
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
        $formattedAttributesConfig = $gapicClient->attributesConfigName('[PROJECT]', '[LOCATION]', '[CATALOG]');
        $key = 'key106079';
        $request = (new RemoveCatalogAttributeRequest())
            ->setAttributesConfig($formattedAttributesConfig)
            ->setKey($key);
        try {
            $gapicClient->removeCatalogAttribute($request);
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
    public function replaceCatalogAttributeTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $expectedResponse = new AttributesConfig();
        $expectedResponse->setName($name);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedAttributesConfig = $gapicClient->attributesConfigName('[PROJECT]', '[LOCATION]', '[CATALOG]');
        $catalogAttribute = new CatalogAttribute();
        $catalogAttributeKey = 'catalogAttributeKey-1525777188';
        $catalogAttribute->setKey($catalogAttributeKey);
        $request = (new ReplaceCatalogAttributeRequest())
            ->setAttributesConfig($formattedAttributesConfig)
            ->setCatalogAttribute($catalogAttribute);
        $response = $gapicClient->replaceCatalogAttribute($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.retail.v2.CatalogService/ReplaceCatalogAttribute', $actualFuncCall);
        $actualValue = $actualRequestObject->getAttributesConfig();
        $this->assertProtobufEquals($formattedAttributesConfig, $actualValue);
        $actualValue = $actualRequestObject->getCatalogAttribute();
        $this->assertProtobufEquals($catalogAttribute, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function replaceCatalogAttributeExceptionTest()
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
        $formattedAttributesConfig = $gapicClient->attributesConfigName('[PROJECT]', '[LOCATION]', '[CATALOG]');
        $catalogAttribute = new CatalogAttribute();
        $catalogAttributeKey = 'catalogAttributeKey-1525777188';
        $catalogAttribute->setKey($catalogAttributeKey);
        $request = (new ReplaceCatalogAttributeRequest())
            ->setAttributesConfig($formattedAttributesConfig)
            ->setCatalogAttribute($catalogAttribute);
        try {
            $gapicClient->replaceCatalogAttribute($request);
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
    public function setDefaultBranchTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        $request = new SetDefaultBranchRequest();
        $gapicClient->setDefaultBranch($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.retail.v2.CatalogService/SetDefaultBranch', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function setDefaultBranchExceptionTest()
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
        $request = new SetDefaultBranchRequest();
        try {
            $gapicClient->setDefaultBranch($request);
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
    public function updateAttributesConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $expectedResponse = new AttributesConfig();
        $expectedResponse->setName($name);
        $transport->addResponse($expectedResponse);
        // Mock request
        $attributesConfig = new AttributesConfig();
        $attributesConfigName = 'attributesConfigName-1073347164';
        $attributesConfig->setName($attributesConfigName);
        $request = (new UpdateAttributesConfigRequest())
            ->setAttributesConfig($attributesConfig);
        $response = $gapicClient->updateAttributesConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.retail.v2.CatalogService/UpdateAttributesConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getAttributesConfig();
        $this->assertProtobufEquals($attributesConfig, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateAttributesConfigExceptionTest()
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
        $attributesConfig = new AttributesConfig();
        $attributesConfigName = 'attributesConfigName-1073347164';
        $attributesConfig->setName($attributesConfigName);
        $request = (new UpdateAttributesConfigRequest())
            ->setAttributesConfig($attributesConfig);
        try {
            $gapicClient->updateAttributesConfig($request);
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
    public function updateCatalogTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $expectedResponse = new Catalog();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $catalog = new Catalog();
        $catalogName = 'catalogName-1007379900';
        $catalog->setName($catalogName);
        $catalogDisplayName = 'catalogDisplayName1836270740';
        $catalog->setDisplayName($catalogDisplayName);
        $catalogProductLevelConfig = new ProductLevelConfig();
        $catalog->setProductLevelConfig($catalogProductLevelConfig);
        $request = (new UpdateCatalogRequest())
            ->setCatalog($catalog);
        $response = $gapicClient->updateCatalog($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.retail.v2.CatalogService/UpdateCatalog', $actualFuncCall);
        $actualValue = $actualRequestObject->getCatalog();
        $this->assertProtobufEquals($catalog, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateCatalogExceptionTest()
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
        $catalog = new Catalog();
        $catalogName = 'catalogName-1007379900';
        $catalog->setName($catalogName);
        $catalogDisplayName = 'catalogDisplayName1836270740';
        $catalog->setDisplayName($catalogDisplayName);
        $catalogProductLevelConfig = new ProductLevelConfig();
        $catalog->setProductLevelConfig($catalogProductLevelConfig);
        $request = (new UpdateCatalogRequest())
            ->setCatalog($catalog);
        try {
            $gapicClient->updateCatalog($request);
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
    public function updateCompletionConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $matchingOrder = 'matchingOrder1035789452';
        $maxSuggestions = 618824852;
        $minPrefixLength = 96853510;
        $autoLearning = true;
        $lastSuggestionsImportOperation = 'lastSuggestionsImportOperation-470644314';
        $lastDenylistImportOperation = 'lastDenylistImportOperation-181585959';
        $lastAllowlistImportOperation = 'lastAllowlistImportOperation723854958';
        $expectedResponse = new CompletionConfig();
        $expectedResponse->setName($name);
        $expectedResponse->setMatchingOrder($matchingOrder);
        $expectedResponse->setMaxSuggestions($maxSuggestions);
        $expectedResponse->setMinPrefixLength($minPrefixLength);
        $expectedResponse->setAutoLearning($autoLearning);
        $expectedResponse->setLastSuggestionsImportOperation($lastSuggestionsImportOperation);
        $expectedResponse->setLastDenylistImportOperation($lastDenylistImportOperation);
        $expectedResponse->setLastAllowlistImportOperation($lastAllowlistImportOperation);
        $transport->addResponse($expectedResponse);
        // Mock request
        $completionConfig = new CompletionConfig();
        $completionConfigName = 'completionConfigName2129042921';
        $completionConfig->setName($completionConfigName);
        $request = (new UpdateCompletionConfigRequest())
            ->setCompletionConfig($completionConfig);
        $response = $gapicClient->updateCompletionConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.retail.v2.CatalogService/UpdateCompletionConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getCompletionConfig();
        $this->assertProtobufEquals($completionConfig, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateCompletionConfigExceptionTest()
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
        $completionConfig = new CompletionConfig();
        $completionConfigName = 'completionConfigName2129042921';
        $completionConfig->setName($completionConfigName);
        $request = (new UpdateCompletionConfigRequest())
            ->setCompletionConfig($completionConfig);
        try {
            $gapicClient->updateCompletionConfig($request);
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
    public function addCatalogAttributeAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $expectedResponse = new AttributesConfig();
        $expectedResponse->setName($name);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedAttributesConfig = $gapicClient->attributesConfigName('[PROJECT]', '[LOCATION]', '[CATALOG]');
        $catalogAttribute = new CatalogAttribute();
        $catalogAttributeKey = 'catalogAttributeKey-1525777188';
        $catalogAttribute->setKey($catalogAttributeKey);
        $request = (new AddCatalogAttributeRequest())
            ->setAttributesConfig($formattedAttributesConfig)
            ->setCatalogAttribute($catalogAttribute);
        $response = $gapicClient->addCatalogAttributeAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.retail.v2.CatalogService/AddCatalogAttribute', $actualFuncCall);
        $actualValue = $actualRequestObject->getAttributesConfig();
        $this->assertProtobufEquals($formattedAttributesConfig, $actualValue);
        $actualValue = $actualRequestObject->getCatalogAttribute();
        $this->assertProtobufEquals($catalogAttribute, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
