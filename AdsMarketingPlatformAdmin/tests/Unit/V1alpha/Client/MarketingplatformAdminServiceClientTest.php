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

namespace Google\Ads\MarketingPlatform\Admin\Tests\Unit\V1alpha\Client;

use Google\Ads\MarketingPlatform\Admin\V1alpha\AdminAccessBinding;
use Google\Ads\MarketingPlatform\Admin\V1alpha\AnalyticsAccountLink;
use Google\Ads\MarketingPlatform\Admin\V1alpha\AnalyticsServiceLevel;
use Google\Ads\MarketingPlatform\Admin\V1alpha\Client\MarketingplatformAdminServiceClient;
use Google\Ads\MarketingPlatform\Admin\V1alpha\CreateAdminAccessBindingRequest;
use Google\Ads\MarketingPlatform\Admin\V1alpha\CreateAnalyticsAccountLinkRequest;
use Google\Ads\MarketingPlatform\Admin\V1alpha\CreateUserGroupMemberRequest;
use Google\Ads\MarketingPlatform\Admin\V1alpha\CreateUserGroupRequest;
use Google\Ads\MarketingPlatform\Admin\V1alpha\DeleteAnalyticsAccountLinkRequest;
use Google\Ads\MarketingPlatform\Admin\V1alpha\DeleteUserGroupMemberRequest;
use Google\Ads\MarketingPlatform\Admin\V1alpha\DeleteUserGroupRequest;
use Google\Ads\MarketingPlatform\Admin\V1alpha\FindSalesPartnerManagedClientsRequest;
use Google\Ads\MarketingPlatform\Admin\V1alpha\FindSalesPartnerManagedClientsResponse;
use Google\Ads\MarketingPlatform\Admin\V1alpha\GetAdminAccessBindingRequest;
use Google\Ads\MarketingPlatform\Admin\V1alpha\GetOrganizationRequest;
use Google\Ads\MarketingPlatform\Admin\V1alpha\GetUserGroupMemberRequest;
use Google\Ads\MarketingPlatform\Admin\V1alpha\GetUserGroupRequest;
use Google\Ads\MarketingPlatform\Admin\V1alpha\ListAdminAccessBindingsRequest;
use Google\Ads\MarketingPlatform\Admin\V1alpha\ListAdminAccessBindingsResponse;
use Google\Ads\MarketingPlatform\Admin\V1alpha\ListAnalyticsAccountLinksRequest;
use Google\Ads\MarketingPlatform\Admin\V1alpha\ListAnalyticsAccountLinksResponse;
use Google\Ads\MarketingPlatform\Admin\V1alpha\ListOrganizationsRequest;
use Google\Ads\MarketingPlatform\Admin\V1alpha\ListOrganizationsResponse;
use Google\Ads\MarketingPlatform\Admin\V1alpha\ListUserGroupMembersRequest;
use Google\Ads\MarketingPlatform\Admin\V1alpha\ListUserGroupMembersResponse;
use Google\Ads\MarketingPlatform\Admin\V1alpha\ListUserGroupsRequest;
use Google\Ads\MarketingPlatform\Admin\V1alpha\ListUserGroupsResponse;
use Google\Ads\MarketingPlatform\Admin\V1alpha\Organization;
use Google\Ads\MarketingPlatform\Admin\V1alpha\ReportPropertyUsageRequest;
use Google\Ads\MarketingPlatform\Admin\V1alpha\ReportPropertyUsageResponse;
use Google\Ads\MarketingPlatform\Admin\V1alpha\SetPropertyServiceLevelRequest;
use Google\Ads\MarketingPlatform\Admin\V1alpha\SetPropertyServiceLevelResponse;
use Google\Ads\MarketingPlatform\Admin\V1alpha\UpdateAdminAccessBindingRequest;
use Google\Ads\MarketingPlatform\Admin\V1alpha\UpdateUserGroupMemberRequest;
use Google\Ads\MarketingPlatform\Admin\V1alpha\UpdateUserGroupRequest;
use Google\Ads\MarketingPlatform\Admin\V1alpha\UserGroup;
use Google\Ads\MarketingPlatform\Admin\V1alpha\UserGroupMember;
use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;
use Google\Rpc\Code;
use stdClass;

/**
 * @group admin
 *
 * @group gapic
 */
class MarketingplatformAdminServiceClientTest extends GeneratedTest
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

    /** @return MarketingplatformAdminServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new MarketingplatformAdminServiceClient($options);
    }

    /** @test */
    public function createAdminAccessBindingTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $userEmail = 'userEmail1921668648';
        $name = 'name3373707';
        $expectedResponse = new AdminAccessBinding();
        $expectedResponse->setUserEmail($userEmail);
        $expectedResponse->setName($name);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->organizationName('[ORGANIZATION]');
        $adminAccessBinding = new AdminAccessBinding();
        $request = (new CreateAdminAccessBindingRequest())
            ->setParent($formattedParent)
            ->setAdminAccessBinding($adminAccessBinding);
        $response = $gapicClient->createAdminAccessBinding($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.marketingplatform.admin.v1alpha.MarketingplatformAdminService/CreateAdminAccessBinding',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getAdminAccessBinding();
        $this->assertProtobufEquals($adminAccessBinding, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createAdminAccessBindingExceptionTest()
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
        $formattedParent = $gapicClient->organizationName('[ORGANIZATION]');
        $adminAccessBinding = new AdminAccessBinding();
        $request = (new CreateAdminAccessBindingRequest())
            ->setParent($formattedParent)
            ->setAdminAccessBinding($adminAccessBinding);
        try {
            $gapicClient->createAdminAccessBinding($request);
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
    public function createAnalyticsAccountLinkTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $analyticsAccount = 'analyticsAccount1988159092';
        $displayName = 'displayName1615086568';
        $expectedResponse = new AnalyticsAccountLink();
        $expectedResponse->setName($name);
        $expectedResponse->setAnalyticsAccount($analyticsAccount);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->organizationName('[ORGANIZATION]');
        $analyticsAccountLink = new AnalyticsAccountLink();
        $analyticsAccountLinkAnalyticsAccount = $gapicClient->accountName('[ACCOUNT]');
        $analyticsAccountLink->setAnalyticsAccount($analyticsAccountLinkAnalyticsAccount);
        $request = (new CreateAnalyticsAccountLinkRequest())
            ->setParent($formattedParent)
            ->setAnalyticsAccountLink($analyticsAccountLink);
        $response = $gapicClient->createAnalyticsAccountLink($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.marketingplatform.admin.v1alpha.MarketingplatformAdminService/CreateAnalyticsAccountLink',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getAnalyticsAccountLink();
        $this->assertProtobufEquals($analyticsAccountLink, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createAnalyticsAccountLinkExceptionTest()
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
        $formattedParent = $gapicClient->organizationName('[ORGANIZATION]');
        $analyticsAccountLink = new AnalyticsAccountLink();
        $analyticsAccountLinkAnalyticsAccount = $gapicClient->accountName('[ACCOUNT]');
        $analyticsAccountLink->setAnalyticsAccount($analyticsAccountLinkAnalyticsAccount);
        $request = (new CreateAnalyticsAccountLinkRequest())
            ->setParent($formattedParent)
            ->setAnalyticsAccountLink($analyticsAccountLink);
        try {
            $gapicClient->createAnalyticsAccountLink($request);
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
    public function createUserGroupTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $expectedResponse = new UserGroup();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->organizationName('[ORGANIZATION]');
        $userGroup = new UserGroup();
        $request = (new CreateUserGroupRequest())->setParent($formattedParent)->setUserGroup($userGroup);
        $response = $gapicClient->createUserGroup($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.marketingplatform.admin.v1alpha.MarketingplatformAdminService/CreateUserGroup',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getUserGroup();
        $this->assertProtobufEquals($userGroup, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createUserGroupExceptionTest()
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
        $formattedParent = $gapicClient->organizationName('[ORGANIZATION]');
        $userGroup = new UserGroup();
        $request = (new CreateUserGroupRequest())->setParent($formattedParent)->setUserGroup($userGroup);
        try {
            $gapicClient->createUserGroup($request);
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
    public function createUserGroupMemberTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $userEmail = 'userEmail1921668648';
        $name = 'name3373707';
        $expectedResponse = new UserGroupMember();
        $expectedResponse->setUserEmail($userEmail);
        $expectedResponse->setName($name);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->userGroupName('[ORGANIZATION]', '[USER_GROUP]');
        $userGroupMember = new UserGroupMember();
        $request = (new CreateUserGroupMemberRequest())
            ->setParent($formattedParent)
            ->setUserGroupMember($userGroupMember);
        $response = $gapicClient->createUserGroupMember($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.marketingplatform.admin.v1alpha.MarketingplatformAdminService/CreateUserGroupMember',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getUserGroupMember();
        $this->assertProtobufEquals($userGroupMember, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createUserGroupMemberExceptionTest()
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
        $formattedParent = $gapicClient->userGroupName('[ORGANIZATION]', '[USER_GROUP]');
        $userGroupMember = new UserGroupMember();
        $request = (new CreateUserGroupMemberRequest())
            ->setParent($formattedParent)
            ->setUserGroupMember($userGroupMember);
        try {
            $gapicClient->createUserGroupMember($request);
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
    public function deleteAnalyticsAccountLinkTest()
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
        $formattedName = $gapicClient->analyticsAccountLinkName('[ORGANIZATION]', '[ANALYTICS_ACCOUNT_LINK]');
        $request = (new DeleteAnalyticsAccountLinkRequest())->setName($formattedName);
        $gapicClient->deleteAnalyticsAccountLink($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.marketingplatform.admin.v1alpha.MarketingplatformAdminService/DeleteAnalyticsAccountLink',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteAnalyticsAccountLinkExceptionTest()
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
        $formattedName = $gapicClient->analyticsAccountLinkName('[ORGANIZATION]', '[ANALYTICS_ACCOUNT_LINK]');
        $request = (new DeleteAnalyticsAccountLinkRequest())->setName($formattedName);
        try {
            $gapicClient->deleteAnalyticsAccountLink($request);
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
    public function deleteUserGroupTest()
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
        $formattedName = $gapicClient->userGroupName('[ORGANIZATION]', '[USER_GROUP]');
        $request = (new DeleteUserGroupRequest())->setName($formattedName);
        $gapicClient->deleteUserGroup($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.marketingplatform.admin.v1alpha.MarketingplatformAdminService/DeleteUserGroup',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteUserGroupExceptionTest()
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
        $formattedName = $gapicClient->userGroupName('[ORGANIZATION]', '[USER_GROUP]');
        $request = (new DeleteUserGroupRequest())->setName($formattedName);
        try {
            $gapicClient->deleteUserGroup($request);
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
    public function deleteUserGroupMemberTest()
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
        $formattedName = $gapicClient->userGroupMemberName('[ORGANIZATION]', '[USER_GROUP]', '[MEMBER]');
        $request = (new DeleteUserGroupMemberRequest())->setName($formattedName);
        $gapicClient->deleteUserGroupMember($request);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.marketingplatform.admin.v1alpha.MarketingplatformAdminService/DeleteUserGroupMember',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function deleteUserGroupMemberExceptionTest()
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
        $formattedName = $gapicClient->userGroupMemberName('[ORGANIZATION]', '[USER_GROUP]', '[MEMBER]');
        $request = (new DeleteUserGroupMemberRequest())->setName($formattedName);
        try {
            $gapicClient->deleteUserGroupMember($request);
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
    public function findSalesPartnerManagedClientsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new FindSalesPartnerManagedClientsResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedOrganization = $gapicClient->organizationName('[ORGANIZATION]');
        $request = (new FindSalesPartnerManagedClientsRequest())->setOrganization($formattedOrganization);
        $response = $gapicClient->findSalesPartnerManagedClients($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.marketingplatform.admin.v1alpha.MarketingplatformAdminService/FindSalesPartnerManagedClients',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getOrganization();
        $this->assertProtobufEquals($formattedOrganization, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function findSalesPartnerManagedClientsExceptionTest()
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
        $formattedOrganization = $gapicClient->organizationName('[ORGANIZATION]');
        $request = (new FindSalesPartnerManagedClientsRequest())->setOrganization($formattedOrganization);
        try {
            $gapicClient->findSalesPartnerManagedClients($request);
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
    public function getAdminAccessBindingTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $userEmail = 'userEmail1921668648';
        $name2 = 'name2-1052831874';
        $expectedResponse = new AdminAccessBinding();
        $expectedResponse->setUserEmail($userEmail);
        $expectedResponse->setName($name2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->adminAccessBindingName('[ORGANIZATION]', '[ADMIN_ACCESS_BINDING]');
        $request = (new GetAdminAccessBindingRequest())->setName($formattedName);
        $response = $gapicClient->getAdminAccessBinding($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.marketingplatform.admin.v1alpha.MarketingplatformAdminService/GetAdminAccessBinding',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getAdminAccessBindingExceptionTest()
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
        $formattedName = $gapicClient->adminAccessBindingName('[ORGANIZATION]', '[ADMIN_ACCESS_BINDING]');
        $request = (new GetAdminAccessBindingRequest())->setName($formattedName);
        try {
            $gapicClient->getAdminAccessBinding($request);
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
    public function getOrganizationTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $expectedResponse = new Organization();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->organizationName('[ORGANIZATION]');
        $request = (new GetOrganizationRequest())->setName($formattedName);
        $response = $gapicClient->getOrganization($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.marketingplatform.admin.v1alpha.MarketingplatformAdminService/GetOrganization',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getOrganizationExceptionTest()
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
        $formattedName = $gapicClient->organizationName('[ORGANIZATION]');
        $request = (new GetOrganizationRequest())->setName($formattedName);
        try {
            $gapicClient->getOrganization($request);
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
    public function getUserGroupTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $expectedResponse = new UserGroup();
        $expectedResponse->setName($name2);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->userGroupName('[ORGANIZATION]', '[USER_GROUP]');
        $request = (new GetUserGroupRequest())->setName($formattedName);
        $response = $gapicClient->getUserGroup($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.marketingplatform.admin.v1alpha.MarketingplatformAdminService/GetUserGroup',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getUserGroupExceptionTest()
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
        $formattedName = $gapicClient->userGroupName('[ORGANIZATION]', '[USER_GROUP]');
        $request = (new GetUserGroupRequest())->setName($formattedName);
        try {
            $gapicClient->getUserGroup($request);
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
    public function getUserGroupMemberTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $userEmail = 'userEmail1921668648';
        $name2 = 'name2-1052831874';
        $expectedResponse = new UserGroupMember();
        $expectedResponse->setUserEmail($userEmail);
        $expectedResponse->setName($name2);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->userGroupMemberName('[ORGANIZATION]', '[USER_GROUP]', '[MEMBER]');
        $request = (new GetUserGroupMemberRequest())->setName($formattedName);
        $response = $gapicClient->getUserGroupMember($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.marketingplatform.admin.v1alpha.MarketingplatformAdminService/GetUserGroupMember',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getUserGroupMemberExceptionTest()
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
        $formattedName = $gapicClient->userGroupMemberName('[ORGANIZATION]', '[USER_GROUP]', '[MEMBER]');
        $request = (new GetUserGroupMemberRequest())->setName($formattedName);
        try {
            $gapicClient->getUserGroupMember($request);
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
    public function listAdminAccessBindingsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $adminAccessBindingsElement = new AdminAccessBinding();
        $adminAccessBindings = [$adminAccessBindingsElement];
        $expectedResponse = new ListAdminAccessBindingsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setAdminAccessBindings($adminAccessBindings);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->organizationName('[ORGANIZATION]');
        $request = (new ListAdminAccessBindingsRequest())->setParent($formattedParent);
        $response = $gapicClient->listAdminAccessBindings($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAdminAccessBindings()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.marketingplatform.admin.v1alpha.MarketingplatformAdminService/ListAdminAccessBindings',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listAdminAccessBindingsExceptionTest()
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
        $formattedParent = $gapicClient->organizationName('[ORGANIZATION]');
        $request = (new ListAdminAccessBindingsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listAdminAccessBindings($request);
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
    public function listAnalyticsAccountLinksTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $analyticsAccountLinksElement = new AnalyticsAccountLink();
        $analyticsAccountLinks = [$analyticsAccountLinksElement];
        $expectedResponse = new ListAnalyticsAccountLinksResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setAnalyticsAccountLinks($analyticsAccountLinks);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->organizationName('[ORGANIZATION]');
        $request = (new ListAnalyticsAccountLinksRequest())->setParent($formattedParent);
        $response = $gapicClient->listAnalyticsAccountLinks($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getAnalyticsAccountLinks()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.marketingplatform.admin.v1alpha.MarketingplatformAdminService/ListAnalyticsAccountLinks',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listAnalyticsAccountLinksExceptionTest()
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
        $formattedParent = $gapicClient->organizationName('[ORGANIZATION]');
        $request = (new ListAnalyticsAccountLinksRequest())->setParent($formattedParent);
        try {
            $gapicClient->listAnalyticsAccountLinks($request);
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
    public function listOrganizationsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $organizationsElement = new Organization();
        $organizations = [$organizationsElement];
        $expectedResponse = new ListOrganizationsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setOrganizations($organizations);
        $transport->addResponse($expectedResponse);
        $request = new ListOrganizationsRequest();
        $response = $gapicClient->listOrganizations($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getOrganizations()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.marketingplatform.admin.v1alpha.MarketingplatformAdminService/ListOrganizations',
            $actualFuncCall
        );
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listOrganizationsExceptionTest()
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
        $request = new ListOrganizationsRequest();
        try {
            $gapicClient->listOrganizations($request);
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
    public function listUserGroupMembersTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $userGroupMembersElement = new UserGroupMember();
        $userGroupMembers = [$userGroupMembersElement];
        $expectedResponse = new ListUserGroupMembersResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setUserGroupMembers($userGroupMembers);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->userGroupName('[ORGANIZATION]', '[USER_GROUP]');
        $request = (new ListUserGroupMembersRequest())->setParent($formattedParent);
        $response = $gapicClient->listUserGroupMembers($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getUserGroupMembers()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.marketingplatform.admin.v1alpha.MarketingplatformAdminService/ListUserGroupMembers',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listUserGroupMembersExceptionTest()
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
        $formattedParent = $gapicClient->userGroupName('[ORGANIZATION]', '[USER_GROUP]');
        $request = (new ListUserGroupMembersRequest())->setParent($formattedParent);
        try {
            $gapicClient->listUserGroupMembers($request);
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
    public function listUserGroupsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $userGroupsElement = new UserGroup();
        $userGroups = [$userGroupsElement];
        $expectedResponse = new ListUserGroupsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setUserGroups($userGroups);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->organizationName('[ORGANIZATION]');
        $request = (new ListUserGroupsRequest())->setParent($formattedParent);
        $response = $gapicClient->listUserGroups($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getUserGroups()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.marketingplatform.admin.v1alpha.MarketingplatformAdminService/ListUserGroups',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listUserGroupsExceptionTest()
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
        $formattedParent = $gapicClient->organizationName('[ORGANIZATION]');
        $request = (new ListUserGroupsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listUserGroups($request);
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
    public function reportPropertyUsageTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new ReportPropertyUsageResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $organization = 'organization1178922291';
        $month = 'month104080000';
        $request = (new ReportPropertyUsageRequest())->setOrganization($organization)->setMonth($month);
        $response = $gapicClient->reportPropertyUsage($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.marketingplatform.admin.v1alpha.MarketingplatformAdminService/ReportPropertyUsage',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getOrganization();
        $this->assertProtobufEquals($organization, $actualValue);
        $actualValue = $actualRequestObject->getMonth();
        $this->assertProtobufEquals($month, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function reportPropertyUsageExceptionTest()
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
        $organization = 'organization1178922291';
        $month = 'month104080000';
        $request = (new ReportPropertyUsageRequest())->setOrganization($organization)->setMonth($month);
        try {
            $gapicClient->reportPropertyUsage($request);
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
    public function setPropertyServiceLevelTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new SetPropertyServiceLevelResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $analyticsAccountLink = 'analyticsAccountLink-545363227';
        $formattedAnalyticsProperty = $gapicClient->propertyName('[PROPERTY]');
        $serviceLevel = AnalyticsServiceLevel::ANALYTICS_SERVICE_LEVEL_UNSPECIFIED;
        $request = (new SetPropertyServiceLevelRequest())
            ->setAnalyticsAccountLink($analyticsAccountLink)
            ->setAnalyticsProperty($formattedAnalyticsProperty)
            ->setServiceLevel($serviceLevel);
        $response = $gapicClient->setPropertyServiceLevel($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.marketingplatform.admin.v1alpha.MarketingplatformAdminService/SetPropertyServiceLevel',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getAnalyticsAccountLink();
        $this->assertProtobufEquals($analyticsAccountLink, $actualValue);
        $actualValue = $actualRequestObject->getAnalyticsProperty();
        $this->assertProtobufEquals($formattedAnalyticsProperty, $actualValue);
        $actualValue = $actualRequestObject->getServiceLevel();
        $this->assertProtobufEquals($serviceLevel, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function setPropertyServiceLevelExceptionTest()
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
        $analyticsAccountLink = 'analyticsAccountLink-545363227';
        $formattedAnalyticsProperty = $gapicClient->propertyName('[PROPERTY]');
        $serviceLevel = AnalyticsServiceLevel::ANALYTICS_SERVICE_LEVEL_UNSPECIFIED;
        $request = (new SetPropertyServiceLevelRequest())
            ->setAnalyticsAccountLink($analyticsAccountLink)
            ->setAnalyticsProperty($formattedAnalyticsProperty)
            ->setServiceLevel($serviceLevel);
        try {
            $gapicClient->setPropertyServiceLevel($request);
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
    public function updateAdminAccessBindingTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $userEmail = 'userEmail1921668648';
        $name = 'name3373707';
        $expectedResponse = new AdminAccessBinding();
        $expectedResponse->setUserEmail($userEmail);
        $expectedResponse->setName($name);
        $transport->addResponse($expectedResponse);
        // Mock request
        $adminAccessBinding = new AdminAccessBinding();
        $updateMask = new FieldMask();
        $request = (new UpdateAdminAccessBindingRequest())
            ->setAdminAccessBinding($adminAccessBinding)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateAdminAccessBinding($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.marketingplatform.admin.v1alpha.MarketingplatformAdminService/UpdateAdminAccessBinding',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getAdminAccessBinding();
        $this->assertProtobufEquals($adminAccessBinding, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateAdminAccessBindingExceptionTest()
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
        $adminAccessBinding = new AdminAccessBinding();
        $updateMask = new FieldMask();
        $request = (new UpdateAdminAccessBindingRequest())
            ->setAdminAccessBinding($adminAccessBinding)
            ->setUpdateMask($updateMask);
        try {
            $gapicClient->updateAdminAccessBinding($request);
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
    public function updateUserGroupTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $displayName = 'displayName1615086568';
        $description = 'description-1724546052';
        $expectedResponse = new UserGroup();
        $expectedResponse->setName($name);
        $expectedResponse->setDisplayName($displayName);
        $expectedResponse->setDescription($description);
        $transport->addResponse($expectedResponse);
        // Mock request
        $userGroup = new UserGroup();
        $updateMask = new FieldMask();
        $request = (new UpdateUserGroupRequest())->setUserGroup($userGroup)->setUpdateMask($updateMask);
        $response = $gapicClient->updateUserGroup($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.marketingplatform.admin.v1alpha.MarketingplatformAdminService/UpdateUserGroup',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getUserGroup();
        $this->assertProtobufEquals($userGroup, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateUserGroupExceptionTest()
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
        $userGroup = new UserGroup();
        $updateMask = new FieldMask();
        $request = (new UpdateUserGroupRequest())->setUserGroup($userGroup)->setUpdateMask($updateMask);
        try {
            $gapicClient->updateUserGroup($request);
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
    public function updateUserGroupMemberTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $userEmail = 'userEmail1921668648';
        $name = 'name3373707';
        $expectedResponse = new UserGroupMember();
        $expectedResponse->setUserEmail($userEmail);
        $expectedResponse->setName($name);
        $transport->addResponse($expectedResponse);
        // Mock request
        $userGroupMember = new UserGroupMember();
        $updateMask = new FieldMask();
        $request = (new UpdateUserGroupMemberRequest())
            ->setUserGroupMember($userGroupMember)
            ->setUpdateMask($updateMask);
        $response = $gapicClient->updateUserGroupMember($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.marketingplatform.admin.v1alpha.MarketingplatformAdminService/UpdateUserGroupMember',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getUserGroupMember();
        $this->assertProtobufEquals($userGroupMember, $actualValue);
        $actualValue = $actualRequestObject->getUpdateMask();
        $this->assertProtobufEquals($updateMask, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateUserGroupMemberExceptionTest()
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
        $userGroupMember = new UserGroupMember();
        $updateMask = new FieldMask();
        $request = (new UpdateUserGroupMemberRequest())
            ->setUserGroupMember($userGroupMember)
            ->setUpdateMask($updateMask);
        try {
            $gapicClient->updateUserGroupMember($request);
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
    public function createAdminAccessBindingAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $userEmail = 'userEmail1921668648';
        $name = 'name3373707';
        $expectedResponse = new AdminAccessBinding();
        $expectedResponse->setUserEmail($userEmail);
        $expectedResponse->setName($name);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->organizationName('[ORGANIZATION]');
        $adminAccessBinding = new AdminAccessBinding();
        $request = (new CreateAdminAccessBindingRequest())
            ->setParent($formattedParent)
            ->setAdminAccessBinding($adminAccessBinding);
        $response = $gapicClient->createAdminAccessBindingAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.marketingplatform.admin.v1alpha.MarketingplatformAdminService/CreateAdminAccessBinding',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getAdminAccessBinding();
        $this->assertProtobufEquals($adminAccessBinding, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
