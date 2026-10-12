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

namespace Google\Ads\AdManager\Tests\Unit\V1\Client;

use Google\Ads\AdManager\V1\AdRule;
use Google\Ads\AdManager\V1\AdRuleSlot;
use Google\Ads\AdManager\V1\BatchActivateAdRulesRequest;
use Google\Ads\AdManager\V1\BatchActivateAdRulesResponse;
use Google\Ads\AdManager\V1\BatchCreateAdRulesRequest;
use Google\Ads\AdManager\V1\BatchCreateAdRulesResponse;
use Google\Ads\AdManager\V1\BatchDeactivateAdRulesRequest;
use Google\Ads\AdManager\V1\BatchDeactivateAdRulesResponse;
use Google\Ads\AdManager\V1\BatchDeleteAdRulesRequest;
use Google\Ads\AdManager\V1\BatchUpdateAdRulesRequest;
use Google\Ads\AdManager\V1\BatchUpdateAdRulesResponse;
use Google\Ads\AdManager\V1\Client\AdRuleServiceClient;
use Google\Ads\AdManager\V1\CreateAdRuleRequest;
use Google\Ads\AdManager\V1\GetAdRuleRequest;
use Google\Ads\AdManager\V1\ListAdRulesRequest;
use Google\Ads\AdManager\V1\ListAdRulesResponse;
use Google\Ads\AdManager\V1\Targeting;
use Google\Ads\AdManager\V1\UpdateAdRuleRequest;
use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Protobuf\GPBEmpty;
use Google\Protobuf\Timestamp;
use Google\Rpc\Code;
use stdClass;

/**
 * @group admanager
 *
 * @group gapic
 */
class AdRuleServiceClientTest extends GeneratedTest
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

    /** @return AdRuleServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new AdRuleServiceClient($options);
    }

    /** @test */
    public function batchActivateAdRulesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchActivateAdRulesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $formattedNames = [$gapicClient->adRuleName('[NETWORK_CODE]', '[AD_RULE]')];
        $request = (new BatchActivateAdRulesRequest())->setParent($formattedParent)->setNames($formattedNames);
        $response = $gapicClient->batchActivateAdRules($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.AdRuleService/BatchActivateAdRules', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($formattedNames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchActivateAdRulesExceptionTest()
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
        $formattedNames = [$gapicClient->adRuleName('[NETWORK_CODE]', '[AD_RULE]')];
        $request = (new BatchActivateAdRulesRequest())->setParent($formattedParent)->setNames($formattedNames);
        try {
            $gapicClient->batchActivateAdRules($request);
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
    public function batchCreateAdRulesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchCreateAdRulesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchCreateAdRulesRequest())->setParent($formattedParent)->setRequests($requests);
        $response = $gapicClient->batchCreateAdRules($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.AdRuleService/BatchCreateAdRules', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchCreateAdRulesExceptionTest()
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
        $request = (new BatchCreateAdRulesRequest())->setParent($formattedParent)->setRequests($requests);
        try {
            $gapicClient->batchCreateAdRules($request);
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
    public function batchDeactivateAdRulesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchDeactivateAdRulesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $formattedNames = [$gapicClient->adRuleName('[NETWORK_CODE]', '[AD_RULE]')];
        $request = (new BatchDeactivateAdRulesRequest())->setParent($formattedParent)->setNames($formattedNames);
        $response = $gapicClient->batchDeactivateAdRules($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.AdRuleService/BatchDeactivateAdRules', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($formattedNames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchDeactivateAdRulesExceptionTest()
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
        $formattedNames = [$gapicClient->adRuleName('[NETWORK_CODE]', '[AD_RULE]')];
        $request = (new BatchDeactivateAdRulesRequest())->setParent($formattedParent)->setNames($formattedNames);
        try {
            $gapicClient->batchDeactivateAdRules($request);
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
    public function batchDeleteAdRulesTest()
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
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $formattedNames = [$gapicClient->adRuleName('[NETWORK_CODE]', '[AD_RULE]')];
        $request = (new BatchDeleteAdRulesRequest())->setParent($formattedParent)->setNames($formattedNames);
        $gapicClient->batchDeleteAdRules($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.AdRuleService/BatchDeleteAdRules', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($formattedNames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchDeleteAdRulesExceptionTest()
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
        $formattedNames = [$gapicClient->adRuleName('[NETWORK_CODE]', '[AD_RULE]')];
        $request = (new BatchDeleteAdRulesRequest())->setParent($formattedParent)->setNames($formattedNames);
        try {
            $gapicClient->batchDeleteAdRules($request);
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
    public function batchUpdateAdRulesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchUpdateAdRulesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchUpdateAdRulesRequest())->setParent($formattedParent)->setRequests($requests);
        $response = $gapicClient->batchUpdateAdRules($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.AdRuleService/BatchUpdateAdRules', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchUpdateAdRulesExceptionTest()
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
        $request = (new BatchUpdateAdRulesRequest())->setParent($formattedParent)->setRequests($requests);
        try {
            $gapicClient->batchUpdateAdRules($request);
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
    public function createAdRuleTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $priority = 1165461084;
        $endTimeUnlimited = false;
        $maxImpressionsPerLineItemPerStream = 953264587;
        $maxImpressionsPerLineItemPerPod = 328454224;
        $expectedResponse = new AdRule();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setPriority($priority);
        $expectedResponse->setEndTimeUnlimited($endTimeUnlimited);
        $expectedResponse->setMaxImpressionsPerLineItemPerStream($maxImpressionsPerLineItemPerStream);
        $expectedResponse->setMaxImpressionsPerLineItemPerPod($maxImpressionsPerLineItemPerPod);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $adRule = new AdRule();
        $adRuleDisplayName = 'adRuleDisplayName569340718';
        $adRule->setDisplayName($adRuleDisplayName);
        $adRuleStartTime = new Timestamp();
        $adRule->setStartTime($adRuleStartTime);
        $adRulePreroll = new AdRuleSlot();
        $adRule->setPreroll($adRulePreroll);
        $adRuleMidrolls = [];
        $adRule->setMidrolls($adRuleMidrolls);
        $adRulePostroll = new AdRuleSlot();
        $adRule->setPostroll($adRulePostroll);
        $adRuleTargeting = new Targeting();
        $adRule->setTargeting($adRuleTargeting);
        $request = (new CreateAdRuleRequest())->setParent($formattedParent)->setAdRule($adRule);
        $response = $gapicClient->createAdRule($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.AdRuleService/CreateAdRule', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getAdRule();
        $this->assertProtobufEquals($adRule, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createAdRuleExceptionTest()
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
        $adRule = new AdRule();
        $adRuleDisplayName = 'adRuleDisplayName569340718';
        $adRule->setDisplayName($adRuleDisplayName);
        $adRuleStartTime = new Timestamp();
        $adRule->setStartTime($adRuleStartTime);
        $adRulePreroll = new AdRuleSlot();
        $adRule->setPreroll($adRulePreroll);
        $adRuleMidrolls = [];
        $adRule->setMidrolls($adRuleMidrolls);
        $adRulePostroll = new AdRuleSlot();
        $adRule->setPostroll($adRulePostroll);
        $adRuleTargeting = new Targeting();
        $adRule->setTargeting($adRuleTargeting);
        $request = (new CreateAdRuleRequest())->setParent($formattedParent)->setAdRule($adRule);
        try {
            $gapicClient->createAdRule($request);
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
    public function getAdRuleTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $priority = 1165461084;
        $endTimeUnlimited = false;
        $maxImpressionsPerLineItemPerStream = 953264587;
        $maxImpressionsPerLineItemPerPod = 328454224;
        $expectedResponse = new AdRule();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setPriority($priority);
        $expectedResponse->setEndTimeUnlimited($endTimeUnlimited);
        $expectedResponse->setMaxImpressionsPerLineItemPerStream($maxImpressionsPerLineItemPerStream);
        $expectedResponse->setMaxImpressionsPerLineItemPerPod($maxImpressionsPerLineItemPerPod);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->adRuleName('[NETWORK_CODE]', '[AD_RULE]');
        $request = (new GetAdRuleRequest())->setName($formattedName);
        $response = $gapicClient->getAdRule($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.AdRuleService/GetAdRule', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getAdRuleExceptionTest()
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
        $formattedName = $gapicClient->adRuleName('[NETWORK_CODE]', '[AD_RULE]');
        $request = (new GetAdRuleRequest())->setName($formattedName);
        try {
            $gapicClient->getAdRule($request);
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
    public function listAdRulesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $totalSize = 705419236;
        $adRulesElement = new AdRule();
        $adRules = [$adRulesElement];
        $expectedResponse = new ListAdRulesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setAdRules($adRules);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $request = (new ListAdRulesRequest())->setParent($formattedParent);
        $response = $gapicClient->listAdRules($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAdRules()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.AdRuleService/ListAdRules', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listAdRulesExceptionTest()
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
        $request = (new ListAdRulesRequest())->setParent($formattedParent);
        try {
            $gapicClient->listAdRules($request);
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
    public function updateAdRuleTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $priority = 1165461084;
        $endTimeUnlimited = false;
        $maxImpressionsPerLineItemPerStream = 953264587;
        $maxImpressionsPerLineItemPerPod = 328454224;
        $expectedResponse = new AdRule();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setPriority($priority);
        $expectedResponse->setEndTimeUnlimited($endTimeUnlimited);
        $expectedResponse->setMaxImpressionsPerLineItemPerStream($maxImpressionsPerLineItemPerStream);
        $expectedResponse->setMaxImpressionsPerLineItemPerPod($maxImpressionsPerLineItemPerPod);
        $transport->addResponse($expectedResponse);
        // Mock request
        $adRule = new AdRule();
        $adRuleDisplayName = 'adRuleDisplayName569340718';
        $adRule->setDisplayName($adRuleDisplayName);
        $adRuleStartTime = new Timestamp();
        $adRule->setStartTime($adRuleStartTime);
        $adRulePreroll = new AdRuleSlot();
        $adRule->setPreroll($adRulePreroll);
        $adRuleMidrolls = [];
        $adRule->setMidrolls($adRuleMidrolls);
        $adRulePostroll = new AdRuleSlot();
        $adRule->setPostroll($adRulePostroll);
        $adRuleTargeting = new Targeting();
        $adRule->setTargeting($adRuleTargeting);
        $request = (new UpdateAdRuleRequest())->setAdRule($adRule);
        $response = $gapicClient->updateAdRule($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.AdRuleService/UpdateAdRule', $actualFuncCall);
        $actualValue = $actualRequestObject->getAdRule();
        $this->assertProtobufEquals($adRule, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateAdRuleExceptionTest()
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
        $adRule = new AdRule();
        $adRuleDisplayName = 'adRuleDisplayName569340718';
        $adRule->setDisplayName($adRuleDisplayName);
        $adRuleStartTime = new Timestamp();
        $adRule->setStartTime($adRuleStartTime);
        $adRulePreroll = new AdRuleSlot();
        $adRule->setPreroll($adRulePreroll);
        $adRuleMidrolls = [];
        $adRule->setMidrolls($adRuleMidrolls);
        $adRulePostroll = new AdRuleSlot();
        $adRule->setPostroll($adRulePostroll);
        $adRuleTargeting = new Targeting();
        $adRule->setTargeting($adRuleTargeting);
        $request = (new UpdateAdRuleRequest())->setAdRule($adRule);
        try {
            $gapicClient->updateAdRule($request);
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
    public function batchActivateAdRulesAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchActivateAdRulesResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $formattedNames = [$gapicClient->adRuleName('[NETWORK_CODE]', '[AD_RULE]')];
        $request = (new BatchActivateAdRulesRequest())->setParent($formattedParent)->setNames($formattedNames);
        $response = $gapicClient->batchActivateAdRulesAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.AdRuleService/BatchActivateAdRules', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($formattedNames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
