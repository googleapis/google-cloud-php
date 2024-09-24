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

namespace Google\Ads\MarketingPlatform\Admin\Tests\Unit\V1alpha\Client;

use Google\Ads\MarketingPlatform\Admin\V1alpha\AnalyticsAccountLink;
use Google\Ads\MarketingPlatform\Admin\V1alpha\AnalyticsServiceLevel;
use Google\Ads\MarketingPlatform\Admin\V1alpha\Client\MarketingplatformAdminServiceClient;
use Google\Ads\MarketingPlatform\Admin\V1alpha\CreateAnalyticsAccountLinkRequest;
use Google\Ads\MarketingPlatform\Admin\V1alpha\DeleteAnalyticsAccountLinkRequest;
use Google\Ads\MarketingPlatform\Admin\V1alpha\GetOrganizationRequest;
use Google\Ads\MarketingPlatform\Admin\V1alpha\ListAnalyticsAccountLinksRequest;
use Google\Ads\MarketingPlatform\Admin\V1alpha\ListAnalyticsAccountLinksResponse;
use Google\Ads\MarketingPlatform\Admin\V1alpha\Organization;
use Google\Ads\MarketingPlatform\Admin\V1alpha\SetPropertyServiceLevelRequest;
use Google\Ads\MarketingPlatform\Admin\V1alpha\SetPropertyServiceLevelResponse;
use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
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
    public function createAnalyticsAccountLinkAsyncTest()
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
        $response = $gapicClient->createAnalyticsAccountLinkAsync($request)->wait();
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
}
