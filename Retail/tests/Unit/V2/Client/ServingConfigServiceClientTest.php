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
use Google\Cloud\Retail\V2\AddControlRequest;
use Google\Cloud\Retail\V2\Client\ServingConfigServiceClient;
use Google\Cloud\Retail\V2\CreateServingConfigRequest;
use Google\Cloud\Retail\V2\DeleteServingConfigRequest;
use Google\Cloud\Retail\V2\GetServingConfigRequest;
use Google\Cloud\Retail\V2\ListServingConfigsRequest;
use Google\Cloud\Retail\V2\ListServingConfigsResponse;
use Google\Cloud\Retail\V2\RemoveControlRequest;
use Google\Cloud\Retail\V2\ServingConfig;
use Google\Cloud\Retail\V2\UpdateServingConfigRequest;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group retail
 *
 * @group gapic
 */
class ServingConfigServiceClientTest extends GeneratedTest
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

    /** @return ServingConfigServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new ServingConfigServiceClient($options);
    }

    /** @test */
    public function addControlTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $modelId = 'modelId-619038223';
        $priceRerankingLevel = 'priceRerankingLevel1240955890';
        $diversityLevel = 'diversityLevel1294448926';
        $enableCategoryFilterLevel = 'enableCategoryFilterLevel-215507998';
        $expectedResponse = new ServingConfig();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setModelId($modelId);
        $expectedResponse->setPriceRerankingLevel($priceRerankingLevel);
        $expectedResponse->setDiversityLevel($diversityLevel);
        $expectedResponse->setEnableCategoryFilterLevel($enableCategoryFilterLevel);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedServingConfig = $gapicClient->servingConfigName('[PROJECT]', '[LOCATION]', '[CATALOG]', '[SERVING_CONFIG]');
        $controlId = 'controlId637416253';
        $request = (new AddControlRequest())
            ->setServingConfig($formattedServingConfig)
            ->setControlId($controlId);
        $response = $gapicClient->addControl($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.retail.v2.ServingConfigService/AddControl', $actualFuncCall);
        $actualValue = $actualRequestObject->getServingConfig();
        $this->assertProtobufEquals($formattedServingConfig, $actualValue);
        $actualValue = $actualRequestObject->getControlId();
        $this->assertProtobufEquals($controlId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function addControlExceptionTest()
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
        $formattedServingConfig = $gapicClient->servingConfigName('[PROJECT]', '[LOCATION]', '[CATALOG]', '[SERVING_CONFIG]');
        $controlId = 'controlId637416253';
        $request = (new AddControlRequest())
            ->setServingConfig($formattedServingConfig)
            ->setControlId($controlId);
        try {
            $gapicClient->addControl($request);
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
    public function createServingConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $modelId = 'modelId-619038223';
        $priceRerankingLevel = 'priceRerankingLevel1240955890';
        $diversityLevel = 'diversityLevel1294448926';
        $enableCategoryFilterLevel = 'enableCategoryFilterLevel-215507998';
        $expectedResponse = new ServingConfig();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setModelId($modelId);
        $expectedResponse->setPriceRerankingLevel($priceRerankingLevel);
        $expectedResponse->setDiversityLevel($diversityLevel);
        $expectedResponse->setEnableCategoryFilterLevel($enableCategoryFilterLevel);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->catalogName('[PROJECT]', '[LOCATION]', '[CATALOG]');
        $servingConfig = new ServingConfig();
        $servingConfigDisplayName = 'servingConfigDisplayName-490549473';
        $servingConfig->setDisplayName($servingConfigDisplayName);
        $servingConfigSolutionTypes = [];
        $servingConfig->setSolutionTypes($servingConfigSolutionTypes);
        $servingConfigId = 'servingConfigId-600821051';
        $request = (new CreateServingConfigRequest())
            ->setParent($formattedParent)
            ->setServingConfig($servingConfig)
            ->setServingConfigId($servingConfigId);
        $response = $gapicClient->createServingConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.retail.v2.ServingConfigService/CreateServingConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getServingConfig();
        $this->assertProtobufEquals($servingConfig, $actualValue);
        $actualValue = $actualRequestObject->getServingConfigId();
        $this->assertProtobufEquals($servingConfigId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createServingConfigExceptionTest()
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
        $formattedParent = $gapicClient->catalogName('[PROJECT]', '[LOCATION]', '[CATALOG]');
        $servingConfig = new ServingConfig();
        $servingConfigDisplayName = 'servingConfigDisplayName-490549473';
        $servingConfig->setDisplayName($servingConfigDisplayName);
        $servingConfigSolutionTypes = [];
        $servingConfig->setSolutionTypes($servingConfigSolutionTypes);
        $servingConfigId = 'servingConfigId-600821051';
        $request = (new CreateServingConfigRequest())
            ->setParent($formattedParent)
            ->setServingConfig($servingConfig)
            ->setServingConfigId($servingConfigId);
        try {
            $gapicClient->createServingConfig($request);
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
    public function deleteServingConfigTest()
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
        $formattedName = $gapicClient->servingConfigName('[PROJECT]', '[LOCATION]', '[CATALOG]', '[SERVING_CONFIG]');
        $request = (new DeleteServingConfigRequest())
            ->setName($formattedName);
        $gapicClient->deleteServingConfig($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.retail.v2.ServingConfigService/DeleteServingConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteServingConfigExceptionTest()
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
        $formattedName = $gapicClient->servingConfigName('[PROJECT]', '[LOCATION]', '[CATALOG]', '[SERVING_CONFIG]');
        $request = (new DeleteServingConfigRequest())
            ->setName($formattedName);
        try {
            $gapicClient->deleteServingConfig($request);
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
    public function getServingConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $modelId = 'modelId-619038223';
        $priceRerankingLevel = 'priceRerankingLevel1240955890';
        $diversityLevel = 'diversityLevel1294448926';
        $enableCategoryFilterLevel = 'enableCategoryFilterLevel-215507998';
        $expectedResponse = new ServingConfig();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setModelId($modelId);
        $expectedResponse->setPriceRerankingLevel($priceRerankingLevel);
        $expectedResponse->setDiversityLevel($diversityLevel);
        $expectedResponse->setEnableCategoryFilterLevel($enableCategoryFilterLevel);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->servingConfigName('[PROJECT]', '[LOCATION]', '[CATALOG]', '[SERVING_CONFIG]');
        $request = (new GetServingConfigRequest())
            ->setName($formattedName);
        $response = $gapicClient->getServingConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.retail.v2.ServingConfigService/GetServingConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getServingConfigExceptionTest()
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
        $formattedName = $gapicClient->servingConfigName('[PROJECT]', '[LOCATION]', '[CATALOG]', '[SERVING_CONFIG]');
        $request = (new GetServingConfigRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getServingConfig($request);
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
    public function listServingConfigsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $servingConfigsElement = new ServingConfig();
        $servingConfigs = [
            $servingConfigsElement,
        ];
        $expectedResponse = new ListServingConfigsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setServingConfigs($servingConfigs);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->catalogName('[PROJECT]', '[LOCATION]', '[CATALOG]');
        $request = (new ListServingConfigsRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listServingConfigs($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getServingConfigs()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.retail.v2.ServingConfigService/ListServingConfigs', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listServingConfigsExceptionTest()
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
        $formattedParent = $gapicClient->catalogName('[PROJECT]', '[LOCATION]', '[CATALOG]');
        $request = (new ListServingConfigsRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listServingConfigs($request);
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
    public function removeControlTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $modelId = 'modelId-619038223';
        $priceRerankingLevel = 'priceRerankingLevel1240955890';
        $diversityLevel = 'diversityLevel1294448926';
        $enableCategoryFilterLevel = 'enableCategoryFilterLevel-215507998';
        $expectedResponse = new ServingConfig();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setModelId($modelId);
        $expectedResponse->setPriceRerankingLevel($priceRerankingLevel);
        $expectedResponse->setDiversityLevel($diversityLevel);
        $expectedResponse->setEnableCategoryFilterLevel($enableCategoryFilterLevel);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedServingConfig = $gapicClient->servingConfigName('[PROJECT]', '[LOCATION]', '[CATALOG]', '[SERVING_CONFIG]');
        $controlId = 'controlId637416253';
        $request = (new RemoveControlRequest())
            ->setServingConfig($formattedServingConfig)
            ->setControlId($controlId);
        $response = $gapicClient->removeControl($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.retail.v2.ServingConfigService/RemoveControl', $actualFuncCall);
        $actualValue = $actualRequestObject->getServingConfig();
        $this->assertProtobufEquals($formattedServingConfig, $actualValue);
        $actualValue = $actualRequestObject->getControlId();
        $this->assertProtobufEquals($controlId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function removeControlExceptionTest()
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
        $formattedServingConfig = $gapicClient->servingConfigName('[PROJECT]', '[LOCATION]', '[CATALOG]', '[SERVING_CONFIG]');
        $controlId = 'controlId637416253';
        $request = (new RemoveControlRequest())
            ->setServingConfig($formattedServingConfig)
            ->setControlId($controlId);
        try {
            $gapicClient->removeControl($request);
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
    public function updateServingConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $modelId = 'modelId-619038223';
        $priceRerankingLevel = 'priceRerankingLevel1240955890';
        $diversityLevel = 'diversityLevel1294448926';
        $enableCategoryFilterLevel = 'enableCategoryFilterLevel-215507998';
        $expectedResponse = new ServingConfig();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setModelId($modelId);
        $expectedResponse->setPriceRerankingLevel($priceRerankingLevel);
        $expectedResponse->setDiversityLevel($diversityLevel);
        $expectedResponse->setEnableCategoryFilterLevel($enableCategoryFilterLevel);
        $transport->addResponse($expectedResponse);
        // Mock request
        $servingConfig = new ServingConfig();
        $servingConfigDisplayName = 'servingConfigDisplayName-490549473';
        $servingConfig->setDisplayName($servingConfigDisplayName);
        $servingConfigSolutionTypes = [];
        $servingConfig->setSolutionTypes($servingConfigSolutionTypes);
        $request = (new UpdateServingConfigRequest())
            ->setServingConfig($servingConfig);
        $response = $gapicClient->updateServingConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.retail.v2.ServingConfigService/UpdateServingConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getServingConfig();
        $this->assertProtobufEquals($servingConfig, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateServingConfigExceptionTest()
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
        $servingConfig = new ServingConfig();
        $servingConfigDisplayName = 'servingConfigDisplayName-490549473';
        $servingConfig->setDisplayName($servingConfigDisplayName);
        $servingConfigSolutionTypes = [];
        $servingConfig->setSolutionTypes($servingConfigSolutionTypes);
        $request = (new UpdateServingConfigRequest())
            ->setServingConfig($servingConfig);
        try {
            $gapicClient->updateServingConfig($request);
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
    public function addControlAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $modelId = 'modelId-619038223';
        $priceRerankingLevel = 'priceRerankingLevel1240955890';
        $diversityLevel = 'diversityLevel1294448926';
        $enableCategoryFilterLevel = 'enableCategoryFilterLevel-215507998';
        $expectedResponse = new ServingConfig();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setModelId($modelId);
        $expectedResponse->setPriceRerankingLevel($priceRerankingLevel);
        $expectedResponse->setDiversityLevel($diversityLevel);
        $expectedResponse->setEnableCategoryFilterLevel($enableCategoryFilterLevel);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedServingConfig = $gapicClient->servingConfigName('[PROJECT]', '[LOCATION]', '[CATALOG]', '[SERVING_CONFIG]');
        $controlId = 'controlId637416253';
        $request = (new AddControlRequest())
            ->setServingConfig($formattedServingConfig)
            ->setControlId($controlId);
        $response = $gapicClient->addControlAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.retail.v2.ServingConfigService/AddControl', $actualFuncCall);
        $actualValue = $actualRequestObject->getServingConfig();
        $this->assertProtobufEquals($formattedServingConfig, $actualValue);
        $actualValue = $actualRequestObject->getControlId();
        $this->assertProtobufEquals($controlId, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
