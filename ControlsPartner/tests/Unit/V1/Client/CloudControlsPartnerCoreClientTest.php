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

namespace Google\Cloud\CloudControlsPartner\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\CloudControlsPartner\V1\AccessApprovalRequest;
use Google\Cloud\CloudControlsPartner\V1\Client\CloudControlsPartnerCoreClient;
use Google\Cloud\CloudControlsPartner\V1\Customer;
use Google\Cloud\CloudControlsPartner\V1\EkmConnections;
use Google\Cloud\CloudControlsPartner\V1\GetCustomerRequest;
use Google\Cloud\CloudControlsPartner\V1\GetEkmConnectionsRequest;
use Google\Cloud\CloudControlsPartner\V1\GetPartnerPermissionsRequest;
use Google\Cloud\CloudControlsPartner\V1\GetPartnerRequest;
use Google\Cloud\CloudControlsPartner\V1\GetWorkloadRequest;
use Google\Cloud\CloudControlsPartner\V1\ListAccessApprovalRequestsRequest;
use Google\Cloud\CloudControlsPartner\V1\ListAccessApprovalRequestsResponse;
use Google\Cloud\CloudControlsPartner\V1\ListCustomersRequest;
use Google\Cloud\CloudControlsPartner\V1\ListCustomersResponse;
use Google\Cloud\CloudControlsPartner\V1\ListWorkloadsRequest;
use Google\Cloud\CloudControlsPartner\V1\ListWorkloadsResponse;
use Google\Cloud\CloudControlsPartner\V1\Partner;
use Google\Cloud\CloudControlsPartner\V1\PartnerPermissions;
use Google\Cloud\CloudControlsPartner\V1\Workload;
use Google\Rpc\Code;
use stdClass;

/**
 * @group cloudcontrolspartner
 *
 * @group gapic
 */
class CloudControlsPartnerCoreClientTest extends GeneratedTest
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

    /** @return CloudControlsPartnerCoreClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new CloudControlsPartnerCoreClient($options);
    }

    /** @test */
    public function getCustomerTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $isOnboarded = false;
        $expectedResponse = new Customer();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setIsOnboarded($isOnboarded);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->customerName('[ORGANIZATION]', '[LOCATION]', '[CUSTOMER]');
        $request = (new GetCustomerRequest())->setName($formattedName);
        $response = $gapicClient->getCustomer($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.cloudcontrolspartner.v1.CloudControlsPartnerCore/GetCustomer',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getCustomerExceptionTest()
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
        $formattedName = $gapicClient->customerName('[ORGANIZATION]', '[LOCATION]', '[CUSTOMER]');
        $request = (new GetCustomerRequest())->setName($formattedName);
        try {
            $gapicClient->getCustomer($request);
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
    public function getEkmConnectionsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $expectedResponse = new EkmConnections();
        $expectedResponse->setName($name2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->ekmConnectionsName('[ORGANIZATION]', '[LOCATION]', '[CUSTOMER]', '[WORKLOAD]');
        $request = (new GetEkmConnectionsRequest())->setName($formattedName);
        $response = $gapicClient->getEkmConnections($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.cloudcontrolspartner.v1.CloudControlsPartnerCore/GetEkmConnections',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getEkmConnectionsExceptionTest()
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
        $formattedName = $gapicClient->ekmConnectionsName('[ORGANIZATION]', '[LOCATION]', '[CUSTOMER]', '[WORKLOAD]');
        $request = (new GetEkmConnectionsRequest())->setName($formattedName);
        try {
            $gapicClient->getEkmConnections($request);
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
    public function getPartnerTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $partnerProjectId = 'partnerProjectId438161368';
        $expectedResponse = new Partner();
        $expectedResponse->setName($name2);
        $expectedResponse->setPartnerProjectId($partnerProjectId);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->partnerName('[ORGANIZATION]', '[LOCATION]');
        $request = (new GetPartnerRequest())->setName($formattedName);
        $response = $gapicClient->getPartner($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.cloudcontrolspartner.v1.CloudControlsPartnerCore/GetPartner', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getPartnerExceptionTest()
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
        $formattedName = $gapicClient->partnerName('[ORGANIZATION]', '[LOCATION]');
        $request = (new GetPartnerRequest())->setName($formattedName);
        try {
            $gapicClient->getPartner($request);
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
    public function getPartnerPermissionsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $expectedResponse = new PartnerPermissions();
        $expectedResponse->setName($name2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->partnerPermissionsName(
            '[ORGANIZATION]',
            '[LOCATION]',
            '[CUSTOMER]',
            '[WORKLOAD]'
        );
        $request = (new GetPartnerPermissionsRequest())->setName($formattedName);
        $response = $gapicClient->getPartnerPermissions($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.cloudcontrolspartner.v1.CloudControlsPartnerCore/GetPartnerPermissions',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getPartnerPermissionsExceptionTest()
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
        $formattedName = $gapicClient->partnerPermissionsName(
            '[ORGANIZATION]',
            '[LOCATION]',
            '[CUSTOMER]',
            '[WORKLOAD]'
        );
        $request = (new GetPartnerPermissionsRequest())->setName($formattedName);
        try {
            $gapicClient->getPartnerPermissions($request);
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
    public function getWorkloadTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $folderId = 527488652;
        $folder = 'folder-1268966290';
        $isOnboarded = false;
        $keyManagementProjectId = 'keyManagementProjectId1004472221';
        $location = 'location1901043637';
        $expectedResponse = new Workload();
        $expectedResponse->setName($name2);
        $expectedResponse->setFolderId($folderId);
        $expectedResponse->setFolder($folder);
        $expectedResponse->setIsOnboarded($isOnboarded);
        $expectedResponse->setKeyManagementProjectId($keyManagementProjectId);
        $expectedResponse->setLocation($location);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->workloadName('[ORGANIZATION]', '[LOCATION]', '[CUSTOMER]', '[WORKLOAD]');
        $request = (new GetWorkloadRequest())->setName($formattedName);
        $response = $gapicClient->getWorkload($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.cloudcontrolspartner.v1.CloudControlsPartnerCore/GetWorkload',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getWorkloadExceptionTest()
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
        $formattedName = $gapicClient->workloadName('[ORGANIZATION]', '[LOCATION]', '[CUSTOMER]', '[WORKLOAD]');
        $request = (new GetWorkloadRequest())->setName($formattedName);
        try {
            $gapicClient->getWorkload($request);
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
    public function listAccessApprovalRequestsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $accessApprovalRequestsElement = new AccessApprovalRequest();
        $accessApprovalRequests = [$accessApprovalRequestsElement];
        $expectedResponse = new ListAccessApprovalRequestsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setAccessApprovalRequests($accessApprovalRequests);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->workloadName('[ORGANIZATION]', '[LOCATION]', '[CUSTOMER]', '[WORKLOAD]');
        $request = (new ListAccessApprovalRequestsRequest())->setParent($formattedParent);
        $response = $gapicClient->listAccessApprovalRequests($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAccessApprovalRequests()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.cloudcontrolspartner.v1.CloudControlsPartnerCore/ListAccessApprovalRequests',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listAccessApprovalRequestsExceptionTest()
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
        $formattedParent = $gapicClient->workloadName('[ORGANIZATION]', '[LOCATION]', '[CUSTOMER]', '[WORKLOAD]');
        $request = (new ListAccessApprovalRequestsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listAccessApprovalRequests($request);
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
    public function listCustomersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $customersElement = new Customer();
        $customers = [$customersElement];
        $expectedResponse = new ListCustomersResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setCustomers($customers);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->organizationLocationName('[ORGANIZATION]', '[LOCATION]');
        $request = (new ListCustomersRequest())->setParent($formattedParent);
        $response = $gapicClient->listCustomers($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getCustomers()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.cloudcontrolspartner.v1.CloudControlsPartnerCore/ListCustomers',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listCustomersExceptionTest()
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
        $formattedParent = $gapicClient->organizationLocationName('[ORGANIZATION]', '[LOCATION]');
        $request = (new ListCustomersRequest())->setParent($formattedParent);
        try {
            $gapicClient->listCustomers($request);
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
    public function listWorkloadsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $workloadsElement = new Workload();
        $workloads = [$workloadsElement];
        $expectedResponse = new ListWorkloadsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setWorkloads($workloads);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->customerName('[ORGANIZATION]', '[LOCATION]', '[CUSTOMER]');
        $request = (new ListWorkloadsRequest())->setParent($formattedParent);
        $response = $gapicClient->listWorkloads($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getWorkloads()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.cloudcontrolspartner.v1.CloudControlsPartnerCore/ListWorkloads',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listWorkloadsExceptionTest()
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
        $formattedParent = $gapicClient->customerName('[ORGANIZATION]', '[LOCATION]', '[CUSTOMER]');
        $request = (new ListWorkloadsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listWorkloads($request);
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
    public function getCustomerAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $isOnboarded = false;
        $expectedResponse = new Customer();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setIsOnboarded($isOnboarded);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->customerName('[ORGANIZATION]', '[LOCATION]', '[CUSTOMER]');
        $request = (new GetCustomerRequest())->setName($formattedName);
        $response = $gapicClient->getCustomerAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.cloudcontrolspartner.v1.CloudControlsPartnerCore/GetCustomer',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
