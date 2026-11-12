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

namespace Google\Cloud\DiscoveryEngine\Tests\Unit\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\GeneratedTest;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\DiscoveryEngine\V1\Client\LicenseConfigServiceClient;
use Google\Cloud\DiscoveryEngine\V1\CreateLicenseConfigRequest;
use Google\Cloud\DiscoveryEngine\V1\DistributeLicenseConfigRequest;
use Google\Cloud\DiscoveryEngine\V1\DistributeLicenseConfigResponse;
use Google\Cloud\DiscoveryEngine\V1\GetLicenseConfigRequest;
use Google\Cloud\DiscoveryEngine\V1\LicenseConfig;
use Google\Cloud\DiscoveryEngine\V1\ListLicenseConfigsRequest;
use Google\Cloud\DiscoveryEngine\V1\ListLicenseConfigsResponse;
use Google\Cloud\DiscoveryEngine\V1\RetractLicenseConfigRequest;
use Google\Cloud\DiscoveryEngine\V1\RetractLicenseConfigResponse;
use Google\Cloud\DiscoveryEngine\V1\SubscriptionTerm;
use Google\Cloud\DiscoveryEngine\V1\SubscriptionTier;
use Google\Cloud\DiscoveryEngine\V1\UpdateLicenseConfigRequest;
use Google\Rpc\Code;
use Google\Type\Date;
use stdClass;

/**
 * @group discoveryengine
 *
 * @group gapic
 */
class LicenseConfigServiceClientTest extends GeneratedTest
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

    /** @return LicenseConfigServiceClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new LicenseConfigServiceClient($options);
    }

    /** @test */
    public function createLicenseConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $licenseCount = 1565113455;
        $autoRenew = false;
        $freeTrial = false;
        $geminiBundle = true;
        $earlyTerminated = false;
        $expectedResponse = new LicenseConfig();
        $expectedResponse->setName($name);
        $expectedResponse->setLicenseCount($licenseCount);
        $expectedResponse->setAutoRenew($autoRenew);
        $expectedResponse->setFreeTrial($freeTrial);
        $expectedResponse->setGeminiBundle($geminiBundle);
        $expectedResponse->setEarlyTerminated($earlyTerminated);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $licenseConfig = new LicenseConfig();
        $licenseConfigLicenseCount = 1449823279;
        $licenseConfig->setLicenseCount($licenseConfigLicenseCount);
        $licenseConfigSubscriptionTier = SubscriptionTier::SUBSCRIPTION_TIER_UNSPECIFIED;
        $licenseConfig->setSubscriptionTier($licenseConfigSubscriptionTier);
        $licenseConfigStartDate = new Date();
        $licenseConfig->setStartDate($licenseConfigStartDate);
        $licenseConfigSubscriptionTerm = SubscriptionTerm::SUBSCRIPTION_TERM_UNSPECIFIED;
        $licenseConfig->setSubscriptionTerm($licenseConfigSubscriptionTerm);
        $request = (new CreateLicenseConfigRequest())->setParent($formattedParent)->setLicenseConfig($licenseConfig);
        $response = $gapicClient->createLicenseConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.discoveryengine.v1.LicenseConfigService/CreateLicenseConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getLicenseConfig();
        $this->assertProtobufEquals($licenseConfig, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function createLicenseConfigExceptionTest()
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
        $licenseConfig = new LicenseConfig();
        $licenseConfigLicenseCount = 1449823279;
        $licenseConfig->setLicenseCount($licenseConfigLicenseCount);
        $licenseConfigSubscriptionTier = SubscriptionTier::SUBSCRIPTION_TIER_UNSPECIFIED;
        $licenseConfig->setSubscriptionTier($licenseConfigSubscriptionTier);
        $licenseConfigStartDate = new Date();
        $licenseConfig->setStartDate($licenseConfigStartDate);
        $licenseConfigSubscriptionTerm = SubscriptionTerm::SUBSCRIPTION_TERM_UNSPECIFIED;
        $licenseConfig->setSubscriptionTerm($licenseConfigSubscriptionTerm);
        $request = (new CreateLicenseConfigRequest())->setParent($formattedParent)->setLicenseConfig($licenseConfig);
        try {
            $gapicClient->createLicenseConfig($request);
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
    public function distributeLicenseConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new DistributeLicenseConfigResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedBillingAccountLicenseConfig = $gapicClient->billingAccountLicenseConfigName(
            '[BILLING_ACCOUNT]',
            '[BILLING_ACCOUNT_LICENSE_CONFIG]'
        );
        $projectNumber = 828084015;
        $location = 'location1901043637';
        $licenseCount = 1565113455;
        $request = (new DistributeLicenseConfigRequest())
            ->setBillingAccountLicenseConfig($formattedBillingAccountLicenseConfig)
            ->setProjectNumber($projectNumber)
            ->setLocation($location)
            ->setLicenseCount($licenseCount);
        $response = $gapicClient->distributeLicenseConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.discoveryengine.v1.LicenseConfigService/DistributeLicenseConfig',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getBillingAccountLicenseConfig();
        $this->assertProtobufEquals($formattedBillingAccountLicenseConfig, $actualValue);
        $actualValue = $actualRequestObject->getProjectNumber();
        $this->assertProtobufEquals($projectNumber, $actualValue);
        $actualValue = $actualRequestObject->getLocation();
        $this->assertProtobufEquals($location, $actualValue);
        $actualValue = $actualRequestObject->getLicenseCount();
        $this->assertProtobufEquals($licenseCount, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function distributeLicenseConfigExceptionTest()
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
        $formattedBillingAccountLicenseConfig = $gapicClient->billingAccountLicenseConfigName(
            '[BILLING_ACCOUNT]',
            '[BILLING_ACCOUNT_LICENSE_CONFIG]'
        );
        $projectNumber = 828084015;
        $location = 'location1901043637';
        $licenseCount = 1565113455;
        $request = (new DistributeLicenseConfigRequest())
            ->setBillingAccountLicenseConfig($formattedBillingAccountLicenseConfig)
            ->setProjectNumber($projectNumber)
            ->setLocation($location)
            ->setLicenseCount($licenseCount);
        try {
            $gapicClient->distributeLicenseConfig($request);
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
    public function getLicenseConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name2 = 'name2-1052831874';
        $licenseCount = 1565113455;
        $autoRenew = false;
        $freeTrial = false;
        $geminiBundle = true;
        $earlyTerminated = false;
        $expectedResponse = new LicenseConfig();
        $expectedResponse->setName($name2);
        $expectedResponse->setLicenseCount($licenseCount);
        $expectedResponse->setAutoRenew($autoRenew);
        $expectedResponse->setFreeTrial($freeTrial);
        $expectedResponse->setGeminiBundle($geminiBundle);
        $expectedResponse->setEarlyTerminated($earlyTerminated);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedName = $gapicClient->licenseConfigName('[PROJECT]', '[LOCATION]', '[LICENSE_CONFIG]');
        $request = (new GetLicenseConfigRequest())->setName($formattedName);
        $response = $gapicClient->getLicenseConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.discoveryengine.v1.LicenseConfigService/GetLicenseConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getName();
        $this->assertProtobufEquals($formattedName, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function getLicenseConfigExceptionTest()
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
        $formattedName = $gapicClient->licenseConfigName('[PROJECT]', '[LOCATION]', '[LICENSE_CONFIG]');
        $request = (new GetLicenseConfigRequest())->setName($formattedName);
        try {
            $gapicClient->getLicenseConfig($request);
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
    public function listLicenseConfigsTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $nextPageToken = '';
        $licenseConfigsElement = new LicenseConfig();
        $licenseConfigs = [$licenseConfigsElement];
        $expectedResponse = new ListLicenseConfigsResponse();
        $expectedResponse->setNextPageToken($nextPageToken);
        $expectedResponse->setLicenseConfigs($licenseConfigs);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $request = (new ListLicenseConfigsRequest())->setParent($formattedParent);
        $response = $gapicClient->listLicenseConfigs($request);
        $this->assertEquals($expectedResponse, $response->getPage()->getResponseObject());
        $resources = iterator_to_array($response->iterateAllElements());
        $this->assertSame(1, count($resources));
        $this->assertEquals($expectedResponse->getLicenseConfigs()[0], $resources[0]);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.discoveryengine.v1.LicenseConfigService/ListLicenseConfigs', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function listLicenseConfigsExceptionTest()
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
        $request = (new ListLicenseConfigsRequest())->setParent($formattedParent);
        try {
            $gapicClient->listLicenseConfigs($request);
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
    public function retractLicenseConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $expectedResponse = new RetractLicenseConfigResponse();
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedBillingAccountLicenseConfig = $gapicClient->billingAccountLicenseConfigName(
            '[BILLING_ACCOUNT]',
            '[BILLING_ACCOUNT_LICENSE_CONFIG]'
        );
        $formattedLicenseConfig = $gapicClient->licenseConfigName('[PROJECT]', '[LOCATION]', '[LICENSE_CONFIG]');
        $request = (new RetractLicenseConfigRequest())
            ->setBillingAccountLicenseConfig($formattedBillingAccountLicenseConfig)
            ->setLicenseConfig($formattedLicenseConfig);
        $response = $gapicClient->retractLicenseConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame(
            '/google.cloud.discoveryengine.v1.LicenseConfigService/RetractLicenseConfig',
            $actualFuncCall
        );
        $actualValue = $actualRequestObject->getBillingAccountLicenseConfig();
        $this->assertProtobufEquals($formattedBillingAccountLicenseConfig, $actualValue);
        $actualValue = $actualRequestObject->getLicenseConfig();
        $this->assertProtobufEquals($formattedLicenseConfig, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function retractLicenseConfigExceptionTest()
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
        $formattedBillingAccountLicenseConfig = $gapicClient->billingAccountLicenseConfigName(
            '[BILLING_ACCOUNT]',
            '[BILLING_ACCOUNT_LICENSE_CONFIG]'
        );
        $formattedLicenseConfig = $gapicClient->licenseConfigName('[PROJECT]', '[LOCATION]', '[LICENSE_CONFIG]');
        $request = (new RetractLicenseConfigRequest())
            ->setBillingAccountLicenseConfig($formattedBillingAccountLicenseConfig)
            ->setLicenseConfig($formattedLicenseConfig);
        try {
            $gapicClient->retractLicenseConfig($request);
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
    public function updateLicenseConfigTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $licenseCount = 1565113455;
        $autoRenew = false;
        $freeTrial = false;
        $geminiBundle = true;
        $earlyTerminated = false;
        $expectedResponse = new LicenseConfig();
        $expectedResponse->setName($name);
        $expectedResponse->setLicenseCount($licenseCount);
        $expectedResponse->setAutoRenew($autoRenew);
        $expectedResponse->setFreeTrial($freeTrial);
        $expectedResponse->setGeminiBundle($geminiBundle);
        $expectedResponse->setEarlyTerminated($earlyTerminated);
        $transport->addResponse($expectedResponse);
        // Mock request
        $licenseConfig = new LicenseConfig();
        $licenseConfigLicenseCount = 1449823279;
        $licenseConfig->setLicenseCount($licenseConfigLicenseCount);
        $licenseConfigSubscriptionTier = SubscriptionTier::SUBSCRIPTION_TIER_UNSPECIFIED;
        $licenseConfig->setSubscriptionTier($licenseConfigSubscriptionTier);
        $licenseConfigStartDate = new Date();
        $licenseConfig->setStartDate($licenseConfigStartDate);
        $licenseConfigSubscriptionTerm = SubscriptionTerm::SUBSCRIPTION_TERM_UNSPECIFIED;
        $licenseConfig->setSubscriptionTerm($licenseConfigSubscriptionTerm);
        $request = (new UpdateLicenseConfigRequest())->setLicenseConfig($licenseConfig);
        $response = $gapicClient->updateLicenseConfig($request);
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.discoveryengine.v1.LicenseConfigService/UpdateLicenseConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getLicenseConfig();
        $this->assertProtobufEquals($licenseConfig, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }

    /** @test */
    public function updateLicenseConfigExceptionTest()
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
        $licenseConfig = new LicenseConfig();
        $licenseConfigLicenseCount = 1449823279;
        $licenseConfig->setLicenseCount($licenseConfigLicenseCount);
        $licenseConfigSubscriptionTier = SubscriptionTier::SUBSCRIPTION_TIER_UNSPECIFIED;
        $licenseConfig->setSubscriptionTier($licenseConfigSubscriptionTier);
        $licenseConfigStartDate = new Date();
        $licenseConfig->setStartDate($licenseConfigStartDate);
        $licenseConfigSubscriptionTerm = SubscriptionTerm::SUBSCRIPTION_TERM_UNSPECIFIED;
        $licenseConfig->setSubscriptionTerm($licenseConfigSubscriptionTerm);
        $request = (new UpdateLicenseConfigRequest())->setLicenseConfig($licenseConfig);
        try {
            $gapicClient->updateLicenseConfig($request);
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
    public function createLicenseConfigAsyncTest()
    {
        $transport = $this->createTransport();
        $gapicClient = $this->createClient([
            'transport' => $transport,
        ]);
        $this->assertTrue($transport->isExhausted());
        // Mock response
        $name = 'name3373707';
        $licenseCount = 1565113455;
        $autoRenew = false;
        $freeTrial = false;
        $geminiBundle = true;
        $earlyTerminated = false;
        $expectedResponse = new LicenseConfig();
        $expectedResponse->setName($name);
        $expectedResponse->setLicenseCount($licenseCount);
        $expectedResponse->setAutoRenew($autoRenew);
        $expectedResponse->setFreeTrial($freeTrial);
        $expectedResponse->setGeminiBundle($geminiBundle);
        $expectedResponse->setEarlyTerminated($earlyTerminated);
        $transport->addResponse($expectedResponse);
        // Mock request
        $formattedParent = $gapicClient->locationName('[PROJECT]', '[LOCATION]');
        $licenseConfig = new LicenseConfig();
        $licenseConfigLicenseCount = 1449823279;
        $licenseConfig->setLicenseCount($licenseConfigLicenseCount);
        $licenseConfigSubscriptionTier = SubscriptionTier::SUBSCRIPTION_TIER_UNSPECIFIED;
        $licenseConfig->setSubscriptionTier($licenseConfigSubscriptionTier);
        $licenseConfigStartDate = new Date();
        $licenseConfig->setStartDate($licenseConfigStartDate);
        $licenseConfigSubscriptionTerm = SubscriptionTerm::SUBSCRIPTION_TERM_UNSPECIFIED;
        $licenseConfig->setSubscriptionTerm($licenseConfigSubscriptionTerm);
        $request = (new CreateLicenseConfigRequest())->setParent($formattedParent)->setLicenseConfig($licenseConfig);
        $response = $gapicClient->createLicenseConfigAsync($request)->wait();
        $this->assertEquals($expectedResponse, $response);
        $actualRequests = $transport->popReceivedCalls();
        $this->assertSame(1, count($actualRequests));
        $actualFuncCall = $actualRequests[0]->getFuncCall();
        $actualRequestObject = $actualRequests[0]->getRequestObject();
        $this->assertSame('/google.cloud.discoveryengine.v1.LicenseConfigService/CreateLicenseConfig', $actualFuncCall);
        $actualValue = $actualRequestObject->getParent();
        $this->assertProtobufEquals($formattedParent, $actualValue);
        $actualValue = $actualRequestObject->getLicenseConfig();
        $this->assertProtobufEquals($licenseConfig, $actualValue);
        $this->assertTrue($transport->isExhausted());
    }
}
