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

namespace Google\Ads\AdManager\Tests\Unit\V1\Client;

use Google\Ads\AdManager\V1\BatchActivateCustomTargetingValuesRequest;
use Google\Ads\AdManager\V1\BatchActivateCustomTargetingValuesResponse;
use Google\Ads\AdManager\V1\BatchCreateCustomTargetingValuesRequest;
use Google\Ads\AdManager\V1\BatchCreateCustomTargetingValuesResponse;
use Google\Ads\AdManager\V1\BatchDeactivateCustomTargetingValuesRequest;
use Google\Ads\AdManager\V1\BatchDeactivateCustomTargetingValuesResponse;
use Google\Ads\AdManager\V1\BatchUpdateCustomTargetingValuesRequest;
use Google\Ads\AdManager\V1\BatchUpdateCustomTargetingValuesResponse;
use Google\Ads\AdManager\V1\Client\CustomTargetingValueServiceClient;
use Google\Ads\AdManager\V1\CreateCustomTargetingValueRequest;
use Google\Ads\AdManager\V1\CustomTargetingValue;
use Google\Ads\AdManager\V1\CustomTargetingValueMatchTypeEnum\CustomTargetingValueMatchType;
use Google\Ads\AdManager\V1\GetCustomTargetingValueRequest;
use Google\Ads\AdManager\V1\ListCustomTargetingValuesRequest;
use Google\Ads\AdManager\V1\ListCustomTargetingValuesResponse;
use Google\Ads\AdManager\V1\UpdateCustomTargetingValueRequest;
use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Rpc\Code;
use stdClass;

/**
 * @group admanager
 *
 * @group gapic
 */
class CustomTargetingValueServiceClientTest extends GeneratedTest
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

    /** @return CustomTargetingValueServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new CustomTargetingValueServiceClient($options);
    }

    /** @test */
    public function batchActivateCustomTargetingValuesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchActivateCustomTargetingValuesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchActivateCustomTargetingValuesRequest())
            ->setParent($formattedParent)
            ->setRequests($requests);
        $response = $gapicClient->batchActivateCustomTargetingValues($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.CustomTargetingValueService/BatchActivateCustomTargetingValues',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchActivateCustomTargetingValuesExceptionTest()
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
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchActivateCustomTargetingValuesRequest())
            ->setParent($formattedParent)
            ->setRequests($requests);
        try {
            $gapicClient->batchActivateCustomTargetingValues($request);
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
    public function batchCreateCustomTargetingValuesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchCreateCustomTargetingValuesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchCreateCustomTargetingValuesRequest())->setParent($formattedParent)->setRequests($requests);
        $response = $gapicClient->batchCreateCustomTargetingValues($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.CustomTargetingValueService/BatchCreateCustomTargetingValues',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchCreateCustomTargetingValuesExceptionTest()
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
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchCreateCustomTargetingValuesRequest())->setParent($formattedParent)->setRequests($requests);
        try {
            $gapicClient->batchCreateCustomTargetingValues($request);
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
    public function batchDeactivateCustomTargetingValuesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchDeactivateCustomTargetingValuesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchDeactivateCustomTargetingValuesRequest())
            ->setParent($formattedParent)
            ->setRequests($requests);
        $response = $gapicClient->batchDeactivateCustomTargetingValues($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.CustomTargetingValueService/BatchDeactivateCustomTargetingValues',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchDeactivateCustomTargetingValuesExceptionTest()
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
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchDeactivateCustomTargetingValuesRequest())
            ->setParent($formattedParent)
            ->setRequests($requests);
        try {
            $gapicClient->batchDeactivateCustomTargetingValues($request);
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
    public function batchUpdateCustomTargetingValuesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchUpdateCustomTargetingValuesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchUpdateCustomTargetingValuesRequest())->setParent($formattedParent)->setRequests($requests);
        $response = $gapicClient->batchUpdateCustomTargetingValues($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.CustomTargetingValueService/BatchUpdateCustomTargetingValues',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchUpdateCustomTargetingValuesExceptionTest()
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
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchUpdateCustomTargetingValuesRequest())->setParent($formattedParent)->setRequests($requests);
        try {
            $gapicClient->batchUpdateCustomTargetingValues($request);
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
    public function createCustomTargetingValueTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $customTargetingKey = 'customTargetingKey-385515133';
        $adTagName = 'adTagName-1355595604';
        $displayName = 'displayName1615086568';
        $expectedResponse = new CustomTargetingValue();
        $expectedResponse->setName($name);
        $expectedResponse->setCustomTargetingKey($customTargetingKey);
        $expectedResponse->setAdTagName($adTagName);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $customTargetingValue = new CustomTargetingValue();
        $customTargetingValueCustomTargetingKey = $gapicClient->customTargetingKeyName(
            '[NETWORK_CODE]',
            '[CUSTOM_TARGETING_KEY]'
        );
        $customTargetingValue->setCustomTargetingKey($customTargetingValueCustomTargetingKey);
        $customTargetingValueMatchType = CustomTargetingValueMatchType::CUSTOM_TARGETING_VALUE_MATCH_TYPE_UNSPECIFIED;
        $customTargetingValue->setMatchType($customTargetingValueMatchType);
        $request = (new CreateCustomTargetingValueRequest())
            ->setParent($formattedParent)
            ->setCustomTargetingValue($customTargetingValue);
        $response = $gapicClient->createCustomTargetingValue($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.CustomTargetingValueService/CreateCustomTargetingValue',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getCustomTargetingValue();
        $this->assertProtobufEquals($customTargetingValue, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createCustomTargetingValueExceptionTest()
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
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $customTargetingValue = new CustomTargetingValue();
        $customTargetingValueCustomTargetingKey = $gapicClient->customTargetingKeyName(
            '[NETWORK_CODE]',
            '[CUSTOM_TARGETING_KEY]'
        );
        $customTargetingValue->setCustomTargetingKey($customTargetingValueCustomTargetingKey);
        $customTargetingValueMatchType = CustomTargetingValueMatchType::CUSTOM_TARGETING_VALUE_MATCH_TYPE_UNSPECIFIED;
        $customTargetingValue->setMatchType($customTargetingValueMatchType);
        $request = (new CreateCustomTargetingValueRequest())
            ->setParent($formattedParent)
            ->setCustomTargetingValue($customTargetingValue);
        try {
            $gapicClient->createCustomTargetingValue($request);
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
    public function getCustomTargetingValueTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $customTargetingKey = 'customTargetingKey-385515133';
        $adTagName = 'adTagName-1355595604';
        $displayName = 'displayName1615086568';
        $expectedResponse = new CustomTargetingValue();
        $expectedResponse->setName($name2);
        $expectedResponse->setCustomTargetingKey($customTargetingKey);
        $expectedResponse->setAdTagName($adTagName);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->customTargetingValueName('[NETWORK_CODE]', '[CUSTOM_TARGETING_VALUE]');
        $request = (new GetCustomTargetingValueRequest())->setName($formattedName);
        $response = $gapicClient->getCustomTargetingValue($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.CustomTargetingValueService/GetCustomTargetingValue',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getCustomTargetingValueExceptionTest()
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
        $formattedName = $gapicClient->customTargetingValueName('[NETWORK_CODE]', '[CUSTOM_TARGETING_VALUE]');
        $request = (new GetCustomTargetingValueRequest())->setName($formattedName);
        try {
            $gapicClient->getCustomTargetingValue($request);
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
    public function listCustomTargetingValuesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $totalSize = 705419236;
        $customTargetingValuesElement = new CustomTargetingValue();
        $customTargetingValues = [$customTargetingValuesElement];
        $expectedResponse = new ListCustomTargetingValuesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setCustomTargetingValues($customTargetingValues);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $request = (new ListCustomTargetingValuesRequest())->setParent($formattedParent);
        $response = $gapicClient->listCustomTargetingValues($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCustomTargetingValues()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.CustomTargetingValueService/ListCustomTargetingValues',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listCustomTargetingValuesExceptionTest()
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
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $request = (new ListCustomTargetingValuesRequest())->setParent($formattedParent);
        try {
            $gapicClient->listCustomTargetingValues($request);
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
    public function updateCustomTargetingValueTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $customTargetingKey = 'customTargetingKey-385515133';
        $adTagName = 'adTagName-1355595604';
        $displayName = 'displayName1615086568';
        $expectedResponse = new CustomTargetingValue();
        $expectedResponse->setName($name);
        $expectedResponse->setCustomTargetingKey($customTargetingKey);
        $expectedResponse->setAdTagName($adTagName);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $customTargetingValue = new CustomTargetingValue();
        $customTargetingValueCustomTargetingKey = $gapicClient->customTargetingKeyName(
            '[NETWORK_CODE]',
            '[CUSTOM_TARGETING_KEY]'
        );
        $customTargetingValue->setCustomTargetingKey($customTargetingValueCustomTargetingKey);
        $customTargetingValueMatchType = CustomTargetingValueMatchType::CUSTOM_TARGETING_VALUE_MATCH_TYPE_UNSPECIFIED;
        $customTargetingValue->setMatchType($customTargetingValueMatchType);
        $request = (new UpdateCustomTargetingValueRequest())->setCustomTargetingValue($customTargetingValue);
        $response = $gapicClient->updateCustomTargetingValue($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.CustomTargetingValueService/UpdateCustomTargetingValue',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getCustomTargetingValue();
        $this->assertProtobufEquals($customTargetingValue, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateCustomTargetingValueExceptionTest()
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
        $customTargetingValue = new CustomTargetingValue();
        $customTargetingValueCustomTargetingKey = $gapicClient->customTargetingKeyName(
            '[NETWORK_CODE]',
            '[CUSTOM_TARGETING_KEY]'
        );
        $customTargetingValue->setCustomTargetingKey($customTargetingValueCustomTargetingKey);
        $customTargetingValueMatchType = CustomTargetingValueMatchType::CUSTOM_TARGETING_VALUE_MATCH_TYPE_UNSPECIFIED;
        $customTargetingValue->setMatchType($customTargetingValueMatchType);
        $request = (new UpdateCustomTargetingValueRequest())->setCustomTargetingValue($customTargetingValue);
        try {
            $gapicClient->updateCustomTargetingValue($request);
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
    public function batchActivateCustomTargetingValuesAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchActivateCustomTargetingValuesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchActivateCustomTargetingValuesRequest())
            ->setParent($formattedParent)
            ->setRequests($requests);
        $response = $gapicClient->batchActivateCustomTargetingValuesAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.CustomTargetingValueService/BatchActivateCustomTargetingValues',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
