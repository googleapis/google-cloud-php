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
use Google\Cloud\DiscoveryEngine\V1\Client\WidgetConfigServiceClient;
use Google\Cloud\DiscoveryEngine\V1\GetWidgetConfigRequest;
use Google\Cloud\DiscoveryEngine\V1\SolutionType;
use Google\Cloud\DiscoveryEngine\V1\UpdateWidgetConfigRequest;
use Google\Cloud\DiscoveryEngine\V1\WidgetConfig;
use Google\Rpc\Code;
use stdClass;

/**
 * @group discoveryengine
 *
 * @group gapic
 */
class WidgetConfigServiceClientTest extends GeneratedTest
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

    /** @return WidgetConfigServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new WidgetConfigServiceClient($options);
    }

    /** @test */
    public function getWidgetConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $configId = 'configId-804450504';
        $llmEnabled = false;
        $enableResultScore = true;
        $minimumDataTermAccepted = true;
        $enablePrivateKnowledgeGraph = false;
        $geminiBundle = true;
        $expectedResponse = new WidgetConfig();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setConfigId($configId);
        $expectedResponse->setLlmEnabled($llmEnabled);
        $expectedResponse->setEnableResultScore($enableResultScore);
        $expectedResponse->setMinimumDataTermAccepted($minimumDataTermAccepted);
        $expectedResponse->setEnablePrivateKnowledgeGraph($enablePrivateKnowledgeGraph);
        $expectedResponse->setGeminiBundle($geminiBundle);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->widgetConfigName('[PROJECT]', '[LOCATION]', '[DATA_STORE]', '[WIDGET_CONFIG]');
        $request = (new GetWidgetConfigRequest())->setName($formattedName);
        $response = $gapicClient->getWidgetConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.discoveryengine.v1.WidgetConfigService/GetWidgetConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getWidgetConfigExceptionTest()
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
        $formattedName = $gapicClient->widgetConfigName('[PROJECT]', '[LOCATION]', '[DATA_STORE]', '[WIDGET_CONFIG]');
        $request = (new GetWidgetConfigRequest())->setName($formattedName);
        try {
            $gapicClient->getWidgetConfig($request);
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
    public function updateWidgetConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $configId = 'configId-804450504';
        $llmEnabled = false;
        $enableResultScore = true;
        $minimumDataTermAccepted = true;
        $enablePrivateKnowledgeGraph = false;
        $geminiBundle = true;
        $expectedResponse = new WidgetConfig();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setConfigId($configId);
        $expectedResponse->setLlmEnabled($llmEnabled);
        $expectedResponse->setEnableResultScore($enableResultScore);
        $expectedResponse->setMinimumDataTermAccepted($minimumDataTermAccepted);
        $expectedResponse->setEnablePrivateKnowledgeGraph($enablePrivateKnowledgeGraph);
        $expectedResponse->setGeminiBundle($geminiBundle);
        $transport->addResponse($expectedResponse);
        // Mock request
        $widgetConfig = new WidgetConfig();
        $widgetConfigDisplayName = 'widgetConfigDisplayName960426983';
        $widgetConfig->setDisplayName($widgetConfigDisplayName);
        $widgetConfigSolutionType = SolutionType::SOLUTION_TYPE_UNSPECIFIED;
        $widgetConfig->setSolutionType($widgetConfigSolutionType);
        $request = (new UpdateWidgetConfigRequest())->setWidgetConfig($widgetConfig);
        $response = $gapicClient->updateWidgetConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.discoveryengine.v1.WidgetConfigService/UpdateWidgetConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getWidgetConfig();
        $this->assertProtobufEquals($widgetConfig, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateWidgetConfigExceptionTest()
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
        $widgetConfig = new WidgetConfig();
        $widgetConfigDisplayName = 'widgetConfigDisplayName960426983';
        $widgetConfig->setDisplayName($widgetConfigDisplayName);
        $widgetConfigSolutionType = SolutionType::SOLUTION_TYPE_UNSPECIFIED;
        $widgetConfig->setSolutionType($widgetConfigSolutionType);
        $request = (new UpdateWidgetConfigRequest())->setWidgetConfig($widgetConfig);
        try {
            $gapicClient->updateWidgetConfig($request);
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
    public function getWidgetConfigAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $configId = 'configId-804450504';
        $llmEnabled = false;
        $enableResultScore = true;
        $minimumDataTermAccepted = true;
        $enablePrivateKnowledgeGraph = false;
        $geminiBundle = true;
        $expectedResponse = new WidgetConfig();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setConfigId($configId);
        $expectedResponse->setLlmEnabled($llmEnabled);
        $expectedResponse->setEnableResultScore($enableResultScore);
        $expectedResponse->setMinimumDataTermAccepted($minimumDataTermAccepted);
        $expectedResponse->setEnablePrivateKnowledgeGraph($enablePrivateKnowledgeGraph);
        $expectedResponse->setGeminiBundle($geminiBundle);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->widgetConfigName('[PROJECT]', '[LOCATION]', '[DATA_STORE]', '[WIDGET_CONFIG]');
        $request = (new GetWidgetConfigRequest())->setName($formattedName);
        $response = $gapicClient->getWidgetConfigAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.discoveryengine.v1.WidgetConfigService/GetWidgetConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
