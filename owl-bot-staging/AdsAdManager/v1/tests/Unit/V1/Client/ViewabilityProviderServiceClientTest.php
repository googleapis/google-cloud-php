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

use Google\Ads\AdManager\V1\BatchCreateViewabilityProvidersRequest;
use Google\Ads\AdManager\V1\BatchCreateViewabilityProvidersResponse;
use Google\Ads\AdManager\V1\BatchUpdateViewabilityProvidersRequest;
use Google\Ads\AdManager\V1\BatchUpdateViewabilityProvidersResponse;
use Google\Ads\AdManager\V1\Client\ViewabilityProviderServiceClient;
use Google\Ads\AdManager\V1\CreateViewabilityProviderRequest;
use Google\Ads\AdManager\V1\GetViewabilityProviderRequest;
use Google\Ads\AdManager\V1\ListViewabilityProvidersRequest;
use Google\Ads\AdManager\V1\ListViewabilityProvidersResponse;
use Google\Ads\AdManager\V1\UpdateViewabilityProviderRequest;
use Google\Ads\AdManager\V1\ViewabilityProvider;
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
class ViewabilityProviderServiceClientTest extends GeneratedTest
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

    /** @return ViewabilityProviderServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new ViewabilityProviderServiceClient($options);
    }

    /** @test */
    public function batchCreateViewabilityProvidersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchCreateViewabilityProvidersResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchCreateViewabilityProvidersRequest())
            ->setParent($formattedParent)
            ->setRequests($requests);
        $response = $gapicClient->batchCreateViewabilityProviders($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.ViewabilityProviderService/BatchCreateViewabilityProviders', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchCreateViewabilityProvidersExceptionTest()
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
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchCreateViewabilityProvidersRequest())
            ->setParent($formattedParent)
            ->setRequests($requests);
        try {
            $gapicClient->batchCreateViewabilityProviders($request);
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
    public function batchUpdateViewabilityProvidersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchUpdateViewabilityProvidersResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchUpdateViewabilityProvidersRequest())
            ->setParent($formattedParent)
            ->setRequests($requests);
        $response = $gapicClient->batchUpdateViewabilityProviders($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.ViewabilityProviderService/BatchUpdateViewabilityProviders', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function batchUpdateViewabilityProvidersExceptionTest()
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
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchUpdateViewabilityProvidersRequest())
            ->setParent($formattedParent)
            ->setRequests($requests);
        try {
            $gapicClient->batchUpdateViewabilityProviders($request);
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
    public function createViewabilityProviderTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $vendorKey = 'vendorKey694652648';
        $verificationScriptUrl = 'verificationScriptUrl1107990687';
        $verificationScriptUrlParameters = 'verificationScriptUrlParameters-1854786166';
        $rejectionTrackerUrl = 'rejectionTrackerUrl-1482910542';
        $address = 'address-1147692044';
        $email = 'email96619420';
        $fax = 'fax101149';
        $phone = 'phone106642798';
        $externalId = 'externalId-1153075697';
        $comment = 'comment950398559';
        $primaryContact = 'primaryContact203339491';
        $expectedResponse = new ViewabilityProvider();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setVendorKey($vendorKey);
        $expectedResponse->setVerificationScriptUrl($verificationScriptUrl);
        $expectedResponse->setVerificationScriptUrlParameters($verificationScriptUrlParameters);
        $expectedResponse->setRejectionTrackerUrl($rejectionTrackerUrl);
        $expectedResponse->setAddress($address);
        $expectedResponse->setEmail($email);
        $expectedResponse->setFax($fax);
        $expectedResponse->setPhone($phone);
        $expectedResponse->setExternalId($externalId);
        $expectedResponse->setComment($comment);
        $expectedResponse->setPrimaryContact($primaryContact);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $viewabilityProvider = new ViewabilityProvider();
        $viewabilityProviderDisplayName = 'viewabilityProviderDisplayName1689037975';
        $viewabilityProvider->setDisplayName($viewabilityProviderDisplayName);
        $viewabilityProviderVendorKey = 'viewabilityProviderVendorKey2038002849';
        $viewabilityProvider->setVendorKey($viewabilityProviderVendorKey);
        $viewabilityProviderVerificationScriptUrl = 'viewabilityProviderVerificationScriptUrl640968307';
        $viewabilityProvider->setVerificationScriptUrl($viewabilityProviderVerificationScriptUrl);
        $request = (new CreateViewabilityProviderRequest())
            ->setParent($formattedParent)
            ->setViewabilityProvider($viewabilityProvider);
        $response = $gapicClient->createViewabilityProvider($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.ViewabilityProviderService/CreateViewabilityProvider', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getViewabilityProvider();
        $this->assertProtobufEquals($viewabilityProvider, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createViewabilityProviderExceptionTest()
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
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $viewabilityProvider = new ViewabilityProvider();
        $viewabilityProviderDisplayName = 'viewabilityProviderDisplayName1689037975';
        $viewabilityProvider->setDisplayName($viewabilityProviderDisplayName);
        $viewabilityProviderVendorKey = 'viewabilityProviderVendorKey2038002849';
        $viewabilityProvider->setVendorKey($viewabilityProviderVendorKey);
        $viewabilityProviderVerificationScriptUrl = 'viewabilityProviderVerificationScriptUrl640968307';
        $viewabilityProvider->setVerificationScriptUrl($viewabilityProviderVerificationScriptUrl);
        $request = (new CreateViewabilityProviderRequest())
            ->setParent($formattedParent)
            ->setViewabilityProvider($viewabilityProvider);
        try {
            $gapicClient->createViewabilityProvider($request);
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
    public function getViewabilityProviderTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $vendorKey = 'vendorKey694652648';
        $verificationScriptUrl = 'verificationScriptUrl1107990687';
        $verificationScriptUrlParameters = 'verificationScriptUrlParameters-1854786166';
        $rejectionTrackerUrl = 'rejectionTrackerUrl-1482910542';
        $address = 'address-1147692044';
        $email = 'email96619420';
        $fax = 'fax101149';
        $phone = 'phone106642798';
        $externalId = 'externalId-1153075697';
        $comment = 'comment950398559';
        $primaryContact = 'primaryContact203339491';
        $expectedResponse = new ViewabilityProvider();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setVendorKey($vendorKey);
        $expectedResponse->setVerificationScriptUrl($verificationScriptUrl);
        $expectedResponse->setVerificationScriptUrlParameters($verificationScriptUrlParameters);
        $expectedResponse->setRejectionTrackerUrl($rejectionTrackerUrl);
        $expectedResponse->setAddress($address);
        $expectedResponse->setEmail($email);
        $expectedResponse->setFax($fax);
        $expectedResponse->setPhone($phone);
        $expectedResponse->setExternalId($externalId);
        $expectedResponse->setComment($comment);
        $expectedResponse->setPrimaryContact($primaryContact);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->viewabilityProviderName('[NETWORK_CODE]', '[VIEWABILITY_PROVIDER]');
        $request = (new GetViewabilityProviderRequest())
            ->setName($formattedName);
        $response = $gapicClient->getViewabilityProvider($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.ViewabilityProviderService/GetViewabilityProvider', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getViewabilityProviderExceptionTest()
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
        $formattedName = $gapicClient->viewabilityProviderName('[NETWORK_CODE]', '[VIEWABILITY_PROVIDER]');
        $request = (new GetViewabilityProviderRequest())
            ->setName($formattedName);
        try {
            $gapicClient->getViewabilityProvider($request);
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
    public function listViewabilityProvidersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $totalSize = 705419236;
        $viewabilityProvidersElement = new ViewabilityProvider();
        $viewabilityProviders = [
            $viewabilityProvidersElement,
        ];
        $expectedResponse = new ListViewabilityProvidersResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setTotalSize($totalSize);
        $expectedResponse->setViewabilityProviders($viewabilityProviders);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $request = (new ListViewabilityProvidersRequest())
            ->setParent($formattedParent);
        $response = $gapicClient->listViewabilityProviders($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getViewabilityProviders()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.ViewabilityProviderService/ListViewabilityProviders', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listViewabilityProvidersExceptionTest()
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
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $request = (new ListViewabilityProvidersRequest())
            ->setParent($formattedParent);
        try {
            $gapicClient->listViewabilityProviders($request);
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
    public function updateViewabilityProviderTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $vendorKey = 'vendorKey694652648';
        $verificationScriptUrl = 'verificationScriptUrl1107990687';
        $verificationScriptUrlParameters = 'verificationScriptUrlParameters-1854786166';
        $rejectionTrackerUrl = 'rejectionTrackerUrl-1482910542';
        $address = 'address-1147692044';
        $email = 'email96619420';
        $fax = 'fax101149';
        $phone = 'phone106642798';
        $externalId = 'externalId-1153075697';
        $comment = 'comment950398559';
        $primaryContact = 'primaryContact203339491';
        $expectedResponse = new ViewabilityProvider();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setVendorKey($vendorKey);
        $expectedResponse->setVerificationScriptUrl($verificationScriptUrl);
        $expectedResponse->setVerificationScriptUrlParameters($verificationScriptUrlParameters);
        $expectedResponse->setRejectionTrackerUrl($rejectionTrackerUrl);
        $expectedResponse->setAddress($address);
        $expectedResponse->setEmail($email);
        $expectedResponse->setFax($fax);
        $expectedResponse->setPhone($phone);
        $expectedResponse->setExternalId($externalId);
        $expectedResponse->setComment($comment);
        $expectedResponse->setPrimaryContact($primaryContact);
        $transport->addResponse($expectedResponse);
        // Mock request
        $viewabilityProvider = new ViewabilityProvider();
        $viewabilityProviderDisplayName = 'viewabilityProviderDisplayName1689037975';
        $viewabilityProvider->setDisplayName($viewabilityProviderDisplayName);
        $viewabilityProviderVendorKey = 'viewabilityProviderVendorKey2038002849';
        $viewabilityProvider->setVendorKey($viewabilityProviderVendorKey);
        $viewabilityProviderVerificationScriptUrl = 'viewabilityProviderVerificationScriptUrl640968307';
        $viewabilityProvider->setVerificationScriptUrl($viewabilityProviderVerificationScriptUrl);
        $request = (new UpdateViewabilityProviderRequest())
            ->setViewabilityProvider($viewabilityProvider);
        $response = $gapicClient->updateViewabilityProvider($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.ViewabilityProviderService/UpdateViewabilityProvider', $actualFuncCall);
        $actualValue = $actualRequestObject->getViewabilityProvider();
        $this->assertProtobufEquals($viewabilityProvider, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateViewabilityProviderExceptionTest()
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
        $viewabilityProvider = new ViewabilityProvider();
        $viewabilityProviderDisplayName = 'viewabilityProviderDisplayName1689037975';
        $viewabilityProvider->setDisplayName($viewabilityProviderDisplayName);
        $viewabilityProviderVendorKey = 'viewabilityProviderVendorKey2038002849';
        $viewabilityProvider->setVendorKey($viewabilityProviderVendorKey);
        $viewabilityProviderVerificationScriptUrl = 'viewabilityProviderVerificationScriptUrl640968307';
        $viewabilityProvider->setVerificationScriptUrl($viewabilityProviderVerificationScriptUrl);
        $request = (new UpdateViewabilityProviderRequest())
            ->setViewabilityProvider($viewabilityProvider);
        try {
            $gapicClient->updateViewabilityProvider($request);
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
    public function batchCreateViewabilityProvidersAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new BatchCreateViewabilityProvidersResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->networkName('[NETWORK_CODE]');
        $requests = [];
        $request = (new BatchCreateViewabilityProvidersRequest())
            ->setParent($formattedParent)
            ->setRequests($requests);
        $response = $gapicClient->batchCreateViewabilityProvidersAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.ads.admanager.v1.ViewabilityProviderService/BatchCreateViewabilityProviders', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getRequests();
        $this->assertProtobufEquals($requests, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
