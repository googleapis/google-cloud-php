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

namespace Google\Cloud\AccessApproval\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\AccessApproval\V1\AccessApprovalServiceAccount;
use Google\Cloud\AccessApproval\V1\AccessApprovalSettings;
use Google\Cloud\AccessApproval\V1\ApprovalRequest;
use Google\Cloud\AccessApproval\V1\ApproveApprovalRequestMessage;
use Google\Cloud\AccessApproval\V1\Client\AccessApprovalClient;
use Google\Cloud\AccessApproval\V1\DeleteAccessApprovalSettingsMessage;
use Google\Cloud\AccessApproval\V1\DismissApprovalRequestMessage;
use Google\Cloud\AccessApproval\V1\GetAccessApprovalServiceAccountMessage;
use Google\Cloud\AccessApproval\V1\GetAccessApprovalSettingsMessage;
use Google\Cloud\AccessApproval\V1\GetApprovalRequestMessage;
use Google\Cloud\AccessApproval\V1\InvalidateApprovalRequestMessage;
use Google\Cloud\AccessApproval\V1\ListApprovalRequestsMessage;
use Google\Cloud\AccessApproval\V1\ListApprovalRequestsResponse;
use Google\Cloud\AccessApproval\V1\UpdateAccessApprovalSettingsMessage;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group accessapproval
 *
 * @group gapic
 */
class AccessApprovalClientTest extends GeneratedTest
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

    /** @return AccessApprovalClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new AccessApprovalClient($options);
    }

    /** @test */
    public function approveApprovalRequestTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $requestedResourceName = 'requestedResourceName-1409378037';
        $expectedResponse = new ApprovalRequest();
        $expectedResponse->setName($name2);
        $expectedResponse->setRequestedResourceName($requestedResourceName);
        $transport->addResponse($expectedResponse);
        $request = new ApproveApprovalRequestMessage();
        $response = $gapicClient->approveApprovalRequest($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.accessapproval.v1.AccessApproval/ApproveApprovalRequest', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function approveApprovalRequestExceptionTest()
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
        $request = new ApproveApprovalRequestMessage();
        try {
            $gapicClient->approveApprovalRequest($request);
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
    public function deleteAccessApprovalSettingsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new GPBEmpty();
        $transport->addResponse($expectedResponse);
        $request = new DeleteAccessApprovalSettingsMessage();
        $gapicClient->deleteAccessApprovalSettings($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.accessapproval.v1.AccessApproval/DeleteAccessApprovalSettings', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteAccessApprovalSettingsExceptionTest()
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
        $request = new DeleteAccessApprovalSettingsMessage();
        try {
            $gapicClient->deleteAccessApprovalSettings($request);
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
    public function dismissApprovalRequestTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $requestedResourceName = 'requestedResourceName-1409378037';
        $expectedResponse = new ApprovalRequest();
        $expectedResponse->setName($name2);
        $expectedResponse->setRequestedResourceName($requestedResourceName);
        $transport->addResponse($expectedResponse);
        $request = new DismissApprovalRequestMessage();
        $response = $gapicClient->dismissApprovalRequest($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.accessapproval.v1.AccessApproval/DismissApprovalRequest', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function dismissApprovalRequestExceptionTest()
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
        $request = new DismissApprovalRequestMessage();
        try {
            $gapicClient->dismissApprovalRequest($request);
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
    public function getAccessApprovalServiceAccountTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $accountEmail = 'accountEmail-539286774';
        $expectedResponse = new AccessApprovalServiceAccount();
        $expectedResponse->setName($name2);
        $expectedResponse->setAccountEmail($accountEmail);
        $transport->addResponse($expectedResponse);
        $request = new GetAccessApprovalServiceAccountMessage();
        $response = $gapicClient->getAccessApprovalServiceAccount($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.accessapproval.v1.AccessApproval/GetAccessApprovalServiceAccount', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getAccessApprovalServiceAccountExceptionTest()
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
        $request = new GetAccessApprovalServiceAccountMessage();
        try {
            $gapicClient->getAccessApprovalServiceAccount($request);
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
    public function getAccessApprovalSettingsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $enrolledAncestor = false;
        $activeKeyVersion = 'activeKeyVersion559224639';
        $ancestorHasActiveKeyVersion = true;
        $invalidKeyVersion = true;
        $expectedResponse = new AccessApprovalSettings();
        $expectedResponse->setName($name2);
        $expectedResponse->setEnrolledAncestor($enrolledAncestor);
        $expectedResponse->setActiveKeyVersion($activeKeyVersion);
        $expectedResponse->setAncestorHasActiveKeyVersion($ancestorHasActiveKeyVersion);
        $expectedResponse->setInvalidKeyVersion($invalidKeyVersion);
        $transport->addResponse($expectedResponse);
        $request = new GetAccessApprovalSettingsMessage();
        $response = $gapicClient->getAccessApprovalSettings($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.accessapproval.v1.AccessApproval/GetAccessApprovalSettings', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getAccessApprovalSettingsExceptionTest()
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
        $request = new GetAccessApprovalSettingsMessage();
        try {
            $gapicClient->getAccessApprovalSettings($request);
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
    public function getApprovalRequestTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $requestedResourceName = 'requestedResourceName-1409378037';
        $expectedResponse = new ApprovalRequest();
        $expectedResponse->setName($name2);
        $expectedResponse->setRequestedResourceName($requestedResourceName);
        $transport->addResponse($expectedResponse);
        $request = new GetApprovalRequestMessage();
        $response = $gapicClient->getApprovalRequest($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.accessapproval.v1.AccessApproval/GetApprovalRequest', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getApprovalRequestExceptionTest()
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
        $request = new GetApprovalRequestMessage();
        try {
            $gapicClient->getApprovalRequest($request);
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
    public function invalidateApprovalRequestTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $requestedResourceName = 'requestedResourceName-1409378037';
        $expectedResponse = new ApprovalRequest();
        $expectedResponse->setName($name2);
        $expectedResponse->setRequestedResourceName($requestedResourceName);
        $transport->addResponse($expectedResponse);
        $request = new InvalidateApprovalRequestMessage();
        $response = $gapicClient->invalidateApprovalRequest($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.accessapproval.v1.AccessApproval/InvalidateApprovalRequest', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function invalidateApprovalRequestExceptionTest()
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
        $request = new InvalidateApprovalRequestMessage();
        try {
            $gapicClient->invalidateApprovalRequest($request);
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
    public function listApprovalRequestsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $approvalRequestsElement = new ApprovalRequest();
        $approvalRequests = [
            $approvalRequestsElement,
        ];
        $expectedResponse = new ListApprovalRequestsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setApprovalRequests($approvalRequests);
        $transport->addResponse($expectedResponse);
        $request = new ListApprovalRequestsMessage();
        $response = $gapicClient->listApprovalRequests($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getApprovalRequests()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.accessapproval.v1.AccessApproval/ListApprovalRequests', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listApprovalRequestsExceptionTest()
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
        $request = new ListApprovalRequestsMessage();
        try {
            $gapicClient->listApprovalRequests($request);
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
    public function updateAccessApprovalSettingsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $enrolledAncestor = false;
        $activeKeyVersion = 'activeKeyVersion559224639';
        $ancestorHasActiveKeyVersion = true;
        $invalidKeyVersion = true;
        $expectedResponse = new AccessApprovalSettings();
        $expectedResponse->setName($name);
        $expectedResponse->setEnrolledAncestor($enrolledAncestor);
        $expectedResponse->setActiveKeyVersion($activeKeyVersion);
        $expectedResponse->setAncestorHasActiveKeyVersion($ancestorHasActiveKeyVersion);
        $expectedResponse->setInvalidKeyVersion($invalidKeyVersion);
        $transport->addResponse($expectedResponse);
        $request = new UpdateAccessApprovalSettingsMessage();
        $response = $gapicClient->updateAccessApprovalSettings($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.accessapproval.v1.AccessApproval/UpdateAccessApprovalSettings', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateAccessApprovalSettingsExceptionTest()
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
        $request = new UpdateAccessApprovalSettingsMessage();
        try {
            $gapicClient->updateAccessApprovalSettings($request);
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
    public function approveApprovalRequestAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $requestedResourceName = 'requestedResourceName-1409378037';
        $expectedResponse = new ApprovalRequest();
        $expectedResponse->setName($name2);
        $expectedResponse->setRequestedResourceName($requestedResourceName);
        $transport->addResponse($expectedResponse);
        $request = new ApproveApprovalRequestMessage();
        $response = $gapicClient->approveApprovalRequestAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.accessapproval.v1.AccessApproval/ApproveApprovalRequest', $actualFuncCall);
        $this->assertTrue($transport->isExhausted());
    }
}
