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

use Google\Ads\AdManager\V1\BatchActivateLineItemCreativeAssociationsRequest;
use Google\Ads\AdManager\V1\BatchActivateLineItemCreativeAssociationsResponse;
use Google\Ads\AdManager\V1\BatchCreateLineItemCreativeAssociationsRequest;
use Google\Ads\AdManager\V1\BatchCreateLineItemCreativeAssociationsResponse;
use Google\Ads\AdManager\V1\BatchDeactivateLineItemCreativeAssociationsRequest;
use Google\Ads\AdManager\V1\BatchDeactivateLineItemCreativeAssociationsResponse;
use Google\Ads\AdManager\V1\BatchDeleteLineItemCreativeAssociationsRequest;
use Google\Ads\AdManager\V1\BatchUpdateLineItemCreativeAssociationsRequest;
use Google\Ads\AdManager\V1\BatchUpdateLineItemCreativeAssociationsResponse;
use Google\Ads\AdManager\V1\Client\LineItemCreativeAssociationServiceClient;
use Google\Ads\AdManager\V1\CreateLineItemCreativeAssociationRequest;
use Google\Ads\AdManager\V1\GetLineItemCreativeAssociationRequest;
use Google\Ads\AdManager\V1\LineItemCreativeAssociation;
use Google\Ads\AdManager\V1\ListLineItemCreativeAssociationsRequest;
use Google\Ads\AdManager\V1\ListLineItemCreativeAssociationsResponse;
use Google\Ads\AdManager\V1\PreviewLineItemCreativeAssociationRequest;
use Google\Ads\AdManager\V1\PreviewLineItemCreativeAssociationResponse;
use Google\Ads\AdManager\V1\UpdateLineItemCreativeAssociationRequest;
use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group admanager
 *
 * @group gapic
 */
class LineItemCreativeAssociationServiceClientTest extends GeneratedTest
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

    /** @return LineItemCreativeAssociationServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new LineItemCreativeAssociationServiceClient($options);
    }

    /** @test */
    public function batchActivateLineItemCreativeAssociationsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchActivateLineItemCreativeAssociationsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->lineItemName('[NETWORK_CODE]', '[LINE_ITEM]');
        $formattedNames = [
            $gapicClient->lineItemCreativeAssociationName('[NETWORK_CODE]', '[LINE_ITEM]', '[CREATIVE]'),
        ];
        $request = (new BatchActivateLineItemCreativeAssociationsRequest())
            ->setParent($formattedParent)
            ->setNames($formattedNames);
        $response = $gapicClient->batchActivateLineItemCreativeAssociations($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.LineItemCreativeAssociationService/BatchActivateLineItemCreativeAssociations',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($formattedNames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchActivateLineItemCreativeAssociationsExceptionTest()
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
        $formattedParent = $gapicClient->lineItemName('[NETWORK_CODE]', '[LINE_ITEM]');
        $formattedNames = [
            $gapicClient->lineItemCreativeAssociationName('[NETWORK_CODE]', '[LINE_ITEM]', '[CREATIVE]'),
        ];
        $request = (new BatchActivateLineItemCreativeAssociationsRequest())
            ->setParent($formattedParent)
            ->setNames($formattedNames);
        try {
            $gapicClient->batchActivateLineItemCreativeAssociations($request);
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
    public function batchCreateLineItemCreativeAssociationsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchCreateLineItemCreativeAssociationsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->lineItemName('[NETWORK_CODE]', '[LINE_ITEM]');
        $requests = [];
        $request = (new BatchCreateLineItemCreativeAssociationsRequest())
            ->setParent($formattedParent)
            ->setRequests($requests);
        $response = $gapicClient->batchCreateLineItemCreativeAssociations($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.LineItemCreativeAssociationService/BatchCreateLineItemCreativeAssociations',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchCreateLineItemCreativeAssociationsExceptionTest()
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
        $formattedParent = $gapicClient->lineItemName('[NETWORK_CODE]', '[LINE_ITEM]');
        $requests = [];
        $request = (new BatchCreateLineItemCreativeAssociationsRequest())
            ->setParent($formattedParent)
            ->setRequests($requests);
        try {
            $gapicClient->batchCreateLineItemCreativeAssociations($request);
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
    public function batchDeactivateLineItemCreativeAssociationsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchDeactivateLineItemCreativeAssociationsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->lineItemName('[NETWORK_CODE]', '[LINE_ITEM]');
        $formattedNames = [
            $gapicClient->lineItemCreativeAssociationName('[NETWORK_CODE]', '[LINE_ITEM]', '[CREATIVE]'),
        ];
        $request = (new BatchDeactivateLineItemCreativeAssociationsRequest())
            ->setParent($formattedParent)
            ->setNames($formattedNames);
        $response = $gapicClient->batchDeactivateLineItemCreativeAssociations($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.LineItemCreativeAssociationService/BatchDeactivateLineItemCreativeAssociations',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($formattedNames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchDeactivateLineItemCreativeAssociationsExceptionTest()
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
        $formattedParent = $gapicClient->lineItemName('[NETWORK_CODE]', '[LINE_ITEM]');
        $formattedNames = [
            $gapicClient->lineItemCreativeAssociationName('[NETWORK_CODE]', '[LINE_ITEM]', '[CREATIVE]'),
        ];
        $request = (new BatchDeactivateLineItemCreativeAssociationsRequest())
            ->setParent($formattedParent)
            ->setNames($formattedNames);
        try {
            $gapicClient->batchDeactivateLineItemCreativeAssociations($request);
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
    public function batchDeleteLineItemCreativeAssociationsTest()
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
        $formattedParent = $gapicClient->lineItemName('[NETWORK_CODE]', '[LINE_ITEM]');
        $formattedNames = [
            $gapicClient->lineItemCreativeAssociationName('[NETWORK_CODE]', '[LINE_ITEM]', '[CREATIVE]'),
        ];
        $request = (new BatchDeleteLineItemCreativeAssociationsRequest())
            ->setParent($formattedParent)
            ->setNames($formattedNames);
        $gapicClient->batchDeleteLineItemCreativeAssociations($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.LineItemCreativeAssociationService/BatchDeleteLineItemCreativeAssociations',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($formattedNames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchDeleteLineItemCreativeAssociationsExceptionTest()
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
        $formattedParent = $gapicClient->lineItemName('[NETWORK_CODE]', '[LINE_ITEM]');
        $formattedNames = [
            $gapicClient->lineItemCreativeAssociationName('[NETWORK_CODE]', '[LINE_ITEM]', '[CREATIVE]'),
        ];
        $request = (new BatchDeleteLineItemCreativeAssociationsRequest())
            ->setParent($formattedParent)
            ->setNames($formattedNames);
        try {
            $gapicClient->batchDeleteLineItemCreativeAssociations($request);
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
    public function batchUpdateLineItemCreativeAssociationsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchUpdateLineItemCreativeAssociationsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->lineItemName('[NETWORK_CODE]', '[LINE_ITEM]');
        $requests = [];
        $request = (new BatchUpdateLineItemCreativeAssociationsRequest())
            ->setParent($formattedParent)
            ->setRequests($requests);
        $response = $gapicClient->batchUpdateLineItemCreativeAssociations($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.LineItemCreativeAssociationService/BatchUpdateLineItemCreativeAssociations',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchUpdateLineItemCreativeAssociationsExceptionTest()
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
        $formattedParent = $gapicClient->lineItemName('[NETWORK_CODE]', '[LINE_ITEM]');
        $requests = [];
        $request = (new BatchUpdateLineItemCreativeAssociationsRequest())
            ->setParent($formattedParent)
            ->setRequests($requests);
        try {
            $gapicClient->batchUpdateLineItemCreativeAssociations($request);
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
    public function createLineItemCreativeAssociationTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $lineItem = 'lineItem-1796383618';
        $creative = 'creative1820422063';
        $creativeSet = 'creativeSet1778445266';
        $destinationUrl = 'destinationUrl-1762229826';
        $manualCreativeRotationWeight = 1.23697667e8;
        $sequentialCreativeRotationIndex = 365271007;
        $targetingDisplayName = 'targetingDisplayName-1628527434';
        $expectedResponse = new LineItemCreativeAssociation();
        $expectedResponse->setName($name);
        $expectedResponse->setLineItem($lineItem);
        $expectedResponse->setCreative($creative);
        $expectedResponse->setCreativeSet($creativeSet);
        $expectedResponse->setDestinationUrl($destinationUrl);
        $expectedResponse->setManualCreativeRotationWeight($manualCreativeRotationWeight);
        $expectedResponse->setSequentialCreativeRotationIndex($sequentialCreativeRotationIndex);
        $expectedResponse->setTargetingDisplayName($targetingDisplayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->lineItemName('[NETWORK_CODE]', '[LINE_ITEM]');
        $lineItemCreativeAssociation = new LineItemCreativeAssociation();
        $lineItemCreativeAssociationLineItem = $gapicClient->lineItemName('[NETWORK_CODE]', '[LINE_ITEM]');
        $lineItemCreativeAssociation->setLineItem($lineItemCreativeAssociationLineItem);
        $request = (new CreateLineItemCreativeAssociationRequest())
            ->setParent($formattedParent)
            ->setLineItemCreativeAssociation($lineItemCreativeAssociation);
        $response = $gapicClient->createLineItemCreativeAssociation($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.LineItemCreativeAssociationService/CreateLineItemCreativeAssociation',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getLineItemCreativeAssociation();
        $this->assertProtobufEquals($lineItemCreativeAssociation, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createLineItemCreativeAssociationExceptionTest()
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
        $formattedParent = $gapicClient->lineItemName('[NETWORK_CODE]', '[LINE_ITEM]');
        $lineItemCreativeAssociation = new LineItemCreativeAssociation();
        $lineItemCreativeAssociationLineItem = $gapicClient->lineItemName('[NETWORK_CODE]', '[LINE_ITEM]');
        $lineItemCreativeAssociation->setLineItem($lineItemCreativeAssociationLineItem);
        $request = (new CreateLineItemCreativeAssociationRequest())
            ->setParent($formattedParent)
            ->setLineItemCreativeAssociation($lineItemCreativeAssociation);
        try {
            $gapicClient->createLineItemCreativeAssociation($request);
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
    public function getLineItemCreativeAssociationTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $lineItem = 'lineItem-1796383618';
        $creative = 'creative1820422063';
        $creativeSet = 'creativeSet1778445266';
        $destinationUrl = 'destinationUrl-1762229826';
        $manualCreativeRotationWeight = 1.23697667e8;
        $sequentialCreativeRotationIndex = 365271007;
        $targetingDisplayName = 'targetingDisplayName-1628527434';
        $expectedResponse = new LineItemCreativeAssociation();
        $expectedResponse->setName($name2);
        $expectedResponse->setLineItem($lineItem);
        $expectedResponse->setCreative($creative);
        $expectedResponse->setCreativeSet($creativeSet);
        $expectedResponse->setDestinationUrl($destinationUrl);
        $expectedResponse->setManualCreativeRotationWeight($manualCreativeRotationWeight);
        $expectedResponse->setSequentialCreativeRotationIndex($sequentialCreativeRotationIndex);
        $expectedResponse->setTargetingDisplayName($targetingDisplayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->lineItemCreativeAssociationName('[NETWORK_CODE]', '[LINE_ITEM]', '[CREATIVE]');
        $request = (new GetLineItemCreativeAssociationRequest())->setName($formattedName);
        $response = $gapicClient->getLineItemCreativeAssociation($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.LineItemCreativeAssociationService/GetLineItemCreativeAssociation',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getLineItemCreativeAssociationExceptionTest()
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
        $formattedName = $gapicClient->lineItemCreativeAssociationName('[NETWORK_CODE]', '[LINE_ITEM]', '[CREATIVE]');
        $request = (new GetLineItemCreativeAssociationRequest())->setName($formattedName);
        try {
            $gapicClient->getLineItemCreativeAssociation($request);
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
    public function listLineItemCreativeAssociationsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $totalSize = 705419236;
        $lineItemCreativeAssociationsElement = new LineItemCreativeAssociation();
        $lineItemCreativeAssociations = [$lineItemCreativeAssociationsElement];
        $expectedResponse = new ListLineItemCreativeAssociationsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setLineItemCreativeAssociations($lineItemCreativeAssociations);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->lineItemName('[NETWORK_CODE]', '[LINE_ITEM]');
        $request = (new ListLineItemCreativeAssociationsRequest())->setParent($formattedParent);
        $response = $gapicClient->listLineItemCreativeAssociations($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getLineItemCreativeAssociations()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.LineItemCreativeAssociationService/ListLineItemCreativeAssociations',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listLineItemCreativeAssociationsExceptionTest()
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
        $formattedParent = $gapicClient->lineItemName('[NETWORK_CODE]', '[LINE_ITEM]');
        $request = (new ListLineItemCreativeAssociationsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listLineItemCreativeAssociations($request);
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
    public function previewLineItemCreativeAssociationTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new PreviewLineItemCreativeAssociationResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->lineItemCreativeAssociationName('[NETWORK_CODE]', '[LINE_ITEM]', '[CREATIVE]');
        $siteUrl = 'siteUrl675534967';
        $request = (new PreviewLineItemCreativeAssociationRequest())->setName($formattedName)->setSiteUrl($siteUrl);
        $response = $gapicClient->previewLineItemCreativeAssociation($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.LineItemCreativeAssociationService/PreviewLineItemCreativeAssociation',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $actualValue = $actualRequestObject->getSiteUrl();
        $this->assertProtobufEquals($siteUrl, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function previewLineItemCreativeAssociationExceptionTest()
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
        $formattedName = $gapicClient->lineItemCreativeAssociationName('[NETWORK_CODE]', '[LINE_ITEM]', '[CREATIVE]');
        $siteUrl = 'siteUrl675534967';
        $request = (new PreviewLineItemCreativeAssociationRequest())->setName($formattedName)->setSiteUrl($siteUrl);
        try {
            $gapicClient->previewLineItemCreativeAssociation($request);
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
    public function updateLineItemCreativeAssociationTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $lineItem = 'lineItem-1796383618';
        $creative = 'creative1820422063';
        $creativeSet = 'creativeSet1778445266';
        $destinationUrl = 'destinationUrl-1762229826';
        $manualCreativeRotationWeight = 1.23697667e8;
        $sequentialCreativeRotationIndex = 365271007;
        $targetingDisplayName = 'targetingDisplayName-1628527434';
        $expectedResponse = new LineItemCreativeAssociation();
        $expectedResponse->setName($name);
        $expectedResponse->setLineItem($lineItem);
        $expectedResponse->setCreative($creative);
        $expectedResponse->setCreativeSet($creativeSet);
        $expectedResponse->setDestinationUrl($destinationUrl);
        $expectedResponse->setManualCreativeRotationWeight($manualCreativeRotationWeight);
        $expectedResponse->setSequentialCreativeRotationIndex($sequentialCreativeRotationIndex);
        $expectedResponse->setTargetingDisplayName($targetingDisplayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $lineItemCreativeAssociation = new LineItemCreativeAssociation();
        $lineItemCreativeAssociationLineItem = $gapicClient->lineItemName('[NETWORK_CODE]', '[LINE_ITEM]');
        $lineItemCreativeAssociation->setLineItem($lineItemCreativeAssociationLineItem);
        $request = (new UpdateLineItemCreativeAssociationRequest())->setLineItemCreativeAssociation(
            $lineItemCreativeAssociation
        );
        $response = $gapicClient->updateLineItemCreativeAssociation($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.LineItemCreativeAssociationService/UpdateLineItemCreativeAssociation',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getLineItemCreativeAssociation();
        $this->assertProtobufEquals($lineItemCreativeAssociation, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateLineItemCreativeAssociationExceptionTest()
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
        $lineItemCreativeAssociation = new LineItemCreativeAssociation();
        $lineItemCreativeAssociationLineItem = $gapicClient->lineItemName('[NETWORK_CODE]', '[LINE_ITEM]');
        $lineItemCreativeAssociation->setLineItem($lineItemCreativeAssociationLineItem);
        $request = (new UpdateLineItemCreativeAssociationRequest())->setLineItemCreativeAssociation(
            $lineItemCreativeAssociation
        );
        try {
            $gapicClient->updateLineItemCreativeAssociation($request);
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
    public function batchActivateLineItemCreativeAssociationsAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchActivateLineItemCreativeAssociationsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->lineItemName('[NETWORK_CODE]', '[LINE_ITEM]');
        $formattedNames = [
            $gapicClient->lineItemCreativeAssociationName('[NETWORK_CODE]', '[LINE_ITEM]', '[CREATIVE]'),
        ];
        $request = (new BatchActivateLineItemCreativeAssociationsRequest())
            ->setParent($formattedParent)
            ->setNames($formattedNames);
        $response = $gapicClient->batchActivateLineItemCreativeAssociationsAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.ads.admanager.v1.LineItemCreativeAssociationService/BatchActivateLineItemCreativeAssociations',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getNames();
        $this->assertProtobufEquals($formattedNames, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
