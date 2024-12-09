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

namespace Google\Cloud\Retail\Tests\Unit\V2\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Retail\V2\BatchUpdateGenerativeQuestionConfigsRequest;
use Google\Cloud\Retail\V2\BatchUpdateGenerativeQuestionConfigsResponse;
use Google\Cloud\Retail\V2\Client\GenerativeQuestionServiceClient;
use Google\Cloud\Retail\V2\GenerativeQuestionConfig;
use Google\Cloud\Retail\V2\GenerativeQuestionsFeatureConfig;
use Google\Cloud\Retail\V2\GetGenerativeQuestionsFeatureConfigRequest;
use Google\Cloud\Retail\V2\ListGenerativeQuestionConfigsRequest;
use Google\Cloud\Retail\V2\ListGenerativeQuestionConfigsResponse;
use Google\Cloud\Retail\V2\UpdateGenerativeQuestionConfigRequest;
use Google\Cloud\Retail\V2\UpdateGenerativeQuestionsFeatureConfigRequest;
use Google\Rpc\Code;
use stdClass;

/**
 * @group retail
 *
 * @group gapic
 */
class GenerativeQuestionServiceClientTest extends GeneratedTest
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

    /** @return GenerativeQuestionServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new GenerativeQuestionServiceClient($options);
    }

    /** @test */
    public function batchUpdateGenerativeQuestionConfigsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchUpdateGenerativeQuestionConfigsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $requests = [];
        $request = (new BatchUpdateGenerativeQuestionConfigsRequest())->setRequests($requests);
        $response = $gapicClient->batchUpdateGenerativeQuestionConfigs($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.retail.v2.GenerativeQuestionService/BatchUpdateGenerativeQuestionConfigs',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchUpdateGenerativeQuestionConfigsExceptionTest()
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
        $requests = [];
        $request = (new BatchUpdateGenerativeQuestionConfigsRequest())->setRequests($requests);
        try {
            $gapicClient->batchUpdateGenerativeQuestionConfigs($request);
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
    public function getGenerativeQuestionsFeatureConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $catalog2 = 'catalog21455933836';
        $featureEnabled = true;
        $minimumProducts = 417095051;
        $expectedResponse = new GenerativeQuestionsFeatureConfig();
        $expectedResponse->setCatalog($catalog2);
        $expectedResponse->setFeatureEnabled($featureEnabled);
        $expectedResponse->setMinimumProducts($minimumProducts);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedCatalog = $gapicClient->catalogName('[PROJECT]', '[LOCATION]', '[CATALOG]');
        $request = (new GetGenerativeQuestionsFeatureConfigRequest())->setCatalog($formattedCatalog);
        $response = $gapicClient->getGenerativeQuestionsFeatureConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.retail.v2.GenerativeQuestionService/GetGenerativeQuestionsFeatureConfig',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getCatalog();
        $this->assertProtobufEquals($formattedCatalog, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getGenerativeQuestionsFeatureConfigExceptionTest()
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
        $formattedCatalog = $gapicClient->catalogName('[PROJECT]', '[LOCATION]', '[CATALOG]');
        $request = (new GetGenerativeQuestionsFeatureConfigRequest())->setCatalog($formattedCatalog);
        try {
            $gapicClient->getGenerativeQuestionsFeatureConfig($request);
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
    public function listGenerativeQuestionConfigsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new ListGenerativeQuestionConfigsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->catalogName('[PROJECT]', '[LOCATION]', '[CATALOG]');
        $request = (new ListGenerativeQuestionConfigsRequest())->setParent($formattedParent);
        $response = $gapicClient->listGenerativeQuestionConfigs($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.retail.v2.GenerativeQuestionService/ListGenerativeQuestionConfigs',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listGenerativeQuestionConfigsExceptionTest()
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
        $request = (new ListGenerativeQuestionConfigsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listGenerativeQuestionConfigs($request);
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
    public function updateGenerativeQuestionConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $catalog = 'catalog555704345';
        $facet = 'facet97187255';
        $generatedQuestion = 'generatedQuestion-1515248490';
        $finalQuestion = 'finalQuestion1509683343';
        $frequency = -7002384;
        $allowedInConversation = true;
        $expectedResponse = new GenerativeQuestionConfig();
        $expectedResponse->setCatalog($catalog);
        $expectedResponse->setFacet($facet);
        $expectedResponse->setGeneratedQuestion($generatedQuestion);
        $expectedResponse->setFinalQuestion($finalQuestion);
        $expectedResponse->setFrequency($frequency);
        $expectedResponse->setAllowedInConversation($allowedInConversation);
        $transport->addResponse($expectedResponse);
        // Mock request
        $generativeQuestionConfig = new GenerativeQuestionConfig();
        $generativeQuestionConfigCatalog = 'generativeQuestionConfigCatalog-1000208599';
        $generativeQuestionConfig->setCatalog($generativeQuestionConfigCatalog);
        $generativeQuestionConfigFacet = 'generativeQuestionConfigFacet-592699193';
        $generativeQuestionConfig->setFacet($generativeQuestionConfigFacet);
        $request = (new UpdateGenerativeQuestionConfigRequest())->setGenerativeQuestionConfig(
            $generativeQuestionConfig
        );
        $response = $gapicClient->updateGenerativeQuestionConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.retail.v2.GenerativeQuestionService/UpdateGenerativeQuestionConfig',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getGenerativeQuestionConfig();
        $this->assertProtobufEquals($generativeQuestionConfig, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateGenerativeQuestionConfigExceptionTest()
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
        $generativeQuestionConfig = new GenerativeQuestionConfig();
        $generativeQuestionConfigCatalog = 'generativeQuestionConfigCatalog-1000208599';
        $generativeQuestionConfig->setCatalog($generativeQuestionConfigCatalog);
        $generativeQuestionConfigFacet = 'generativeQuestionConfigFacet-592699193';
        $generativeQuestionConfig->setFacet($generativeQuestionConfigFacet);
        $request = (new UpdateGenerativeQuestionConfigRequest())->setGenerativeQuestionConfig(
            $generativeQuestionConfig
        );
        try {
            $gapicClient->updateGenerativeQuestionConfig($request);
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
    public function updateGenerativeQuestionsFeatureConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $catalog = 'catalog555704345';
        $featureEnabled = true;
        $minimumProducts = 417095051;
        $expectedResponse = new GenerativeQuestionsFeatureConfig();
        $expectedResponse->setCatalog($catalog);
        $expectedResponse->setFeatureEnabled($featureEnabled);
        $expectedResponse->setMinimumProducts($minimumProducts);
        $transport->addResponse($expectedResponse);
        // Mock request
        $generativeQuestionsFeatureConfig = new GenerativeQuestionsFeatureConfig();
        $generativeQuestionsFeatureConfigCatalog = 'generativeQuestionsFeatureConfigCatalog-1230760186';
        $generativeQuestionsFeatureConfig->setCatalog($generativeQuestionsFeatureConfigCatalog);
        $request = (new UpdateGenerativeQuestionsFeatureConfigRequest())->setGenerativeQuestionsFeatureConfig(
            $generativeQuestionsFeatureConfig
        );
        $response = $gapicClient->updateGenerativeQuestionsFeatureConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.retail.v2.GenerativeQuestionService/UpdateGenerativeQuestionsFeatureConfig',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getGenerativeQuestionsFeatureConfig();
        $this->assertProtobufEquals($generativeQuestionsFeatureConfig, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateGenerativeQuestionsFeatureConfigExceptionTest()
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
        $generativeQuestionsFeatureConfig = new GenerativeQuestionsFeatureConfig();
        $generativeQuestionsFeatureConfigCatalog = 'generativeQuestionsFeatureConfigCatalog-1230760186';
        $generativeQuestionsFeatureConfig->setCatalog($generativeQuestionsFeatureConfigCatalog);
        $request = (new UpdateGenerativeQuestionsFeatureConfigRequest())->setGenerativeQuestionsFeatureConfig(
            $generativeQuestionsFeatureConfig
        );
        try {
            $gapicClient->updateGenerativeQuestionsFeatureConfig($request);
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
    public function batchUpdateGenerativeQuestionConfigsAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchUpdateGenerativeQuestionConfigsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $requests = [];
        $request = (new BatchUpdateGenerativeQuestionConfigsRequest())->setRequests($requests);
        $response = $gapicClient->batchUpdateGenerativeQuestionConfigsAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.retail.v2.GenerativeQuestionService/BatchUpdateGenerativeQuestionConfigs',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
