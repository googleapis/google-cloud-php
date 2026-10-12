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

use Google\Ads\AdManager\V1\BatchActivateCreativeWrappersRequest;
use Google\Ads\AdManager\V1\BatchActivateCreativeWrappersResponse;
use Google\Ads\AdManager\V1\BatchCreateCreativeWrappersRequest;
use Google\Ads\AdManager\V1\BatchCreateCreativeWrappersResponse;
use Google\Ads\AdManager\V1\BatchDeactivateCreativeWrappersRequest;
use Google\Ads\AdManager\V1\BatchDeactivateCreativeWrappersResponse;
use Google\Ads\AdManager\V1\BatchUpdateCreativeWrappersRequest;
use Google\Ads\AdManager\V1\BatchUpdateCreativeWrappersResponse;
use Google\Ads\AdManager\V1\Client\CreativeWrapperServiceClient;
use Google\Ads\AdManager\V1\CreateCreativeWrapperRequest;
use Google\Ads\AdManager\V1\CreativeWrapper;
use Google\Ads\AdManager\V1\CreativeWrapperTypeEnum\CreativeWrapperType;
use Google\Ads\AdManager\V1\GetCreativeWrapperRequest;
use Google\Ads\AdManager\V1\ListCreativeWrappersRequest;
use Google\Ads\AdManager\V1\ListCreativeWrappersResponse;
use Google\Ads\AdManager\V1\UpdateCreativeWrapperRequest;
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
class CreativeWrapperServiceClientTest extends GeneratedTest
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

    /** @return CreativeWrapperServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new CreativeWrapperServiceClient($options);
    }

    /** @test */
    public function batchActivateCreativeWrappersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchActivateCreativeWrappersResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $formattedNames = [$gapicClient->creativeWrapperName('[NETWORK_CODE]', '[CREATIVE_WRAPPER]')];
        $request = (new BatchActivateCreativeWrappersRequest())->setParent($formattedParent)->setNames($formattedNames);
        $response = $gapicClient->batchActivateCreativeWrappers($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.CreativeWrapperService/BatchActivateCreativeWrappers',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($formattedNames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchActivateCreativeWrappersExceptionTest()
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
        $formattedNames = [$gapicClient->creativeWrapperName('[NETWORK_CODE]', '[CREATIVE_WRAPPER]')];
        $request = (new BatchActivateCreativeWrappersRequest())->setParent($formattedParent)->setNames($formattedNames);
        try {
            $gapicClient->batchActivateCreativeWrappers($request);
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
    public function batchCreateCreativeWrappersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchCreateCreativeWrappersResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchCreateCreativeWrappersRequest())->setParent($formattedParent)->setRequests($requests);
        $response = $gapicClient->batchCreateCreativeWrappers($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.CreativeWrapperService/BatchCreateCreativeWrappers',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchCreateCreativeWrappersExceptionTest()
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
        $request = (new BatchCreateCreativeWrappersRequest())->setParent($formattedParent)->setRequests($requests);
        try {
            $gapicClient->batchCreateCreativeWrappers($request);
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
    public function batchDeactivateCreativeWrappersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchDeactivateCreativeWrappersResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $formattedNames = [$gapicClient->creativeWrapperName('[NETWORK_CODE]', '[CREATIVE_WRAPPER]')];
        $request = (new BatchDeactivateCreativeWrappersRequest())
            ->setParent($formattedParent)
            ->setNames($formattedNames);
        $response = $gapicClient->batchDeactivateCreativeWrappers($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.CreativeWrapperService/BatchDeactivateCreativeWrappers',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($formattedNames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchDeactivateCreativeWrappersExceptionTest()
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
        $formattedNames = [$gapicClient->creativeWrapperName('[NETWORK_CODE]', '[CREATIVE_WRAPPER]')];
        $request = (new BatchDeactivateCreativeWrappersRequest())
            ->setParent($formattedParent)
            ->setNames($formattedNames);
        try {
            $gapicClient->batchDeactivateCreativeWrappers($request);
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
    public function batchUpdateCreativeWrappersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchUpdateCreativeWrappersResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchUpdateCreativeWrappersRequest())->setParent($formattedParent)->setRequests($requests);
        $response = $gapicClient->batchUpdateCreativeWrappers($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.CreativeWrapperService/BatchUpdateCreativeWrappers',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchUpdateCreativeWrappersExceptionTest()
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
        $request = (new BatchUpdateCreativeWrappersRequest())->setParent($formattedParent)->setRequests($requests);
        try {
            $gapicClient->batchUpdateCreativeWrappers($request);
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
    public function createCreativeWrapperTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $label = 'label102727412';
        $headerCreative = 'headerCreative-142389983';
        $footerCreative = 'footerCreative-1665463853';
        $htmlHeader = 'htmlHeader2063004065';
        $htmlFooter = 'htmlFooter2015413423';
        $ampHeader = 'ampHeader2082447720';
        $ampFooter = 'ampFooter2034857078';
        $expectedResponse = new CreativeWrapper();
        $expectedResponse->setName($name);
        $expectedResponse->setLabel($label);
        $expectedResponse->setHeaderCreative($headerCreative);
        $expectedResponse->setFooterCreative($footerCreative);
        $expectedResponse->setHtmlHeader($htmlHeader);
        $expectedResponse->setHtmlFooter($htmlFooter);
        $expectedResponse->setAmpHeader($ampHeader);
        $expectedResponse->setAmpFooter($ampFooter);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $creativeWrapper = new CreativeWrapper();
        $creativeWrapperLabel = $gapicClient->labelName('[NETWORK_CODE]', '[LABEL]');
        $creativeWrapper->setLabel($creativeWrapperLabel);
        $creativeWrapperCreativeWrapperType = CreativeWrapperType::CREATIVE_WRAPPER_TYPE_UNSPECIFIED;
        $creativeWrapper->setCreativeWrapperType($creativeWrapperCreativeWrapperType);
        $request = (new CreateCreativeWrapperRequest())
            ->setParent($formattedParent)
            ->setCreativeWrapper($creativeWrapper);
        $response = $gapicClient->createCreativeWrapper($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.CreativeWrapperService/CreateCreativeWrapper', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getCreativeWrapper();
        $this->assertProtobufEquals($creativeWrapper, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createCreativeWrapperExceptionTest()
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
        $creativeWrapper = new CreativeWrapper();
        $creativeWrapperLabel = $gapicClient->labelName('[NETWORK_CODE]', '[LABEL]');
        $creativeWrapper->setLabel($creativeWrapperLabel);
        $creativeWrapperCreativeWrapperType = CreativeWrapperType::CREATIVE_WRAPPER_TYPE_UNSPECIFIED;
        $creativeWrapper->setCreativeWrapperType($creativeWrapperCreativeWrapperType);
        $request = (new CreateCreativeWrapperRequest())
            ->setParent($formattedParent)
            ->setCreativeWrapper($creativeWrapper);
        try {
            $gapicClient->createCreativeWrapper($request);
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
    public function getCreativeWrapperTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $label = 'label102727412';
        $headerCreative = 'headerCreative-142389983';
        $footerCreative = 'footerCreative-1665463853';
        $htmlHeader = 'htmlHeader2063004065';
        $htmlFooter = 'htmlFooter2015413423';
        $ampHeader = 'ampHeader2082447720';
        $ampFooter = 'ampFooter2034857078';
        $expectedResponse = new CreativeWrapper();
        $expectedResponse->setName($name2);
        $expectedResponse->setLabel($label);
        $expectedResponse->setHeaderCreative($headerCreative);
        $expectedResponse->setFooterCreative($footerCreative);
        $expectedResponse->setHtmlHeader($htmlHeader);
        $expectedResponse->setHtmlFooter($htmlFooter);
        $expectedResponse->setAmpHeader($ampHeader);
        $expectedResponse->setAmpFooter($ampFooter);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->creativeWrapperName('[NETWORK_CODE]', '[CREATIVE_WRAPPER]');
        $request = (new GetCreativeWrapperRequest())->setName($formattedName);
        $response = $gapicClient->getCreativeWrapper($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.CreativeWrapperService/GetCreativeWrapper', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getCreativeWrapperExceptionTest()
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
        $formattedName = $gapicClient->creativeWrapperName('[NETWORK_CODE]', '[CREATIVE_WRAPPER]');
        $request = (new GetCreativeWrapperRequest())->setName($formattedName);
        try {
            $gapicClient->getCreativeWrapper($request);
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
    public function listCreativeWrappersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $totalSize = 705419236;
        $creativeWrappersElement = new CreativeWrapper();
        $creativeWrappers = [$creativeWrappersElement];
        $expectedResponse = new ListCreativeWrappersResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setCreativeWrappers($creativeWrappers);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $request = (new ListCreativeWrappersRequest())->setParent($formattedParent);
        $response = $gapicClient->listCreativeWrappers($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCreativeWrappers()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.CreativeWrapperService/ListCreativeWrappers', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listCreativeWrappersExceptionTest()
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
        $request = (new ListCreativeWrappersRequest())->setParent($formattedParent);
        try {
            $gapicClient->listCreativeWrappers($request);
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
    public function updateCreativeWrapperTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $label = 'label102727412';
        $headerCreative = 'headerCreative-142389983';
        $footerCreative = 'footerCreative-1665463853';
        $htmlHeader = 'htmlHeader2063004065';
        $htmlFooter = 'htmlFooter2015413423';
        $ampHeader = 'ampHeader2082447720';
        $ampFooter = 'ampFooter2034857078';
        $expectedResponse = new CreativeWrapper();
        $expectedResponse->setName($name);
        $expectedResponse->setLabel($label);
        $expectedResponse->setHeaderCreative($headerCreative);
        $expectedResponse->setFooterCreative($footerCreative);
        $expectedResponse->setHtmlHeader($htmlHeader);
        $expectedResponse->setHtmlFooter($htmlFooter);
        $expectedResponse->setAmpHeader($ampHeader);
        $expectedResponse->setAmpFooter($ampFooter);
        $transport->addResponse($expectedResponse);
        // Mock request
        $creativeWrapper = new CreativeWrapper();
        $creativeWrapperLabel = $gapicClient->labelName('[NETWORK_CODE]', '[LABEL]');
        $creativeWrapper->setLabel($creativeWrapperLabel);
        $creativeWrapperCreativeWrapperType = CreativeWrapperType::CREATIVE_WRAPPER_TYPE_UNSPECIFIED;
        $creativeWrapper->setCreativeWrapperType($creativeWrapperCreativeWrapperType);
        $request = (new UpdateCreativeWrapperRequest())->setCreativeWrapper($creativeWrapper);
        $response = $gapicClient->updateCreativeWrapper($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.CreativeWrapperService/UpdateCreativeWrapper', $actualFuncCall);
        $actualValue = $actualRequestObject->getCreativeWrapper();
        $this->assertProtobufEquals($creativeWrapper, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateCreativeWrapperExceptionTest()
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
        $creativeWrapper = new CreativeWrapper();
        $creativeWrapperLabel = $gapicClient->labelName('[NETWORK_CODE]', '[LABEL]');
        $creativeWrapper->setLabel($creativeWrapperLabel);
        $creativeWrapperCreativeWrapperType = CreativeWrapperType::CREATIVE_WRAPPER_TYPE_UNSPECIFIED;
        $creativeWrapper->setCreativeWrapperType($creativeWrapperCreativeWrapperType);
        $request = (new UpdateCreativeWrapperRequest())->setCreativeWrapper($creativeWrapper);
        try {
            $gapicClient->updateCreativeWrapper($request);
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
    public function batchActivateCreativeWrappersAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchActivateCreativeWrappersResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $formattedNames = [$gapicClient->creativeWrapperName('[NETWORK_CODE]', '[CREATIVE_WRAPPER]')];
        $request = (new BatchActivateCreativeWrappersRequest())->setParent($formattedParent)->setNames($formattedNames);
        $response = $gapicClient->batchActivateCreativeWrappersAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.CreativeWrapperService/BatchActivateCreativeWrappers',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($formattedNames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
