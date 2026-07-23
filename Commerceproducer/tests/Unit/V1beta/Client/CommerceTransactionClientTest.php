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

namespace Google\Cloud\Commerceproducer\Tests\Unit\V1beta\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Commerceproducer\V1beta\CancelPrivateOfferRequest;
use Google\Cloud\Commerceproducer\V1beta\Client\CommerceTransactionClient;
use Google\Cloud\Commerceproducer\V1beta\CreatePrivateOfferDocumentRequest;
use Google\Cloud\Commerceproducer\V1beta\CreatePrivateOfferRequest;
use Google\Cloud\Commerceproducer\V1beta\DeletePrivateOfferDocumentRequest;
use Google\Cloud\Commerceproducer\V1beta\DeletePrivateOfferRequest;
use Google\Cloud\Commerceproducer\V1beta\GetPrivateOfferDocumentRequest;
use Google\Cloud\Commerceproducer\V1beta\GetPrivateOfferRequest;
use Google\Cloud\Commerceproducer\V1beta\GetServiceRequest;
use Google\Cloud\Commerceproducer\V1beta\GetSkuGroupRequest;
use Google\Cloud\Commerceproducer\V1beta\GetSkuRequest;
use Google\Cloud\Commerceproducer\V1beta\GetStandardOfferRequest;
use Google\Cloud\Commerceproducer\V1beta\ListPrivateOfferDocumentsRequest;
use Google\Cloud\Commerceproducer\V1beta\ListPrivateOfferDocumentsResponse;
use Google\Cloud\Commerceproducer\V1beta\ListPrivateOffersRequest;
use Google\Cloud\Commerceproducer\V1beta\ListPrivateOffersResponse;
use Google\Cloud\Commerceproducer\V1beta\ListServicesRequest;
use Google\Cloud\Commerceproducer\V1beta\ListServicesResponse;
use Google\Cloud\Commerceproducer\V1beta\ListSkuGroupsRequest;
use Google\Cloud\Commerceproducer\V1beta\ListSkuGroupsResponse;
use Google\Cloud\Commerceproducer\V1beta\ListSkusRequest;
use Google\Cloud\Commerceproducer\V1beta\ListSkusResponse;
use Google\Cloud\Commerceproducer\V1beta\ListStandardOffersRequest;
use Google\Cloud\Commerceproducer\V1beta\ListStandardOffersResponse;
use Google\Cloud\Commerceproducer\V1beta\PrivateOffer;
use Google\Cloud\Commerceproducer\V1beta\PrivateOfferDocument;
use Google\Cloud\Commerceproducer\V1beta\PrivateOfferDocument\DocumentType;
use Google\Cloud\Commerceproducer\V1beta\PublishPrivateOfferRequest;
use Google\Cloud\Commerceproducer\V1beta\ResolveAmendmentTargetRequest;
use Google\Cloud\Commerceproducer\V1beta\ResolveAmendmentTargetResponse;
use Google\Cloud\Commerceproducer\V1beta\Service;
use Google\Cloud\Commerceproducer\V1beta\Sku;
use Google\Cloud\Commerceproducer\V1beta\SkuGroup;
use Google\Cloud\Commerceproducer\V1beta\StandardOffer;
use Google\Cloud\Commerceproducer\V1beta\UpdatePrivateOfferDocumentRequest;
use Google\Cloud\Commerceproducer\V1beta\UpdatePrivateOfferRequest;
use Google\Cloud\Location\GetLocationRequest;
use Google\Cloud\Location\ListLocationsRequest;
use Google\Cloud\Location\ListLocationsResponse;
use Google\Cloud\Location\Location;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group commerceproducer
 *
 * @group gapic
 */
class CommerceTransactionClientTest extends GeneratedTest
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

    /** @return CommerceTransactionClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new CommerceTransactionClient($options);
    }

    /** @test */
    public function cancelPrivateOfferTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $cancellationNote2 = 'cancellationNote2686711265';
        $internalNote = 'internalNote1826508852';
        $title = 'title110371416';
        $customerNote = 'customerNote-2143804493';
        $expectedResponse = new PrivateOffer();
        $expectedResponse->setName($name2);
        $expectedResponse->setCancellationNote($cancellationNote2);
        $expectedResponse->setInternalNote($internalNote);
        $expectedResponse->setTitle($title);
        $expectedResponse->setCustomerNote($customerNote);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->privateOfferName('[PROJECT]', '[LOCATION]', '[PRIVATE_OFFER]');
        $request = (new CancelPrivateOfferRequest())->setName($formattedName);
        $response = $gapicClient->cancelPrivateOffer($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.commerceproducer.v1beta.CommerceTransaction/CancelPrivateOffer',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function cancelPrivateOfferExceptionTest()
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
        $formattedName = $gapicClient->privateOfferName('[PROJECT]', '[LOCATION]', '[PRIVATE_OFFER]');
        $request = (new CancelPrivateOfferRequest())->setName($formattedName);
        try {
            $gapicClient->cancelPrivateOffer($request);
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
    public function createPrivateOfferTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $cancellationNote = 'cancellationNote-750122578';
        $internalNote = 'internalNote1826508852';
        $title = 'title110371416';
        $customerNote = 'customerNote-2143804493';
        $expectedResponse = new PrivateOffer();
        $expectedResponse->setName($name);
        $expectedResponse->setCancellationNote($cancellationNote);
        $expectedResponse->setInternalNote($internalNote);
        $expectedResponse->setTitle($title);
        $expectedResponse->setCustomerNote($customerNote);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $privateOffer = new PrivateOffer();
        $request = (new CreatePrivateOfferRequest())->setParent($formattedParent)->setPrivateOffer($privateOffer);
        $response = $gapicClient->createPrivateOffer($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.commerceproducer.v1beta.CommerceTransaction/CreatePrivateOffer',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getPrivateOffer();
        $this->assertProtobufEquals($privateOffer, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createPrivateOfferExceptionTest()
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $privateOffer = new PrivateOffer();
        $request = (new CreatePrivateOfferRequest())->setParent($formattedParent)->setPrivateOffer($privateOffer);
        try {
            $gapicClient->createPrivateOffer($request);
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
    public function createPrivateOfferDocumentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $inlineContent = '-45';
        $name = 'name3373707';
        $mimeType = 'mimeType-196041627';
        $expectedResponse = new PrivateOfferDocument();
        $expectedResponse->setInlineContent($inlineContent);
        $expectedResponse->setName($name);
        $expectedResponse->setMimeType($mimeType);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->privateOfferName('[PROJECT]', '[LOCATION]', '[PRIVATE_OFFER]');
        $privateOfferDocument = new PrivateOfferDocument();
        $privateOfferDocumentDocumentType = DocumentType::DOCUMENT_TYPE_UNSPECIFIED;
        $privateOfferDocument->setDocumentType($privateOfferDocumentDocumentType);
        $request = (new CreatePrivateOfferDocumentRequest())
            ->setParent($formattedParent)
            ->setPrivateOfferDocument($privateOfferDocument);
        $response = $gapicClient->createPrivateOfferDocument($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.commerceproducer.v1beta.CommerceTransaction/CreatePrivateOfferDocument',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getPrivateOfferDocument();
        $this->assertProtobufEquals($privateOfferDocument, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createPrivateOfferDocumentExceptionTest()
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
        $formattedParent = $gapicClient->privateOfferName('[PROJECT]', '[LOCATION]', '[PRIVATE_OFFER]');
        $privateOfferDocument = new PrivateOfferDocument();
        $privateOfferDocumentDocumentType = DocumentType::DOCUMENT_TYPE_UNSPECIFIED;
        $privateOfferDocument->setDocumentType($privateOfferDocumentDocumentType);
        $request = (new CreatePrivateOfferDocumentRequest())
            ->setParent($formattedParent)
            ->setPrivateOfferDocument($privateOfferDocument);
        try {
            $gapicClient->createPrivateOfferDocument($request);
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
    public function deletePrivateOfferTest()
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
        $formattedName = $gapicClient->privateOfferName('[PROJECT]', '[LOCATION]', '[PRIVATE_OFFER]');
        $request = (new DeletePrivateOfferRequest())->setName($formattedName);
        $gapicClient->deletePrivateOffer($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.commerceproducer.v1beta.CommerceTransaction/DeletePrivateOffer',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deletePrivateOfferExceptionTest()
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
        $formattedName = $gapicClient->privateOfferName('[PROJECT]', '[LOCATION]', '[PRIVATE_OFFER]');
        $request = (new DeletePrivateOfferRequest())->setName($formattedName);
        try {
            $gapicClient->deletePrivateOffer($request);
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
    public function deletePrivateOfferDocumentTest()
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
        $formattedName = $gapicClient->privateOfferDocumentName(
            '[PROJECT]',
            '[LOCATION]',
            '[PRIVATE_OFFER]',
            '[DOCUMENT]'
        );
        $request = (new DeletePrivateOfferDocumentRequest())->setName($formattedName);
        $gapicClient->deletePrivateOfferDocument($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.commerceproducer.v1beta.CommerceTransaction/DeletePrivateOfferDocument',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deletePrivateOfferDocumentExceptionTest()
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
        $formattedName = $gapicClient->privateOfferDocumentName(
            '[PROJECT]',
            '[LOCATION]',
            '[PRIVATE_OFFER]',
            '[DOCUMENT]'
        );
        $request = (new DeletePrivateOfferDocumentRequest())->setName($formattedName);
        try {
            $gapicClient->deletePrivateOfferDocument($request);
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
    public function getPrivateOfferTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $cancellationNote = 'cancellationNote-750122578';
        $internalNote = 'internalNote1826508852';
        $title = 'title110371416';
        $customerNote = 'customerNote-2143804493';
        $expectedResponse = new PrivateOffer();
        $expectedResponse->setName($name2);
        $expectedResponse->setCancellationNote($cancellationNote);
        $expectedResponse->setInternalNote($internalNote);
        $expectedResponse->setTitle($title);
        $expectedResponse->setCustomerNote($customerNote);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->privateOfferName('[PROJECT]', '[LOCATION]', '[PRIVATE_OFFER]');
        $request = (new GetPrivateOfferRequest())->setName($formattedName);
        $response = $gapicClient->getPrivateOffer($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.commerceproducer.v1beta.CommerceTransaction/GetPrivateOffer', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getPrivateOfferExceptionTest()
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
        $formattedName = $gapicClient->privateOfferName('[PROJECT]', '[LOCATION]', '[PRIVATE_OFFER]');
        $request = (new GetPrivateOfferRequest())->setName($formattedName);
        try {
            $gapicClient->getPrivateOffer($request);
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
    public function getPrivateOfferDocumentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $inlineContent = '-45';
        $name2 = 'name2-1052831874';
        $mimeType = 'mimeType-196041627';
        $expectedResponse = new PrivateOfferDocument();
        $expectedResponse->setInlineContent($inlineContent);
        $expectedResponse->setName($name2);
        $expectedResponse->setMimeType($mimeType);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->privateOfferDocumentName(
            '[PROJECT]',
            '[LOCATION]',
            '[PRIVATE_OFFER]',
            '[DOCUMENT]'
        );
        $request = (new GetPrivateOfferDocumentRequest())->setName($formattedName);
        $response = $gapicClient->getPrivateOfferDocument($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.commerceproducer.v1beta.CommerceTransaction/GetPrivateOfferDocument',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getPrivateOfferDocumentExceptionTest()
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
        $formattedName = $gapicClient->privateOfferDocumentName(
            '[PROJECT]',
            '[LOCATION]',
            '[PRIVATE_OFFER]',
            '[DOCUMENT]'
        );
        $request = (new GetPrivateOfferDocumentRequest())->setName($formattedName);
        try {
            $gapicClient->getPrivateOfferDocument($request);
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
    public function getServiceTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $title = 'title110371416';
        $expectedResponse = new Service();
        $expectedResponse->setName($name2);
        $expectedResponse->setTitle($title);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->serviceName('[PROJECT]', '[LOCATION]', '[SERVICE]');
        $request = (new GetServiceRequest())->setName($formattedName);
        $response = $gapicClient->getService($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.commerceproducer.v1beta.CommerceTransaction/GetService', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getServiceExceptionTest()
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
        $formattedName = $gapicClient->serviceName('[PROJECT]', '[LOCATION]', '[SERVICE]');
        $request = (new GetServiceRequest())->setName($formattedName);
        try {
            $gapicClient->getService($request);
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
    public function getSkuTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $description = 'description-1724546052';
        $expectedResponse = new Sku();
        $expectedResponse->setName($name2);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->skuName('[PROJECT]', '[LOCATION]', '[SERVICE]', '[SKU]');
        $request = (new GetSkuRequest())->setName($formattedName);
        $response = $gapicClient->getSku($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.commerceproducer.v1beta.CommerceTransaction/GetSku', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getSkuExceptionTest()
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
        $formattedName = $gapicClient->skuName('[PROJECT]', '[LOCATION]', '[SERVICE]', '[SKU]');
        $request = (new GetSkuRequest())->setName($formattedName);
        try {
            $gapicClient->getSku($request);
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
    public function getSkuGroupTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $expectedResponse = new SkuGroup();
        $expectedResponse->setName($name2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->skuGroupName('[PROJECT]', '[LOCATION]', '[SKU_GROUP]');
        $request = (new GetSkuGroupRequest())->setName($formattedName);
        $response = $gapicClient->getSkuGroup($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.commerceproducer.v1beta.CommerceTransaction/GetSkuGroup', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getSkuGroupExceptionTest()
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
        $formattedName = $gapicClient->skuGroupName('[PROJECT]', '[LOCATION]', '[SKU_GROUP]');
        $request = (new GetSkuGroupRequest())->setName($formattedName);
        try {
            $gapicClient->getSkuGroup($request);
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
    public function getStandardOfferTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $termDurationMonths = 480407851;
        $name2 = 'name2-1052831874';
        $serviceLevel = 'serviceLevel-1730336390';
        $serviceLevelTitle = 'serviceLevelTitle2097359699';
        $expectedResponse = new StandardOffer();
        $expectedResponse->setTermDurationMonths($termDurationMonths);
        $expectedResponse->setName($name2);
        $expectedResponse->setServiceLevel($serviceLevel);
        $expectedResponse->setServiceLevelTitle($serviceLevelTitle);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->standardOfferName('[PROJECT]', '[LOCATION]', '[SERVICE]', '[STANDARD_OFFER]');
        $request = (new GetStandardOfferRequest())->setName($formattedName);
        $response = $gapicClient->getStandardOffer($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.commerceproducer.v1beta.CommerceTransaction/GetStandardOffer',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getStandardOfferExceptionTest()
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
        $formattedName = $gapicClient->standardOfferName('[PROJECT]', '[LOCATION]', '[SERVICE]', '[STANDARD_OFFER]');
        $request = (new GetStandardOfferRequest())->setName($formattedName);
        try {
            $gapicClient->getStandardOffer($request);
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
    public function listPrivateOfferDocumentsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $privateOfferDocumentsElement = new PrivateOfferDocument();
        $privateOfferDocuments = [$privateOfferDocumentsElement];
        $expectedResponse = new ListPrivateOfferDocumentsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setPrivateOfferDocuments($privateOfferDocuments);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->privateOfferName('[PROJECT]', '[LOCATION]', '[PRIVATE_OFFER]');
        $request = (new ListPrivateOfferDocumentsRequest())->setParent($formattedParent);
        $response = $gapicClient->listPrivateOfferDocuments($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getPrivateOfferDocuments()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.commerceproducer.v1beta.CommerceTransaction/ListPrivateOfferDocuments',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listPrivateOfferDocumentsExceptionTest()
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
        $formattedParent = $gapicClient->privateOfferName('[PROJECT]', '[LOCATION]', '[PRIVATE_OFFER]');
        $request = (new ListPrivateOfferDocumentsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listPrivateOfferDocuments($request);
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
    public function listPrivateOffersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $privateOffersElement = new PrivateOffer();
        $privateOffers = [$privateOffersElement];
        $expectedResponse = new ListPrivateOffersResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setPrivateOffers($privateOffers);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListPrivateOffersRequest())->setParent($formattedParent);
        $response = $gapicClient->listPrivateOffers($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getPrivateOffers()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.commerceproducer.v1beta.CommerceTransaction/ListPrivateOffers',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listPrivateOffersExceptionTest()
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListPrivateOffersRequest())->setParent($formattedParent);
        try {
            $gapicClient->listPrivateOffers($request);
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
    public function listServicesTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $servicesElement = new Service();
        $services = [$servicesElement];
        $expectedResponse = new ListServicesResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setServices($services);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListServicesRequest())->setParent($formattedParent);
        $response = $gapicClient->listServices($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getServices()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.commerceproducer.v1beta.CommerceTransaction/ListServices', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listServicesExceptionTest()
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListServicesRequest())->setParent($formattedParent);
        try {
            $gapicClient->listServices($request);
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
    public function listSkuGroupsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $skuGroupsElement = new SkuGroup();
        $skuGroups = [$skuGroupsElement];
        $expectedResponse = new ListSkuGroupsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setSkuGroups($skuGroups);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListSkuGroupsRequest())->setParent($formattedParent);
        $response = $gapicClient->listSkuGroups($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getSkuGroups()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.commerceproducer.v1beta.CommerceTransaction/ListSkuGroups', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listSkuGroupsExceptionTest()
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListSkuGroupsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listSkuGroups($request);
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
    public function listSkusTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $skusElement = new Sku();
        $skus = [$skusElement];
        $expectedResponse = new ListSkusResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setSkus($skus);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->serviceName('[PROJECT]', '[LOCATION]', '[SERVICE]');
        $request = (new ListSkusRequest())->setParent($formattedParent);
        $response = $gapicClient->listSkus($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getSkus()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.commerceproducer.v1beta.CommerceTransaction/ListSkus', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listSkusExceptionTest()
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
        $formattedParent = $gapicClient->serviceName('[PROJECT]', '[LOCATION]', '[SERVICE]');
        $request = (new ListSkusRequest())->setParent($formattedParent);
        try {
            $gapicClient->listSkus($request);
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
    public function listStandardOffersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $standardOffersElement = new StandardOffer();
        $standardOffers = [$standardOffersElement];
        $expectedResponse = new ListStandardOffersResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setStandardOffers($standardOffers);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->serviceName('[PROJECT]', '[LOCATION]', '[SERVICE]');
        $request = (new ListStandardOffersRequest())->setParent($formattedParent);
        $response = $gapicClient->listStandardOffers($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getStandardOffers()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.commerceproducer.v1beta.CommerceTransaction/ListStandardOffers',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listStandardOffersExceptionTest()
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
        $formattedParent = $gapicClient->serviceName('[PROJECT]', '[LOCATION]', '[SERVICE]');
        $request = (new ListStandardOffersRequest())->setParent($formattedParent);
        try {
            $gapicClient->listStandardOffers($request);
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
    public function publishPrivateOfferTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $cancellationNote = 'cancellationNote-750122578';
        $internalNote = 'internalNote1826508852';
        $title = 'title110371416';
        $customerNote = 'customerNote-2143804493';
        $expectedResponse = new PrivateOffer();
        $expectedResponse->setName($name2);
        $expectedResponse->setCancellationNote($cancellationNote);
        $expectedResponse->setInternalNote($internalNote);
        $expectedResponse->setTitle($title);
        $expectedResponse->setCustomerNote($customerNote);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->privateOfferName('[PROJECT]', '[LOCATION]', '[PRIVATE_OFFER]');
        $request = (new PublishPrivateOfferRequest())->setName($formattedName);
        $response = $gapicClient->publishPrivateOffer($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.commerceproducer.v1beta.CommerceTransaction/PublishPrivateOffer',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function publishPrivateOfferExceptionTest()
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
        $formattedName = $gapicClient->privateOfferName('[PROJECT]', '[LOCATION]', '[PRIVATE_OFFER]');
        $request = (new PublishPrivateOfferRequest())->setName($formattedName);
        try {
            $gapicClient->publishPrivateOffer($request);
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
    public function resolveAmendmentTargetTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $requiredPrivateOffer = 'requiredPrivateOffer-880218112';
        $expectedResponse = new ResolveAmendmentTargetResponse();
        $expectedResponse->setRequiredPrivateOffer($requiredPrivateOffer);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $formattedTargetBillingAccount = $gapicClient->billingAccountName('[BILLING_ACCOUNT]');
        $formattedBaseStandardOffer = $gapicClient->standardOfferName(
            '[PROJECT]',
            '[LOCATION]',
            '[SERVICE]',
            '[STANDARD_OFFER]'
        );
        $request = (new ResolveAmendmentTargetRequest())
            ->setParent($formattedParent)
            ->setTargetBillingAccount($formattedTargetBillingAccount)
            ->setBaseStandardOffer($formattedBaseStandardOffer);
        $response = $gapicClient->resolveAmendmentTarget($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.commerceproducer.v1beta.CommerceTransaction/ResolveAmendmentTarget',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getTargetBillingAccount();
        $this->assertProtobufEquals($formattedTargetBillingAccount, $actualValue);
        $actualValue = $actualRequestObject->getBaseStandardOffer();
        $this->assertProtobufEquals($formattedBaseStandardOffer, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function resolveAmendmentTargetExceptionTest()
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
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $formattedTargetBillingAccount = $gapicClient->billingAccountName('[BILLING_ACCOUNT]');
        $formattedBaseStandardOffer = $gapicClient->standardOfferName(
            '[PROJECT]',
            '[LOCATION]',
            '[SERVICE]',
            '[STANDARD_OFFER]'
        );
        $request = (new ResolveAmendmentTargetRequest())
            ->setParent($formattedParent)
            ->setTargetBillingAccount($formattedTargetBillingAccount)
            ->setBaseStandardOffer($formattedBaseStandardOffer);
        try {
            $gapicClient->resolveAmendmentTarget($request);
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
    public function updatePrivateOfferTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $cancellationNote = 'cancellationNote-750122578';
        $internalNote = 'internalNote1826508852';
        $title = 'title110371416';
        $customerNote = 'customerNote-2143804493';
        $expectedResponse = new PrivateOffer();
        $expectedResponse->setName($name);
        $expectedResponse->setCancellationNote($cancellationNote);
        $expectedResponse->setInternalNote($internalNote);
        $expectedResponse->setTitle($title);
        $expectedResponse->setCustomerNote($customerNote);
        $transport->addResponse($expectedResponse);
        // Mock request
        $privateOffer = new PrivateOffer();
        $request = (new UpdatePrivateOfferRequest())->setPrivateOffer($privateOffer);
        $response = $gapicClient->updatePrivateOffer($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.commerceproducer.v1beta.CommerceTransaction/UpdatePrivateOffer',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getPrivateOffer();
        $this->assertProtobufEquals($privateOffer, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updatePrivateOfferExceptionTest()
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
        $privateOffer = new PrivateOffer();
        $request = (new UpdatePrivateOfferRequest())->setPrivateOffer($privateOffer);
        try {
            $gapicClient->updatePrivateOffer($request);
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
    public function updatePrivateOfferDocumentTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $inlineContent = '-45';
        $name = 'name3373707';
        $mimeType = 'mimeType-196041627';
        $expectedResponse = new PrivateOfferDocument();
        $expectedResponse->setInlineContent($inlineContent);
        $expectedResponse->setName($name);
        $expectedResponse->setMimeType($mimeType);
        $transport->addResponse($expectedResponse);
        // Mock request
        $privateOfferDocument = new PrivateOfferDocument();
        $privateOfferDocumentDocumentType = DocumentType::DOCUMENT_TYPE_UNSPECIFIED;
        $privateOfferDocument->setDocumentType($privateOfferDocumentDocumentType);
        $request = (new UpdatePrivateOfferDocumentRequest())->setPrivateOfferDocument($privateOfferDocument);
        $response = $gapicClient->updatePrivateOfferDocument($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.commerceproducer.v1beta.CommerceTransaction/UpdatePrivateOfferDocument',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getPrivateOfferDocument();
        $this->assertProtobufEquals($privateOfferDocument, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updatePrivateOfferDocumentExceptionTest()
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
        $privateOfferDocument = new PrivateOfferDocument();
        $privateOfferDocumentDocumentType = DocumentType::DOCUMENT_TYPE_UNSPECIFIED;
        $privateOfferDocument->setDocumentType($privateOfferDocumentDocumentType);
        $request = (new UpdatePrivateOfferDocumentRequest())->setPrivateOfferDocument($privateOfferDocument);
        try {
            $gapicClient->updatePrivateOfferDocument($request);
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
    public function getLocationTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $locationId = 'locationId552319461';
        $displayName = 'displayName1615086568';
        $expectedResponse = new Location();
        $expectedResponse->setName($name2);
        $expectedResponse->setLocationId($locationId);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        $request = new GetLocationRequest();
        $response = $gapicClient->getLocation($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.location.Locations/GetLocation', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getLocationExceptionTest()
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
        $request = new GetLocationRequest();
        try {
            $gapicClient->getLocation($request);
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
    public function listLocationsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $locationsElement = new Location();
        $locations = [$locationsElement];
        $expectedResponse = new ListLocationsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setLocations($locations);
        $transport->addResponse($expectedResponse);
        $request = new ListLocationsRequest();
        $response = $gapicClient->listLocations($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getLocations()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.location.Locations/ListLocations', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listLocationsExceptionTest()
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
        $request = new ListLocationsRequest();
        try {
            $gapicClient->listLocations($request);
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
    public function cancelPrivateOfferAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $cancellationNote2 = 'cancellationNote2686711265';
        $internalNote = 'internalNote1826508852';
        $title = 'title110371416';
        $customerNote = 'customerNote-2143804493';
        $expectedResponse = new PrivateOffer();
        $expectedResponse->setName($name2);
        $expectedResponse->setCancellationNote($cancellationNote2);
        $expectedResponse->setInternalNote($internalNote);
        $expectedResponse->setTitle($title);
        $expectedResponse->setCustomerNote($customerNote);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->privateOfferName('[PROJECT]', '[LOCATION]', '[PRIVATE_OFFER]');
        $request = (new CancelPrivateOfferRequest())->setName($formattedName);
        $response = $gapicClient->cancelPrivateOfferAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.commerceproducer.v1beta.CommerceTransaction/CancelPrivateOffer',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
